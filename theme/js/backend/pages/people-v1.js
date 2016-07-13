/* ========================================================================
 * people-v1.js
 * Page/renders: pages-people-directory.html
 * Plugins used: shuffle
 * ======================================================================== */
'use strict';

(function (factory) {
    if (typeof define === 'function' && define.amd) {
        define([
            'shuffle'
        ], factory);
    } else {
        factory();
    }
}(function () {

    $(function () {
        // Shuffle
        // ================================
        var $grid   = $('#shuffle-grid'),
            $filter = $('#shuffle-filter'),
            $sizer  = $grid.find('shuffle-sizer');
        
        // instatiate shuffle
        $grid.shuffle({
            itemSelector: '.shuffle',
            sizer: $sizer
        });

        // Filter options
        $filter.on('keyup change', function () {
            var val = this.value.toLowerCase();
            $grid.shuffle('shuffle', function ($el, shuffle) {

                // Only search elements in the current group
                if (shuffle.group !== 'all' && $.inArray(shuffle.group, $el.data('groups')) === -1) {
                    return false;
                }

                var text = $.trim($el.find('.panel-body > h5').text()).toLowerCase();
                return text.indexOf(val) !== -1;
            });
        });

        // Update shuffle on sidebar minimize/maximize
        $('html')
            .on('fa.sidebar.minimize', function () { $grid.shuffle('update'); })
            .on('fa.sidebar.maximize', function () { $grid.shuffle('update'); });
    });

}));