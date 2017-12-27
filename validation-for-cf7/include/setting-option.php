<?php
if ( ! defined( 'ABSPATH' ) ) {
    die( 'Error!' );
}
function vfcf7_register_settings() {
    //add_option( 'vfcf7_option_name', 'This is my option value.');
    register_setting( 'vfcf7_options_group', 'vfcf7_option_name', 'vfcf7_callback' );
    register_setting( 'vfcf7_options_group', 'vfcf7_option_name1', 'vfcf7_callback' );
    register_setting( 'vfcf7_options_group', 'vfcf7_option_name2', 'vfcf7_callback' );
    register_setting( 'vfcf7_options_group', 'vfcf7_option_name3', 'vfcf7_callback' );
    register_setting( 'vfcf7_options_group', 'vfcf7_option_name4', 'vfcf7_callback' );
    register_setting( 'vfcf7_options_group', 'vfcf7_option_name5', 'vfcf7_callback' );
}
add_action( 'admin_init', 'vfcf7_register_settings' );

function vfcf7_register_options_page() {
    add_options_page('Page Title', 'Validation For Contact Form 7', 'manage_options', 'vfcf7', 'vfcf7_options_page');
}
add_action('admin_menu', 'vfcf7_register_options_page');
function vfcf7_options_page()
{
    ?>
    <div>
        <?php screen_icon(); ?>
        <h2>Validation For Contact Form 7</h2>
        <form method="post" action="options.php">
            <?php settings_fields( 'vfcf7_options_group' ); ?>
            <p>Some text here.</p>
            <table>
                <tr valign="top">
                    <th scope="row"><label for="vfcf7_option_name">Telephone</label></th>
                    <td><input type="text" id="vfcf7_option_name" name="vfcf7_option_name" value="<?php echo get_option('vfcf7_option_name'); ?>" /></td>
                    <td><em>Enter a class name eg:phone and use like:[tel* tel-372 class:phone]</em></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="vfcf7_option_name1">Zipcode</label></th>
                    <td><input type="text" id="vfcf7_option_name1" name="vfcf7_option_name1" value="<?php echo get_option('vfcf7_option_name1'); ?>" /></td>
                    <td><em>Enter a zipcode field name and use like:[text* USZipCode]</em></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="vfcf7_option_name2">Full Name</label></th>
                    <td><input type="text" id="vfcf7_option_name2" name="vfcf7_option_name2" value="<?php echo get_option('vfcf7_option_name2'); ?>" /></td>
                    <td><em>Enter a fullname field name and use like:[text* fullname]</em></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="vfcf7_option_name3">First Name</label></th>
                    <td><input type="text" id="vfcf7_option_name3" name="vfcf7_option_name3" value="<?php echo get_option('vfcf7_option_name3'); ?>" /></td>
                    <td><em>Enter a firstname field name and use like:[text* firstname]</em></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="vfcf7_option_name4">Middle Name</label></th>
                    <td><input type="text" id="vfcf7_option_name4" name="vfcf7_option_name4" value="<?php echo get_option('vfcf7_option_name4'); ?>" /></td>
                    <td><em>Enter a middlename field name and use like:[text* middlename]</em></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="vfcf7_option_name5">Last Name</label></th>
                    <td><input type="text" id="vfcf7_option_name5" name="vfcf7_option_name5" value="<?php echo get_option('vfcf7_option_name5'); ?>" /></td>
                    <td><em>Enter a lastname field name and use like:[text* lastname]</em></td>
                </tr>
            </table>
            <?php  submit_button(); ?>
        </form>
    </div>

    <?php
} ?>
