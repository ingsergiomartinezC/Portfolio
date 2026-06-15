/**
 * Mi Tema Hijo — main.js
 * Scripts principales del tema.
 *
 * Módulos:
 *   - Menú mobile (hamburguesa)
 *   - Header sticky con sombra dinámica
 *   - Smooth scroll para anclas internas
 *   - Lazy load de imágenes (fallback para navegadores sin soporte nativo)
 */

(function () {
  'use strict';

  // ─────────────────────────────────────────
  // MENÚ MOBILE
  // ─────────────────────────────────────────
  const menuToggle = document.querySelector('.menu-toggle');
  const primaryNav = document.querySelector('.primary-nav');

  if (menuToggle && primaryNav) {
    menuToggle.addEventListener('click', () => {
      const isOpen = primaryNav.classList.toggle('is-open');
      menuToggle.setAttribute('aria-expanded', isOpen);
      menuToggle.setAttribute('aria-label', isOpen ? 'Cerrar menú' : 'Abrir menú');
      document.body.style.overflow = isOpen ? 'hidden' : '';
    });

    // Cerrar menú al hacer clic fuera
    document.addEventListener('click', (e) => {
      if (!menuToggle.contains(e.target) && !primaryNav.contains(e.target)) {
        primaryNav.classList.remove('is-open');
        menuToggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
      }
    });

    // Cerrar con tecla Escape
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && primaryNav.classList.contains('is-open')) {
        primaryNav.classList.remove('is-open');
        menuToggle.setAttribute('aria-expanded', 'false');
        menuToggle.focus();
        document.body.style.overflow = '';
      }
    });
  }

  // ─────────────────────────────────────────
  // HEADER: sombra al hacer scroll
  // ─────────────────────────────────────────
  const header = document.querySelector('.site-header');

  if (header) {
    const updateHeader = () => {
      header.classList.toggle('is-scrolled', window.scrollY > 20);
    };
    window.addEventListener('scroll', updateHeader, { passive: true });
    updateHeader(); // Estado inicial
  }

  // ─────────────────────────────────────────
  // SMOOTH SCROLL para anclas internas
  // ─────────────────────────────────────────
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener('click', (e) => {
      const target = document.querySelector(anchor.getAttribute('href'));
      if (target) {
        e.preventDefault();
        const headerH = header ? header.offsetHeight : 0;
        const targetY = target.getBoundingClientRect().top + window.scrollY - headerH - 16;
        window.scrollTo({ top: targetY, behavior: 'smooth' });
      }
    });
  });

  // ─────────────────────────────────────────
  // LAZY LOAD de imágenes (fallback)
  // ─────────────────────────────────────────
  if ('IntersectionObserver' in window) {
    const lazyImages = document.querySelectorAll('img[data-src]');
    const imgObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            const img = entry.target;
            img.src = img.dataset.src;
            if (img.dataset.srcset) img.srcset = img.dataset.srcset;
            img.removeAttribute('data-src');
            imgObserver.unobserve(img);
          }
        });
      },
      { rootMargin: '200px 0px' }
    );
    lazyImages.forEach((img) => imgObserver.observe(img));
  }

})();
