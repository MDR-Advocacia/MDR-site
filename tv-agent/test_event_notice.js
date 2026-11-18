const fs=require('fs'),vm=require('vm'),assert=require('assert');
const source=fs.readFileSync(__dirname+'/clips.js','utf8');
const start=Date.parse('2026-11-18T00:00:00-03:00')/1000,end=Date.parse('2026-11-19T00:00:00-03:00')/1000;
for(const [name,now,notice] of [['today',start+18000,true],['before',start-1,true],['after',end+1,true],['ordinary_countdown',start+18000,false]]){
 const nodes={};function node(id){return nodes[id]||(nodes[id]={hidden:false,textContent:'',style:{},setAttribute(){},removeAttribute(){},pause(){},load(){},play(){return Promise.resolve();},currentTime:1,duration:10,paused:false});}
 const payload={version:'test',clips:[{id:510,url:'/fixture.mp4',poster:'/fixture.jpg',seconds:10}],countdown:{target:start+28800},server_time:now,event_notice:notice?{heading:'ISO 9001',text:'Hoje é dia de auditoria',date_label:'18 DE NOVEMBRO',starts_at:start,ends_at:end}:null};
 function XHR(){this.open=(m,u)=>this.url=u;this.setRequestHeader=()=>{};this.send=()=>{if(this.url==='/api/clips'){this.status=200;this.responseText=JSON.stringify(payload);this.onload();}};}
 vm.runInNewContext(source,{document:{getElementById:node},Date:{now:()=>now*1000},XMLHttpRequest:XHR,setInterval(){},setTimeout(){},location:{search:'?run=1'}});
 if(name==='today'){assert.equal(node('cd-message').textContent,'Hoje é dia de auditoria');assert.equal(node('cd-heading').textContent,'ISO 9001');assert.equal(node('cd-target').textContent,'18 DE NOVEMBRO');assert.equal(node('cd-units').hidden,true);assert.equal(node('countdown').hidden,false);}
 else if(name==='after')assert.equal(node('countdown').hidden,true);
 else{assert.equal(node('cd-message').hidden,true);assert.equal(node('cd-units').hidden,false);assert.equal(node('countdown').hidden,false);}
 console.log(name+' PASS');
}
