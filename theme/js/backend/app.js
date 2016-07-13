/* ========================================================================
 * App.js v1.3.0
 * Copyright 2014 pampersdry
 * ======================================================================== */

'use strict';

(function (factory) {
    if (typeof define === 'function' && define.amd) {
        define([
            'core'
        ], factory);
    } else {
        factory();
    }
}(function () {

    var APP = {
        // Core init
        // NOTE: init at html element
        // ================================
        init: function () {
            $('html').Core({
                loader: false,
                console: false
            });
        },

        // Template sidebar sparklines
        // NOTE: require sparkline plugin
        // ================================
        sidebarSparklines: {
            init: function () {
                $('aside .sidebar-sparklines').sparkline('html', { enableTagOptions: true });
            }
        },

        // Template header dropdown
        // ================================
        headerDropdown: {
            init: function (options) {
                // core dropdown function
                function coreDropdown (e) {
                    // define variable
                    var $target         = $(e.target),
                        $mediaList      = $target.find('.media-list'),
                        $indicator      = $target.find('.indicator');

                    // show indicator
                    $indicator
                        .addClass('animation animating fadeInDown')
                        .one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                            $(this).removeClass('animation animating fadeInDown');
                        });

                    // Check for content via ajax
                    $.ajax({
                        url: options.url,
                        cache: false,
                        type: 'POST',
                        dataType: 'json'
                    }).done(function (data) {
                        // define some variable
                        var template    = $target.find('.mustache-template').html(),
                            rendered    = Mustache.render(template, data);

                        // hide indicator
                        $indicator.addClass('hide');

                        // update data total
                        $target.find('.count').html('('+data.data.length+')');

                        // render mustache template
                        $mediaList.prepend(rendered);

                        // add some intro animation
                        $mediaList.find('.media.new').each(function () {
                            $(this)
                                .addClass('animation animating flipInX')
                                .one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                                    $(this).removeClass('animation animating flipInX');
                                });
                        });
                    });
                }

                // the dropdown
                $(options.dropdown).one('shown.bs.dropdown', coreDropdown);
            }
        }
    };

    $(function () {
        // Init template core
        APP.init();

        // Init template sidebar summary
        APP.sidebarSparklines.init();

        // Init template message dropdown
        APP.headerDropdown.init({
            'dropdown': '#header-dd-message',
            'url': '../api/message.php'
        });

        // Init template notification dropdown
        APP.headerDropdown.init({
            'dropdown': '#header-dd-notification',
            'url': '../api/notification.php'
        });
    });
    
}));