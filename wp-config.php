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
define('DB_NAME', 'thescene_astrochimp_com');

/** MySQL database username */
define('DB_USER', 'thesceneastrochi');

/** MySQL database password */
define('DB_PASSWORD', 'Rxkrv-C?');

/** MySQL hostname */
define('DB_HOST', 'mysql.thescene.astrochimp.com');

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
define('AUTH_KEY',         'Ve1S_`2EJO~~e8Mo!Sy"y(Fh77?k(wz2y9fP#ne4;Oq;"~7IGX|a?DNwL^zlu)lB');
define('SECURE_AUTH_KEY',  '4UfpXuDQN5i+!qlz`oS@y%/Zil8p%TOpinFHHXo/?m6yEHs+Sv7^TKw`x&yeq#|M');
define('LOGGED_IN_KEY',    'hV~3O?6BbUBRMt?gI"N&stdz2#Iv~^AmyqIJibDfsS:5_aXa!:RM1DXl0ZIm9%VF');
define('NONCE_KEY',        'kDbREazdpzQNaB82Lt!~20LK"A:XY$koFlx5~iv6x~5HE/aX:8WU)bP1P^L$+8Iq');
define('AUTH_SALT',        'k/tk6b^2r`jtg`ggG5h!VIH9qw*k85LaQv6)X9X4@rzh@MVjZ:4stz@c^o)ZT89|');
define('SECURE_AUTH_SALT', 'Bcnhl~4Zk+BurxpAURGcrPRt|T:%ze&bEadyi:C%Zd;uSy7$2?1`kqmd6"snnu)i');
define('LOGGED_IN_SALT',   ')A4#T0)yWXHqY5kD?`Hi;LfIBNhWl"F"5PqiMjR;(i#;11q|Fik!kKP5|(~L69J_');
define('NONCE_SALT',       '/Av;/CUi@sw"~yBj+ESInFj3RuB$n~Ed(Atdbv7WNY(D/)m*qQ|ijK:z00H*eMKu');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_2_';

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

