<?php
function hook_javascript() {
    ?>
    <script>
        jQuery(document).ready(function(){            

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