"""Regression checks for delayed TV launch and current playback acknowledgement."""
import importlib.util,tempfile,os,json
from pathlib import Path
from types import SimpleNamespace
src=Path(__file__).with_name('bridge.py')
os.environ['TV_BRIDGE_CONFIG']='/unused'
os.environ['TV_PAIRING_FILE']='/unused'
import sys;sys.path.insert(0,str(src.parent))
s=importlib.util.spec_from_file_location('bridge',src);b=importlib.util.module_from_spec(s);s.loader.exec_module(b)
for scenario,expected,opens in [('first',True,1),('retry',True,2),('stale',False,2),('wrong_run',False,2),('loading',False,1),('not_ready',False,1)]:
 with tempfile.TemporaryDirectory() as d:
  b.STATE=Path(d);clock=[1000.0];calls=[]
  b.time=SimpleNamespace(time=lambda:clock[0],sleep=lambda t:clock.__setitem__(0,clock[0]+t))
  b.config=lambda:{'default_mode':'clips','player_origin':'http://192.168.0.33:8097'}
  class FakeTV:
   def request(self,uri,payload=None):
    if uri=='system.launcher/open':
     calls.append(payload)
     if scenario!='retry' or len(calls)==2:
      beat={'run':'99' if scenario=='wrong_run' else '12','received_at':clock[0]-100 if scenario=='stale' else clock[0],'status':'loading' if scenario=='loading' else 'playing #1 paused=false ready='+('0' if scenario=='not_ready' else '4')}
      (b.STATE/'player-heartbeat.json').write_text(json.dumps(beat))
    return {'state':'Active','appId':'com.webos.app.browser'}
   def close(self):pass
  b.TV=FakeTV;r=b.execute({'id':12,'action':'start'})
  assert r['ok']==expected,(scenario,r)
  assert len(calls)==opens,(scenario,len(calls))
  assert all(x['target'].endswith('run=12') for x in calls)
  print(scenario,'PASS')
