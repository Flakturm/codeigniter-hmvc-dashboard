$(document).on('click', '#close-preview', function(){ 
    $('.image-preview').popover('hide');
    // Hover befor close the preview
    $('.image-preview').hover(
        function () {
           $(this).popover('show');
        }, 
         function () {
           $(this).popover('hide');
        }
    );    
});

$(function() {

    function clearEvent (ele) {
        ele.closest('.img-upload').find('.image-preview').attr("data-content","").popover('hide');
        ele.closest('.img-upload').find('.image-preview-filename').val("");
        ele.closest('.img-upload').find('.image-preview-clear').hide();
        ele.closest('.img-upload').find('.pic-img').hide();
        ele.closest('.img-upload').find('.image-preview-input input:file').val("");
        ele.closest('.img-upload').find('.image-preview-input-title').text("瀏覽"); 
    }

    function checkImageHeightWidth (ele, image, width, height) {
        // access image size here 
        if (image.width == width && image.height == height) { // image dimension 
            ele.closest('.img-upload').find('.image-alert-container').hide();
        }
        else {
            var alert = '';
            // construct bootstrap alert with some css animation
            alert += '<div class="alert alert-danger animation animating flipInX">';
            alert += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
            alert += '<p class="nm">圖必須是 ' + width + 'px x ' + height + 'px</p>';
            alert += '</div>';
            // append to affected form
            ele.closest('.img-upload').find('.image-alert-container').html(alert);
            ele.closest('.img-upload').find('.image-alert-container').show();
            clearEvent(ele);
            return;
        }
    }

    // Create the close button
    var closebtn = $('<button/>', {
        type:"button",
        text: 'x',
        id: 'close-preview',
        style: 'font-size: initial;',
    });
    closebtn.attr("class","close pull-right");
    // Set the popover default content
    $('.image-preview').popover({
        trigger:'manual',
        html:true,
        title: "<strong>預覽</strong>"+$(closebtn)[0].outerHTML,
        content: "There's no image",
        placement:'bottom'
    });
    // Clear event
    $('.image-preview-clear').click(function(){
        clearEvent($(this));
        if ( $(this).closest('.input-group-btn').find('input[type="hidden"]').length ) {
            $(this).closest('.input-group-btn').find('input[type="hidden"]').val(1);
        }
    }); 
    // Create the preview image
    $(".image-preview-input input:file").change(function (){
        var image_kb = 500;
        var this_ele = $(this);
        var fixed_width = this_ele.closest('.img-upload').find('.img-fixed-width').text();
        var fixed_height = this_ele.closest('.img-upload').find('.img-fixed-height').text();
        var img = $('<img/>', {
            id: 'dynamic',
            width: (fixed_width * 0.6)
        });      
        var file = this.files[0];
        
        if ( file.size > (image_kb * 1024) ) { // image file size is larger than 500k 
            var alert = '';
            // construct bootstrap alert with some css animation
            alert += '<div class="alert alert-danger animation animating flipInX">';
            alert += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
            alert += '<p class="nm">檔案超過 500KB</p>';
            alert += '</div>';
            // append to affected form
            this_ele.closest('.img-upload').find('.image-alert-container').html(alert);
            this_ele.closest('.img-upload').find('.image-alert-container').show();
            clearEvent(ele);
            return;
        }
        else {
            this_ele.closest('.img-upload').find('.image-alert-container').hide();
        }

        var reader = new FileReader();
        // Set preview image into the popover data-content
        reader.onload = function (e) {
            var image = new Image();
            image.src = e.target.result;

            image.onload = function() {

                checkImageHeightWidth(this_ele, this, fixed_width, fixed_height);
                
            };
            this_ele.closest('.image-preview').find(".image-preview-input-title").text("更換");
            this_ele.closest('.image-preview').find(".image-preview-clear").show();
            this_ele.closest('.image-preview').find(".image-preview-filename").val(file.name);            
            img.attr('src', e.target.result);
            this_ele.closest('.img-upload').find('a').attr('href', e.target.result);
            this_ele.closest('.img-upload').find('.pic-img').attr('src', e.target.result);
            this_ele.closest('.image-preview').attr("data-content",$(img)[0].outerHTML).popover("show");
        }

        reader.readAsDataURL(file);
    });

    if ( $('.popup-link').length ) {
        $('.popup-link').magnificPopup({
          type: 'image',
          closeOnContentClick: true,
            closeBtnInside: false,
            fixedContentPos: true,
            mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
            image: {
                verticalFit: true
            },
            zoom: {
                enabled: true,
                duration: 300 // don't foget to change the duration also in CSS
            }
        });
    }
});