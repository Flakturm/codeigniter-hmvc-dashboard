/* ========================================================================
 * Core v1.3.0
 * Copyright 2015 pampersdry
 * ======================================================================== */

/* global Waypoint */

'use strict';

(function (factory) {
    if (typeof define === 'function' && define.amd) {
        define([
            'fastclick',
            'responsejs',
            'unveil',
            'placeholder',
            'waypoint',
            'waypoint.inview',
            'transit',
            'slimscroll'
        ], factory);
    } else {
        factory();
    }
}(function () {

    // Create the defaults once
    // ================================
    var pluginName  = 'Core',
        defaults    = {
            console: false,
            loader: false,
            eventPrefix: 'fa',
            breakpoint: {
                'lg': 1200,
                'md': 992,
                'sm': 768,
                'xs': 480
            }
        },
        isMinimize = false,
        isScreenlg = false,
        isScreenmd = false,
        isScreensm = false,
        isScreenxs = false;

    // Core MAIN function
    // ================================
    function MAIN(element, options) {
        this.element    = element;
        this.settings   = $.extend({}, defaults, options);
        this._defaults  = defaults;
        this._name      = pluginName;
        this.init();
    }

    // Core MAIN function prototype
    // ================================
    MAIN.prototype = {
        init: function () {
            this.VIEWPORTWATCH();
            this.MISC.Init();
            this.PLUGINS();
        },

        // Viewport watcher
        // ================================
        VIEWPORTWATCH: function () {
            var element = this.element;
            var settings = this.settings;

            Response.action(function () {
                // main content min height hack
                //$('#main').css({ 'min-height': $(window).height() });

                isScreenlg = Response.band(settings.breakpoint.lg);
                isScreenmd = Response.band(settings.breakpoint.md, settings.breakpoint.lg-1);
                isScreensm = Response.band(settings.breakpoint.sm, settings.breakpoint.md-1);
                isScreenxs = Response.band(0, settings.breakpoint.xs);

                if(isScreenlg) {
                    $(element)
                        .addClass('screen-lg')
                        .removeClass('screen-md')
                        .removeClass('screen-sm')
                        .removeClass('screen-xs');
                }

                if(isScreenmd) {
                    $(element)
                        .removeClass('screen-lg')
                        .addClass('screen-md')
                        .removeClass('screen-sm')
                        .removeClass('screen-xs');
                }

                if(isScreensm) {
                    $(element)
                        .removeClass('screen-lg')
                        .removeClass('screen-md')
                        .addClass('screen-sm')
                        .removeClass('screen-xs');
                }

                if(isScreenxs) {
                    $(element)
                        .removeClass('screen-lg')
                        .removeClass('screen-md')
                        .removeClass('screen-sm')
                        .addClass('screen-xs');
                }
            });
        },

        // Misc
        // ================================
        MISC: {
            // @MISC: Init
            Init: function () {
                this.ConsoleFix();
                this.Scrollbar('.slimscroll');
                this.Fastclick();
                this.Unveil();
                this.BsTooltip();
                this.BsPopover();
                this.BsHoverDropdown();
                this.InputPlaceholder();
            },

            // @MISC: ConsoleFix
            // Per call
            // ================================
            ConsoleFix: function () {
                var method,
                    noop = function () {},
                    methods = [
                        'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
                        'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
                        'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
                        'timeStamp', 'trace', 'warn'
                    ],
                    length = methods.length,
                    console = (window.console = window.console || {});

                while (length--) {
                    method = methods[length];

                    // Only stub undefined methods.
                    if (!console[method]) {
                        console[method] = noop;
                    }
                }
            },

            // @MISC: Scrollbar
            // Per call
            // ================================
            Scrollbar: function (elem) {
                $('.no-touch '+elem).each(function (index, value) {
                    $(value).slimScroll({
                        size: '8px',
                        height: false,
                        distance: '0px',
                        wrapperClass: $(value).data('wrapper') || 'viewport',
                        railClass: 'scrollrail',
                        barClass: 'scrollbar',
                        wheelStep: 10,
                        railVisible: false
                    });
                });
            },

            // @MISC: Fastclick
            // Per call
            // ================================
            Fastclick: function () {
                FastClick.attach(document.body);
            },

            // @MISC: Unveil - lazyload images
            // Per call
            // ================================
            Unveil: function () {
                $('[data-toggle~=unveil]').unveil(200, function () {
                    $(this).load(function () {
                        $(this).addClass('unveiled');
                    });
                });
            },

            // @MISC: BsTooltip - Bootstrap tooltip
            // Per call
            // ================================
            BsTooltip: function () {
                $('[data-toggle~=tooltip]').tooltip();
            },

            // @MISC: BsPopover - Bootstrap popover
            // Per call
            // ================================
            BsPopover: function () {
                $('[data-toggle~=popover]').popover();
            },

            // @MISC: BsHoverDropdown - Bootstrap hover dropdown
            // Per call
            // ================================
            BsHoverDropdown: function () {
                $('[data-toggle="dropdown"].dropdown-hover').dropdownHover().dropdown();
            },

            // @MISC: IE9 input placeholder support
            // Per call
            // ================================
            InputPlaceholder: function () {
                $('input, textarea').placeholder();
            }
        },

        // Custom Mini Plugins
        // ================================
        PLUGINS: function () {
            var element = this.element;
            var settings = this.settings;

            // @PLUGIN: ToTop
            // Self invoking
            // ================================
            (function () {
                var toggler     = '[data-toggle~=totop]';

                // toggler
                $(element).on('click', toggler, function (e) {
                    $('html, body').animate({
                        scrollTop: 0
                    }, 200);

                    e.preventDefault();
                });
            })();

            // @PLUGIN: WayPoint
            // Self invoking
            // ================================
            (function () {
                var toggler     = '[data-toggle~=waypoints]';

                $(toggler).each(function () {
                    var wayShowAnimation = $(this).data('showanim') || 'fadeIn',
                        wayHideAnimation = $(this).data('hideanim') || false,
                        wayOffset = $(this).data('offset') || '80%',
                        wayMarker = $(this).data('marker') || this,
                        triggerOnce = $(this).data('trigger-once') || false;

                    // waypoints core
                    $(wayMarker).waypoint({
                        handler: function (direction) {
                            //console.log($(wayMarker));
                            if(direction === 'down') {
                                $(wayMarker)
                                    .removeClass(wayHideAnimation + ' animated')
                                    .addClass(wayShowAnimation + ' animating')
                                    .on('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                                        $(this)
                                            .removeClass('animating')
                                            .addClass('animated')
                                            .removeClass(wayShowAnimation);
                                    });
                            }
                            if((direction === 'up') && (wayHideAnimation !== false)) {
                                $(wayMarker)
                                    .removeClass(wayShowAnimation + ' animated')
                                    .addClass(wayHideAnimation + ' animating')
                                    .on('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                                        $(this)
                                            .removeClass('animating')
                                            .removeClass('animated')
                                            .removeClass(wayHideAnimation);
                                    });
                            }
                        },
                        continuous: true,
                        offset: wayOffset
                    });
                });
            })();

            // @PLUGIN: WayPoints inview
            // Self invoking
            // ================================
            (function () {
                var toggler     = '[data-toggle~=inview]';

                $(toggler).each(function () {
                    var inviewEnterClass    = $(this).data('enter-class') || 'inview-enter',
                        inviewEnteredClass  = $(this).data('entered-class') || 'inview-entered',
                        inviewExitClass     = $(this).data('exit-class') || 'inview-exit',
                        inviewExitedClass   = $(this).data('exited-class') || 'inview-exited';

                    new Waypoint.Inview({
                        element: this,
                        enter: function (direction) {
                            $(this.element)
                                .removeClass(inviewEnteredClass)
                                .removeClass(inviewExitClass)
                                .removeClass(inviewExitedClass)
                                .addClass(inviewEnterClass);
                        },
                        entered: function (direction) {
                            $(this.element)
                                .removeClass(inviewEnterClass)
                                .removeClass(inviewExitClass)
                                .removeClass(inviewExitedClass)
                                .addClass(inviewEnteredClass);
                        },
                        exit: function (direction) {
                            $(this.element)
                                .removeClass(inviewEnterClass)
                                .removeClass(inviewEnteredClass)
                                .removeClass(inviewExitedClass)
                                .addClass(inviewExitClass);
                        },
                        exited: function (direction) {
                            $(this.element)
                                .removeClass(inviewEnterClass)
                                .removeClass(inviewEnteredClass)
                                .removeClass(inviewExitClass)
                                .addClass(inviewExitedClass);
                        }
                    });
                });
            })();

            // @PLUGIN: SelectRow
            // Self invoking
            // ================================
            (function () {
                var contextual,
                    toggler     = '[data-toggle~=selectrow]',
                    target      = $(toggler).data('target');

                // Core SelectRow function
                // state: checked/unchecked
                var selectrow = function (row, state) {
                    // contextual
                    if($(row).data('contextual')) {
                        contextual = $(row).data('contextual');
                    } else {
                        contextual = 'active';
                    }
                    
                    if(state === 'checked') {
                        // add contextual class
                        $(row).parents(target).addClass(contextual);

                        // publish event
                        $(element).trigger(settings.eventPrefix+'.selectrow.selected', { 'element': $(row).parents(target) });
                    } else {
                        // remove contextual class
                        $(row).parents(target).removeClass(contextual);

                        // publish event
                        $(element).trigger(settings.eventPrefix+'.selectrow.unselected', { 'element': $(row).parents(target) });
                    }
                };
                
                // check on DOM ready
                $(toggler).each(function () {
                    if($(this).is(':checked')) {
                        selectrow(this, 'checked');
                    }
                });

                // clicker
                $(document).on('change', toggler, function () {
                    // checked / unchecked
                    if($(this).is(':checked')) {
                        selectrow(this, 'checked');
                    } else {
                        selectrow(this, 'unchecked');
                    }
                });
            })();

            // @PLUGIN: CheckAll
            // Self invoking
            // ================================
            (function () {
                var contextual,
                    toggler     = '[data-toggle~=checkall]';

                // check on DOM ready
                $(toggler).each(function () {
                    if($(this).is(':checked')) {
                        checked();
                    }
                });
                
                // clicker
                $(document).on('change', toggler, function () {
                    var target      = $(this).data('target');

                    // checked / unchecked
                    if($(this).is(':checked')) {
                        checked(target);
                    } else {
                        unchecked(target);
                    }
                });

                // Core CheckAll function
                var checked = function (target) {
                    // find checkbox
                    $(target).find('input[type=checkbox]').each(function () {
                        // select row
                        if($(this).data('toggle') === 'selectrow') {
                            // trigger change event
                            if(!$(this).is(':checked')) {
                                $(this)
                                    .prop('checked', true)
                                    .trigger('change');
                            }
                        }  
                    });

                    // publish event
                    $(element).trigger(settings.eventPrefix+'.checkall.checked', { 'element': $(target) });
                };
                
                var unchecked = function (target) {
                    // find checkbox
                    $(target).find('input[type=checkbox]').each(function () {
                        // select row
                        if($(this).data('toggle') === 'selectrow') {
                            // trigger change event
                            if($(this).is(':checked')) {
                                $(this)
                                    .prop('checked', false)
                                    .trigger('change');
                            }
                        }
                    });

                    // publish event
                    $(element).trigger(settings.eventPrefix+'.checkall.unchecked', { 'element': $(target) });
                };
            })();

            // @PLUGIN: Panel Refresh
            // Self invoking
            // ================================
            (function () {
                var isDemo          = false,
                    indicatorClass  = 'indicator',
                    toggler         = '[data-toggle~=panelrefresh]';

                // clicker
                $(element).on('click', toggler, function (e) {
                    // find panel element
                    var panel       = $(this).parents('.panel'),
                        indicator   = panel.find('.'+indicatorClass);

                    // check if demo or not
                    if($(this).hasClass('demo')) {
                        isDemo = true;
                    } else {
                        isDemo = false;
                    }
                    
                    // check indicator
                    if(indicator.length !== 0) {
                        indicator.addClass('show');

                        // check if demo or not
                        if(isDemo) {
                            setTimeout(function () {
                                indicator.removeClass('show');
                            }, 2000);
                        }

                        // publish event
                        $(element).trigger(settings.eventPrefix+'.panelrefresh.refresh', { 'element': $(panel) });
                    } else {
                        $.error('There is no `indicator` element inside this panel.');
                    }

                    // prevent default
                    e.preventDefault();
                });
            })();
            
            // @PLUGIN: Panel Collapse
            // Self invoking
            // ================================
            (function () {
                var toggler   = '[data-toggle~=panelcollapse]';

                // clicker
                $(element).on('click', toggler, function (e) {
                    // find panel element
                    var panel   = $(this).parents('.panel'),
                        target  = panel.children('.panel-collapse'),
                        height  = target.height();

                    // error handling
                    if(target.length === 0) {
                        $.error('collapsable element need to be wrap inside ".panel-collapse"');
                    }

                    var open = function (toggler) {
                        $(toggler).removeClass('down').addClass('up');
                        $(target)
                            .removeClass('pull').addClass('pulling')
                            .css('height', '0px')
                            .transition({ height: height }, function() {
                                $(this).removeClass('pulling').addClass('pull out');
                                $(this).css({ 'height': '' });
                            });

                        // publish event
                        $(element).trigger(settings.eventPrefix+'.panelcollapse.open', { 'element': $(panel) });
                    };

                    var close = function (toggler) {
                        $(toggler).removeClass('up').addClass('down');
                        $(target)
                            .removeClass('pull out').addClass('pulling')
                            .css('height', height)
                            .transition({ height: '0px' }, function() {
                                $(this).removeClass('pulling').addClass('pull');
                                $(this).css({ 'height': '' });
                            });

                        // publish event
                        $(element).trigger(settings.eventPrefix+'.panelcollapse.close', { 'element': $(panel) });
                    };

                    // collapse the element
                    if($(target).hasClass('out')) {
                        close(this);
                    } else {
                        open(this);
                    }

                    // prevent default
                    e.preventDefault();
                });
            })();
            
            // @PLUGIN: Panel Remove
            // Self invoking
            // ================================
            (function () {
                var panel,
                    parent,
                    handler   = '[data-toggle~=panelremove]';

                // clicker
                $(element).on('click', handler, function (e) {
                    // find panel element
                    panel   = $(this).parents('.panel');
                    parent  = $(this).data('parent');

                    // remove panel
                    panel.transition({ scale: 0 }, function () {
                        //remove
                        if(parent) {
                            $(this).parents(parent).remove();
                        } else {
                            $(this).remove();
                        }

                        // publish event
                        $(element).trigger(settings.eventPrefix+'.panelcollapse.remove', { 'element': $(panel) });
                    });

                    // prevent default
                    e.preventDefault();
                });
            })();

            // @PLUGIN: SidebarMinimize
            // Self invoking
            // ================================
            (function () {
                // define variable
                var minimizeHandler   = '[data-toggle~=minimize]';

                // core minimize function
                var toggleMinimize = function (e) {
                    // toggle class
                    if($(element).hasClass('sidebar-minimized')) {
                        isMinimize = false;
                        $(element).removeClass('sidebar-minimized');

                        // publish event
                        $(element).trigger(settings.eventPrefix+'.sidebar.maximize', { 'element': $(element) });
                    } else {
                        isMinimize = true;
                        $(element).addClass('sidebar-minimized');

                        // publish event
                        $(element).trigger(settings.eventPrefix+'.sidebar.minimize', { 'element': $(element) });
                    }

                    // prevent default
                    e.preventDefault();
                };

                $(element).on('click', minimizeHandler, toggleMinimize);
            })();

            // @PLUGIN: SidebarMenu
            // Self invoking
            // utilize bootstrap collapse
            // TODO: add function custom event
            // ================================
            (function () {
                // define variable
                var menuHandler     = '[data-toggle~=menu]',
                    submenuHandler  = '[data-toggle~=submenu]';

                // core toggle collapse
                var handleClick = function (e) {
                    var $this       = $(this),
                        parent      = $this.data('parent'),
                        target      = $this.data('target');

                    // default click event handler
                    if(e.type === 'click') {
                        // toggle hide and show
                        if($(target).hasClass('in')) {
                            // hide the submenu
                            $(target).collapse('hide');
                            $this.parent().removeClass('open');
                        } else {
                            // hide other showed target if parent is defined
                            if(!!parent) {
                                $(parent+' .in').each(function () {
                                    $(this).collapse('hide');
                                    $(this).parent().removeClass('open');
                                });
                            }

                            // show the submenu
                            $(target).collapse('show');
                            $this.parent().addClass('open');
                        }
                    }

                    // run only on tablet view and sidebar-menu collapse
                    if((isScreensm) || (isMinimize)) {
                        // if have target
                        if($(target).length > 0) {
                            // touch devices
                            if($(element).hasClass('touch')) {
                                // click event handler
                                if(e.type === 'click') {
                                    if($this.parent().hasClass('hover')) {
                                        // remove hover class and clear the `top` css attr val
                                        $this.parent().removeClass('hover');
                                        $(target).css('top', '');
                                    } else {
                                        // remove other opened submenus
                                        if(parent) {
                                            $(parent+' .hover').each(function (index, elem) {
                                                $(elem).removeClass('hover');
                                            });
                                        }

                                        // add hover class and calculate submenu offset
                                        $this.parent().addClass('hover');
                                        if($(target)[0].getBoundingClientRect().bottom >= Response.deviceH()) {
                                            $(target).css('top', '-'+($(target)[0].getBoundingClientRect().bottom-Response.deviceH()+2)+'px');
                                        }
                                    }
                                }
                            }
                        }
                    }
                };

                // core preserveSubmenu function
                var handleHover = function (e) {
                    var $this       = $(this),
                        parent      = $this.children(submenuHandler).data('parent'),
                        target      = $this.children(submenuHandler).data('target');

                    // run only on tablet view and sidebar-menu collapse
                    if((isScreensm) || (isMinimize)) {
                        // if have target
                        if($(target).length > 0) {
                            // touch devices
                            if(!$(element).hasClass('touch')) {

                                // mouseenter event handler
                                if(e.type === 'mouseenter') {
                                    // add hover class and calculate submenu offset
                                    $this.addClass('hover open');
                                    if($(target)[0].getBoundingClientRect().bottom >= Response.deviceH()) {
                                        $(target).css('top', '-'+($(target)[0].getBoundingClientRect().bottom-Response.deviceH()+2)+'px');
                                    }
                                }

                                // mouseleave event handler
                                if(e.type === 'mouseleave') {
                                    // remove hover class and clear the `top` css attr val
                                    $this.removeClass('hover open');
                                    $(target).css('top', '');
                                }

                            }
                        }
                    }
                };

                $(document)
                    .on('click', submenuHandler, handleClick)
                    .on('mouseenter mouseleave', menuHandler+' > li', handleHover);
            })();

            // @PLUGIN: SideBar
            // Self invoking
            // ================================
            (function () {
                var direction,
                    sidebar,
                    toggler      = '[data-toggle~=sidebar]',
                    openClass    = 'sidebar-open';

                var open = function () {
                    $(element).addClass(openClass+'-'+direction);
                    $(element).trigger(settings.eventPrefix+'.sidebar.open', { 'element': $(sidebar) });
                };

                var close = function () {
                    if ($(element).hasClass(openClass+'-'+direction)) {
                        $(element).removeClass(openClass+'-'+direction);
                        $(element).trigger(settings.eventPrefix+'.sidebar.close', { 'element': $(sidebar) });
                    }
                };

                // sidebar toggler
                var toggle = function () {
                    // get direction
                    direction = $(this).data('direction');

                    if(direction === 'ltr') {
                        sidebar = '.sidebar-left';
                    } else {
                        sidebar = '.sidebar-right';
                    }
                    
                    // trigger error if `data-direction` is not set
                    if((direction === false)||(direction === '')) {
                        $.error('missing `data-direction` value (ltr or rtl)');
                    }

                    // open/close sidebar
                    if(!$(element).hasClass(openClass+'-'+direction)) {
                        open();
                    } else {
                        close();
                    }
                    
                    return false;
                };

                $(document)
                    .on('click', close)
                    .on('click', '.sidebar,'+ toggler, function (e) { e.stopPropagation(); })
                    .on('click', toggler, toggle);
            })();

            // @PLUGIN: OffCanvas
            // Self invoking
            // ================================
            $(function () {
                // define variable
                var container       = '[data-toggle~=offcanvas]',
                    pluginErrors    = [],
                    direction,
                    optOpenerClass,
                    optCloserClass;

                $(container).each(function (index, value) {
                    // define variable
                    var options         = $(value).data('options');

                    // check for valid options object
                    if(options !== undefined) {
                        if(typeof options !== 'object') {
                            pluginErrors.push('OffCanvas: `data-options` need to be a valid javascript object!');
                        } else {
                            // set value
                            optOpenerClass  = 'offcanvas-opener' || options.openerClass;
                            optCloserClass  = 'offcanvas-closer' || options.closerClass;
                        }
                    } else {
                        // set default value
                        optOpenerClass = 'offcanvas-opener';
                        optCloserClass = 'offcanvas-closer';
                    }

                    // check for errors
                    if (pluginErrors.length <= 0) {
                        $(value)
                            .on('click', '.'+optOpenerClass, function (e) {
                                // get direction
                                if($(this).hasClass('offcanvas-open-rtl')) {
                                    direction = 'offcanvas-open-rtl';
                                } else {
                                    direction = 'offcanvas-open-ltr';
                                }

                                $(value)
                                    .removeClass('offcanvas-open-ltr offcanvas-open-rtl')
                                    .addClass(direction);

                                // trigger custom event
                                $(element).trigger(settings.eventPrefix+'.offcanvas.open', { 'element': $(value) });

                                // prevent default
                                e.preventDefault();
                            }).on('click', '.'+optCloserClass, function (e) {
                                $(value)
                                    .removeClass('offcanvas-open-ltr offcanvas-open-rtl');

                                // trigger custom event
                                $(element).trigger(settings.eventPrefix+'.offcanvas.close', { 'element': $(value) });

                                // prevent default
                                e.preventDefault();
                            });
                    } else {
                        $.each(pluginErrors, function (index, value) {
                            $.error(value);
                        });
                    }
                });
            });
        }
    };

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $.fn[pluginName] = function (options) {
        return this.each(function () {
            if (!$.data(this, pluginName)) {
                $.data(this, pluginName, new MAIN(this, options));
            }
        });
    };
    
}));