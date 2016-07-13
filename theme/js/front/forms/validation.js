/* ========================================================================
 * validation.js
 * Page/renders: forms-validation.html
 * Plugins used: selectize, parsley
 * ======================================================================== */

'use strict';

(function (factory) {
    if (typeof define === 'function' && define.amd) {
        define([
            'selectize',
            'parsley'
        ], factory);
    } else {
        factory();
    }
}(function () {

    $(function () {
        // custom select
        // ================================
        $('select').selectize();
    });
    
}));