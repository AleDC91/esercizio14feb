<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('WP_CACHE', true);
define( 'WPCACHEHOME', '/var/www/progetto_week_11/wp-content/plugins/wp-super-cache/' );
define('DB_NAME', 'progetto_week_11' );

/** Database username */
define('DB_USER', 'progettoWeek11Admin' );

/** Database password */
define('DB_PASSWORD', '3kmd#!kIH7R!09llsW@?!fgh65#RTXS' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

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

define('AUTH_KEY',         '7o.G:-E[F+@^Z6P>n{0:.=PIvd:pj%?O6b=-!0`;;7a>Eh}CK&.rXL9K=kzO];8y');
define('SECURE_AUTH_KEY',  ' $xL(DJn!&BCYca!_6>+Keyh>Y/|!^2q|LT0e/-)&E!ElJT0CYAOboszIpv>E`Pm');
define('LOGGED_IN_KEY',    '-?BISLf>N+;>BVxH$7l|G:e23QsS[mc+9cO=we#Wbn+X0TAHhQr5.V<JZZ&T.<:6');
define('NONCE_KEY',        'K4N1g|a5l)KWJ:k3wvFc%kBU[.YJ:_cV;?^$)P_c&]1}.cf!~8TKSpD,b,-q?S1<');
define('AUTH_SALT',        'mXDt}q].d&ZsCm3(F?G8D,tVeS=92tRS$.ZW{ed$thKx,9A]2]`/-}ju!w]9v~ E');
define('SECURE_AUTH_SALT', '<u*gO-+2b MS?|<?+;l><pD|K$PMsQOSTWbfAm&alw}zosn*[eb^L@D+Vjja#FhH');
define('LOGGED_IN_SALT',   'Vx_TcKyw0GR-G7BiOI%oP{TyyYl;`nSZr0-@+j[92JDLA-la,X/Ibd;!J($Zg.4D');
define('NONCE_SALT',       '%$&KZ9tHX(CZy8?sHV@b3?E+(sdtQkXvUw}3#aZ6~VH~m/!Sr0fhX/T~Ex]#7Zw)');
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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
define('FS_METHOD', 'direct');
