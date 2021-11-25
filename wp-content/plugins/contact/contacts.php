<?php
/*
Plugin Name: Contact
Description: Creation plugin
Author: Malekalita
Version: 1.0.0
*/

// first step : create DB reservation
function contact_database(){
    global $wpdb; 

    $table_name = $wpdb->prefix . 'contacts';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint (9) NOT NULL AUTO_INCREMENT,
        name_contact varchar (100) NOT NULL, 
        email varchar (100) NOT NULL, 
        content TEXT(200) NOT NULL, 
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    add_option('contact_db_version' , '1.0');
}

register_activation_hook(__FILE__, 'contact_database');

// Step 2 : creat default data
function insert_contact(){
  global $wpdb; 

  $table_name = $wpdb->prefix .'contacts';

  $sql = "INSERT INTO $table_name (name_contact, email, content) VALUES ('Test', 'test@test.nc', 'test');";

  require_once(ABSPATH . 'wp-admin/includes/update.php');
  dbDelta($sql);
  add_option('contact_db_version' , '1.0');
}

register_activation_hook(__FILE__, 'insert_contact');

// Third step : add plugin to admin
function add_plugin_contact_to_admin(){
  function contact_content(){
      echo "<h1> Contacts </h1>";
      echo "<div style='margin-right:20px'>";

      if(class_exists( 'WP_List_Table' ) ) {
          require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
          require_once(plugin_dir_path(__FILE__). 'contact-list-table.php');
          $contactListTable = new ContactListTable();
          $contactListTable->prepare_items();
          $contactListTable->display();
      } else {
          echo "WP_List_Table n'est pas disponible";
      }

      echo "</div>";
  }

  add_menu_page('Contacts', 'Contacts', 'manage_options', 'contact-plugin', 'contact_content');
}

add_action('admin_menu', 'add_plugin_contact_to_admin');

function contact_form(){
    ob_start();
    global $wpdb;

    if (isset($_POST['contact'])) {
        $name_contact = sanitize_text_field($_POST['name_contact']);
        $email = sanitize_text_field($_POST['email']);
        $content = sanitize_text_field($_POST['content']);
    
        
        if (!empty($name_contact) && !empty($email) && !empty($content)) {
          $table_name = $wpdb->prefix . 'contacts';

          $wpdb->insert(
            $table_name, array(
              'name_contact' => $name_contact,
              'email' => $email,
              'content' => $content
            )
          );

          echo 'Merci pour votre inscription !';
        }

    }

    $table_name = $wpdb->prefix . 'posts';
    $results = $wpdb->get_results("SELECT * FROM $table_name WHERE post_type = 'events' AND post_status = 'publish';", ARRAY_A);
    // var_dump($result);
    
    
    echo '<form method="POST">
    <h3> Formulaire de contact <h3>
    <input type="text" name="name_contact" class="form-control mb-4" placeholder="Prénom Nom" style="color:black;" required/>
    <input type="text" name="email" class="form-control mb-4" placeholder="Email" style="color:black;" required/>
    <textarea class="form-control mb-4" name="content" id="textAreaExample" rows="4" name="content" style="color:black;" required></textarea>
    <button type="submit" name="contact" class="btn btn-info btn-block mb-4">ENVOYER</button>
    </form>';

    return ob_get_clean();
}

add_shortcode('contact_form', 'contact_form');
