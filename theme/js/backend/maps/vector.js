/* ========================================================================
 * vector.js
 * Page/renders: maps-vector.html
 * Plugins used: jqvmap
 * ======================================================================== */

/* jshint camelcase: false */
/* global sample_data */

'use strict';

(function (factory) {
    if (typeof define === 'function' && define.amd) {
        define([
            'jqvmap'
        ], factory);
    } else {
        factory();
    }
}(function () {

    $(function () {
        // World map
        // ================================
        $.when(
            $.getScript('../plugins/jqvmap/js/data/jquery.vmap.sampledata.js'),
            $.getScript('../plugins/jqvmap/js/maps/jquery.vmap.world.js'),
            $.Deferred(function (deferred) {
                $(deferred.resolve);
            })
        ).done(function () {
            // hide loading indicator
            $('#world-map').parents('.panel').find('.indicator').removeClass('show');
            $('#map-marker').parents('.panel').find('.indicator').removeClass('show');

            // init the map
            $('#world-map').vectorMap({
                map: 'world_en',
                backgroundColor: 'transparent',
                color: '#666',
                hoverOpacity: 0.7,
                enableZoom: true,
                showTooltip: true,
                values: sample_data,
                scaleColors: ['#00B1E1', '#91C854', '#63D3E9', '#FFD66A', '#ED5466'],
                normalizeFunction: 'polynomial'
            });

            // marker example
            $('#map-marker').vectorMap({
                map: 'world_en',
                backgroundColor: 'transparent',
                color: '#666',
                hoverOpacity: 0.7,
                enableZoom: true,
                showTooltip: true,
                values: sample_data,
                scaleColors: ['#00B1E1', '#91C854', '#63D3E9', '#FFD66A', '#ED5466'],
                normalizeFunction: 'polynomial',
                pins: {
                    // marker style-1
                    'ru':'<a href="javascript:void(0)" class="marker marker-1-1"></a>',
                    'lb':'<a href="javascript:void(0)" class="marker marker-1-2"></a>',
                    'br':'<a href="javascript:void(0)" class="marker marker-1-3"></a>',
                    'au':'<a href="javascript:void(0)" class="marker marker-1-4"></a>',
                    'my':'<a href="javascript:void(0)" class="marker marker-1-5"></a>',

                    // marker style-2
                    'in':'<a href="javascript:void(0)" class="marker marker-2-1"></a>',
                    'ca':'<a href="javascript:void(0)" class="marker marker-2-2"></a>',
                    'cg':'<a href="javascript:void(0)" class="marker marker-2-3"></a>',
                    'dz':'<a href="javascript:void(0)" class="marker marker-2-4"></a>',
                    'gl':'<a href="javascript:void(0)" class="marker marker-2-5"></a>'
                }
            });
        });

        // Continents - asia
        // ================================
        $.when(
            $.getScript('../plugins/jqvmap/js/maps/continents/jquery.vmap.asia.js'),
            $.Deferred(function (deferred) {
                $(deferred.resolve);
            })
        ).done(function () {
            // hide loading indicator
            $('#map-asia').parents('.panel').find('.indicator').removeClass('show');

            // init the map
            $('#map-asia').vectorMap({
                map: 'asia_en',
                backgroundColor: 'transparent',
                color: '#666',
                hoverOpacity: 0.7,
                enableZoom: false,
                showTooltip: true,
                normalizeFunction: 'polynomial'
            });
        });

        // Continents - europe
        // ================================
        $.when(
            $.getScript('../plugins/jqvmap/js/maps/continents/jquery.vmap.europe.js'),
            $.Deferred(function (deferred) {
                $(deferred.resolve);
            })
        ).done(function () {
            // hide loading indicator
            $('#map-europe').parents('.panel').find('.indicator').removeClass('show');

            // init the map
            $('#map-europe').vectorMap({
                map: 'europe_en',
                backgroundColor: 'transparent',
                color: '#666',
                hoverOpacity: 0.7,
                enableZoom: false,
                showTooltip: true,
                normalizeFunction: 'polynomial'
            });
        });

        // Continents - Australia
        // ================================
        $.when(
            $.getScript('../plugins/jqvmap/js/maps/continents/jquery.vmap.australia.js'),
            $.Deferred(function (deferred) {
                $(deferred.resolve);
            })
        ).done(function () {
            // hide loading indicator
            $('#map-australia').parents('.panel').find('.indicator').removeClass('show');

            // init the map
            $('#map-australia').vectorMap({
                map: 'australia_en',
                backgroundColor: 'transparent',
                color: '#666',
                hoverOpacity: 0.7,
                enableZoom: false,
                showTooltip: true,
                normalizeFunction: 'polynomial'
            });
        });

        // Continents - Africa
        // ================================
        $.when(
            $.getScript('../plugins/jqvmap/js/maps/continents/jquery.vmap.africa.js'),
            $.Deferred(function (deferred) {
                $(deferred.resolve);
            })
        ).done(function () {
            // hide loading indicator
            $('#map-africa').parents('.panel').find('.indicator').removeClass('show');

            // init the map
            $('#map-africa').vectorMap({
                map: 'africa_en',
                backgroundColor: 'transparent',
                color: '#666',
                hoverOpacity: 0.7,
                enableZoom: false,
                showTooltip: true,
                normalizeFunction: 'polynomial'
            });
        });

        // Continents - North America
        // ================================
        $.when(
            $.getScript('../plugins/jqvmap/js/maps/continents/jquery.vmap.north-america.js'),
            $.Deferred(function (deferred) {
                $(deferred.resolve);
            })
        ).done(function () {
            // hide loading indicator
            $('#map-north-america').parents('.panel').find('.indicator').removeClass('show');

            // init the map
            $('#map-north-america').vectorMap({
                map: 'north-america_en',
                backgroundColor: 'transparent',
                color: '#666',
                hoverOpacity: 0.7,
                enableZoom: false,
                showTooltip: true,
                normalizeFunction: 'polynomial'
            });
        });

        // Continents - South America
        // ================================
        $.when(
            $.getScript('../plugins/jqvmap/js/maps/continents/jquery.vmap.south-america.js'),
            $.Deferred(function (deferred) {
                $(deferred.resolve);
            })
        ).done(function () {
            // hide loading indicator
            $('#map-south-america').parents('.panel').find('.indicator').removeClass('show');

            // init the map
            $('#map-south-america').vectorMap({
                map: 'south-america_en',
                backgroundColor: 'transparent',
                color: '#666',
                hoverOpacity: 0.7,
                enableZoom: false,
                showTooltip: true,
                normalizeFunction: 'polynomial'
            });
        });
    });

}));