<?php
/*
Plugin Name: WP Full Stripe
Plugin URI: http://paymentsplugin.com
Description: Complete Stripe payments integration for Wordpress
Author: Mammothology
Version: 3.6.0
Author URI: http://paymentsplugin.com
Text Domain: wp-full-stripe
Domain Path: /languages
*/

define( 'STRIPE_API_VERSION', '1.17.2');

//defines
if ( ! defined( 'WP_FULL_STRIPE_NAME' ) ) {
	define( 'WP_FULL_STRIPE_NAME', trim( dirname( plugin_basename( __FILE__ ) ), '/' ) );
}

if ( ! defined( 'WP_FULL_STRIPE_BASENAME' ) ) {
	define( 'WP_FULL_STRIPE_BASENAME', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'WP_FULL_STRIPE_DIR' ) ) {
	define( 'WP_FULL_STRIPE_DIR', plugin_dir_path( __FILE__ ) );
}

//Stripe PHP library
if ( ! class_exists( 'Stripe' ) ) {
	include_once( 'stripe-php/lib/Stripe.php' );
} else {
	if ( substr( Stripe::VERSION, 0, strpos( Stripe::VERSION, '.' ) ) != substr( STRIPE_API_VERSION, 0, strpos( STRIPE_API_VERSION, '.' ) ) ) {
		wp_die(plugin_basename(__FILE__) . ': ' . __('Incompatible Stripe API client loaded. Plugin is unserviceable.'));
	}
}

require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'wp-full-stripe-main.php';
register_activation_hook( __FILE__, array( 'MM_WPFS', 'setup_db' ) );

function wp_full_stripe_load_plugin_textdomain() {
	load_plugin_textdomain( 'wp-full-stripe', false, basename( dirname( __FILE__ ) ) . '/languages/' );
}

add_action( 'plugins_loaded', 'wp_full_stripe_load_plugin_textdomain' );