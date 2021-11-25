<?php

class AbonnementListTable extends WP_List_Table {
    public function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = array();
        $data = $this->get_data();

        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $data;
    }

    function column_post_id($item) {
		global $wpdb;
		$post_id = $item['post_id'];
		$table_name = $wpdb->prefix . 'posts';
		$abonnement = $wpdb->get_row("SELECT * FROM $table_name WHERE ID=$post_id AND post_type='offres'");

		$query_args = array('action' => 'edit','post'  => $abonnement->ID);
        // var_dump($course);
		return '<a href="'. esc_url(wp_nonce_url(add_query_arg( $query_args, 'post.php' ))) .'">'. $abonnement->post_title . '</a>';
        
	}

    public function get_columns()
    {
        $columns = array(
            'id' => 'ID',
            'name_user' => 'Prenom Nom',
            'email' => 'Email',
            'post_id' => 'Type abonnement',
        );

        return $columns;
    }

    public function column_default( $item, $column_name )
    {
        switch( $column_name ) {
            case 'id':
            case 'name_user':
            case 'email':
            case 'post_id' :
                return $item[ $column_name ];

            default:
                return print_r( $item, true ) ;
        }
    }

    public function get_data()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'abonnements';

        $result = $wpdb->get_results( "SELECT * FROM $table_name", ARRAY_A);

        return $result;
    }
}