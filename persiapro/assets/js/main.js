/**
 * PersiaPro Main JavaScript
 *
 * @package PersiaPro
 * @since 1.0.0
 */

(function () {
	'use strict';

	var data = window.persiaproData || {};

	/**
	 * Mobile navigation toggle
	 */
	function initMobileNav() {
		var toggle = document.querySelector('.pp-nav-toggle');
		var nav = document.querySelector('.pp-nav');
		if (!toggle || !nav) return;

		var overlay = document.createElement('div');
		overlay.className = 'pp-nav-overlay';
		document.body.appendChild(overlay);

		function closeNav() {
			nav.classList.remove('is-open');
			overlay.classList.remove('is-visible');
			toggle.setAttribute('aria-expanded', 'false');
			document.body.style.overflow = '';
		}

		function openNav() {
			nav.classList.add('is-open');
			overlay.classList.add('is-visible');
			toggle.setAttribute('aria-expanded', 'true');
			document.body.style.overflow = 'hidden';
		}

		toggle.addEventListener('click', function () {
			if (nav.classList.contains('is-open')) {
				closeNav();
			} else {
				openNav();
			}
		});

		overlay.addEventListener('click', closeNav);

		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape') closeNav();
		});
	}

	/**
	 * Sticky / transparent header scroll behavior
	 */
	function initHeader() {
		var header = document.querySelector('.pp-header');
		if (!header) return;

		var isTransparent = header.classList.contains('pp-header--transparent');

		if (isTransparent || data.stickyHeader) {
			window.addEventListener('scroll', function () {
				if (window.scrollY > 50) {
					header.classList.add('pp-header--scrolled');
				} else {
					header.classList.remove('pp-header--scrolled');
				}
			}, { passive: true });
		}
	}

	/**
	 * Back to top button
	 */
	function initBackToTop() {
		if (!data.backToTop) return;

		var btn = document.querySelector('.pp-back-to-top');
		if (!btn) return;

		window.addEventListener('scroll', function () {
			if (window.scrollY > 400) {
				btn.classList.add('is-visible');
			} else {
				btn.classList.remove('is-visible');
			}
		}, { passive: true });

		btn.addEventListener('click', function () {
			window.scrollTo({ top: 0, behavior: 'smooth' });
		});
	}

	/**
	 * Scroll animations
	 */
	function initAnimations() {
		if (!('IntersectionObserver' in window)) return;

		var elements = document.querySelectorAll('.pp-post-card, .pp-material-card, .pp-animate');
		if (!elements.length) return;

		var observer = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (entry.isIntersecting) {
					entry.target.classList.add('is-visible', 'pp-animate');
					observer.unobserve(entry.target);
				}
			});
		}, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

		elements.forEach(function (el) {
			el.classList.add('pp-animate');
			observer.observe(el);
		});
	}

	/**
	 * Blog post slider on homepage
	 */
	function initSliders() {
		var sliders = document.querySelectorAll('.pp-slider');
		if (!sliders.length) return;

		sliders.forEach(function (slider) {
			var track = slider.querySelector('.pp-slider__track');
			var slides = slider.querySelectorAll('.pp-slider__slide');
			var prevBtn = slider.closest('.pp-container').querySelector('.pp-slider__btn--prev');
			var nextBtn = slider.closest('.pp-container').querySelector('.pp-slider__btn--next');
			var dotsContainer = slider.querySelector('.pp-slider__dots');

			if (!track || slides.length === 0) return;

			var desktopSlides = parseInt(slider.getAttribute('data-slides-desktop'), 10) || 3;
			var currentIndex = 0;
			var visibleCount = getVisibleCount();
			var maxIndex = Math.max(0, slides.length - visibleCount);

			function getVisibleCount() {
				if (window.innerWidth <= 768) return 1;
				if (window.innerWidth <= 992) return 2;
				return desktopSlides;
			}

			function updateSlider() {
				visibleCount = getVisibleCount();
				maxIndex = Math.max(0, slides.length - visibleCount);
				if (currentIndex > maxIndex) currentIndex = maxIndex;

				var slideWidth = slides[0].offsetWidth;
				var gap = 24;
				var offset = currentIndex * (slideWidth + gap);
				var isRtl = document.documentElement.getAttribute('dir') === 'rtl';
				var translate = isRtl ? offset : -offset;
				track.style.transform = 'translateX(' + translate + 'px)';

				if (prevBtn) prevBtn.disabled = currentIndex <= 0;
				if (nextBtn) nextBtn.disabled = currentIndex >= maxIndex;

				updateDots();
			}

			function buildDots() {
				if (!dotsContainer) return;
				dotsContainer.innerHTML = '';
				var dotCount = maxIndex + 1;
				if (dotCount <= 1) return;

				for (var i = 0; i <= maxIndex; i++) {
					var dot = document.createElement('button');
					dot.className = 'pp-slider__dot' + (i === currentIndex ? ' is-active' : '');
					dot.setAttribute('aria-label', 'Slide ' + (i + 1));
					dot.dataset.index = i;
					dot.addEventListener('click', function () {
						currentIndex = parseInt(this.dataset.index, 10);
						updateSlider();
					});
					dotsContainer.appendChild(dot);
				}
			}

			function updateDots() {
				if (!dotsContainer) return;
				var dots = dotsContainer.querySelectorAll('.pp-slider__dot');
				dots.forEach(function (dot, i) {
					dot.classList.toggle('is-active', i === currentIndex);
				});
			}

			if (prevBtn) {
				prevBtn.addEventListener('click', function () {
					if (currentIndex > 0) {
						currentIndex--;
						updateSlider();
					}
				});
			}

			if (nextBtn) {
				nextBtn.addEventListener('click', function () {
					if (currentIndex < maxIndex) {
						currentIndex++;
						updateSlider();
					}
				});
			}

			var touchStartX = 0;
			slider.addEventListener('touchstart', function (e) {
				touchStartX = e.changedTouches[0].screenX;
			}, { passive: true });

			slider.addEventListener('touchend', function (e) {
				var diff = touchStartX - e.changedTouches[0].screenX;
				if (Math.abs(diff) > 50) {
					if (diff > 0 && currentIndex < maxIndex) currentIndex++;
					else if (diff < 0 && currentIndex > 0) currentIndex--;
					updateSlider();
				}
			}, { passive: true });

			var resizeTimer;
			window.addEventListener('resize', function () {
				clearTimeout(resizeTimer);
				resizeTimer = setTimeout(function () {
					buildDots();
					updateSlider();
				}, 150);
			});

			buildDots();
			updateSlider();
		});
	}

	/**
	 * Initialize on DOM ready
	 */
	function init() {
		initMobileNav();
		initHeader();
		initBackToTop();
		initAnimations();
		initSliders();
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
