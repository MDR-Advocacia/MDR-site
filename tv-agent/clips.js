(function(){'use strict';
var video=document.getElementById('screen'),message=document.getElementById('message'),label=document.getElementById('message-text'),button=document.getElementById('start'),list=[],index=0,version='',active=null,busy=false,lastSwitch=0,lastMoved=0,lastPosition=-1,sequence=0;
function beat(status){var x=new XMLHttpRequest();x.open('POST','/api/player-heartbeat',true);x.setRequestHeader('Content-Type','application/json');x.send(JSON.stringify({at:Date.now(),version:version,item:active?active.id:0,status:status+' #'+sequence+' t='+Math.round(video.currentTime||0)+'/'+Math.round(video.duration||0)+' paused='+video.paused+' ended='+video.ended}));}
function showStart(){message.style.display='block';label.textContent='Selecione para iniciar a programação.';button.hidden=false;}
function play(){var p=video.play();if(p&&p.catch)p.catch(showStart);}
function next(){
 if(Date.now()-lastSwitch<800)return;
 lastSwitch=Date.now();lastMoved=lastSwitch;lastPosition=-1;sequence++;
 // Explicitly release the previous decoder before opening the next item on webOS.
 video.pause();video.removeAttribute('src');video.load();
 if(!list.length){active=null;message.style.display='block';label.textContent='Aguardando programação válida.';button.hidden=true;return;}
 index=index%list.length;active=list[index++];video.src=active.url;video.muted=false;message.style.display='none';button.hidden=true;video.load();play();beat('loading');
}
video.onended=next;video.onerror=function(){if(active&&video.error){beat('media_error');setTimeout(next,2000);}};
button.onclick=function(){play();message.style.display='none';};
function refresh(){if(busy)return;busy=true;var x=new XMLHttpRequest();x.open('GET','/api/clips',true);x.timeout=15000;x.onload=function(){busy=false;if(x.status!==200)return;try{var p=JSON.parse(x.responseText);list=p.clips;version=p.version;if(!active||!list.some(function(c){return c.id===active.id&&c.url===active.url;})){index=0;next();}beat(video.paused?'paused':'playing');}catch(e){}};x.onerror=x.ontimeout=function(){busy=false;};x.send();}
setInterval(function(){
 if(!active)return;
 var position=video.currentTime||0,now=Date.now();
 if(position!==lastPosition){lastPosition=position;lastMoved=now;}
 if(video.ended||(video.duration>0&&position>=video.duration-.12)){next();return;}
 // Recover a stalled media element; never send keys or fake interaction to the TV.
 if(now-lastMoved>Math.max(25000,active.seconds*1000+15000)){beat('stalled_skip');next();}
},2000);
setInterval(refresh,10000);refresh();
}());
