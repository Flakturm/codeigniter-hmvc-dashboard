/* ========================================================================
 * carousel.js
 * Page/renders: components-carousel.html
 * Plugins used: owl carousel
 * ======================================================================== */
'use strict';

(function (factory) {
    if (typeof define === 'function' && define.amd) {
        define([
            'owl-carousel'
        ], factory);
    } else {
        factory();
    }
}(function () {

    $(function () {
        // Carousel
        // ================================
        // default
        $('#default').owlCarousel();

        // autoplay
        $('#auto-play').owlCarousel({
            autoPlay: true
        });

        // lazy load
        $('#lazy-load').owlCarousel({
            lazyLoad : true
        });

        // one slide
        $('#one-slide').owlCarousel({
            navigation: true,
            singleItem: true
        });
    });
    
}));