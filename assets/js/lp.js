/* header部のスクロール対応 */
jQuery(window).on('scroll', function () {
    if (jQuery('.header').height() < jQuery(this).scrollTop()) {
        jQuery('.header').addClass('bg-dark');
        jQuery('.header').css({'color' : 'white'});
    } else {
        jQuery('.header').removeClass('bg-dark');
        jQuery('.header').css({'color' : 'black'});
    }
});

/* アニメーション対応 */
$(function() {
    $('.box1').on('inview', function(event, isInView) {
        if (isInView) {
            $(this).addClass("fadeInLeft");
        } else {
            $(this).removeClass("fadeInLeft");
        }
    });
    $('.box2').on('inview', function(event, isInView) {
        if (isInView) {
            $(this).addClass("fadeInDown");
        } else {
            $(this).removeClass("fadeInDown");
        }
    });
});