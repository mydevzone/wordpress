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
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '>FbSSz?4j=@a>fdZe8)4a;4J=WfE>AyD)=bH+l/0;pi6rRhh`m`FC7|j[y+vRMda');
define('SECURE_AUTH_KEY',  '%8Zavj}(wS.DkC.^RI8k|SKAg4yOP^|A#&,Qz3`gmYFxk+H?vbEG2c@nm&4*!]W<');
define('LOGGED_IN_KEY',    'x9^y$+$dXie8N-wa ;r+RvzgN)0ldqZ,&|0u6u + .GB%]JnBH7E<^>u*spk:RBn');
define('NONCE_KEY',        'CPNXOeVCszhe)0)18HUQ?F`gL)7}),VGfpDbokX&^QwJ+&jPG]wEkmCmc-LJi[^v');
define('AUTH_SALT',        '|q,OwY;q.V0c^Y),Kn-erv/J|RRoIdtxKRjVNcGk=^sOUevx0Slir&m$07s>kg,@');
define('SECURE_AUTH_SALT', '}~;_xN|:K!]#z0>k|=Z1`BQAg9ud|3j^e8)lQ|l$X;w&yiWY<H%@]-2/-@ox:W-^');
define('LOGGED_IN_SALT',   'rK|Dc~.(zs<El=2L[$uAr=5&:oP)S]Z6~dGPgOv)cc?{/xWS?g6V-aPb>GT_YH}p');
define('NONCE_SALT',       '+EDW3V}JS484H[;(3NYi/o/p<{=4WP1#s}3Sj`#LXMFS;(GdH<HUp>0O(?Qi<wh4');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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

