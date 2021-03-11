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
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'h+JLtkD8KB09kD++ysL8/raOUeNjoCxEHCJ3Q4nvGmNrf0BSnnxidA6qEdKpPcmPtbVuqG3O1GnhTaLPVoVmcg==');
define('SECURE_AUTH_KEY',  '1FaKGnqtP8+a9rhi3Hev6TPh01MDrbMqMvQ4itXZEspihP9XJyHQtxFXUMADTDpAYlxl6nx18z0rvvgMd3rkYg==');
define('LOGGED_IN_KEY',    '7LKot0hjpCZ8ZTTVevsLjCRjAjqnL5ieJh1gKohqgMg9PXS7CUioCh+glMao1TK9vvyvGVP7RfoMPg+qN2+eIA==');
define('NONCE_KEY',        'TSZ5TfXDNThSrgHD1oE8GJJtZHYfxAPR/OJRU1DfXRiyXD5ZidVUmW6HsMfUe3ld21ujiWlFmBA4XvZntX/dCQ==');
define('AUTH_SALT',        'LvbO46/3xXAgl0j14P49rgGYvaQNj9tQNoH2wncB4AaGkjcYSUtWF7PbqbAwLcNv2J71IVVGEDPIPp/fZwdfSA==');
define('SECURE_AUTH_SALT', 'j1MFiQWc2cfP0oe/GdBNBLgwqlMkn7eaM/doDjxrc47bJJbhodBaftXpRGsQs9ydJy4TylHQXzmVby620gnKcQ==');
define('LOGGED_IN_SALT',   'UYeadrv6wyaonxI5BHtl/7CUT1aLUhHSYwG54pc4rFzeWP2aj00NLw0+/K478xu63IoTL3ZV3uaYJ5Gq8uSUbQ==');
define('NONCE_SALT',       'eZPKFvqMZCSPn4xaVoGHWBmq/6Qem7A4EgJ/hzrkSePwEBynBkwRAesefa6PiKScsU4tG43gWW13a81HtQclaw==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
