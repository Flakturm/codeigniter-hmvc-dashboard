$(document).on('change', '#invoice-types', function(){
    $('.invoice-inputs').toggleClass("hide");
});
$('.not-link').click(function(e) {
    e.preventDefault();
});
$('.remote-link').on('click', function (e) {
    $('#remote-modal').find('.modal-body').load($(this).data("remote"));
});
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();
});