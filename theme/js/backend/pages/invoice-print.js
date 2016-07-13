/* ========================================================================
* invoice-print.js
* Page/renders: page-invoice-printable.html
* Plugins used: 
* ======================================================================== */

'use strict';

(function (factory) {
    if (typeof define === 'function' && define.amd) {
        define([], factory);
    } else {
        factory();
    }
}(function () {

    $(function () {
        // Popup browser Print
        // ================================
        window.print();
    });
    
}));