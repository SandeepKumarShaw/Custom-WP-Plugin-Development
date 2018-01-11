<?php
/*
  Plugin Name: Validation For Contact Form 7
  Plugin URI: https://www.example.com/
  Description: This plugin integrates validation in contact form 7
  Version: 1.0
  Author: WP Team
  Author URI: https://www.example.com/
*/

ob_start();
if ( ! defined( 'ABSPATH' ) ) {
    die( 'Error!' );
}


function vfcf7_enqueue_scripts(){

    wp_enqueue_script( 'jquery-maskedinput', plugin_dir_url( __FILE__ ) . 'js/jquery.maskedinput.js', array('jquery'),'', true );
    wp_enqueue_script( 'jquery-vfcf7', plugin_dir_url( __FILE__ ) . 'js/vfcf7_common.js', array('jquery'),'', true );


}
add_action( 'wp_enqueue_scripts', 'vfcf7_enqueue_scripts' );


require_once( 'include/setting-option.php' );
require_once( 'include/setting-option-jquery.php' );

//**************====================================Email Validation===========================**************//

add_filter('wpcf7_validate_email', 'wpcf7_custom_email_validation_filter', 20, 2); // Email field
add_filter('wpcf7_validate_email*', 'wpcf7_custom_email_validation_filter', 20, 2); // Req. Email field

function wpcf7_validate_email_check($emailAddress) {
    $expression = '/^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})$/';
    if (preg_match($expression, $emailAddress)) {
        return true;
    } else {
        return false;
    }
}
function wpcf7_custom_email_validation_filter($result, $tags) {
    $tags = new WPCF7_Shortcode( $tags );
    $type = $tags->type;
    $name = $tags->name;
    if ('email' == $type || 'email*' == $type) {
        $email_value = sanitize_email($_POST[$name]);
        if(!wpcf7_validate_email_check($email_value)){
            $result->invalidate( $tags, __( 'Email address entered is not valid.', 'contact-form-7-email-validation' ));
        }
    }
    return $result;
}
//**************==========================Telephone number Validation===========================**************//

add_filter( 'wpcf7_validate_tel', 'wpcf7_custom_tel_validation_filter', 10, 2 );
add_filter( 'wpcf7_validate_tel*', 'wpcf7_custom_tel_validation_filter', 10, 2 );

function wpcf7_validate_tel_check($tel) {
    $expression = '/^\(?(\d{3})\)?[- ]?(\d{3})[- ]?(\d{4})$/';
    if (preg_match($expression, $tel)) {
        return true;
    } else {
        return false;
    }
}
function wpcf7_custom_tel_validation_filter($result, $tags) {
    $tags = new WPCF7_Shortcode( $tags );
    $type = $tags->type;
    $name = $tags->name;
    if ('tel' == $type || 'tel*' == $type) {

        if(!wpcf7_validate_tel_check($_POST[$name])){
            $result->invalidate( $tags, __( 'Phone Number entered is not valid.', 'contact-form-7-email-validation' ));
        }
    }
    return $result;
}
//**************====================================Url Validation===========================**************//


function wpcf7_custom_url_check( $result, $url )
{
    if ($result)
    {

        $regex ='/^(http(s)?:\/\/)?(www\.)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/';

        if (!preg_match($regex,$url)) $result=FALSE;
    }
    return $result;
}
add_filter( 'wpcf7_is_url', 'wpcf7_custom_url_check', 10, 2 );


//**************==================================Text field Validation=======================**************//

add_filter('wpcf7_validate_text','wpcf7_custom_form_validation', 10, 2); // text field
add_filter('wpcf7_validate_text*', 'wpcf7_custom_form_validation', 10, 2); // Req. text field

function wpcf7_custom_form_validation( $result, $tag ) {
    $USZipCode  = get_option('vfcf7_option_name1');
    $fullname   = get_option('vfcf7_option_name2');
    $firstname  = get_option('vfcf7_option_name3');
    $middlename = get_option('vfcf7_option_name4');
    $lastname   = get_option('vfcf7_option_name5');


    if ( $USZipCode == $tag->name ) {
        $regex = '/^\d{5}(-\d{4})?$/';
        if (!preg_match($regex, $_POST[$USZipCode], $matches)) {
            $result->invalidate($tag, "This is not a valid Zipcode!" );
        }
    }
    if ( $fullname == $tag->name ) {
        $regex = '/^[a-zA-Z ]{2,150}$/';
        if (!preg_match($regex, $_POST[$fullname], $matches)) {
            $result->invalidate($tag, "This is not a valid name!" );
        }
    }
    if ( $firstname == $tag->name ) {
        $regex = '/^[a-zA-Z]{2,}$/';
        if (!preg_match($regex, $_POST[$firstname], $matches)) {
            $result->invalidate($tag, "This is not a valid first name!" );
        }
    }
    if ( $middlename == $tag->name ) {
        $regex = '/^[a-zA-Z]{2,}$/';
        if (!preg_match($regex, $_POST[$middlename], $matches)) {
            $result->invalidate($tag, "This is not a valid middle name!" );
        }
    }
    if ( $lastname == $tag->name ) {
        $regex = '/^[a-zA-Z]{2,}$/';
        if (!preg_match($regex, $_POST[$lastname], $matches)) {
            $result->invalidate($tag, "This is not a valid last name!" );
        }
    }
    return $result;
}

add_filter( 'plugin_action_links', 'vfcf7_activate', 10, 5 );
function vfcf7_activate( $actions, $plugin_file ){
    static $plugin;
    if (!isset($plugin))
        $plugin = plugin_basename(__FILE__);
    if ($plugin == $plugin_file) {
        $settings = array('settings' => '<a href="admin.php?page=vfcf7">' . __('Settings', 'General') . '</a>');
        $site_link = array('support' => '<a href="https://www.example.com/" target="_blank">Support</a>');
        $actions = array_merge($settings, $actions);
        $actions = array_merge($site_link, $actions);
    }
    return $actions;
}
