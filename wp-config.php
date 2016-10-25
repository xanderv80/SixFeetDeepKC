<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'sixfeetdeepkc_com_3');

/** MySQL database username */
define('DB_USER', 'h85snrpm');

/** MySQL database password */
define('DB_PASSWORD', 'ybtTCnCr');

/** MySQL hostname */
define('DB_HOST', 'mysql.sixfeetdeepkc.com');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'w&"XASRq"qtSn~OINnDg_AP?V!;*54yPY`OCT_TeBwi:xp(Fem?^XR+r:%_W?;F|');
define('SECURE_AUTH_KEY',  'QP&6YA*vFdd_gq5^0Vu6uMjqbdCoO*_hN/aQC&a@~1MZ8`_F?94m@IXy:G)5t)$"');
define('LOGGED_IN_KEY',    '7b$Af5b~WC!(M$Tmtx$;0gHwndWAYuoQ?*OV#CajO2%Js)8g?Lcbo#xBC:#3*30*');
define('NONCE_KEY',        'v1#*Y*mHamyIOzUZP1@*IwOdGHO_Fd:#a4?7kp+j;R0?kMH+*PO?uNhuo$Kg2Chq');
define('AUTH_SALT',        '+`z;|fTV8oSdd?ZsC*wAWss8go5C%7MKZj7|GC^bWGm@O1sg/5Xt5()ig*W??7M0');
define('SECURE_AUTH_SALT', 'NYASdC`f:kAJ6R|_i;CSVcS8@?C%bXETk)dk*SB%;5E5gcZ!*docE&AyvFXE5l4&');
define('LOGGED_IN_SALT',   'j4V#Sqp_prAgm:2Sj1Qo31o8Cc#yud)gk+0sc_EvEB*mW!+PhEmeii&pb4Ac2E7#');
define('NONCE_SALT',       '(CyqQT%9oH0:FD_lK#4sQWGxt@V:K9_$xwjNpy`rWY;k@31T4S5W#Q*d|YqGjH)u');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_wdw7x7_';

/**
 * Limits total Post Revisions saved per Post/Page.
 * Change or comment this line out if you would like to increase or remove the limit.
 */
define('WP_POST_REVISIONS',  10);

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

