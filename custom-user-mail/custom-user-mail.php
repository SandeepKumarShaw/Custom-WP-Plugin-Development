<?php

/**
 * Plugin Name: Custom User Mail
 * Description: This plugin allow to send new register user a wellcome msg with user login credential
 * Author: webskitters
 * Version: 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    die( 'Error!' );
}
function wp_new_user_notification( $user_id, $deprecated = null, $notify = '' ) {
    if ( $deprecated !== null ) {
        _deprecated_argument( __FUNCTION__, '4.3.1' );
    }
 
    global $wpdb, $wp_hasher;
    $user = get_userdata( $user_id );
 
    // The blogname option is escaped with esc_html on the way into the database in sanitize_option
    // we want to reverse this for the plain text arena of emails.
    $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
  
    if ( 'user' !== $notify ) {
        $switched_locale = switch_to_locale( get_locale() );
        $message  = sprintf( __( 'New user registration on your site %s:' ), $blogname ) . "\r\n\r\n";
        $message .= sprintf( __( 'Username: %s' ), $user->user_login ) . "\r\n\r\n";
        $message .= sprintf( __( 'Email: %s' ), $user->user_email ) . "\r\n";


 
        @wp_mail( get_option( 'admin_email' ), sprintf( __( '[%s] New User Registration' ), $blogname ), $message );
 
        if ( $switched_locale ) {
            restore_previous_locale();
        }
    }
 
    // `$deprecated was pre-4.3 `$plaintext_pass`. An empty `$plaintext_pass` didn't sent a user notification.
    if ( 'admin' === $notify || ( empty( $deprecated ) && empty( $notify ) ) ) {
        return;
    }
 
    // Generate something random for a password reset key.
    $key = wp_generate_password( 20, false );
 
    /** This action is documented in wp-login.php */
    do_action( 'retrieve_password_key', $user->user_login, $key );
 
    // Now insert the key, hashed, into the DB.
    if ( empty( $wp_hasher ) ) {
        require_once ABSPATH . WPINC . '/class-phpass.php';
        $wp_hasher = new PasswordHash( 8, true );
    }
    $hashed = time() . ':' . $wp_hasher->HashPassword( $key );
    $wpdb->update( $wpdb->users, array( 'user_activation_key' => $hashed ), array( 'user_login' => $user->user_login ) );
 
    $switched_locale = switch_to_locale( get_user_locale( $user ) ); 




$subject = "New User Registration";

    $message = '
    <html>
    <head>
        <title>Welcome to '.site_url().'</title>
    </head>
    <body>
        <h1>'.get_option( 'cust_thk_msg' ).'</h1>
        <table cellspacing="0" style="border: 2px dashed #FB4314; width: 900px; height: 200px;">
            <tr>
                <th>Name:</th><td>'.$user->first_name.''.$user->last_name.'</td>
            </tr>
            <tr style="background-color: #e0e0e0;">
                <th>Email:</th><td>'.$user->user_email.'</td>
            </tr>
            <tr>
                <th>Website:</th><td><a href="'.site_url().'">'.site_url().'</a></td>
            </tr>
            <tr style="background-color: #e0e0e0;">
                <th>UserName:</th><td>'.$user->user_login.'</td>
            </tr>
             <tr>
                <th>PasswordResetLink:</th><td><a href="'. network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user->user_login), 'login') . '">'. network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user->user_login), 'login') . '</a></td>
            </tr>           
            <tr style="background-color: #e0e0e0;">
                <th>LoginUrl:</th><td><a href="'.site_url().'/sign-in/">'.site_url().'/sign-in/</a></td>
            </tr>            
        </table>
    </body>
    </html>';

   // Set content-type header for sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// Additional headers
$headers .= 'From: '.get_bloginfo().'<'.get_option( 'admin_email' ).'>' . "\r\n";
$headers .= 'Cc: welcome@example.com' . "\r\n";
wp_mail($user->user_email, $subject, $message ,$headers);
if ( $switched_locale ) {
        restore_previous_locale();
    }
}
function wpcust_user_reset_password_redirect() {
    if(!current_user_can('administrator')){
         $redirect_to = get_option( 'cust_login_url' );
         wp_redirect($redirect_to);
         exit();
   }
}
add_action('after_password_reset', 'wpcust_user_reset_password_redirect');

function wpcust_user_logout_redirect(){
    if(!current_user_can('administrator')){
         $redirect_to = get_option( 'cust_logout_url' );
         wp_redirect($redirect_to);
         exit();
   }  
}
add_action('wp_logout', 'wpcust_user_logout_redirect');

require_once( 'inc/custom-user-mail_option.php' );



