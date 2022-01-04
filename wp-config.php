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
define( 'DB_PASSWORD', 'secret' );

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
define('AUTH_KEY',         'v3>)Y) {nYu,aUaFx#FqVJK(B|@k]IqGhs8MyG?K^UHXg:Q4U[3sFjT;;0+:,.nA');
  define('SECURE_AUTH_KEY',  'FD<Juc^@mU^)|Wzs]hmAu`~;Le%8Cs`-:+#1(wmj|.0Oc@O]`$id:1,C]-s2eg^M');
  define('LOGGED_IN_KEY',    'D[{>zr+s.n&GeF}e0/|.pVExGl+=#T#c0Y*|`om).KUR~O7y-0Zb@O=CVLuy,4c(');
  define('NONCE_KEY',        '$/GF=C&3H%ImZ|8jkmxMG1BV#6Md<Q0)-2>ms:3zX6L?L7p%+N)>%X]cs1@70xx5');
  define('AUTH_SALT',        'bff~3tRr&g|vg8MHbD~[c]%i=6sHn=I-xk.TGiGQO#[iB/d.H7IPh</&]U|IxEnO');
  define('SECURE_AUTH_SALT', '4<-Ri>gt]e/e69~fJwlBnhaL|K1,H$u&; HrAddj0N/LGqE]P~lg-P}0bE{1-ntd');
  define('LOGGED_IN_SALT',   'O1C5p-nw|I;ODvjBs -vcy$+SUETDT|dZ/AAUis&*#{sJz}kDgWU#OcCX|2IWLxH');
  define('NONCE_SALT',       'QP+tuj5z@sF|UR*}Y*H`,2&X/Gw1|;5,-yr}yji4$P`<>p+-YX9*DqjgsZ+~Mfzb');
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
