<?php

// Property Sorting
if( isset( $_GET['sort_by'] ) AND !empty( $_GET['sort_by'] ) ) {

    $sort_by = $_GET['sort_by'];

    if( $_GET['sort_by'] == 'default'){
        $order      = 'DESC';
        $order_by   = 'ID';
        $meta_key   = '';
    }
    
    if( $_GET['sort_by'] == 'new'){
        $order      = 'DESC';
        $order_by   = 'ID';
        $meta_key   = '';
    }

    if( $_GET['sort_by'] == 'old'){
        $order      = 'ASC';
        $order_by   = 'ID';
        $meta_key   = '';
    }

    if( $_GET['sort_by'] == 'featured'){
        $meta_key   = '_property_label';
        $order_by   = 'meta_value_num';
        $order      = 'DESC';
    }

    if( $_GET['sort_by'] == 'low_high'){
        $meta_key   = '_property_price';
        $order_by   = 'meta_value_num';
        $order      = 'ASC';
    } 
    
    if( $_GET['sort_by'] == 'high_low'){
        $meta_key   = '_property_price';
        $order_by   = 'meta_value_num';
        $order      = 'DESC';
    } 
}
else {
    $sort_by    = NULL;
    $order      = 'DESC';
    $order_by   = 'ID';
    $meta_key   = '';
}