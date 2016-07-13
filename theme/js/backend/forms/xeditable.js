/* ========================================================================
 * xeditable.js
 * Page/renders: forms-xeditable.html
 * Plugins used: x-editable
 * ======================================================================== */

'use strict';

(function (factory) {
    if (typeof define === 'function' && define.amd) {
        define([
            'xeditable'
        ], factory);
    } else {
        factory();
    }
}(function () {
    $.fn.editable.defaults.mode = 'inline';
    $(function () {
        // text
        // ================================

        // textarea
        // ================================

        // select
        // ================================
        $('#invoice_status').editable({
            source: [
                  {value: 0, text: '否'},
                  {value: 1, text: '是'}
            ],
            success: function(response, newValue) {
                // userModel.set('username', newValue); //update backbone model
                if(newValue == 1) {
                    $('.invoice-block').show();
                } else {
                    $('.invoice-block').hide();
                }
            }
        });
        $('#status').editable({
            url: '/admin/participants/ajaxPartUpdate',
            source: [
                  {value: '候補', text: '候補'},
                  {value: '訂位', text: '訂位'},
                  {value: '取消', text: '取消'}
            ],
            ajaxOptions: {
                dataType: 'json' //assuming json response
            }, 
            success: function(response, newValue) {
                if (response.errors) {
                    return response.message;
                };
            }
        });
        // Checklist
        // ================================
        $('#xe_checklist').editable({
            value: [1],    
            source: [
                  {value: 1, text: 'option1'},
                  {value: 2, text: 'option2'},
                  {value: 3, text: 'option3'}
               ]
        });

        // Combodate
        // ================================
        $('#xe_combodate').editable({
            format: 'YYYY-MM-DD',    
            viewformat: 'DD.MM.YYYY',    
            template: 'D / MMMM / YYYY',    
            combodate: {
                minYear: 2000,
                maxYear: 2015,
                minuteStep: 1
            }
        });

        // Dateui
        // ================================
        $('#xe_dateui').editable({
            format: 'yyyy-mm-dd',    
            viewformat: 'dd/mm/yyyy',    
            datepicker: {
                weekStart: 1
            }
        });

        // Typehead
        // ================================
        $('#xe_typehead').editable({
            value: 'ru',
            typeahead: {
                name: 'country',
                local: [
                    {value: 'ru', tokens: ['Russia']}, 
                    {value: 'gb', tokens: ['Great Britain']}, 
                    {value: 'us', tokens: ['United States']}
                ],
                template: function(item) {
                    return item.tokens[0] + ' (' + item.value + ')'; 
                } 
            }
        });
    });

}));
function makeTextEditable(ele, url) {
    ele.editable({
        url: url,
        ajaxOptions: {
            dataType: 'json' //assuming json response
        }, 
        success: function(response, newValue) {
            if (response.errors) {
                return response.message;
            };
        }
    });
}
function makeSelectEditable(ele, source) {
    ele.editable({
        source: source,
        ajaxOptions: {
            dataType: 'json' //assuming json response
        }, 
        success: function(response, newValue) {
            if (response.errors) {
                return response.message;
            };
        }
    });
}