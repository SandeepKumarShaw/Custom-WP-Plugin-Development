<?php
   /*
   Plugin Name: Change Admin Logo Url
   Plugin URI: https://example.com/
   Description: A plugin that user can change their backend admin logo and also change the powered by url.
   Version: 1.0
   Author: example
   Author URI: https://example.com/
   License: GPL2
   */



if ( ! defined( 'ABSPATH' ) ) {
	die( 'Error!' );
}
function calu_logo_title() {
	if ( get_option( 'calu_logo_url' ) != '' ) {
		return sprintf ( __( 'Go to %1$s'), esc_url( get_option ( 'calu_logo_url' ) ) );
	}
}
add_filter( 'login_headertitle', 'calu_logo_title' );

function calu_logo_url($url) {
	if ( get_option( 'calu_logo_url' ) != '' ) {
		return esc_url( get_option( 'calu_logo_url' ) );
	} else {
		return esc_url( get_bloginfo( 'url' ) );
	}
}
add_filter( 'login_headerurl', 'calu_logo_url' );

function calu_logo_file() {
	if ( get_option( 'calu_logo_file' ) != '' ) {
		echo '<style>.login h1 a { background-image: url("' . esc_url ( get_option( 'calu_logo_file' ) ) . '"); background-size: auto auto; width: 320px; }</style>';
	} /*else {
		echo '<style>.login h1 a { background-image: url("' . plugins_url( 'vanderwijk.png' , __FILE__ ) . '"); background-size: auto auto; width: 320px; }</style>';
	}*/
}
add_action( 'login_head', 'calu_logo_file' );

function calu_admin_scripts() {
	
	wp_enqueue_media();
	wp_register_script( 'calu-media-upload', WP_PLUGIN_URL . '/change-admin-logo-url/resources/js/fileupload.js', array( 'jquery' ) );
    wp_enqueue_script( 'calu-media-upload' );
}
	add_action( 'admin_print_scripts', 'calu_admin_scripts' );

require_once( 'calu-admin/calu-admin-options.php' );
