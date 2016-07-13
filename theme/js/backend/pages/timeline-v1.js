/* ========================================================================
 * timeline-v1.js
 * Page/renders: page-timeline-v1.html
 * Plugins used: magnific-popup, stellar
 * ======================================================================== */

'use strict';

(function (factory) {
    if (typeof define === 'function' && define.amd) {
        define([
            'magnific',
            'stellar'
        ], factory);
    } else {
        factory();
    }
}(function () {

    $(function () {
        // Magnific Popup
        // ================================
        $('#photo-list').magnificPopup({
            delegate: '.magnific',
            type: 'image',
            gallery: {
                enabled: true
            }
        });

        // Stellar
        // ================================
        $.stellar({
            horizontalScrolling: false
        });
    });
    
}));