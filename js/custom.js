jQuery(function($) {
    $(window).scroll(function(){
        if($(this).scrollTop()>84){
            $('#navigation').addClass('fixed');
        }
        else if ($(this).scrollTop()<84){
            $('#navigation').removeClass('fixed');
        }
    });
});