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
define( 'DB_NAME', 'askit_new' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'p@ssw0rd12' );

/** MySQL hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '^xDgEvF@Z[4FF3+Xx>L/]|CnIW,VOB-Zufn?h(|&t2QaJ eI[/[0,4rj/0X)Agw*' );
define( 'SECURE_AUTH_KEY',  '*Tr%@OGzo*i_T/dv&hCMU`-o@KuH[)R`KIU*vj!bx`1417($d$rzGM3lG#r)7yhh' );
define( 'LOGGED_IN_KEY',    'ig~7YC(g,Y9R1.AZQSu4y1V/_|Ew)):Tsfk_-LvNOupY5lRxGTA.sa@f3{1KiUyF' );
define( 'NONCE_KEY',        'eRScs2mrM*ep=wue=B0{=O+M.M$u?1qV3v;]aWG?eEv.yw.fRQ/NCe)4L`-j4u@3' );
define( 'AUTH_SALT',        'X!%DQ2u^Kmm[6d,BcRA_.Sd{>4niCa|lqetZ6Xk]-T{H{B(4C(</n[^F4~EhP0e`' );
define( 'SECURE_AUTH_SALT', 'rC7x.a7@B}l90ee=_u{T,*IP+9%ql@q@FAB-.jX_p_J|ZU%%Ah0qnqz(|L3&cAJ_' );
define( 'LOGGED_IN_SALT',   'yR;QNV,FMC4?SPDmC_sN90gM%CM+qL0(&]/q4ZLzryv,[*s3Gbmwd=Mw@qf%DTi9' );
define( 'NONCE_SALT',       '[)#T#RUha&C2M!=ds;3EQqvsmq+KP3uT9o0;udm|Cyu8W@tl^>TN?50W8Ji$Sszu' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );




// REMOVE FTP ACCESS TO INSTALL THEME VIA ZIP FILE

define('FS_METHOD', 'direct');

