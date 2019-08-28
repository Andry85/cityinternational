<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * @link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'cityinternational');

/** MySQL database username */
define('DB_USER', 'cityinternationa');


//localhost
//define('DB_NAME', 'cityinternational');

/** MySQL database username */
//define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'MkZaPltar');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the @link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'j8MWG8~*ZYULO9(um;5rXdS,.pcZyhEa0ku4o.;AlBKV1H.iUZPFa£M)vkAvX!.w');
define('SECURE_AUTH_KEY',  'r5GXkPkt%;LSHzIv)z,mhT%x%%1XjOo~bzaf6PHhtCe~L9rQkHi7WYBVJ*VJ£F5U');
define('LOGGED_IN_KEY',    '0B9aoGm#CBXwUZTx6:CL(:qnG.CkJ#my7V.b8W~Wj7&J:OE,r)ipg)D.&kaz#8_s');
define('NONCE_KEY',        'l£7G7*C-0+yGx43nM,j6^2KTK*s+^TxALq$Bd9;B=8C6EtXA0$J-;WJGEJ=a~w+e');
define('AUTH_SALT',        'IHXEb*w*Usuipj_Q_,VaCK~.&kk~hL7&FIPGxlPZG1M-FgU,+HNx$tB6R5K19ALf');
define('SECURE_AUTH_SALT', 'z610xwV3iA£M;NxduZVpkbq*.romRhHOl$+$2kmw;w3,l$^bO9ln4rU$h3+M%~^B');
define('LOGGED_IN_SALT',   'z!h74lV$$sFP:K,#04yNxEYs20f;GEkXG3~5vxi;IGppo359EvKhP.XbD-^2Uh,y');
define('NONCE_SALT',       'nz6R,8GvN+Kv=4X.IhHRbPIAQ7f_v%!uv(bam9ouw,%)w^S_~JaB_^jW&qoZTZd)');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', true); // @fixme set to false on deploy

/**
 * LiveReload
 */

define('IW_LIVERELOAD', false); // @fixme set to false on deploy

// First pipe-separated value is default hostname; subsequent values must
// be LOCALHOSTNAME:LIVERELOADHOST (for env-specific live reloading).
define('IW_LIVERELOAD_HOST', 'iwdserver|MacBook-Pro:localhost');

define('IW_WOOCOMMERCE', false);

define('IW_PROFILE', false); // @fixme set to false on deploy

define('IW_WC_DEBUG_INPUTS', false); // @fixme set to false on deploy

define('WPCF7_AUTOP', false);

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
