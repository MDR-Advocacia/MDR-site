"""Outbound, authenticated WordPress bridge. No incoming command port."""
from pathlib import Path
from urllib.request import Request, build_opener, HTTPRedirectHandler
from urllib.parse import urlparse
import base64,hashlib,hmac,json,os,secrets,socket,threading,time
from tv_connection import TV

STATE=Path(os.environ.get('STATE_DIRECTORY','/var/lib/mdr-tv-mvp'))
CONFIG=Path(os.environ['TV_BRIDGE_CONFIG'])
LOCK=threading.Lock()

class NoRedirect(HTTPRedirectHandler):
    def redirect_request(self,*args,**kwargs): raise ValueError('Redirecionamento remoto recusado')

def atomic(path,data):
    tmp=path.with_suffix(path.suffix+'.tmp');tmp.write_bytes(data);tmp.chmod(0o600);tmp.replace(path)

def config():
    c=json.loads(CONFIG.read_text());u=urlparse(c['url'])
    if u.scheme!='https' or u.username or u.password: raise ValueError('Origem WordPress inválida')
    return c

def request(path,body=b'',mime='application/json',limit=400000):
    c=config();stamp=str(int(time.time()));nonce=secrets.token_hex(16);method='POST' if path in ('/bridge/sync','/bridge/capture') else 'GET'
    route='/mdr-tv/v1'+path
    msg='\n'.join([method,route,stamp,nonce,hashlib.sha256(body).hexdigest()])
    headers={'X-MDR-Time':stamp,'X-MDR-Nonce':nonce,'X-MDR-Signature':hmac.new(c['key'].encode(),msg.encode(),hashlib.sha256).hexdigest(),
        'Authorization':'Basic '+base64.b64encode((c['preview_user']+':'+c['preview_password']).encode()).decode(),'Content-Type':mime}
    req=Request(c['url'].rstrip('/')+'/wp-json'+route,data=body if method=='POST' else None,headers=headers,method=method)
    with build_opener(NoRedirect()).open(req,timeout=20) as response:
        data=response.read(limit+1)
        if len(data)>limit:raise ValueError('Resposta acima do limite')
        return data

def load_state():
    try:return json.loads((STATE/'bridge-state.json').read_text())
    except (OSError,ValueError):return {'results':[],'executed':[]}

def execute(command):
    action=command['action'];result={'id':command['id'],'ok':False,'message':'Comando não permitido.'}
    if action not in ('start','start_dynamic','start_clips','volume','mute','capture','status','off'):return result
    tv=None
    try:
        if action in ('start','start_dynamic','start_clips'):
            c=config()
            try:tv=TV()
            except (OSError,ConnectionError):
                mac=c.get('wake_mac','').replace(':','').replace('-','')
                if len(mac)!=12:raise ValueError('TV sem resposta; Wake-on-LAN não configurado')
                packet=b'\xff'*6+bytes.fromhex(mac)*16
                with socket.socket(socket.AF_INET,socket.SOCK_DGRAM) as sock:
                    sock.setsockopt(socket.SOL_SOCKET,socket.SO_BROADCAST,1);sock.sendto(packet,('192.168.30.255',9))
                for _ in range(8):
                    time.sleep(3)
                    try:tv=TV();break
                    except (OSError,ConnectionError):pass
                if tv is None:raise ValueError('TV sem resposta após tentativa de Wake-on-LAN')
            power=tv.request('com.webos.service.tvpower/power/getPowerState').get('state','Unknown')
            if power=='Screen Saver':tv.button('HOME')
            mode=c.get('default_mode','continuous') if action=='start' else ('clips' if action=='start_clips' else 'dynamic')
            try:tv.request('media.controls/stop')
            except RuntimeError:pass
            target='http://192.168.0.33:8097/'+{'dynamic':'player.html','clips':'clips.html','continuous':'continuo.html?canal=v3'}[mode]
            target+=('&' if '?' in target else '?')+'run='+str(int(command['id']))
            tv.request('system.launcher/open',{'target':target})
            if mode=='continuous':
                time.sleep(2);tv.button('ENTER')
            # Read-only state checks do not claim that the desired pixels are on screen.
            app=tv.request('com.webos.applicationManager/getForegroundAppInfo').get('appId','')
            result.update(ok=True,message='URL enviada; navegador '+('confirmado. A imagem exige conferência.' if app=='com.webos.app.browser' else 'ainda não confirmado.'))
        else:
            tv=TV()
            if action=='volume':
                value=int(command.get('value',15))
                if not 0<=value<=50:raise ValueError('Volume fora do limite')
                tv.request('audio/setVolume',{'volume':value});result.update(ok=True,message='Volume solicitado à TV.')
            elif action=='mute':tv.request('audio/setMute',{'mute':True});result.update(ok=True,message='Silêncio solicitado à TV.')
            elif action=='off':tv.request('system/turnOff');result.update(ok=True,message='Desligamento solicitado.')
            elif action=='status':
                power=tv.request('com.webos.service.tvpower/power/getPowerState').get('state','Unknown')
                app=tv.request('com.webos.applicationManager/getForegroundAppInfo').get('appId','Unknown')
                result.update(ok=True,message='Energia: '+power+' · '+app,power=power,app=app)
            elif action=='capture':
                data,mime,status=tv.capture()
                if mime!='image/jpeg':raise ValueError('Captura PNG exige conversão; nenhum arquivo enviado')
                request('/bridge/capture',data,'image/jpeg',2000)
                result.update(ok=True,message='Captura real recebida.',**{'power':status['state'],'app':status['app']})
    except Exception as exc:
        result['message']='Falha: '+type(exc).__name__+' · '+str(exc)[:140]
    finally:
        if tv:tv.close()
    return result

def update_once():
    with LOCK:
        state=load_state()
        # Only explicit status/capture commands touch SSAP. Polling cannot prevent screensaver.
        payload={k:state[k] for k in ('received_version','power','app') if k in state}
        payload['results']=state.get('results',[])
        try:
            beat=json.loads((STATE/'player-heartbeat.json').read_text());payload['player']=beat.get('status','');payload['player_seen']=str(int(beat.get('received_at',0)))
        except (OSError,ValueError):pass
        incoming=json.loads(request('/bridge/sync',json.dumps(payload).encode()))
        state['results']=[]
        manifest=incoming['manifest'];cache=STATE/'cache';cache.mkdir(exist_ok=True)
        asset_groups=[item['assets'] for item in manifest['items']]+[manifest.get('playlist',[])]
        for assets in asset_groups:
            for asset in assets:
                name=asset['hash']
                if len(name)!=64 or any(x not in '0123456789abcdef' for x in name):raise ValueError('Hash inválido')
                path=cache/name
                if not path.exists():
                    data=request('/bridge/media/'+str(int(asset['id'])),limit=20*1024*1024)
                    if hashlib.sha256(data).hexdigest()!=name:raise ValueError('Hash da mídia não confere')
                    atomic(path,data)
                asset['url']='/cache/'+name
        atomic(STATE/'program.json',json.dumps(manifest,ensure_ascii=False).encode())
        state['received_version']=manifest['version'];state['last_success']=time.time();state['error']=None
        for cmd in incoming.get('commands',[]):
            if cmd['id'] in state.get('executed',[]):continue
            result=execute(cmd);state['results'].append(result)
            state['executed']=(state.get('executed',[])+[cmd['id']])[-100:]
            for key in ('power','app'):
                if key in result:state[key]=result[key]
            atomic(STATE/'bridge-state.json',json.dumps(state).encode())
        atomic(STATE/'bridge-state.json',json.dumps(state).encode())

def run():
    STATE.mkdir(parents=True,exist_ok=True)
    while True:
        try:update_once()
        except Exception as exc:
            state=load_state();state['error']=type(exc).__name__
            atomic(STATE/'bridge-state.json',json.dumps(state).encode())
        time.sleep(10)

if __name__=='__main__':run()
