jQuery(document).ready(function(jQuery){
  jQuery(".Phone").mask("(999) 999-9999", {autoclear: false});
      jQuery(".Phone").on("blur", function() {
          var last = jQuery(this).val().substr( jQuery(this).val().indexOf("-") + 1 );
          if( last.length == 4 ) {
              var move = jQuery(this).val().substr( jQuery(this).val().indexOf("-") - 1, 1 );
              //var lastfour = move + last;
              var lastfour = last;
              var first = jQuery(this).val().substr( 0, 9 );
              jQuery(this).val( first + '-' + lastfour );
          }
      });    
});



