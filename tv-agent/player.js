(function(){'use strict';
var program=null,slides=[],index=0,timer=null,refreshing=false,video=document.getElementById('video'),music=document.getElementById('music'),lastVersion='',lastBeat=0,track=0,trackSource='';
function el(id){return document.getElementById(id);}
function get(url,done){var x=new XMLHttpRequest();x.open('GET',url,true);x.timeout=15000;x.onload=function(){if(x.status===200){try{done(JSON.parse(x.responseText));}catch(e){}}};x.send();}
function playAudio(){if(!program||!program.settings.music)return;var tracks=program.playlist||[];var src=tracks.length?tracks[track%tracks.length].url:'/assets/ambiente-mdr.wav';music.loop=tracks.length<2;if(src!==trackSource){music.src=src;trackSource=src;}music.volume=Math.min(.3,(program.settings.volume||14)/100);var p=music.play();if(p&&p.catch)p.catch(function(){el('activate').hidden=false;});}
music.onended=function(){track++;playAudio();};
el('activate').onclick=function(){playAudio();el('activate').hidden=true;};
function pages(text){
 var box=el('text'),words=(text||'').split(/\s+/),result=[],current='';box.textContent='';
 for(var i=0;i<words.length;i++){var next=current+(current?' ':'')+words[i];box.textContent=next;if(box.scrollHeight>box.clientHeight+2&&current){result.push(current);current=words[i];}else{current=next;}}
 if(current)result.push(current);box.textContent='';return result.length?result:[''];
}
function build(p){
 var out=[];for(var i=0;i<p.items.length;i++){var item=p.items[i];if(item.end&&item.end*1000<=Date.now())continue;
 var assets=item.assets.length?item.assets:[null];for(var a=0;a<assets.length;a++){out.push({item:item,asset:assets[a]});}}
 return out;
}
function beat(detail){if(Date.now()-lastBeat<10000)return;lastBeat=Date.now();var x=new XMLHttpRequest();x.open('POST','/api/player-heartbeat',true);x.setRequestHeader('Content-Type','application/json');x.send(JSON.stringify({at:Date.now(),version:lastVersion,item:slides[index]?slides[index].item.id:0,status:detail}));}
function show(){
 clearTimeout(timer);video.pause();video.style.display='none';video.removeAttribute('src');el('shell').style.display='flex';
 if(!program||Date.now()>program.valid_until*1000){music.pause();el('title').textContent='MDR Advocacia';el('text').textContent='Nossa atuação é orientada pelo rigor técnico, pela ética e pela clareza na comunicação.';el('picture').hidden=true;el('placeholder').hidden=false;el('status').textContent='Aguardando programação atualizada';timer=setTimeout(show,10000);beat('fallback');return;}
 if(!slides.length){el('title').textContent='MDR Advocacia';el('text').textContent='Programação em preparação.';timer=setTimeout(show,10000);return;}
 index=index%slides.length;var s=slides[index],item=s.item,asset=s.asset;
 if(item.end&&item.end*1000<=Date.now()){slides.splice(index,1);show();return;}
 document.body.className=item.format==='photo'?'photo':'';el('source').textContent=item.source;el('title').textContent=item.title;el('credit').textContent=item.credit;el('page').textContent='';
 el('status').textContent='TV interna · programação atualizada';el('picture').hidden=true;el('placeholder').hidden=false;
 if(asset&&asset.mime.indexOf('image/')===0){el('picture').src=asset.url;el('picture').hidden=false;el('placeholder').hidden=true;}
 if(asset&&asset.mime==='video/mp4'&&item.video){
  music.pause();el('shell').style.display='none';video.style.display='block';video.src=asset.url;video.muted=!item.audio;
  var advance=function(){video.onended=null;video.onerror=null;index++;show();};video.onended=advance;video.onerror=advance;
  var p=video.play();if(p&&p.catch)p.catch(advance);timer=setTimeout(advance,Math.min(item.seconds,90)*1000);beat('video');return;
 }
 playAudio();var texts=pages(item.text),page=0;
 function textPage(){el('text').textContent=texts[page];el('page').textContent=(index+1)+' / '+slides.length+(texts.length>1?' · texto '+(page+1)+' / '+texts.length:'');beat('slides');timer=setTimeout(function(){page++;if(page<texts.length)textPage();else{index++;show();}},item.seconds*1000);}
 textPage();
}
function refresh(){if(refreshing)return;refreshing=true;get('/api/program',function(p){refreshing=false;program=p;if(p.version!==lastVersion){lastVersion=p.version;slides=build(p);index=0;show();}else if(!slides.length)show();});setTimeout(function(){refreshing=false;},16000);}
el('picture').onerror=function(){el('picture').hidden=true;el('placeholder').hidden=false;};
setInterval(function(){el('clock').textContent=new Date().toLocaleTimeString('pt-BR',{hour:'2-digit',minute:'2-digit'});},1000);
setInterval(refresh,15000);refresh();show();
}());
