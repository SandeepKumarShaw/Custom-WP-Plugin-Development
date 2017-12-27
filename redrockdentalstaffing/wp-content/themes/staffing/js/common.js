jQuery(document).ready(function(jQuery){
    jQuery(window).resize(function () {
        var winWidth = jQuery( window ).width();
        if (winWidth < 768) {
            jQuery('#main-menu').hide();
        }else{
            jQuery('#main-menu').show();
        }
    });
    jQuery(".title-bar").click(function(){
        jQuery("#main-menu").toggle();
    });
    jQuery('.owl-carousel').owlCarousel({
        loop:true,
        margin:0,
        nav:true,
        autoplay:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items:1
            }
        }
    })
    
jQuery(".wpcf7-tel").mask("(999) 999-9999", {autoclear: false});
jQuery(".wpcf7-tel").on("blur", function() {
    var last = jQuery(this).val().substr( jQuery(this).val().indexOf("-") + 1 );
    if( last.length == 4 ) {
        //var lastfour = move + last;
        var lastfour = last;
        var first = jQuery(this).val().substr( 0, 9 );
        jQuery(this).val( first + '-' + lastfour );
    }
  });
});
