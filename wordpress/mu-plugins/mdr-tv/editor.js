(function(){'use strict';document.querySelectorAll('[data-tv-gallery]').forEach(function(root){
var field=root.querySelector('input'),choice=root.querySelector('[data-choice]'),list=root.querySelector('[data-selected]'),items=JSON.parse(root.dataset.items),ids=field.value.split(',').filter(Boolean).map(Number);
items.forEach(function(item){var o=document.createElement('option');o.value=item.id;o.textContent=item.name;choice.appendChild(o);});
function render(){list.textContent='';field.value=ids.join(',');ids.forEach(function(id,index){var row=document.createElement('p'),item=items.find(function(x){return x.id===id;}),name=document.createElement('span');name.textContent=(index+1)+'. '+(item?item.name:'Arquivo indisponível')+' ';row.appendChild(name);
[['↑',-1],['↓',1],['Remover',0]].forEach(function(action){var b=document.createElement('button');b.type='button';b.className='button';b.textContent=action[0];b.setAttribute('aria-label',action[0]+' '+(item?item.name:''));b.onclick=function(){if(!action[1])ids.splice(index,1);else{var to=index+action[1];if(to>=0&&to<ids.length){ids[index]=ids[to];ids[to]=id;}}render();};row.appendChild(b);});list.appendChild(row);});}
root.querySelector('[data-add]').onclick=function(){var id=Number(choice.value);if(id&&ids.indexOf(id)<0&&ids.length<12)ids.push(id);render();};render();
});}());
