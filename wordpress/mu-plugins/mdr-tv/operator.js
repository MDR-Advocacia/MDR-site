(function(){'use strict';
var config=window.mdrTVPanel,root=document.getElementById('mdr-tv-panel');if(!root||!config)return;
var snapshot=config.snapshot,pending={},demos={},feedback={},captureAfter={},refreshBusy=false,pollTimer=null,hiddenAt=0;
var imageDialog=document.getElementById('tvp-image-dialog'),supportDialog=document.getElementById('tvp-support-dialog');
function text(card,selector,value){var el=card.querySelector(selector);if(el)el.textContent=value||'';}
function cardFor(unit){return root.querySelector('[data-unit="'+unit+'"]');}
function unitFor(unit){return snapshot.units.find(function(tv){return tv.id===unit;});}
function request(action,values){var body=new URLSearchParams({action:action,_ajax_nonce:config.nonce});Object.keys(values||{}).forEach(function(key){body.set(key,values[key]);});return fetch(config.ajax,{method:'POST',credentials:'same-origin',headers:{'Content-Type':'application/x-www-form-urlencoded'},body:body.toString(),cache:'no-store'}).then(function(r){return r.json().catch(function(){throw new Error('Não foi possível consultar o painel. Sua sessão pode ter expirado.');});}).then(function(data){if(data===0||data===-1)throw new Error('Sua sessão expirou. Entre novamente no painel com Microsoft 365.');if(!data.success)throw new Error(data.data&&data.data.message||'Não foi possível concluir a solicitação.');return data.data;});}
function showStatus(card,state,title,message,demo){var badge=card.querySelector('.tvp-status');badge.dataset.state=state;badge.dataset.demo=demo?'true':'false';text(card,'[data-status]',title);text(card,'[data-message]',message);}
function render(){snapshot.units.forEach(function(tv){var card=cardFor(tv.id);if(!card)return;
 if(!demos[tv.id])showStatus(card,tv.status.state,tv.status.title,tv.status.message,false);
 var run=pending[tv.id],command=tv.command;
 if(run&&run.action==='start'&&command&&command.id===run.id){
  if(command.state==='success'){delete pending[tv.id];showStatus(card,'success','Início confirmado',command.message,false);if(!captureAfter[run.id]){captureAfter[run.id]=true;send(tv.id,'capture');}}
  else if(command.state==='error'||command.state==='unconfirmed'){delete pending[tv.id];feedback[tv.id]={title:command.title,message:command.message};}
  else showStatus(card,'starting',command.title,command.message,false);
 }
 if(run&&run.action==='capture'&&tv.captureCommand&&tv.captureCommand.id===run.id&&['success','error'].indexOf(tv.captureCommand.state)!==-1){delete pending[tv.id];text(card,'[data-refresh-note]',tv.captureCommand.message);}
 if(pending[tv.id]&&Date.now()-pending[tv.id].at>180000){var p=pending[tv.id];delete pending[tv.id];if(p.action==='start')showStatus(card,'error','Início não confirmado','O prazo terminou sem confirmação. Abra um chamado para a TI se o problema continuar.',false);else text(card,'[data-refresh-note]','Não foi possível atualizar a imagem. A captura anterior foi mantida.');}
 if(!demos[tv.id])card.querySelector('[data-start]').disabled=!!pending[tv.id]||tv.status.state==='starting';
 var image=card.querySelector('[data-image]'),empty=card.querySelector('[data-empty]');
 image.hidden=!tv.image.url;empty.hidden=!!tv.image.url;card.querySelector('[data-zoom]').disabled=!tv.image.url;
 if(tv.image.url&&image.getAttribute('src')!==tv.image.url)image.src=tv.image.url;
 text(card,'[data-capture-time]',tv.image.when+(tv.image.stale&&tv.image.url?' · Imagem antiga':''));
 card.querySelector('[data-refresh]').disabled=snapshot.review||!!pending[tv.id];
 if(feedback[tv.id])showStatus(card,'error',feedback[tv.id].title,feedback[tv.id].message,false);
 text(card,'[data-last-command]',command?command.when+' · '+command.title:'Sem solicitação recente.');text(card,'[data-last-signal]','Último sinal do player: '+tv.lastSignal+'. Horário de Fortaleza.');
});document.getElementById('tvp-updated').textContent=snapshot.when;
 if(snapshot.schedules){var worker=document.querySelector('[data-scheduler-heartbeat]');if(worker&&snapshot.schedules.worker_when)worker.textContent='Servidor verificado em '+snapshot.schedules.worker_when; snapshot.schedules.jobs.forEach(function(job){var row=document.querySelector('[data-schedule-id="'+job.id+'"]');if(row){row.querySelector('[data-schedule-status]').textContent=job.label;row.querySelector('[data-schedule-note]').textContent=job.note;}});}
}
function poll(){if(document.hidden||refreshBusy)return;refreshBusy=true;request('mdr_tv_panel_snapshot').then(function(data){if(snapshot.review!==data.review){window.location.reload();return;}snapshot=data;render();document.getElementById('tvp-global-status').textContent='';}).catch(function(e){snapshot.units.forEach(function(tv){if(!demos[tv.id])showStatus(cardFor(tv.id),'unknown','Não foi possível atualizar','O painel está sem atualização. Isso não informa se a TV está ligada ou desligada.',false);});document.getElementById('tvp-global-status').textContent=e.message+' Os dados anteriores foram mantidos; isso não confirma o estado atual das TVs.';}).finally(function(){refreshBusy=false;});}
function send(unit,action){if(snapshot.review||pending[unit])return;if(action==='start')delete feedback[unit];var card=cardFor(unit);pending[unit]={id:0,at:Date.now(),action:action};card.querySelector('[data-start]').disabled=true;card.querySelector('[data-refresh]').disabled=true;
 if(action==='start')showStatus(card,'starting','Enviando solicitação…','Aguarde. Não é preciso clicar novamente.',false);else text(card,'[data-refresh-note]','Solicitando nova captura…');
 request('mdr_tv_panel_action',{unit:unit,command:action,panel_version:'0.2.1'}).then(function(data){pending[unit]={id:data.id,at:Date.now(),action:action};poll();}).catch(function(e){delete pending[unit];if(action==='start'){feedback[unit]={title:'Solicitação não enviada',message:e.message};showStatus(card,'error','Solicitação não enviada',e.message,false);}else text(card,'[data-refresh-note]',e.message);card.querySelector('[data-start]').disabled=false;card.querySelector('[data-refresh]').disabled=false;});}
function demo(unit){if(!snapshot.review||demos[unit]&&demos[unit].busy)return;var card=cardFor(unit),choice=document.getElementById('tvp-demo-result').value;
 demos[unit]={busy:true};card.querySelector('[data-start]').disabled=true;showStatus(card,'starting','Solicitação enviada','Exemplo: a solicitação foi registrada e o painel aguarda a TV.',true);
 setTimeout(function(){if(!demos[unit])return;showStatus(card,'starting','Aguardando a TV','Exemplo: o serviço recebeu a solicitação. Não é preciso clicar de novo.',true);},850);
 setTimeout(function(){if(!demos[unit])return;demos[unit].busy=false;card.querySelector('[data-start]').disabled=false;
 var states={success:['success','Campanha em reprodução','Exemplo: o player confirmou a reprodução para esta solicitação.'],tv_unreachable:['error','A TV não respondeu','Exemplo: confira se a TV está na tomada. Se continuar, abra um chamado para a TI.'],service_offline:['service_offline','Serviço sem comunicação','Exemplo: o serviço não respondeu. Abra um chamado para a TI.'],unconfirmed:['error','Início não confirmado','Exemplo: não foi possível confirmar a reprodução no prazo. Tente novamente ou abra um chamado.']};
 showStatus.apply(null,[card].concat(states[choice]||states.unconfirmed,[true]));
 },2100);}
root.querySelectorAll('.tvp-card').forEach(function(card){var unit=card.dataset.unit;
 card.querySelector('[data-start]').onclick=function(){if(snapshot.review)demo(unit);else send(unit,'start');};
 card.querySelector('[data-refresh]').onclick=function(){send(unit,'capture');};
 var image=card.querySelector('[data-image]');image.onerror=function(){image.hidden=true;card.querySelector('[data-empty]').hidden=false;card.querySelector('[data-empty]').textContent='Não foi possível carregar esta captura. A imagem não confirma o estado atual da TV.';card.querySelector('[data-zoom]').disabled=true;};
 card.querySelector('[data-zoom]').onclick=function(){var tv=unitFor(unit);if(!tv.image.url)return;var large=document.getElementById('tvp-large-image');large.src=tv.image.url;large.className=tv.image.flip?'tvp-flip':'';large.alt='Captura da TV '+tv.name;document.getElementById('tvp-large-caption').textContent=tv.office+' · '+tv.name+' · '+tv.image.when+(tv.image.stale?' · Imagem antiga':'')+'. Captura pontual, não transmissão ao vivo.';imageDialog.showModal();};
 card.querySelector('[data-support]').onclick=function(){var tv=unitFor(unit),cmd=tv.command,sim=demos[unit];document.getElementById('tvp-support-description').value='TV corporativa — '+tv.name+'\nUnidade: '+tv.office+'\nData/hora: '+snapshot.when+' (Fortaleza)\nEstado: '+card.querySelector('[data-status]').textContent+'\n'+(sim?'Origem: demonstração da interface; sem falha real comprovada.\n':'')+(cmd?'Última solicitação: #'+cmd.id+' · '+cmd.when+'\nResultado: '+cmd.title+'\nReferência: '+cmd.code+'\n':'Sem solicitação recente.\n')+(tv.captureCommand?'Última atualização de imagem: #'+tv.captureCommand.id+' · '+tv.captureCommand.when+'\nResultado da imagem: '+tv.captureCommand.title+' ('+tv.captureCommand.code+')\n':'')+'Último sinal do player: '+tv.lastSignal+'\nCaptura: '+tv.image.when+'\nDescreva o que aparece na TV e se ela está na tomada.';document.getElementById('tvp-copy-status').textContent='';supportDialog.showModal();};
});
root.querySelectorAll('[data-close]').forEach(function(b){b.onclick=function(){b.closest('dialog').close();};});
document.getElementById('tvp-copy').onclick=function(){var field=document.getElementById('tvp-support-description');if(navigator.clipboard&&window.isSecureContext)navigator.clipboard.writeText(field.value).then(function(){document.getElementById('tvp-copy-status').textContent='Dados copiados. Cole na descrição do chamado no GLPI.';}).catch(fallback);else fallback();function fallback(){field.focus();field.select();document.getElementById('tvp-copy-status').textContent='Texto selecionado. Use Copiar e cole na descrição do chamado.';}};
var reset=document.getElementById('tvp-demo-reset');if(reset)reset.onclick=function(){demos={};render();};
document.addEventListener('visibilitychange',function(){if(!document.hidden)poll();});render();pollTimer=setInterval(poll,5000);window.addEventListener('pagehide',function(){clearInterval(pollTimer);});
})();
