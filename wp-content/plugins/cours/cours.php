<?php
/*
Plugin Name: Reservation
Description: Creation plugin
Author: Malekalita
Version: 1.0.0
*/

function cours_init() {
	// CPT Event
	$labels = array(
	  'name' => 'Cours',
	  'all_items' => 'Tous les cours',
	  'singular_name' => 'Cours',
	  'add_new_item' => 'Ajouter un cours',
	  'menu_name' => 'Cours'
	);
  
	$args = array(
	  'labels' => $labels,
	  'public' => true,
	  'show_in_rest' => true,
	  'has_archive' => true,
	  'rewrite' => array("slug" => "cours"),
	  'supports' => array('title', 'editor','thumbnail'),
	  'menu_position' => 5,
    'taxonomies' => array('category'),
	  'menu_icon' => 'dashicons-groups',
	);
  
	register_post_type( 'cours', $args );
}
  
add_action('init', 'cours_init');

// Add meta box place to event
function add_event_place_meta_box() {
	function event_place($post) {
	  $place = get_post_meta($post->ID, 'event_place', true);
  
	  if (empty($place)) $place = the_content();
  
	  echo '<input type="place" name="event_place" value="' . $place  . '" />';
	}
  
	add_meta_box('event_place_meta_boxes', 'Place', 'event_place', 'events', 'side', 'default');
}
  
add_action('add_meta_boxes', 'add_event_place_meta_box');

// Add meta box price to event
function add_event_price_meta_box() {
	function event_price($post) {
	  $price = get_post_meta($post->ID, 'event_price', true);
  
	  if (empty($price)) $price = the_content();
  
	  echo '<input type="price" name="event_price" value="' . $price  . '" />';
	}
  
	add_meta_box('event_price_meta_boxes', 'Price', 'event_price', 'events', 'side', 'default');
}
  
add_action('add_meta_boxes', 'add_event_price_meta_box');

// first step : create DB reservation
function reservation_database(){
    global $wpdb; 

    $table_name = $wpdb->prefix . 'reservations';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint (9) NOT NULL AUTO_INCREMENT,
        name_user varchar (55) NOT NULL, 
        phone int(6) NOT NULL,
        email varchar (55) NOT NULL, 
        name_course text(55) NOT NULL,
        place int(2) NULL, 
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    add_option('reservation_db_version' , '1.0');
}

register_activation_hook(__FILE__, 'reservation_database');

// Step 2 : creat default data
function insert_reservation(){
  global $wpdb; 

  $table_name = $wpdb->prefix .'reservations';

  $sql = "INSERT INTO $table_name (name_user, phone, email, name_course, place) VALUES ('Test test', '123456','test@test.nc', 'test', '1');";

  require_once(ABSPATH . 'wp-admin/includes/update.php');
  dbDelta($sql);
  add_option('reservation_db_version' , '1.0');
}

register_activation_hook(__FILE__, 'insert_reservation');

// Third step : add plugin to admin
function add_plugin_reservation_to_admin(){
  function reservation_content(){
      echo "<h1> Reservations </h1>";
      echo "<div style='margin-right:20px'>";

      if(class_exists( 'WP_List_Table' ) ) {
          require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
          require_once(plugin_dir_path(__FILE__). 'reservation-list-table.php');
          $reservationListTable = new ReservationListTable();
          $reservationListTable->prepare_items();
          $reservationListTable->display();
      } else {
          echo "WP_List_Table n'est pas disponible";
      }

      echo "</div>";
  }

  add_menu_page('Reservations', 'Reservations', 'manage_options', 'reservation-plugin', 'reservation_content');
}

add_action('admin_menu', 'add_plugin_reservation_to_admin');

// create the form reservation cours
function reservation_course_form(){
  ob_start();
  global $wpdb;

  if (isset($_POST['reservations'])) {
      $name_user = sanitize_text_field($_POST['name_user']);
      $phone = sanitize_text_field($_POST['phone']);
      $email = sanitize_text_field($_POST['email']);
      $name_course = sanitize_text_field($_POST['name_course']);
      $place = sanitize_text_field($_POST['place']);
  
      
      if (!empty($name_user) && !empty($phone) && !empty($email) && !empty($name_course) && !empty($place)) {
        $table_name = $wpdb->prefix . 'reservations';

        $wpdb->insert(
          $table_name, array(
            'name_user' => $name_user,
            'phone' => $phone,
            'email' => $email,
            'name_course' => $name_course,
            'place' => $place
          )
        );

        echo 'Merci pour votre inscription !';
      }

  }

  $table_name = $wpdb->prefix . 'posts';
  $results = $wpdb->get_results("SELECT * FROM $table_name WHERE post_type = 'cours' AND post_status = 'publish';", ARRAY_A);
  // var_dump($result);
  
  echo '<form method="POST">
  <h3>Formulaire de réservation <h3>
  <input type="text" name="name_user" class="form-control" placeholder="Prénom" required/>
  <input type="number" name="phone" class="form-control" placeholder="Phone" required/>
  <input type="email" name="email" class="form-control" placeholder="email" required/>
  <select name="name_course" class="form-select">
      <option value=""> Choisir un evenement </option>'; 
      foreach ($results as $result) {
      echo '<option value="'. $result["post_title"] .'">'. $result["post_title"] . '</option>';
      };
  echo '</select>
  <input type="number" name="place" class="form-control" placeholder="place" required/>
  <input type="submit" name="reservations" class="btn btn-primary" value="Envoyer"/>
  </form>';

  return ob_get_clean();
}

add_shortcode('reservation_course_form', 'reservation_course_form');