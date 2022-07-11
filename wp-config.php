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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'creed' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'bBP/qV2U<dZ}-zXFq{_f4~aPev,,WH/L{VDH&;D}+g;eD9um..CvvVD%q!0-+ul/' );
define( 'SECURE_AUTH_KEY',  'Az?CW^cu&0_gP6izOK9?X,9w>n&fN<.I&+Ah/<JTIrIfm]!YOxJ(_=i_$Sqz<dm#' );
define( 'LOGGED_IN_KEY',    'Fd&kG~YMKB@&^3a$q1, 7kz.]Y.zru{x/*nQmEe5&)*kl}&)H^ 1 whU6O>VWd`A' );
define( 'NONCE_KEY',        ',KyuKYSlKK3l&v^~|9)rwow8H.9;UkZeWti=X_^IsSjZ,+d|Q NK#>PbIb4NDAy3' );
define( 'AUTH_SALT',        'N6eqA.9{/aF5X2 [7Ay8.z^<k{^knz~]:MSFbyRZf2A<PBs/04{L-iX2ct}nOUy+' );
define( 'SECURE_AUTH_SALT', 'ICTPnv9w++1ketRT4]9b@XJ|E-O#O8>+h~d?xcDyJ!jt!#h,,4jj5FOy(S.C[SJh' );
define( 'LOGGED_IN_SALT',   'ygee-fKr<Js*GYG=SF uVL%([q(p416~rc]uc-a04v& 5[DxX(R%W-V*h.%ghB0P' );
define( 'NONCE_SALT',       'z./,^CJbU#T`]!}t1*$&NarCbJ^X&okE[`n+)L$5s+I6p#g5XMfnf%*_rqJQp%sJ' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_db1_';

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
