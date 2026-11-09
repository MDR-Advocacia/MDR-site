(() => {
  'use strict';
  const header = document.querySelector('.site-header');
  if (header) {
    const updateHeader = () => header.classList.toggle('is-scrolled', window.scrollY > 56);
    window.addEventListener('scroll', updateHeader, {passive: true});
    updateHeader();
    if ('IntersectionObserver' in window) {
      document.querySelectorAll('.site-menu a[href*="#"]').forEach(link => {
        const url = new URL(link.href);
        const section = url.pathname === location.pathname && url.hash ? document.getElementById(url.hash.slice(1)) : null;
        if (!section) return;
        link.removeAttribute('aria-current');
        const observer = new IntersectionObserver(entries => {
          if (entries.some(entry => entry.isIntersecting)) link.setAttribute('aria-current', 'location');
          else if (link.getAttribute('aria-current') === 'location') link.removeAttribute('aria-current');
        }, {rootMargin: '-150px 0px -50% 0px'});
        observer.observe(section);
      });
    }
  }
  const toggle = document.querySelector('.menu-toggle');
  const nav = document.querySelector('#menu-principal');
  const closeMenu = () => {
    toggle.setAttribute('aria-expanded', 'false');
    nav.classList.remove('open');
  };
  if (toggle && nav) {
    toggle.addEventListener('click', () => {
      const open = toggle.getAttribute('aria-expanded') !== 'true';
      toggle.setAttribute('aria-expanded', String(open));
      nav.classList.toggle('open', open);
    });
    nav.addEventListener('click', event => {
      if (event.target.closest('a')) closeMenu();
    });
    document.addEventListener('keydown', event => {
      if (event.key === 'Escape') closeMenu();
    });
  }

  // Real profile URLs remain usable without JavaScript and in a new tab.
  document.querySelectorAll('[data-profile-dialog]').forEach(link => {
    const dialog = document.getElementById(link.dataset.profileDialog);
    if (!dialog || typeof dialog.showModal !== 'function') return;
    link.setAttribute('aria-haspopup', 'dialog');
    link.setAttribute('aria-controls', dialog.id);
    link.addEventListener('click', event => {
      if (event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return;
      event.preventDefault();
      dialog.showModal();
      document.dispatchEvent(new Event('mdr-dialog-change'));
      document.documentElement.classList.add('dialog-open');
      dialog.addEventListener('close', () => {
        document.documentElement.classList.remove('dialog-open');
        link.focus({ preventScroll: true });
        document.dispatchEvent(new Event('mdr-dialog-change'));
      }, { once: true });
    });
  });
  document.querySelectorAll('.partner-dialog').forEach(dialog => {
    dialog.querySelector('[data-dialog-close]').addEventListener('click', () => dialog.close());
    dialog.addEventListener('click', event => {
      const bounds = dialog.getBoundingClientRect();
      if (event.target === dialog && (event.clientX < bounds.left || event.clientX > bounds.right || event.clientY < bounds.top || event.clientY > bounds.bottom)) {
        dialog.close();
      }
    });
  });

  const video = document.querySelector('#institutional-video');
  const button = document.querySelector('#video-toggle');
  if (video && button) {
    const reduced = window.matchMedia('(prefers-reduced-motion: reduce)');
    const stage = video.closest('.video-stage');
    const poster = stage.querySelector('.video-placeholder');
    let userControlled = false;
    const play = () => {
      if (!video.src) video.src = window.matchMedia('(max-width: 767px)').matches && video.dataset.srcMobile ? video.dataset.srcMobile : video.dataset.src;
      if (video.error) video.load();
      video.muted = true;
      video.play().catch(() => { button.textContent = 'Reproduzir vídeo'; });
    };
    const revealFrame = () => {
      if (video.readyState >= 2 && !video.paused) stage.classList.add('is-video-ready');
    };
    video.addEventListener('playing', () => {
      if ('requestVideoFrameCallback' in video) video.requestVideoFrameCallback(revealFrame);
      else revealFrame();
    });
    video.addEventListener('error', () => {
      stage.classList.remove('is-video-ready');
      button.textContent = 'Tentar vídeo novamente';
    });
    video.addEventListener('play', () => { button.textContent = 'Pausar vídeo'; });
    video.addEventListener('pause', () => { button.textContent = 'Reproduzir vídeo'; });
    button.addEventListener('click', () => {
      userControlled = true;
      if (video.paused) play();
      else video.pause();
    });
    reduced.addEventListener('change', event => {
      if (event.matches) video.pause();
    });
    const queueAutoplay = () => {
      if (reduced.matches || navigator.connection?.saveData || !video.paused || userControlled) return;
      const start = () => {
        if (!reduced.matches && !navigator.connection?.saveData && video.paused && !userControlled) play();
      };
      // Navigation and the high-priority cover paint before the film starts.
      requestAnimationFrame(() => requestAnimationFrame(() => {
        if ('requestIdleCallback' in window) window.requestIdleCallback(start, {timeout: 1600});
        else window.setTimeout(start, 120);
      }));
    };
    const afterPageLoad = () => {
      if (!poster || poster.complete) queueAutoplay();
      else {
        poster.addEventListener('load', queueAutoplay, {once: true});
        poster.addEventListener('error', queueAutoplay, {once: true});
      }
    };
    if (document.readyState === 'complete') afterPageLoad();
    else window.addEventListener('load', afterPageLoad, {once: true});
  }
})();

(() => {
  'use strict';
  const dialog = document.getElementById('certificate-lightbox');
  if (!dialog || typeof dialog.showModal !== 'function') return;
  const image = dialog.querySelector('img');
  const caption = dialog.querySelector('.certificate-caption');
  const original = dialog.querySelector('.certificate-original');
  document.querySelectorAll('.certificate-zoom').forEach(link => {
    link.setAttribute('aria-haspopup', 'dialog');
    link.addEventListener('click', event => {
      if (event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return;
      const thumb = link.querySelector('img');
      if (!thumb) return;
      event.preventDefault();
      image.src = link.href;
      image.alt = thumb.alt;
      caption.textContent = thumb.alt;
      original.href = link.href;
      dialog.showModal();
      document.documentElement.classList.add('dialog-open');
      dialog.addEventListener('close', () => {
        document.documentElement.classList.remove('dialog-open');
        image.removeAttribute('src');
        link.focus({preventScroll:true});
      }, {once:true});
    });
  });
  dialog.querySelector('button').addEventListener('click', () => dialog.close());
  dialog.addEventListener('click', event => {
    const bounds = dialog.getBoundingClientRect();
    if (event.target === dialog && (event.clientX < bounds.left || event.clientX > bounds.right || event.clientY < bounds.top || event.clientY > bounds.bottom)) dialog.close();
  });
})();

(() => {
  'use strict';
  document.querySelectorAll('[data-award-carousel]').forEach(carousel => {
    const track=carousel.querySelector('.award-track'), items=[...track.children], toggle=carousel.querySelector('[data-carousel-toggle]'), position=carousel.querySelector('[data-carousel-position]');
    if(!items.length){carousel.hidden=true;return;}
    const reduced=matchMedia('(prefers-reduced-motion: reduce)');
    let userPaused=false, hovered=false, focused=false, visible=false, timer=null;
    const metrics=()=>({step:items[0]?.getBoundingClientRect().width+parseFloat(getComputedStyle(track).gap||0),end:Math.max(0,track.scrollWidth-track.clientWidth)});
    const update=()=>{const {step}=metrics();position.textContent=Math.min(items.length,Math.round(track.scrollLeft/step)+1)+' / '+items.length;};
    const suspended=()=>userPaused||hovered||focused||!visible||document.hidden||reduced.matches||!!document.querySelector('dialog[open]');
    const advance=(direction)=>{const {step,end}=metrics();let target=track.scrollLeft+direction*step;if(direction>0&&track.scrollLeft>=end-3)target=0;if(direction<0&&track.scrollLeft<=3)target=end;track.scrollTo({left:Math.max(0,Math.min(end,target)),behavior:reduced.matches?'auto':'smooth'});};
    const schedule=()=>{clearTimeout(timer);if(!suspended())timer=setTimeout(()=>{if(!suspended())advance(1);schedule();},7000);toggle.textContent=userPaused?'Continuar apresentação':(reduced.matches?'Apresentação manual':'Pausar apresentação');toggle.setAttribute('aria-pressed',String(userPaused));};
    carousel.querySelector('[data-carousel-next]').addEventListener('click',()=>{userPaused=true;advance(1);schedule();});
    carousel.querySelector('[data-carousel-prev]').addEventListener('click',()=>{userPaused=true;advance(-1);schedule();});
    toggle.addEventListener('click',()=>{userPaused=!userPaused;schedule();});
    carousel.addEventListener('mouseenter',()=>{hovered=true;schedule();});carousel.addEventListener('mouseleave',()=>{hovered=false;schedule();});
    carousel.addEventListener('focusin',()=>{focused=true;schedule();});carousel.addEventListener('focusout',event=>{if(!carousel.contains(event.relatedTarget)){focused=false;schedule();}});
    track.addEventListener('pointerdown',()=>{userPaused=true;schedule();},{passive:true});
    track.addEventListener('scroll',update,{passive:true});window.addEventListener('resize',update,{passive:true});
    document.addEventListener('visibilitychange',schedule);document.addEventListener('mdr-dialog-change',schedule);reduced.addEventListener('change',schedule);
    if('IntersectionObserver'in window)new IntersectionObserver(entries=>{visible=entries[0].isIntersecting;schedule();},{threshold:.2}).observe(carousel);else visible=true;
    update();schedule();
  });
  document.querySelectorAll('[data-share-card]').forEach(button=>{
    button.addEventListener('click',async()=>{
      const status=button.closest('.digital-card-intro').querySelector('.share-status');
      try{if(navigator.share){await navigator.share({title:button.dataset.title,url:button.dataset.url});status.textContent='';}
      else if(navigator.clipboard){await navigator.clipboard.writeText(button.dataset.url);status.textContent='Link do cartão copiado.';}
      else{status.textContent='Compartilhe este endereço: '+button.dataset.url;}}
      catch(error){if(error.name!=='AbortError')status.textContent='Compartilhe o endereço desta página pelo navegador.';}
    });
  });
})();
