/* ========================================================================
 * typography.js
 * Page/renders: components-typography.html
 * Plugins used: prettify
 * ======================================================================== */

/* global prettyPrint */

'use strict';

(function (factory) {
    if (typeof define === 'function' && define.amd) {
        define([
            'prettify'
        ], factory);
    } else {
        factory();
    }
}(function () {

    $(function () {
        // Prettify
        // ================================
        prettyPrint();
    });
    
}));