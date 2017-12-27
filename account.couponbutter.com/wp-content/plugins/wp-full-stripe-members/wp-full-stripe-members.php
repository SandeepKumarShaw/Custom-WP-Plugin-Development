<?php

/*
Plugin Name: WP Full Stripe Members
Plugin URI: http://paymentsplugin.com
Description: Fully featured membership add-on for WP Full Stripe.  Create premium content for subscribers only.
Version: 1.2.0
Author: Mammothology
Author URI: http://paymentsplugin.com
*/

function plugin_init() {
    if( class_exists( 'MM_WPFS' ) )
    {
        //defines
        if (!defined('WPFS_MEMBERS_NAME'))
            define('WPFS_MEMBERS_NAME', trim(dirname(plugin_basename(__FILE__)), '/'));

        if (!defined('WPFS_MEMBERS_BASENAME'))
            define('WPFS_MEMBERS_BASENAME', plugin_basename(__FILE__));

        if (!defined('WPFS_MEMBERS_DIR'))
            define('WPFS_MEMBERS_DIR', WP_PLUGIN_DIR . '/' . WPFS_MEMBERS_NAME);

	    $wpfs_domain  = 'wp-full-stripe';
	    $locale       = apply_filters( 'plugin_locale', get_locale(), $wpfs_domain );
	    $mofile       = trailingslashit( WP_PLUGIN_DIR ) . $wpfs_domain . '/languages/' .$wpfs_domain . '-' . $locale . '.mo';
	    $plugin_rel_path2 = basename( dirname( __FILE__ ) ) . '/languages/';
	    
	    $wpfs_loaded  = load_textdomain( $wpfs_domain, $mofile );
	    $wpfsm_loaded = load_plugin_textdomain( 'wp-full-stripe-members', false, $plugin_rel_path2 );

        require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'wpfs-members-main.php';
        register_activation_hook( __FILE__, array( 'MM_WPFS_Members', 'setup_db' ) );
        register_deactivation_hook( __FILE__, array( 'MM_WPFS_Members', 'uninstall' ) );

    }
}
// Only load once WP Full Stripe is loaded
add_action( 'plugins_loaded', 'plugin_init' );

//TODO: why does this have to be here as well??
if(!class_exists( 'MM_WPFS' ))
    return;

//defines
if (!defined('WPFS_MEMBERS_NAME'))
    define('WPFS_MEMBERS_NAME', trim(dirname(plugin_basename(__FILE__)), '/'));

if (!defined('WPFS_MEMBERS_BASENAME'))
    define('WPFS_MEMBERS_BASENAME', plugin_basename(__FILE__));

if (!defined('WPFS_MEMBERS_DIR'))
    define('WPFS_MEMBERS_DIR', WP_PLUGIN_DIR . '/' . WPFS_MEMBERS_NAME);

require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'wpfs-members-main.php';
register_activation_hook( __FILE__, array( 'MM_WPFS_Members', 'setup_db' ) );
register_deactivation_hook( __FILE__, array( 'MM_WPFS_Members', 'uninstall' ) );
