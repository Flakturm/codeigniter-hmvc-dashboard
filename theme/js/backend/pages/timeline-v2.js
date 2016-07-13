/* ========================================================================
 * timeline-v2.js
 * Page/renders: page-timeline-v2.html
 * Plugins used: stellar
 * ======================================================================== */

'use strict';

(function (factory) {
    if (typeof define === 'function' && define.amd) {
        define([
            'stellar'
        ], factory);
    } else {
        factory();
    }
}(function () {

    $(function () {
        // Stellar
        // ================================
        $.stellar({
            horizontalScrolling: false
        });
    });
    
}));