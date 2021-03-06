<?php
//echo 't';
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'wordpressuser' );

/** MySQL database password */
define( 'DB_PASSWORD', 'password' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

define('FS_METHOD','direct');
//echo 't';
/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'sp:Y1. tV|/`(]Nkc{Za%1pG;DWL)y!q+U_-!YB7PZ8+e$,+1;FE]TVX(^D;3sP&');
define('SECURE_AUTH_KEY',  '>5w@h7YBXM*Oe|afb)`MvyV-@?jvl4e{eI%ISmYdas?]M+^sz%]d<SuJ*{;<n6P^');
define('LOGGED_IN_KEY',    'OPatg|cq@If:1 g+/YLEC-6 1|h&,J.d|<1l^Cmny;xt4m|x8k|0mw_W0vM|!{[f');
define('NONCE_KEY',        '}uU=OKkV</!SH$K?MDchF}^j:{([<b5T=e+S)^H*3j>C?c)a!##DTv+@,%5wny+E');
define('AUTH_SALT',        './T{WGZludy~W-oanxl>b%ZX&(UqO_Y`<nb6NP0CP5+c+U${aoCl-4^/d!z,S&r?');
define('SECURE_AUTH_SALT', ']Aix~N6`C,VsHD!OIoJq#)TVQdal?9p[_V/q-C^rdv*Zk*xSpISkkn_$s;$|a@+:');
define('LOGGED_IN_SALT',   '<S^#nGB-qS1(g_llxtkT(`9a^0_XvasxQ[[2bTo9Y_-aM=sZ{nGxHVI;}9|(Y[]c');
define('NONCE_SALT',       'O`jKtFJLQYL9xb;8m|,/Jgszz&I|jJ|C{%g:QNw87Hvp6ZV,`u35b9C9lznoyllC');
/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
