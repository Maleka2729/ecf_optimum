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
        email varchar (55) NOT NULL, 
        post_id mediumint(9) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    add_option('abonnement_db_version' , '1.0');
}

register_activation_hook(__FILE__, 'abonnement_database');

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

  $table_name = $wpdb->prefix . 'posts';
  $offres = $wpdb->get_results("SELECT * FROM $table_name WHERE post_type='offres' AND post_status = 'publish'; ", ARRAY_A);

  if (isset($_REQUEST['id'])) {
    $table_name = $wpdb->prefix . 'abonnements';
    $abonnement = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $_REQUEST['id']));
  }

if (isset($_POST['abonnements'])) {
    $name_user = sanitize_text_field($_POST['name_user']);
    $email = sanitize_text_field($_POST['email']);
    $post_id = ($_POST['post_id']);

    
    if (!empty($name_user) && !empty($email)) {
      $table_name = $wpdb->prefix . 'abonnements';

      $wpdb->insert(
        $table_name, array(
          'name_user' => $name_user,
          'email' => $email,
          'post_id' => $post_id,
        )
      );

      echo 'Merci pour votre abonnement !';
    }

  }
  
  echo '<form class="mt-5" method="POST">
  <h3>Formulaire inscription abonnement <h3>
  <input type="text" name="name_user" class="form-control mb-4" placeholder="Prénom"  style="color:black;" required/>
  <input type="email" name="email" class="form-control mb-4" placeholder="email"  style="color:black;" required/>
  <select name="post_id" class="form-control mb-4" >
      <option value=""> Choisir un abonnement </option>'; 
      foreach ($offres as $offre) {
        echo "<option value='" . $offre['ID'] . "' " . (isset($abonnement) && $abonnement->post_id == $offre['ID'] ? "selected" : "") . ">" . $offre['post_title'] . "</option>";
      }
  echo '</select>
  <button type="submit" name="abonnements" class="btn btn-info btn-block mb-4">ENVOYER</button>
  </form>';

  return ob_get_clean();
}

add_shortcode('abonnement_course_form', 'abonnement_course_form');