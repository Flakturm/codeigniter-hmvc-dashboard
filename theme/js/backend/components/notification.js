/* ========================================================================
 * notification.js
 * Page/renders: components-notification.html
 * Plugins used: gritter, bootbox
 * ======================================================================== */

/* global bootbox */

'use strict';

(function (factory) {
    if (typeof define === 'function' && define.amd) {
        define([
            'bootbox',
            'gritter'
        ], factory);
    } else {
        factory();
    }
}(function () {

    $(function () {
        // Gritter
        // ================================
        // sticky notice
        $('#add-sticky').on('click', function (e) {
            $.gritter.add({
                title: 'Sticky notice',
                text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus eget tincidunt velit.',
                sticky: true,
            });
            e.preventDefault();
        });

        // regular notice
        $('#add-regular').on('click', function (e) {
            $.gritter.add({
                title: 'Regular notice',
                text: 'This will fade out after a certain amount of time. Vivamus eget tincidunt velit.',
                sticky: false,
            });
            e.preventDefault();
        });

        // max 3 notice
        $('#add-max').on('click', function (e) {
            $.gritter.add({
                title: 'Max of 3 notice on screen',
                text: 'This will fade out after a certain amount of time. Vivamus eget tincidunt velit.',
                sticky: false,
                // (function) before the gritter notice is opened
                'before_open': function () {
                    if ($('.gritter-item-wrapper').length === 3) {
                        // Returning false prevents a new gritter from opening
                        return false;
                    }
                }
            });
            e.preventDefault();
        });

        // with image notice
        $('#add-image').on('click', function (e) {
            $.gritter.add({
                title: 'Notice with image',
                text: 'This will fade out after a certain amount of time. Vivamus eget tincidunt velit.',
                image: '../image/avatar/avatar5.jpg',
                sticky: false
            });
            e.preventDefault();
        });

        // light notice with image
        $('#add-light').on('click', function (e) {
            $.gritter.add({
                title: 'Light notice',
                text: 'This will fade out after a certain amount of time. Vivamus eget tincidunt velit.',
                image: '../image/avatar/avatar9.jpg',
                'class_name': 'gritter-light',
                sticky: true
            });
            e.preventDefault();
        });

        // Bootbox
        // ================================
        // bootbox - alert
        $('#bootbox-alert').on('click', function (event) {
            bootbox.alert('Hello world!');
            event.preventDefault();
        });

        // bootbox - confirm
        $('#part-configuration').on('click', '.bootbox-confirm', function (event) {
            var id = $(this).data('id'); //
            var data = 'participant_id=' + id;
            var url = '/participants/ajaxSendRequest'
            var ladda = Ladda.create($(this)[0]).start();
            bootbox.confirm('確定寄出付款頁面給這位客戶?', function (result) {
                // callback
                if (result) {
                    $.ajax({
                        type: 'post',
                        url: url,
                        dataType: 'json',
                        data: data,
                        success: function(data, textStatus, jqXHR)
                        {
                            ladda.stop();
                            var text;
                            if ( data.success ) {
                                text = '信件已送出';
                            }
                            else {
                                text = '信件送出失敗';
                            }
                            $.gritter.add({
                                title: '系統通知',
                                text: text,
                                sticky: false,
                                time: 1500
                            });
                        },
                        error: function(jqXHR, textStatus, errorThrown)
                        {
                            ladda.stop();
                            $.gritter.add({
                                title: '系統通知',
                                text: '信件送出失敗',
                                sticky: false,
                                time: 1500
                            });
                        }
                    });
                }
                else {
                   ladda.stop(); 
               }
            });
            event.preventDefault();
        });

        // bootbox - prompt
        $('#bootbox-prompt').on('click', function (event) {
            bootbox.prompt('What is your name?', function (result) {
                // callback
            });
            event.preventDefault();
        });

        // bootbox - custom
        $('#bootbox-custom').on('click', function (event) {
            bootbox.dialog({
                message: 'I am a custom dialog',
                title: 'Custom title',
                buttons: {
                    success: {
                        label: 'Success',
                        className: 'btn-success',
                        callback: function () {
                            // callback
                        }
                    },
                    danger: {
                        label: 'Danger',
                        className: 'btn-danger',
                        callback: function () {
                            // callback
                        }
                    },
                    main: {
                        label: 'Primary',
                        className: 'btn-primary',
                        callback: function () {
                            // callback
                        }
                    }
                }
            });
            event.preventDefault();
        });
    });

}));