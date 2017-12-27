<?php

if ( ! defined( 'ABSPATH' ) ) {
    die( 'Error!' );
}

function custom_user_mail_menu() {    
 add_menu_page( 'Custom User mail', 'Custom User mail', 'manage_options', 'custom_user_mail', 'custom_user_settings_page' );
 add_submenu_page( 'custom_user_mail', 'Custom User mail', 'Settings', 'manage_options', 'custom_user_settings_page', 'custom_user_settings_page' );
}
add_action('admin_menu', 'custom_user_mail_menu');

add_action( 'admin_init', function() {
register_setting( 'custom_user_mail_menu_settings', 'cust_thk_msg' );
register_setting( 'custom_user_mail_menu_settings', 'cust_logout_url' );
register_setting( 'custom_user_mail_menu_settings', 'cust_login_url' );
});


function custom_user_settings_page() {
?>
<div class="wrap">
        <h2>Custom User Mail Setting Option</h2>

<form action="options.php" method="post">

<?php
settings_fields( 'custom_user_mail_menu_settings' );
do_settings_sections( 'custom_user_mail_menu_settings' );
?>
<table class="form-table">

    <tr valign="top">
        <th scope="row">Custom Thank You Message</th>
        <td><textarea id="cust_thk_msg" name="cust_thk_msg"><?php echo get_option( 'cust_thk_msg' ); ?></textarea></td>
    </tr>
    <tr valign="top">
        <th scope="row">Custom Login Page</th>
        <td><input type="text" id="cust_login_url" name="cust_login_url" value="<?php echo esc_url ( get_option( 'cust_login_url' ) ); ?>" size="30" /></td>
    </tr>
    <tr valign="top">
        <th scope="row">Custom LogOut Page</th>
        <td><input type="text" id="cust_logout_url" name="cust_logout_url" value="<?php echo esc_url ( get_option( 'cust_logout_url' ) ); ?>" size="30" /></td>
    </tr>
   
</table>   
    <?php submit_button(); ?>
</form>
</div>
<?php
}