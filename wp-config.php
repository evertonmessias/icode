<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

define('WP_HOME','https://icode.dell3490.com/');
define('WP_SITEURL','https://icode.dell3490.com/');
define('FS_METHOD','direct');

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'novoicode' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'efc;2505xx' );

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
define( 'AUTH_KEY',         'SJ1%P8NZgZiNq$:c!S`.PCU adJvba)6-~w}ZMAR*l_S$o.,KVH9yG`Pb;=>fb@0' );
define( 'SECURE_AUTH_KEY',  '66noFU:ruNwNf1L=TxD&Kz|X(6VgW5I#`^fzGY$aLLn<#1{,8* )Z^6tw#yV3Ms;' );
define( 'LOGGED_IN_KEY',    'cUjXkAYNypw2jyf1!@!fkh>OEV:$Y4zwx~x>QSw]E?.J]6q$e{KYTbFw^;%Z*.Yb' );
define( 'NONCE_KEY',        '/TIQV%+kR(Cvk&QpAtc2wf(aNDFK(H0FZo;rWUOT}vP8{mx0s3p<U#P_&ij=9>u ' );
define( 'AUTH_SALT',        '4[ 2LCGmIiK2x1~4y!,OJ7:MET`d+9%UM(Y_fw*sP{?Ib7[{28S#~3ysnxl@2hg<' );
define( 'SECURE_AUTH_SALT', '*[Go$!qD31):4&3L);3|4!zBg,K/lMvRF`4(fv[kP|+gyJgE-[l>*gbk.)Qc>7{7' );
define( 'LOGGED_IN_SALT',   'tjL #$Rekph}-@+!V7yr_H!`we?m^CFlj[UdJaSgyQp1E%w2?aRC=%^%P!+LVd_*' );
define( 'NONCE_SALT',       'SI3 F8es%3Po$7[ W`ooV*zrB}  FbJ[T`(&>_;aR84#rKMaW<S:J2-Y;nh@Y`z)' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * Para desenvolvedores: Modo de debug do WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */

define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true); // Isso fará com que os erros sejam gravados em wp-content/debug.log
define('WP_DEBUG_DISPLAY', false); // Para não exibir erros na tela para o público

//POST_REVISIONS
define('WP_POST_REVISIONS', true);

// SMTP
define( 'SMTP_USER', 'instcomp@ic.unicamp.br' );  // Seu e-mail SMTP
define( 'SMTP_PASS', 'shae2euX' );  // Sua senha de e-mail SMTP
define( 'SMTP_HOST', 'smtp.ic.unicamp.br' );  // O servidor SMTP (exemplo: smtp.gmail.com)
define( 'SMTP_PORT', 587 );  // Porta (587 para TLS, 465 para SSL)
define( 'SMTP_SECURE', 'tls' );  // 'ssl' ou 'tls'
define( 'SMTP_FROM', 'instcomp@ic.unicamp.br' );  // O e-mail do remetente
define( 'SMTP_NAME', 'ICODE' );  // Nome do remetente

// Google RECAPTCHA:
define('RECAPTCHA_V3_SITE_KEY', '6LeJRbgpAAAAAF2IZUkm08BQjGULpT6UWMBNr_L2');
define('RECAPTCHA_V3_SECRET_KEY', '6LeJRbgpAAAAAJyEUfxcwG0JJ0Hq3SawfJbesd49');

// Google OAuth 2.0
define('GOOGLE_CLIENT_ID', '349747948304-85pa1fc8pj4fc7fvts6sp24shkh72o9k.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', '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');
define('GOOGLE_TOKEN_URL', 'https://oauth2.googleapis.com/token');
define('GOOGLE_USERINFO_URL', 'https://www.googleapis.com/oauth2/v2/userinfo');
define('GOOGLE_AUTH_URL','https://accounts.google.com/o/oauth2/v2/auth?');

// Intranet
define("INTRANET","https://intranet.ic.unicamp.br/pub");


// Postgre Config
define("POSTGRE_HOST","localhost");
define("POSTGRE_USER","postgres");
define("POSTGRE_DATA","icodeia_vectors");
define("POSTGRE_PASS","efc;2505xx");
define("POSTGRE_TABL","embeddings");


/** Caminho absoluto para o diretório WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

//*************URL theme [ get_template_directory_uri() ]
define('SITEPATH', '/wp-content/themes/novoicode/');

/** Configura as variáveis e arquivos do WordPress. */
require_once ABSPATH . 'wp-settings.php';
