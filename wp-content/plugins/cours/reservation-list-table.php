<?php

class ReservationListTable extends WP_List_Table {
    public function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = array();
        $data = $this->get_data();

        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $data;
    }

    public function get_columns()
    {
        $columns = array(
            'id' => 'ID',
            'name_user' => 'Prenom Nom',
            'phone' => 'Telephone',
            'email' => 'Email',
            'name_course' => 'Cours',
            'place' => 'Nombre de place',
        );

        return $columns;
    }

    public function column_default( $item, $column_name )
    {
        switch( $column_name ) {
            case 'id':
            case 'name_user':
            case 'phone' :
            case 'email':
            case 'name_course':
            case 'place':
                return $item[ $column_name ];

            default:
                return print_r( $item, true ) ;
        }
    }

    public function get_data()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'reservations';

        $result = $wpdb->get_results( "SELECT * FROM $table_name", ARRAY_A);

        return $result;
    }
}