/* ========================================================================
 * google.js
 * Page/renders: maps-google.html
 * Plugins used: gmaps
 * ======================================================================== */

/* global GMaps */

'use strict';

(function (factory) {
    if (typeof define === 'function' && define.amd) {
        define([
            'tinyMap'
        ], factory);
    } else {
        factory();
    }
}(function () {

    $(function () {
        // tinyMap
        // ================================
        var shop_name = $('#shop-name').text();
        var address = $('#shop-addr').text();
        var body = '<b>' + shop_name + '<br>' + address + '</b>';
        $('#map').tinyMap({
            'center': address,
            'zoom'  : 17,
            'marker': [
                {
                    'addr': address,
                    'text': body,
                    'animation': 'DROP'
                }
            ]
        });
    });

}));