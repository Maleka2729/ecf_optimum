<?php
/*
Plugin Name: Offres
Description: Creation plugin
Author: Malekalita
Version: 1.0.0
*/

function offres_init() {
	// CPT Event
	$labels = array(
	  'name' => 'Offres',
	  'all_items' => 'Toutes les offres',
	  'singular_name' => 'Offres',
	  'add_new_item' => 'Ajouter une offre',
	  'menu_name' => 'Offre'
	);
  
	$args = array(
	  'labels' => $labels,
	  'public' => true,
	  'show_in_rest' => true,
	  'has_archive' => true,
	  'rewrite' => array("slug" => "offres"),
	  'supports' => array('title', 'editor','thumbnail'),
	  'menu_position' => 5,
    'taxonomies' => array('category'),
	  'menu_icon' => 'dashicons-text-page',
	);
  
	register_post_type( 'offres', $args );
}
  
add_action('init', 'offres_init');

// Add meta box price to event
function add_offre_price_meta_box() {
	function offre_price($post) {
	  $price = get_post_meta($post->ID, 'offre_price', true);
  
	  if (empty($price)) $price = the_content();
  
	  echo '<input type="price" name="offre_price" value="' . $price  . '" />';
	}
  
	add_meta_box('offre_price_meta_boxes', 'Price', 'offre_price', 'offres', 'side', 'default');
}
  
add_action('add_meta_boxes', 'add_offre_price_meta_box');

// first step : create DB abonnement
function abonnement_database(){
    global $wpdb; 

    $table_name = $wpdb->prefix . 'abonnements';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint (9) NOT NULL AUTO_INCREMENT,
        name_user varchar (55) NOT NULL, 
        name_abonnement varchar(25) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    add_option('abonnement_db_version' , '1.0');
}

register_activation_hook(__FILE__, 'abonnement_database');

// Step 2 : creat default data
function insert_abonnement(){
  global $wpdb; 

  $table_name = $wpdb->prefix .'abonnements';

  $sql = "INSERT INTO $table_name (name_user, name_abonnement) VALUES ('Test test', 'Offre annuel');";

  require_once(ABSPATH . 'wp-admin/includes/update.php');
  dbDelta($sql);
  add_option('abonnement_db_version' , '1.0');
}

register_activation_hook(__FILE__, 'insert_abonnement');

// Third step : add plugin to admin
function add_plugin_abonnement_to_admin(){
  function abonnement_content(){
      echo "<h1> Abonnements </h1>";
      echo "<div style='margin-right:20px'>";

      if(class_exists( 'WP_List_Table' ) ) {
          require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
          require_once(plugin_dir_path(__FILE__). 'abonnement-list-table.php');
          $abonnementListTable = new AbonnementListTable();
          $abonnementListTable->prepare_items();
          $abonnementListTable->display();
      } else {
          echo "WP_List_Table n'est pas disponible";
      }

      echo "</div>";
  }

  add_menu_page('Abonnements', 'Abonnements', 'manage_options', 'abonnement-plugin', 'abonnement_content');
}

add_action('admin_menu', 'add_plugin_abonnement_to_admin');

// create the form reservation cours
function abonnement_course_form(){
  ob_start();
  global $wpdb;

  if (isset($_POST['abonnements'])) {
      $name_user = sanitize_text_field($_POST['name_user']);
      $name_abonnement = sanitize_text_field($_POST['name_abonnement']);
  
      
      if (!empty($name_user) && !empty($name_abonnement)) {
        $table_name = $wpdb->prefix . 'abonnements';

        $wpdb->insert(
          $table_name, array(
            'name_user' => $name_user,
            'name_abonnement' => $name_abonnement,
          )
        );

        echo 'Merci pour votre inscription !';
      }

  }

  $table_name = $wpdb->prefix . 'posts';
  $results = $wpdb->get_results("SELECT * FROM $table_name WHERE post_type = 'offres' AND post_status = 'publish';", ARRAY_A);
  // var_dump($result);
  
  echo '<form method="POST">
  <h3>Formulaire abonnement <h3>
  <input type="text" name="name_user" class="form-control" placeholder="Prénom Nom" required/>
  <select name="name_abonnement" class="form-select">
      <option value=""> Choisir un abonnement </option>'; 
      foreach ($results as $result) {
      echo '<option value="'. $result["post_title"] .'">'. $result["post_title"] . '</option>';
      };
  echo '</select>
  <input type="submit" name="abonnements" class="btn btn-primary" value="Envoyer"/>
  </form>';

  return ob_get_clean();
}

add_shortcode('abonnement_course_form', 'abonnement_course_form');