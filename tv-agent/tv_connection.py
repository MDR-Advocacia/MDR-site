"""Small SSAP client for the already paired TV; no external packages."""
from pathlib import Path
from urllib.parse import urlparse
import os
import base64,hashlib,json,secrets,socket,ssl,struct,time,urllib.request

HOST=os.environ.get('TV_HOST','192.168.30.79')
KEY_FILE=Path(os.environ['TV_PAIRING_FILE'])

class Socket:
 def __init__(self,path='/',timeout=10,expected=None):
  self.context=ssl._create_unverified_context()
  self.socket=self.context.wrap_socket(socket.create_connection((HOST,3001),timeout=timeout),server_hostname=HOST)
  self.socket.settimeout(timeout);self.buffer=b''
  self.fingerprint=hashlib.sha256(self.socket.getpeercert(binary_form=True)).hexdigest()
  if expected and expected!=self.fingerprint:self.close();raise RuntimeError('Certificado da TV mudou; conexão interrompida')
  key=base64.b64encode(secrets.token_bytes(16)).decode()
  self.socket.sendall((f'GET {path} HTTP/1.1\r\nHost: {HOST}:3001\r\nUpgrade: websocket\r\nConnection: Upgrade\r\nSec-WebSocket-Key: {key}\r\nSec-WebSocket-Version: 13\r\n\r\n').encode())
  while b'\r\n\r\n' not in self.buffer:
   part=self.socket.recv(4096)
   if not part:raise ConnectionError('TV encerrou a conexão')
   self.buffer+=part
  head,self.buffer=self.buffer.split(b'\r\n\r\n',1)
  expected_accept=base64.b64encode(hashlib.sha1((key+'258EAFA5-E914-47DA-95CA-C5AB0DC85B11').encode()).digest())
  if b'101 Switching Protocols' not in head or expected_accept.lower() not in head.lower():raise ConnectionError('Handshake WebSocket recusado')
 def close(self):self.socket.close()
 def send_text(self,text,opcode=1):
  data=text.encode() if isinstance(text,str) else text;n=len(data);mask=secrets.token_bytes(4)
  head=bytes([0x80|opcode,0x80|(n if n<126 else 126 if n<65536 else 127)])
  if n>=126:head+=struct.pack('!H' if n<65536 else '!Q',n)
  self.socket.sendall(head+mask+bytes(v^mask[i%4] for i,v in enumerate(data)))
 def send(self,value):self.send_text(json.dumps(value))
 def take(self,n):
  while len(self.buffer)<n:
   part=self.socket.recv(max(4096,n-len(self.buffer)))
   if not part:raise ConnectionError('Conexão com a TV encerrada')
   self.buffer+=part
  data,self.buffer=self.buffer[:n],self.buffer[n:];return data
 def receive(self):
  while True:
   a,b=self.take(2);opcode=a&15;n=b&127
   if n==126:n=struct.unpack('!H',self.take(2))[0]
   elif n==127:n=struct.unpack('!Q',self.take(8))[0]
   if n>8*1024*1024:raise RuntimeError('Resposta da TV acima do limite')
   mask=self.take(4) if b&128 else None;data=self.take(n)
   if mask:data=bytes(v^mask[i%4] for i,v in enumerate(data))
   if opcode==9:self.send_text(data,10);continue
   if opcode==8:raise ConnectionError('TV encerrou a conexão')
   if opcode==1:return json.loads(data)

class TV:
 def __init__(self):
  saved=json.loads(KEY_FILE.read_text());self.ws=Socket(expected=saved['certificate_sha256']);self.sequence=0
  self.ws.send({'id':'hello','type':'hello','payload':{'sdkVersion':'1.0','deviceModel':'Codex','OSVersion':'macOS','appId':'com.mdr.codex.tv','appName':'Codex - TV MDR','appVersion':'0.3'}});self.ws.receive()
  self.ws.send({'id':'register','type':'register','payload':{'client-key':saved['client_key'],'forcePairing':False,'manifest':{'manifestVersion':1,'permissions':saved.get('permissions',[])}}})
  while True:
   r=self.ws.receive()
   if r.get('type')=='registered':break
   if r.get('type')=='error':raise RuntimeError(r.get('error','Pareamento recusado'))
 def close(self):self.ws.close()
 def request(self,uri,payload=None):
  self.sequence+=1;id='monitor-'+str(self.sequence)
  self.ws.send({'id':id,'type':'request','uri':'ssap://'+uri,'payload':payload or {}})
  while True:
   r=self.ws.receive()
   if r.get('id')!=id:continue
   if r.get('type')=='error':raise RuntimeError(r.get('error','A TV recusou a consulta'))
   p=r.get('payload',{})
   if p.get('returnValue') is False:raise RuntimeError(p.get('errorText','A TV recusou a operação'))
   return p
 def button(self,name):
  if name not in {'UP','DOWN','LEFT','RIGHT','ENTER','BACK','HOME'}:raise ValueError('Tecla não autorizada neste monitor')
  uri=self.request('com.webos.service.networkinput/getPointerInputSocket')['socketPath'];u=urlparse(uri)
  if u.hostname!=HOST or u.scheme not in ('ws','wss') or u.port not in (3000,3001):raise ValueError('Canal de teclado inesperado')
  channel=Socket(u.path+('?' +u.query if u.query else ''),expected=self.ws.fingerprint)
  try:
   # This TV needs the input channel to settle and consume the frame before TLS closes.
   time.sleep(.35)
   channel.send_text('type:button\nname:'+name+'\n\n')
   time.sleep(.5)
  finally:channel.close()
 def capture(self):
  state=self.request('com.webos.service.tvpower/power/getPowerState').get('state','Unknown')
  app=self.request('com.webos.applicationManager/getForegroundAppInfo').get('appId','Unknown')
  uri=self.request('tv/executeOneShot').get('imageUri')
  def checked(value):
   u=urlparse(value)
   if u.scheme not in ('http','https') or u.hostname!=HOST or u.username or u.password or len(value)>4096:raise ValueError('Endereço da captura não corresponde à TV')
   return value
  class Redirect(urllib.request.HTTPRedirectHandler):
   max_redirections=3
   def redirect_request(self,req,fp,code,msg,headers,newurl):return super().redirect_request(req,fp,code,msg,headers,checked(newurl))
  opener=urllib.request.build_opener(Redirect(),urllib.request.HTTPSHandler(context=self.ws.context))
  with opener.open(checked(uri),timeout=10) as response:data=response.read(8*1024*1024+1)
  if len(data)>8*1024*1024:raise ValueError('Captura acima do limite')
  mime='image/png' if data.startswith(b'\x89PNG\r\n\x1a\n') else 'image/jpeg' if data.startswith(b'\xff\xd8') else None
  if not mime:raise ValueError('Resposta da TV não contém imagem reconhecida')
  return data,mime,{'state':state,'app':app}
