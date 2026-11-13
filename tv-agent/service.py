"""Private player/cache and outbound bridge; legacy film stays available."""
from pathlib import Path
from http.server import ThreadingHTTPServer
from functools import partial
import sys
import importlib.util,ipaddress,json,mimetypes,os,re,threading,time
import bridge

ROOT=Path(__file__).resolve().parent
sys.path.append('/opt/mdr-tv-mvp')
spec=importlib.util.spec_from_file_location('legacy','/opt/mdr-tv-mvp/server.py');legacy=importlib.util.module_from_spec(spec);spec.loader.exec_module(legacy)
DEVICE_HOSTS={'127.0.0.1','192.168.0.33',os.environ.get('TV_HOST','192.168.30.79')}
# Separate processes, credential files and caches isolate each TV.

def current_clips():
    """Only serve prepared media still authorized by the current manifest."""
    import hashlib
    try:
        p=json.loads((bridge.STATE/'program.json').read_text())
        ready=json.loads((bridge.STATE/'clips.json').read_text())
        if p['valid_until']<=time.time():return {'version':p['version'],'clips':[]}
        rows=[]
        for item in p['items']:
            if item.get('end') and item['end']<=time.time():continue
            version=hashlib.sha256(json.dumps(item,sort_keys=True,ensure_ascii=False).encode()).hexdigest()
            for c in ready['clips']:
                if c['id']!=item['id'] or c.get('item_version')!=version:continue
                if not re.fullmatch(r'[a-f0-9]{64}(?:-base)?\.mp4',c['file']):continue
                if not (bridge.STATE/'clips'/c['file']).is_file():continue
                poster=c.get('poster','')
                poster='/frames/'+poster if re.fullmatch(r'[a-f0-9]{64}\.jpg',poster) and (bridge.STATE/'clips'/poster).is_file() else ''
                rows.append({**c,'url':'/clips/'+c['file'],'poster':poster})
        return {'version':p['version'],'clips':rows}
    except (OSError,ValueError,KeyError):return {'version':'waiting','clips':[]}

class Handler(legacy.Handler):
    def device(self):return self.client_address[0] in DEVICE_HOSTS
    def respond(self,data,mime='application/json',code=200):
        self.send_response(code);self.send_header('Content-Type',mime);self.send_header('Content-Length',str(len(data)));self.send_header('Cache-Control','no-store');self.end_headers()
        try:self.wfile.write(data)
        except (BrokenPipeError,ConnectionResetError):pass
    def do_GET(self):
        path=self.path.split('?',1)[0]
        if path in ('/player.html','/player.js','/player.css','/api/program','/clips.html','/clips.js','/api/clips') or path.startswith(('/cache/','/clips/','/frames/')):
            if not self.device():self.send_error(403);return
            if path=='/api/clips':self.respond(json.dumps(current_clips()).encode());return
            if path.startswith('/frames/'):
                allowed={c.get('poster') for c in current_clips()['clips']}
                if path not in allowed:self.send_error(404);return
                self.serve_range(bridge.STATE/'clips'/path[8:],'image/jpeg');return
            if path.startswith('/clips/'):
                name=path[7:]
                if name not in {c['file'] for c in current_clips()['clips']}:self.send_error(404);return
                self.serve_range(bridge.STATE/'clips'/name,'video/mp4');return
            if path=='/api/program':
                p=bridge.STATE/'program.json'
                if p.is_file():self.respond(p.read_bytes())
                else:self.respond(json.dumps({'items':[],'settings':{},'version':'empty','valid_until':int(time.time())+30}).encode())
                return
            if path.startswith('/cache/'):
                name=path[7:]
                if not re.fullmatch('[a-f0-9]{64}',name):self.send_error(404);return
                try:p=json.loads((bridge.STATE/'program.json').read_text())
                except (OSError,ValueError):self.send_error(404);return
                assets={a['hash']:a for item in p['items'] if not item.get('end') or item['end']>time.time() for a in item['assets']}
                assets.update({a['hash']:a for a in p.get('playlist',[])})
                if name not in assets or p['valid_until']<time.time():self.send_error(404);return
                target=bridge.STATE/'cache'/name
                if not target.is_file():self.send_error(404);return
                self.serve_range(target,assets[name]['mime']);return
            self.respond((ROOT/path[1:]).read_bytes(),{'.html':'text/html; charset=utf-8','.js':'text/javascript','.css':'text/css'}[Path(path).suffix]);return
        super().do_GET()
    def serve_range(self,p,mime):
        size=p.stat().st_size;start=0;end=size-1;partial=False;value=self.headers.get('Range')
        if value:
            m=re.fullmatch(r'bytes=(\d*)-(\d*)',value)
            if not m or not any(m.groups()):self.send_error(416);return
            a,b=m.groups()
            if not a:start=max(0,size-int(b))
            else:start=int(a);end=min(size-1,int(b)) if b else size-1
            if start>=size or end<start:self.send_error(416);return
            partial=True
        self.send_response(206 if partial else 200);self.send_header('Content-Type',mime);self.send_header('Accept-Ranges','bytes');self.send_header('Content-Length',str(end-start+1))
        if partial:self.send_header('Content-Range',f'bytes {start}-{end}/{size}')
        self.end_headers()
        try:
            with p.open('rb') as f:
                f.seek(start);left=end-start+1
                while left:
                    b=f.read(min(left,65536))
                    if not b:break
                    self.wfile.write(b);left-=len(b)
        except (BrokenPipeError,ConnectionResetError):pass
    def do_HEAD(self):
        path=self.path.split('?',1)[0]
        if path.startswith(('/cache/','/api/program','/player','/clips','/api/clips','/frames/')):
            self.send_error(405);return
        super().do_HEAD()
    def do_POST(self):
        if self.path!='/api/player-heartbeat' or not self.device():self.send_error(403);return
        length=int(self.headers.get('Content-Length','0'))
        if not 0<length<=2000:self.send_error(400);return
        try:
            d=json.loads(self.rfile.read(length));safe={k:str(d.get(k,''))[:100] for k in ('at','run','version','item','status')}
            safe['received_at']=time.time();bridge.atomic(bridge.STATE/'player-heartbeat.json',json.dumps(safe).encode())
            self.respond(b'{"ok":true}')
        except (ValueError,TypeError):self.send_error(400)

if __name__=='__main__':
    bridge.STATE.mkdir(parents=True,exist_ok=True)
    threading.Thread(target=bridge.run,daemon=True).start()
    server=ThreadingHTTPServer((os.environ.get('TV_BIND','192.168.0.33'),int(os.environ.get('TV_PORT','8097'))),partial(Handler,directory='/opt/mdr-tv-mvp/public'))
    server.serve_forever()
