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

// Add meta box place to cours
function add_cours_place_meta_box() {
	function cours_place($post) {
	  $place = get_post_meta($post->ID, 'cours_place', true);
  
	  if (empty($place)) $place = the_content();
  
	  echo '<input type="place" name="cours_place" value="' . $place  . '" />';
	}
  
	add_meta_box('cours_place_meta_boxes', 'Place', 'cours_place', 'cours', 'side', 'default');
}
  
add_action('add_meta_boxes', 'add_cours_place_meta_box');

// Add meta box price to cours
function add_cours_price_meta_box() {
	function cours_price($post) {
	  $price = get_post_meta($post->ID, 'cours_price', true);
  
	  if (empty($price)) $price = the_content();
  
	  echo '<input type="price" name="cours_price" value="' . $price  . '" />';
	}
  
	add_meta_box('cours_price_meta_boxes', 'Price', 'cours_price', 'cours', 'side', 'default');
}
  
add_action('add_meta_boxes', 'add_cours_price_meta_box');

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
        post_id mediumint(9) NOT NULL,
        place int(2) NULL, 
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    add_option('reservation_db_version' , '1.0');
}

register_activation_hook(__FILE__, 'reservation_database');

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

  // Add submenu reservation 
  function submenu_reservation_form() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'posts';
		$courses = $wpdb->get_results("SELECT * FROM $table_name WHERE post_type='cours' AND post_status = 'publish'", ARRAY_A);

		if (isset($_REQUEST['id'])) {
			$table_name = $wpdb->prefix . 'reservations';
			$reservation = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $_REQUEST['id']));
		}

		echo "<h1>Modification Réservation</h1>";
		echo "<div style='margin-right:20px'>";
		echo "<form method='POST'>";
		echo "<input type='text' name='name_user' placeholder='Prénom Nom' " . (!isset($reservation) ? "" : "value='" . $reservation->name_user . "'") . " required><br>";
		echo "<input type='text' name='phone' placeholder='Téléphone' " . (!isset($reservation) ? "" : "value='" . $reservation->phone . "'") . " required><br>";
    echo "<input type='text' name='email' placeholder='Email' " . (!isset($reservation) ? "" : "value='" . $reservation->email . "'") . " required><br>";
		echo "<select name='post_id'>";
      foreach ($courses as $course) {
        echo "<option value='" . $course['ID'] . "' " . (isset($reservation) && $reservation->post_id == $course['ID'] ? "selected" : "") . ">" . $course['post_title'] . "</option>";
      }
		echo "</select><br>";
		echo "<input type='text' name='place' placeholder='Place' " . (!isset($reservation) ? "" : "value='" . $reservation->place . "'") . " required><br>";
    echo "<input type='submit' name='reservation' value='Envoyez'>";
		echo "</form>";
		echo "</div>";

    if (isset($_POST['reservation'])) {
			$name_user = sanitize_text_field($_POST["name_user"]);
			$phone = sanitize_text_field($_POST["phone"]);
      $email = sanitize_text_field($_POST["email"]);
			$post_id = $_POST["post_id"];
      $place = sanitize_text_field($_POST["place"]);
	
			if ($name_user != '' && $phone != '' && $email != '' && $place != '') {
				global $wpdb;
	
				$table_name = $wpdb->prefix . 'reservations';
		
				if (isset($reservation)) {
					$wpdb->update( 
						$table_name,
						array( 
							'name_user' => $name_user,
							'phone' => $phone,
              'email' => $email,
							'post_id' => $post_id,
              'place' => $place,
						),
						array( 
							'id' => $reservation->id,
						),
            
					);
          var_dump($table_name);
					echo "<h4>Réservation mise à jour.</h4>";
          
				} else {
					$wpdb->insert( 
						$table_name,
						array( 
							'name_user' => $name_user,
							'phone' => $phone,
              'email' => $email,
							'post_id' => $post_id,
              'place' => $place,
						)
					);

          

					echo "<h4>Réservation créée</h4>";
				}
			}
		}
	}

	add_submenu_page('reservations', 'Réservation', 'Ajouter', 'edit_posts', 'reservation', 'submenu_reservation_form');
}

add_action('admin_menu', 'add_plugin_reservation_to_admin');

// create the form reservation cours
function reservation_course_form(){
  ob_start();
  global $wpdb;
		$table_name = $wpdb->prefix . 'posts';
		$courses = $wpdb->get_results("SELECT * FROM $table_name WHERE post_type='cours' AND post_status = 'publish'; ", ARRAY_A);

		if (isset($_REQUEST['id'])) {
			$table_name = $wpdb->prefix . 'reservations';
			$reservation = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $_REQUEST['id']));
		}

  if (isset($_POST['reservations'])) {
      $name_user = sanitize_text_field($_POST['name_user']);
      $phone = sanitize_text_field($_POST['phone']);
      $email = sanitize_text_field($_POST['email']);
      $post_id = ($_POST['post_id']);
      $place = sanitize_text_field($_POST['place']);
  
      
      if (!empty($name_user) && !empty($phone) && !empty($email) && !empty($place)) {
        $table_name = $wpdb->prefix . 'reservations';

        $wpdb->insert(
          $table_name, array(
            'name_user' => $name_user,
            'phone' => $phone,
            'email' => $email,
            'post_id' => $post_id,
            'place' => $place
          )
        );

        echo 'Merci pour votre inscription !';
      }

  }
  
  echo '<form method="POST">
  <h3>Formulaire de réservation <h3>
  <input type="text" name="name_user" class="form-control mb-4" placeholder="Prénom NOM" style="color:black;" required/>
  <input type="number" name="phone" class="form-control mb-4" placeholder="Téléphone" style="color:black;" required/>
  <input type="email" name="email" class="form-control mb-4" placeholder="Email" style="color:black;" required/>
  <select class="form-control mb-4" name="post_id">
      <option value=""> Choisir un evenement </option>'; 
      foreach ($courses as $course) {
        echo "<option value='" . $course['ID'] . "' " . (isset($reservation) && $reservation->post_id == $course['ID'] ? "selected" : "") . ">" . $course['post_title'] . "</option>";
      }
  echo '</select>
  <input type="number" name="place" class="form-control mb-4" placeholder="Nombre de participants" style="color:black;" required/>
  <button type="submit" name="reservations" class="btn btn-info btn-block mb-4">ENVOYER</button>
  </form>';

  return ob_get_clean();
}

add_shortcode('reservation_course_form', 'reservation_course_form');