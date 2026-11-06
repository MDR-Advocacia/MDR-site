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
      document.documentElement.classList.add('dialog-open');
      dialog.addEventListener('close', () => {
        document.documentElement.classList.remove('dialog-open');
        link.focus({ preventScroll: true });
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
    const play = () => {
      if (!video.src) video.src = video.dataset.src;
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
      if (video.paused) play();
      else video.pause();
    });
    reduced.addEventListener('change', event => {
      if (event.matches) video.pause();
    });
    const queueAutoplay = () => {
      if (reduced.matches || navigator.connection?.saveData || !video.paused) return;
      const start = () => {
        if (!reduced.matches && !navigator.connection?.saveData && video.paused) play();
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
