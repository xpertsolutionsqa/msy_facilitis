$(document).ready(function () {
    jQuery('#menu-primarymenuar li a').click(function () {

        $('#menu-primarymenuar li a').removeClass('active');
        $(this).addClass('active');

        setTimeout(function () {
            jQuery('.meanmenu-reveal').trigger("click");
        }, 500);
    });

    $(window).scroll(function () {
        $('section').each(function () {
            var top_of_element = $(this).offset().top;
            var bottom_of_element = $(this).offset().top + $(this).outerHeight();
            var bottom_of_screen = $(window).scrollTop() + $(window).innerHeight();
            var top_of_screen = $(window).scrollTop();
            var id = $(this).attr('id');

            if ((bottom_of_screen > top_of_element) && (top_of_screen < bottom_of_element)) {
                $('#menu-primarymenuar li a').removeClass('active');
                $('#menu-primarymenuar li.' + id + ' a').addClass('active');
            }
        });
    });
});