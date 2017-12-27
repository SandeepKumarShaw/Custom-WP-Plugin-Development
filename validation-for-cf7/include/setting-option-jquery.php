<?php
function hook_javascript() {
    ?>
    <script>
        jQuery(document).ready(function(jQuery){

            jQuery(".<?php echo get_option('vfcf7_option_name'); ?>").mask("(999) 999-9999", {autoclear: false});
            jQuery(".<?php echo get_option('vfcf7_option_name'); ?>").on("blur", function() {
                var last = jQuery(this).val().substr( jQuery(this).val().indexOf("-") + 1 );
                if( last.length == 4 ) {
                    var move = jQuery(this).val().substr( jQuery(this).val().indexOf("-") - 1, 1 );
                    //var lastfour = move + last;
                    var lastfour = last;
                    var first = jQuery(this).val().substr( 0, 9 );
                    jQuery(this).val( first + '-' + lastfour );
                }
            });

            jQuery("input[name='<?php echo get_option('vfcf7_option_name1'); ?>").on("keypress keyup blur",function (event) {
                jQuery(this).val(jQuery(this).val().replace(/[^\d].+/, ""));
                if ((event.which != 46 || jQuery(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                    event.preventDefault();
                }
            });

            jQuery("input[name='<?php echo get_option('vfcf7_option_name1'); ?>").prop('maxLength', 5);



        });
    </script>

    <?php
}
add_action('wp_head', 'hook_javascript');

?>