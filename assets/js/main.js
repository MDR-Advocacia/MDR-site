(function() {
  "use strict";

  /**
   * Apply .scrolled class to the body as the page is scrolled down
   */
  function toggleScrolled() {
    const selectBody = document.querySelector('body');
    const selectHeader = document.querySelector('#header');
    if (!selectHeader || (!selectHeader.classList.contains('scroll-up-sticky') && !selectHeader.classList.contains('sticky-top') && !selectHeader.classList.contains('fixed-top'))) return;
    window.scrollY > 100 ? selectBody.classList.add('scrolled') : selectBody.classList.remove('scrolled');
  }

  document.addEventListener('scroll', toggleScrolled);
  window.addEventListener('load', toggleScrolled);

  /**
   * Mobile nav toggle
   */
  const mobileNavToggleBtn = document.querySelector('.mobile-nav-toggle');

  if (mobileNavToggleBtn) {
    function mobileNavToogle() {
      document.querySelector('body').classList.toggle('mobile-nav-active');
      mobileNavToggleBtn.classList.toggle('bi-list');
      mobileNavToggleBtn.classList.toggle('bi-x');
    }
    mobileNavToggleBtn.addEventListener('click', mobileNavToogle);
  }

  /**
   * Hide mobile nav on same-page/hash links
   */
  document.querySelectorAll('#navmenu a').forEach(navmenu => {
    navmenu.addEventListener('click', () => {
      if (document.querySelector('.mobile-nav-active')) {
        mobileNavToogle();
      }
    });
  });

  /**
   * Toggle mobile nav dropdowns
   */
  document.querySelectorAll('.navmenu .toggle-dropdown').forEach(navmenu => {
    navmenu.addEventListener('click', function(e) {
      e.preventDefault();
      this.parentNode.classList.toggle('active');
      this.parentNode.nextElementSibling.classList.toggle('dropdown-active');
      e.stopImmediatePropagation();
    });
  });

  /**
   * Preloader
   */
  const preloader = document.querySelector('#preloader');
  if (preloader) {
    window.addEventListener('load', () => {
      preloader.remove();
    });
  }

  /**
   * Scroll top button
   */
  let scrollTop = document.querySelector('.scroll-top');

  function toggleScrollTop() {
    if (scrollTop) {
      window.scrollY > 100 ? scrollTop.classList.add('active') : scrollTop.classList.remove('active');
    }
  }
  if (scrollTop) {
    scrollTop.addEventListener('click', (e) => {
      e.preventDefault();
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
    window.addEventListener('load', toggleScrollTop);
    document.addEventListener('scroll', toggleScrollTop);
  }

  /**
   * Animation on scroll function and init
   */
  function aosInit() {
    AOS.init({
      duration: 600,
      easing: 'ease-in-out',
      once: true,
      mirror: false
    });
  }
  window.addEventListener('load', aosInit);

  /**
   * Initiate glightbox
   */
  const glightbox = GLightbox({
    selector: '.glightbox'
  });

  /**
   * Init swiper sliders
   */
  function initSwiper() {
    document.querySelectorAll(".init-swiper").forEach(function(swiperElement) {
      let config = JSON.parse(
        swiperElement.querySelector(".swiper-config").innerHTML.trim()
      );

      if (swiperElement.classList.contains("swiper-tab")) {
        initSwiperWithCustomPagination(swiperElement, config);
      } else {
        new Swiper(swiperElement, config);
      }
    });
  }

  window.addEventListener("load", initSwiper);

  /**
   * Init isotope layout and filters
   */
  document.querySelectorAll('.isotope-layout').forEach(function(isotopeItem) {
    let layout = isotopeItem.getAttribute('data-layout') ?? 'masonry';
    let filter = isotopeItem.getAttribute('data-default-filter') ?? '*';
    let sort = isotopeItem.getAttribute('data-sort') ?? 'original-order';

    let initIsotope;
    imagesLoaded(isotopeItem.querySelector('.isotope-container'), function() {
      initIsotope = new Isotope(isotopeItem.querySelector('.isotope-container'), {
        itemSelector: '.isotope-item',
        layoutMode: layout,
        filter: filter,
        sortBy: sort
      });
    });

    isotopeItem.querySelectorAll('.isotope-filters li').forEach(function(filters) {
      filters.addEventListener('click', function() {
        isotopeItem.querySelector('.isotope-filters .filter-active').classList.remove('filter-active');
        this.classList.add('filter-active');
        initIsotope.arrange({
          filter: this.getAttribute('data-filter')
        });
        if (typeof aosInit === 'function') {
          aosInit();
        }
      }, false);
    });

  });

  /**
   * Script para a seção de Prêmios (Página Prêmios)
   */
  const awardLinks = document.querySelectorAll('.award-list-item');
  const awardItems = document.querySelectorAll('.featured-award-item');

  if (awardLinks.length > 0 && awardItems.length > 0) {
    awardLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.dataset.target;
            awardItems.forEach(item => item.classList.remove('visible-award'));
            awardLinks.forEach(l => l.classList.remove('active-award'));
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
              targetElement.classList.add('visible-award');
            }
            this.classList.add('active-award');
        });
    });
  }

  /**
   * Lógica para a página de Prêmios e Certificados (Carrosséis)
   */
  
  // --- LÓGICA PARA OS CARROSSÉIS DA SEÇÃO DE RECONHECIMENTOS ---
  function initCarousel(yearGroupId) {
      const yearGroup = document.getElementById(yearGroupId);
      if (!yearGroup) return;

      const descriptionSwiperEl = yearGroup.querySelector('.swiper-description');
      const sealLinks = yearGroup.querySelectorAll('.seals-grid .seal-item a');

      if (!descriptionSwiperEl || sealLinks.length === 0) return;

      const swiper = new Swiper(descriptionSwiperEl, {
          loop: true,
          autoplay: { delay: 15000, disableOnInteraction: false },
          observer: true,
          observeParents: true,
          autoHeight: true, // ajustar altura
      });

      sealLinks.forEach((sealLink, index) => {
          sealLink.addEventListener('mouseenter', () => {
              swiper.slideToLoop(index);
          });
          sealLink.addEventListener('click', (e) => {
              if (sealLink.getAttribute('href') === '#') {
                  e.preventDefault(); 
              }
              swiper.slideToLoop(index);
          });
      });

      swiper.on('slideChange', function() {
          sealLinks.forEach(link => link.classList.remove('thumb-active'));
          if (sealLinks[swiper.realIndex]) {
              sealLinks[swiper.realIndex].classList.add('thumb-active');
          }
      });

      if (sealLinks.length > 0) {
          sealLinks[0].classList.add('thumb-active');
      }
  }

  // Verifica se estamos na página de prêmios antes de rodar
  if (document.getElementById('year-2025')) {
    initCarousel('year-2026');
    initCarousel('year-2025');
    initCarousel('year-2024');
  }

  // --- LÓGICA PARA O CARROSSEL DE CERTIFICADOS ---
  const certificatesSwiperEl = document.querySelector('.certificates-swiper');
  if (certificatesSwiperEl) {
    new Swiper(certificatesSwiperEl, {
        loop: true,
        speed: 500,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        slidesPerView: 'auto',
        spaceBetween: 30,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            320: { slidesPerView: 1, spaceBetween: 20 },
            576: { slidesPerView: 2, spaceBetween: 20 },
            768: { slidesPerView: 3, spaceBetween: 30 },
            1200: { slidesPerView: 4, spaceBetween: 30 }
        }
    });
  }

  // --- LÓGICA PARA O MODAL (LIGHTBOX) DOS CERTIFICADOS ---
  const modal = document.getElementById("certificateModal");
  if (modal) {
    const modalImg = document.getElementById("modalImage");
    const closeModal = document.querySelector(".close-modal");
    const certificateImages = document.querySelectorAll(".open-modal");

    certificateImages.forEach(img => {
        img.onclick = function() {
            modal.style.display = "flex";
            modalImg.src = this.src;
        }
    });

    function hideModal() {
        modal.style.display = "none";
    }

    closeModal.onclick = hideModal;

    modal.onclick = function(event) {
        if (event.target === modal) {
            hideModal();
        }
    }
  }

})();