/* ========================================================================
 * ajax.js
 * ======================================================================== */

/* global Ladda */

'use strict';

(function (factory) {
    if (typeof define === 'function' && define.amd) {
        define([
            'parsley',
            'ladda'
        ], factory);
    } else {
        factory();
    }
}(function () {

    // Core function
    // ================================
    var formAjax = function (e) {
        var $form   = $('.ajax-form'),
            $btn    = $(this),
            data    = $form.serialize(),
            type    = $form.attr('method'),
            url     = $('#ajax-url').val();

        if ($form.parsley().validate()) {
            var ladda = Ladda.create($btn[0]).start();
            $.ajax({
                type: type,
                url: url,
                dataType: 'json',
                data: data,
                success: function(data, textStatus, jqXHR)
                {
                    ladda.stop();
                    if (data.alert == 'success') {
                        if (data.message) {
                            if (data.redirect) {
                                window.location.replace(data.message);
                                return false;
                            }
                            $('.hide-block').hide();
                            $('.show-block').show();
                            $form[0].reset();
                        }
                        else {
                            $form.submit();
                        }
                    }
                    
                    var bsalert = '';
                        bsalert += '<div class="alert alert-' + data.alert + ' animation animating flipInX">';
                        bsalert += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
                        bsalert += '<p class="nm">' + data.message + '</p>';
                        bsalert += '</div>';

                    $form.find('.message-container').first().html(bsalert);
                    
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    ladda.stop();
                    // Handle errors here

                    var bsalert = '', 
                        message;

                    // construct message base on status code
                    switch (jqXHR.status) {
                        case 404:
                            message = 'The requested file is not found!';
                        break;
                        case 500:
                            message = 'Internal server / script error!';
                        break;
                    }
                    // construct bootstrap alert with some css animation
                    bsalert += '<div class="alert alert-danger animation animating flipInX">';
                    bsalert += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
                    bsalert += '<h4 class="semibold mb5">'+jqXHR.status+' error!</h4>';
                    bsalert += '<p class="nm">'+message+'</p>';
                    bsalert += '</div>';

                    // append to affected form
                    $form.find('.message-container').first().html(bsalert);
                    // STOP LOADING SPINNER
                }
            });
        }

        e.preventDefault();
    };

    $(function () {
        // call ajax
        // ================================
        $('.next-btn').on('click', formAjax);
    });

}));