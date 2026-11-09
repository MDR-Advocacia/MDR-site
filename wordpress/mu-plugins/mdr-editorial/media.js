(() => {
  'use strict';
  document.querySelectorAll('[data-editorial-image]').forEach(group => {
    const input=group.querySelector('[data-image-id]'),preview=group.querySelector('[data-image-preview]');
    group.querySelector('[data-select-image]').addEventListener('click',()=>{
      const frame=wp.media({title:group.dataset.imageTitle||'Miniatura quadrada para a home',button:{text:'Usar esta imagem'},library:{type:'image'},multiple:false});
      frame.on('select',()=>{const attachment=frame.state().get('selection').first().toJSON();input.value=attachment.id;preview.replaceChildren();const img=document.createElement('img');img.src=attachment.sizes?.thumbnail?.url||attachment.url;img.alt='Miniatura selecionada';img.style.maxWidth='150px';preview.append(img);});frame.open();
    });
    group.querySelector('[data-remove-image]').addEventListener('click',()=>{input.value='0';preview.replaceChildren();});
  });
})();
