<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
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
define('DB_NAME', 'delve-free');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         'grBu/BN;cr/fR@T> p%(XD$U+@`NExv]>~=<3!]G3f*!xE5D C@4EyS5^pHeP7>|');
define('SECURE_AUTH_KEY',  'cNqS#EPWF_$Xa! _P^1jxl}~N%`x;Hj@tBsX=ix$0C+|V$y9fP<iAl:Qo}2Eg&XF');
define('LOGGED_IN_KEY',    'thcY.yr.m&oU]15mv]I0=3s/z<~tzEg`)HKmbr48,+,ei0lZaavZo&uO~{&vU+$A');
define('NONCE_KEY',        'R ~Iy+ZguDJ.bVUiNDP|NkI|<S:SgV<t>IM?xTHUKI-[B:(bq,4YC<$*`!0h{nY}');
define('AUTH_SALT',        '@oO>t|K&O6-_b]N/&P;f5TY48Np:IAfs~[gCf|(|+)qy}PK6va|L=u<]y`67QCE;');
define('SECURE_AUTH_SALT', '->>`2edZ=hKar>e+2EA<-.PQ&@|)$#;aoVum:7MvDVo)!W(_rR5L2Aigyp$-BHEW');
define('LOGGED_IN_SALT',   '@cr>r@6|c~o$z`C,QqW,q/Gr-L--1$FT|h?[J>rGu0z>_xq=I@TK[O=M/~U:[J/P');
define('NONCE_SALT',       'L}2vHpAh&d6#s$(aLDu+<nZUl=Z_KdsZNb4`X]o[I;tzRN5%y-)lcK!;7cDh_RxN');

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
