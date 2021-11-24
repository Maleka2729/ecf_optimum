<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en « wp-config.php » et remplir les
 * valeurs.
 *
 * Ce fichier contient les réglages de configuration suivants :
 *
 * Réglages MySQL
 * Préfixe de table
 * Clés secrètes
 * Langue utilisée
 * ABSPATH
 *
 * @link https://fr.wordpress.org/support/article/editing-wp-config-php/.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define( 'DB_NAME', 'optimum' );

/** Utilisateur de la base de données MySQL. */
define( 'DB_USER', 'root' );

/** Mot de passe de la base de données MySQL. */
define( 'DB_PASSWORD', '' );

/** Adresse de l’hébergement MySQL. */
define( 'DB_HOST', 'localhost' );

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/**
 * Type de collation de la base de données.
 * N’y touchez que si vous savez ce que vous faites.
 */
define( 'DB_COLLATE', '' );

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clés secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '421#!!]XqI]<h }e9%F*l]v5=q=h+/{-3?~Eb:2EaFZ!49*L,&)=FkB8|EQanZLB' );
define( 'SECURE_AUTH_KEY',  'w|iDwnLz]D$4{9`y[hrh-5/_K+C})1PzfC}tFvf@|ZCO`RHHk(MvK(w~S&!bU4w1' );
define( 'LOGGED_IN_KEY',    'W+*pMM->zp-Z6rk!2ejoWl[Nc12fg*qb0^5KvUkh_6)m @/4l}yycoy!SjTd9VA3' );
define( 'NONCE_KEY',        'e%``y^B!79~;{>>YmiaD_%oms(UI=LSr5j_OOt4^!RL5^]:Wa*f`0O++!a3 8.|x' );
define( 'AUTH_SALT',        '1-0TLYay|i*Jgf5Mk`S{xBpKo~kASed@v%,rF]f1lrZn!RC-Lb+8X< WuXTqBeNO' );
define( 'SECURE_AUTH_SALT', '&~Xj93sv/8Nr %u^%`x_}AEwYS.}F]79.:(Xy,g-Ma5.QZSQakTl?Ry3G]oi1oQL' );
define( 'LOGGED_IN_SALT',   '[!4h]W,2v=SIS#GZ5!#ikre{D*F*x4wKP2fI.?lB O)[?P}-x^v`NhAXtu_{la/J' );
define( 'NONCE_SALT',       '/I+}g3exMNX@d|==+`;fS?6jgG-CL&)Yy^O%S.H0aFWvBJ+[P+Q|*OsrDI(Q%p<a' );
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix = 'wp_optimum_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortement recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://fr.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* C’est tout, ne touchez pas à ce qui suit ! Bonne publication. */

/** Chemin absolu vers le dossier de WordPress. */
if ( ! defined( 'ABSPATH' ) )
  define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once( ABSPATH . 'wp-settings.php' );
