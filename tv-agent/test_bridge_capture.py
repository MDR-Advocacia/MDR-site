"""Capture retries are bounded and never weaken pairing or send TV controls."""
from pathlib import Path
from types import SimpleNamespace
import importlib.util,os,sys
os.environ['TV_BRIDGE_CONFIG']='/unused';os.environ['TV_PAIRING_FILE']='/unused'
sys.path.insert(0,str(Path(__file__).parent))
s=importlib.util.spec_from_file_location('capture_bridge',Path(__file__).with_name('bridge.py'));b=importlib.util.module_from_spec(s);s.loader.exec_module(b)
for scenario,expected,connections in [('normal',True,1),('connect_timeout',True,2),('capture_timeout',True,2),('timeout_twice',False,2),('certificate_changed',False,1)]:
 calls=[];uploads=[];closed=[]
 b.time=SimpleNamespace(sleep=lambda _:None)
 class FakeTV:
  def __init__(self):
   calls.append('connect');self.number=len(calls)
   if scenario=='connect_timeout' and self.number==1:raise TimeoutError('temporary connection delay')
   if scenario=='certificate_changed':raise RuntimeError('Certificado da TV mudou; conexão interrompida')
  def capture(self):
   if scenario=='timeout_twice' or (scenario=='capture_timeout' and self.number==1):raise TimeoutError('temporary capture delay')
   return b'image','image/jpeg',{'state':'Active','app':'com.webos.app.browser'}
  def request(self,*_):raise AssertionError('Capture must not send TV control commands')
  def close(self):closed.append(self.number)
 b.TV=FakeTV;b.request=lambda *args:uploads.append(args)
 result=b.execute({'id':42,'action':'capture'})
 assert result['ok']==expected,(scenario,result)
 assert len(calls)==connections,(scenario,calls)
 assert len(uploads)==int(expected),(scenario,uploads)
 print(scenario,'PASS')
