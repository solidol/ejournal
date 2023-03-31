import './bootstrap';

$(document).ready(function () {

    //Inputmask("+38 099 999 99 99").mask(".form-phone-input");

    /*
    $("#phone").inputmask({
        "mask": "+38 099 999 99 99"
    });*/


});


$(window).on('load', function () {
    $('body').addClass('loaded_hiding');
    window.setTimeout(function () {
        $('body').addClass('loaded');
        $('body').removeClass('loaded_hiding');
    }, 800);
});
