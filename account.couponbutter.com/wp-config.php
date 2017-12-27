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
define('DB_NAME', 'couponbu_piexec');

/** MySQL database username */
define('DB_USER', 'couponbu_piexec');

/** MySQL database password */
define('DB_PASSWORD', 'CouponBut@234$!&piexec0256');

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
define('AUTH_KEY',         'adf`UbFRMb_20Zc]BMETIX03gwQEa{aSOcqhDC!MSkfjuX+3/:.eZD<KM(vXkqz*');
define('SECURE_AUTH_KEY',  'GS8B+!i9@^U<r3uh T=s_iAB*Fm9+nE|lHE7g>wUdQF}q6;1HC1rgKSJ.A?h[8{$');
define('LOGGED_IN_KEY',    'qF]$u&lXEd&b(Q~#:UG3REb3+ ^9/xHYb[Med~x0sguIuLMWE;#cy3H~YmhzN3?<');
define('NONCE_KEY',        'j*)0kn-D#*E<x:~.bbL}d$&4%y*NF,mO[z}J8s/-TggZ&B+]ktrZo(wM*I`>/vBL');
define('AUTH_SALT',        'q{,1QI2zbF)1z~^X?.~WoCmM7$*uxl`7nIFVDXhEy4@5c-NX)NVK[{gLdn+@Hy:[');
define('SECURE_AUTH_SALT', '#kU6}j5(MdM6z^#Up<6GoTt@FWOh`*Pq>$bKs f9j(w~ZPPL*s$c7VVB+J#q0ye!');
define('LOGGED_IN_SALT',   '@d*8AS..a6G:*DR2APIAI&FZKp}^[B-g8Cywf6X8Z4,swS-=Qsq(w<*Ru~<k{s:~');
define('NONCE_SALT',       'R`*%F;`f9:zh&.7.SZL[O!YH |6.=}11pm7OvFWC3aPTbCN<?)vT.6Z)gP0yH{OF');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
//define('WP_MEMORY_LIMIT', '512M');

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
