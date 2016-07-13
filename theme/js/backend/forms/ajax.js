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
    var formAjax = function (event) {
        var formData = new FormData();

        if ( $('input[type^="file"]').length ) {
            formData.append('site_favicon', $('input[type^="file"]').get(0).files[0]);
            formData.append('site_logo', $('input[type^="file"]').get(1).files[0]);
        }
        
        var other_data = $(this).serializeArray();
        $.each(other_data, function (key,input) {
            formData.append(input.name,input.value);
        });

        var $form   = $(this),
            $btn    = $('#submit-btn'),
            // data    = $form.serialize(),
            type    = $form.attr('method'),
            url     = $form.attr('action') + '/ajaxSave';

        if ($form.parsley().validate()) {
            var ladda = Ladda.create($btn[0]).start();
            $.ajax({
                type: type,
                url: url,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function(data, textStatus, jqXHR)
                {
                    ladda.stop();
                    if (data.redirect) {
                        // console.log(data.redirect);
                        window.location = data.redirect;
                        event.preventDefault();
                        return;
                    }
                    var alert = '';
                    var message = data.alert == 'success' ? data.message : data.errors;
                    $.each(message, function (key,value) {
                        alert += '<p>'+value+'</p>';
                    });
                    $.gritter.add({
                        title: '系統通知',
                        text: alert,
                        sticky: false,
                        time: 2000
                    });
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    // Handle errors here
                    ladda.stop();

                    var alert = '', 
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
                    message += '<h4 class="semibold mb5">'+jqXHR.status+' error!</h4>';
                    message += '<p>'+message+'</p>';

                    $.gritter.add({
                        title: '系統通知',
                        text: message,
                        sticky: false,
                        time: 2000
                    });
                }
            });
        }

        event.preventDefault();
    };

    $(document).on('click', '#send-mail', function(e) {
        // $('form').submit();
        var ladda = Ladda.create(this).start();
        var $form = $('form'),
            type  = $form.attr('method'),
            url   = $form.attr('action') + '/ajaxSendMail';

        $.ajax({
                type: type,
                url: url,
                dataType: 'json',
                data: $form.serialize(),
                success: function(data, textStatus, jqXHR)
                {
                    ladda.stop();
                    var alert = '';
                    var message = data.alert == 'success' ? data.message : data.errors;
                    $.each(message, function (key,value) {
                        alert += '<p>'+value+'</p>';
                    });

                    $.gritter.add({
                        title: '系統通知',
                        text: alert,
                        sticky: false,
                        time: 2500
                    });
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    // Handle errors here
                    ladda.stop();

                    var alert = '', 
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
                    message += '<h4 class="semibold mb5">'+jqXHR.status+' error!</h4>';
                    message += '<p>'+message+'</p>';

                    $.gritter.add({
                        title: '系統通知',
                        text: message,
                        sticky: false,
                        time: 2000
                    });
                }
            });

        e.preventDefault();
        return false;
    });

    $(function () {
        // Init form
        // ================================
        $('.ajax-form').on('submit', formAjax);
        $('.ajax-forget-form').on('submit', function(event) {
            var $form   = $(this),
            $btn    = $('#submit-btn'),
            data    = $form.serialize(),
            type    = $form.attr('method'),
            url     = $form.attr('action') + '/ajaxSendPassword';

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
                        var bsalert = '';
                            bsalert += '<div class="alert alert-'+data.alert+' animation animating flipInX">';
                            bsalert += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
                            var message = data.alert == 'success' ? data.message : data.errors;
                            $.each(message, function (key,value) {
                                bsalert += '<p class="nm">'+value+'</p>';
                            });
                            bsalert += '</div>';

                        $form.find('.message-container').first().html(bsalert);
                        $form.find('.form-dismiss').hide();
                    },
                    error: function(jqXHR, textStatus, errorThrown)
                    {
                        // Handle errors here
                        ladda.stop();

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

            event.preventDefault();

        });
    });

}));