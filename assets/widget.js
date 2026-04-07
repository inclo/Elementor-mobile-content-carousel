(function($){
  function initMobileCarousel(scope){
    var $root = $(scope).find('.emc-mobile-carousel');
    if(!$root.length){ return; }

    $root.each(function(){
      var el = this;
      if (el.dataset.emcInitialized === 'true') { return; }

      var config = {};
      try {
        config = JSON.parse(el.dataset.emcConfig || '{}');
      } catch(e) {
        config = {};
      }

      if (window.innerWidth > (config.breakpoint || 767)) {
        return;
      }

      var swiperEl = el.querySelector('.emc-swiper');
      if (!swiperEl || typeof Swiper === 'undefined') {
        return;
      }

      var swiper = new Swiper(swiperEl, {
        loop: !!config.loop,
        slidesPerView: config.slidesPerView || 1.15,
        spaceBetween: config.spaceBetween || 12,
        speed: 600,
        watchOverflow: true,
        autoplay: config.autoplay ? {
          delay: config.autoplayDelay || 2500,
          disableOnInteraction: false,
          pauseOnMouseEnter: !!config.pauseOnHover
        } : false,
        pagination: config.showPagination ? {
          el: el.querySelector('.emc-pagination'),
          clickable: true
        } : false,
        navigation: config.showArrows ? {
          nextEl: el.querySelector('.emc-nav-next'),
          prevEl: el.querySelector('.emc-nav-prev')
        } : false,
        breakpoints: {
          0: { slidesPerView: config.slidesPerView || 1.15 },
          480: { slidesPerView: Math.max(1.05, config.slidesPerView || 1.15) }
        }
      });

      el.dataset.emcInitialized = 'true';
      el.emcSwiper = swiper;
    });
  }

  $(window).on('elementor/frontend/init', function() {
    if (window.elementorFrontend && window.elementorFrontend.hooks) {
      elementorFrontend.hooks.addAction('frontend/element_ready/emc_mobile_carousel.default', initMobileCarousel);
      elementorFrontend.hooks.addAction('frontend/element_ready/emc_mobile_carousel_nested.default', initMobileCarousel);
    }
  });

  $(document).ready(function(){
    initMobileCarousel(document);
  });
})(jQuery);
