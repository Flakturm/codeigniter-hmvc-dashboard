/* ========================================================================
 * fileupload.js
 * Page/renders: forms-fileupload.html
 * Plugins used: Blueimp fileupload
 * ======================================================================== */

'use strict';

(function (factory) {
    if (typeof define === 'function' && define.amd) {
        define([
            'fileupload'
        ], factory);
    } else {
        factory();
    }
}(function () {
    
    // Reset global drop and dragover
    // ================================
    $(document).bind('drop dragover', function (e) {
        e.preventDefault();
    });

    $(function () {
        // Basic
        // ================================
        var url = 'server/php/',
            rowId = 0,
            imgId = 0,
            uploadButton = $('<button/>')
                .addClass('btn btn-primary')
                .prop('disabled', true)
                .text('Processing...')
                .on('click', function() {
                    var $this = $(this),
                        data = $this.data();
                        $this
                            .off('click')
                            .text('Abort')
                            .on('click', function() {
                                $this.remove();
                                data.abort();
                            });
                        data.submit().always(function() {
                        $this.remove();
                });
            });

        // Init fileuploader
        $('#basic-uploader input[type="file"]').fileupload({
            url: url,
            dataType: 'json',
            autoUpload: false,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            maxFileSize: 5000000,
            dropZone: $('#basic-uploader .dropzone'),
            disableImageResize: /Android(?!.*Chrome)|Opera/.test(window.navigator.userAgent),
            previewMaxWidth: 50,
            previewMaxHeight: 50,
            previewCrop: true
        }).on('fileuploadadd', function (e, data) {

            $('#basic-uploader .upload-lists').children('tbody').append(
                '<tr class="upload-list-'+(rowId += 1)+'">'+
                '<td width="50"></td>'+
                '<td><strong>'+data.files[0].name+'</strong></td>'+
                '<td>'+(data.files[0].size * 1e-6)+'MB</td>'+
                '<td class="text-right" width="80"></td>'+
                '</tr>'
            );

            // append the upload buttom
            $('#basic-uploader .upload-lists').find('.upload-list-'+rowId+' > td').eq(3).append(uploadButton.clone(true).data(data)[0]);

        }).on('fileuploadprocessalways', function (e, data) {
            var index = data.index,
                file = data.files[index],
                $canvas = $(file.preview).addClass('img-circle pull-left');

            // append the upload file
            $('#basic-uploader .upload-lists').find('.upload-list-'+(imgId += 1)+' > td').eq(0).append($canvas[0]);

            if (index + 1 === data.files.length) {
                $('#basic-uploader .upload-lists').find('.upload-list-'+rowId+' > td > button').text('Upload').prop('disabled', !!data.files.error);
            }

        }).on('fileuploadprogressall', function(e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#basic-uploader .progress-bar').css('width', progress + '%');

        }).on('fileuploaddone', function(e, data) {
            $.each(data.result.files, function(index, file) {
                if (file.error) {
                    $('#basic-uploader .alert').html('').addClass('alert-danger').append(file.error);
                }
            });

        }).on('fileuploadfail', function(e, data) {
            $.each(data.files, function(index) {
                $('#basic-uploader .alert').html('').addClass('alert-danger').html('File upload failed.');
            });

        }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');
    });

}));