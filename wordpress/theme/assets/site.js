(() => {
  'use strict';
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
    const play = () => {
      if (!video.src) video.src = video.dataset.src;
      video.muted = true;
      video.play().catch(() => { button.textContent = 'Reproduzir vídeo'; });
    };
    video.addEventListener('play', () => { button.textContent = 'Pausar vídeo'; });
    video.addEventListener('pause', () => { button.textContent = 'Reproduzir vídeo'; });
    button.addEventListener('click', () => {
      if (video.paused) play();
      else video.pause();
    });
    reduced.addEventListener('change', event => {
      if (event.matches) video.pause();
    });
    if (!reduced.matches) play();
  }
})();
