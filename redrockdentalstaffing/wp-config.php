<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'p1994516_staffing_agency');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'password');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '<6bbu$EPJP!*d@)g=+B>+ac&_*aqMSL~c}@N:oP0,c~o.e^K1)JGBe!&dc]U,p]L');
define('SECURE_AUTH_KEY',  'c8/pw@<7XjwaByX9B$<+ZWr4gEW^aj<^dW-8Xjdq:^kn3WxSpD)fDhkPlJS=?-{T');
define('LOGGED_IN_KEY',    'J){5k8fSP>TRE0j*K<[3rKFJC@KI6ed[E=si[QUS2FIv;)J;C,qs36_n>D)%h,U2');
define('NONCE_KEY',        'E?;VwiUYHgM:.h~f2=A&_#2hyrsouu}/uwd,:(qSlEnip 1Y@,C:^@nbh/y!]yM*');
define('AUTH_SALT',        '+ :1.C7TH)G(PG6B}z?uV.wVl^9fP$;b^9!JP`xfpsuZmh%]MUvYHdXAMp6t-3kj');
define('SECURE_AUTH_SALT', 'D_,<@EAB@yxVb(~tgGP}3&>,ABSI*h:%0f#p:Ggze>]L?3TJyrV9_UMKE:?r+>2_');
define('LOGGED_IN_SALT',   '$*HI sG-`FXL~CVpj|Au5Yxb%@ps45thO|GJXxuhTW,%[)HB%VyMP2UAfvdO+R83');
define('NONCE_SALT',       'm945u!+SrQ2Xj?;;J[t-GBEOqz}w]I|XaiUX^7k+^tkWf!Nkn9.U]bp =,4RS5&g');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'sa_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

ini_set('display_errors',0);
error_reporting(E_ALL|E_STRICT);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

# Disables all core updates. Added by SiteGround Autoupdate:
define( 'WP_AUTO_UPDATE_CORE', false );
