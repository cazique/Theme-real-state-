<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

/**
 * Luxus Property Custom Post Type
 * 
 */

// Register Custom Post Type Property
add_action( 'init', 'luxus_property_cpt', 0 );
function luxus_property_cpt() {

	$labels = array(
		'name' => _x( 'Properties', 'Post Type General Name', 'luxus-core' ),
		'singular_name' => _x( 'Property', 'Post Type Singular Name', 'luxus-core' ),
		'menu_name' => _x( 'Properties', 'Admin Menu text', 'luxus-core' ),
		'name_admin_bar' => _x( 'Property', 'Add New on Toolbar', 'luxus-core' ),
		'archives' => __( 'Property Archives', 'luxus-core' ),
		'attributes' => __( 'Property Attributes', 'luxus-core' ),
		'parent_item_colon' => __( 'Parent Property:', 'luxus-core' ),
		'all_items' => __( 'All Properties', 'luxus-core' ),
		'add_new_item' => __( 'Add New Property', 'luxus-core' ),
		'add_new' => __( 'Add New', 'luxus-core' ),
		'new_item' => __( 'New Property', 'luxus-core' ),
		'edit_item' => __( 'Edit Property', 'luxus-core' ),
		'update_item' => __( 'Update Property', 'luxus-core' ),
		'view_item' => __( 'View Property', 'luxus-core' ),
		'view_items' => __( 'View Properties', 'luxus-core' ),
		'search_items' => __( 'Search Property', 'luxus-core' ),
		'not_found' => __( 'Not found', 'luxus-core' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'luxus-core' ),
		'featured_image' => __( 'Featured Image', 'luxus-core' ),
		'set_featured_image' => __( 'Set featured image', 'luxus-core' ),
		'remove_featured_image' => __( 'Remove featured image', 'luxus-core' ),
		'use_featured_image' => __( 'Use as featured image', 'luxus-core' ),
		'insert_into_item' => __( 'Insert into Property', 'luxus-core' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Property', 'luxus-core' ),
		'items_list' => __( 'Properties list', 'luxus-core' ),
		'items_list_navigation' => __( 'Properties list navigation', 'luxus-core' ),
		'filter_items_list' => __( 'Filter Properties list', 'luxus-core' ),
	);

	$args = array(
		'label' => __( 'Property', 'luxus-core' ),
		'description' => __( 'Properties', 'luxus-core' ),
		'labels' => $labels,
		'menu_icon' => 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 64.368 64.366"><path d="M62.489,26.526,33.267-.04l-.279-.254a2.682,2.682,0,0,0-.625-.425l-.03-.013a2.685,2.685,0,0,0-2.3,0L30-.719a2.682,2.682,0,0,0-.625.425l-.275.25L-.122,26.526a2.682,2.682,0,1,0,3.608,3.969l.878-.8v31a2.682,2.682,0,0,0,2.682,2.682H55.321A2.682,2.682,0,0,0,58,60.694v-31l.878.8a2.682,2.682,0,0,0,3.608-3.969ZM25.819,58.012V41.92a5.364,5.364,0,1,1,10.728,0V58.012Zm26.82,0H41.911V41.92a10.728,10.728,0,1,0-21.456,0V58.012H9.728V24.821L31.183,5.315,52.639,24.821Z" transform="translate(1 0.991)" fill="#a7aaad"/></svg>'),
		'supports' => array('title', 'editor', 'thumbnail', 'author'),
		'supports' => array('title', 'editor', 'thumbnail', 'revisions', 'author', 'comments'),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 5,
		'show_in_admin_bar' => true,
		'show_in_nav_menus' => true,
		'can_export' => true,
		'has_archive' => true,
		'hierarchical' => true,
		'exclude_from_search' => false,
		'show_in_rest' => true,
		'publicly_queryable' => true,
		'capability_type' => 'post',
	);

	register_post_type( 'property', $args );

}

// Register Custom Taxonomy 'Property Types'
add_action( 'init', 'luxus_property_types', 0 );
function luxus_property_types() {

	$labels = array(
		'name'                       => _x( 'Property Types', 'Taxonomy General Name', 'luxus-core' ),
		'singular_name'              => _x( 'Property Type', 'Taxonomy Singular Name', 'luxus-core' ),
		'menu_name'                  => __( 'Property Types', 'luxus-core' ),
		'all_items'                  => __( 'All Types', 'luxus-core' ),
		'parent_item'                => __( 'Parent Type', 'luxus-core' ),
		'parent_item_colon'          => __( 'Parent Type:', 'luxus-core' ),
		'new_item_name'              => __( 'New Type Name', 'luxus-core' ),
		'add_new_item'               => __( 'Add New Type', 'luxus-core' ),
		'edit_item'                  => __( 'Edit Type', 'luxus-core' ),
		'update_item'                => __( 'Update Type', 'luxus-core' ),
		'view_item'                  => __( 'View Type', 'luxus-core' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'luxus-core' ),
		'add_or_remove_items'        => __( 'Add or remove Types', 'luxus-core' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'luxus-core' ),
		'popular_items'              => __( 'Popular Types', 'luxus-core' ),
		'search_items'               => __( 'Search Types', 'luxus-core' ),
		'not_found'                  => __( 'Not Found', 'luxus-core' ),
		'no_terms'                   => __( 'No items', 'luxus-core' ),
		'items_list'                 => __( 'Types list', 'luxus-core' ),
		'items_list_navigation'      => __( 'Types list navigation', 'luxus-core' ),
	);

	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'show_in_rest'               => false,
		'show_in_quick_edit'         => true,
    	'meta_box_cb'                => false,
	);

	register_taxonomy( 'property_type', array( 'property' ), $args );
}

// Register Custom Taxonomy 'Property Status'
add_action( 'init', 'luxus_property_status', 0 );
function luxus_property_status() {

	$labels = array(
		'name'                       => _x( 'Property Status', 'Taxonomy General Name', 'luxus-core' ),
		'singular_name'              => _x( 'Property Status', 'Taxonomy Singular Name', 'luxus-core' ),
		'menu_name'                  => __( 'Property Status', 'luxus-core' ),
		'all_items'                  => __( 'All Status', 'luxus-core' ),
		'parent_item'                => __( 'Parent Status', 'luxus-core' ),
		'parent_item_colon'          => __( 'Parent Status:', 'luxus-core' ),
		'new_item_name'              => __( 'New Status Name', 'luxus-core' ),
		'add_new_item'               => __( 'Add New Status', 'luxus-core' ),
		'edit_item'                  => __( 'Edit Status', 'luxus-core' ),
		'update_item'                => __( 'Update Status', 'luxus-core' ),
		'view_item'                  => __( 'View Status', 'luxus-core' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'luxus-core' ),
		'add_or_remove_items'        => __( 'Add or remove Status', 'luxus-core' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'luxus-core' ),
		'popular_items'              => __( 'Popular Status', 'luxus-core' ),
		'search_items'               => __( 'Search Status', 'luxus-core' ),
		'not_found'                  => __( 'Not Found', 'luxus-core' ),
		'no_terms'                   => __( 'No items', 'luxus-core' ),
		'items_list'                 => __( 'Status list', 'luxus-core' ),
		'items_list_navigation'      => __( 'Status list navigation', 'luxus-core' ),
	);

	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'show_in_rest'               => false,
		'show_in_quick_edit'         => true,
    	'meta_box_cb'                => false,
	);

	register_taxonomy( 'property_status', array( 'property' ), $args );
}

// Register Custom Taxonomy 'Property Cities'
add_action( 'init', 'luxus_property_cities', 0 );
function luxus_property_cities() {

	$labels = array(
		'name'                       => _x( 'Property Cities', 'Taxonomy General Name', 'luxus-core' ),
		'singular_name'              => _x( 'Property City', 'Taxonomy Singular Name', 'luxus-core' ),
		'menu_name'                  => __( 'Property Cities', 'luxus-core' ),
		'all_items'                  => __( 'All Cities', 'luxus-core' ),
		'parent_item'                => __( 'Parent City', 'luxus-core' ),
		'parent_item_colon'          => __( 'Parent City:', 'luxus-core' ),
		'new_item_name'              => __( 'New City Name', 'luxus-core' ),
		'add_new_item'               => __( 'Add New City', 'luxus-core' ),
		'edit_item'                  => __( 'Edit City', 'luxus-core' ),
		'update_item'                => __( 'Update City', 'luxus-core' ),
		'view_item'                  => __( 'View City', 'luxus-core' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'luxus-core' ),
		'add_or_remove_items'        => __( 'Add or remove Cities', 'luxus-core' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'luxus-core' ),
		'popular_items'              => __( 'Popular Cities', 'luxus-core' ),
		'search_items'               => __( 'Search Cities', 'luxus-core' ),
		'not_found'                  => __( 'Not Found', 'luxus-core' ),
		'no_terms'                   => __( 'No items', 'luxus-core' ),
		'items_list'                 => __( 'Cities list', 'luxus-core' ),
		'items_list_navigation'      => __( 'Cities list navigation', 'luxus-core' ),
	);

	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => false,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'show_in_rest'               => false,
		'show_in_quick_edit'         => false,
    	'meta_box_cb'                => false,
		
	);
	register_taxonomy( 'property_city', array( 'property' ), $args );
}

// Register Custom Taxonomy 'Property Provinces'
add_action( 'init', 'luxus_property_provinces', 0 );
function luxus_property_provinces() {

	$labels = array(
		'name'                       => _x( 'Property Provinces', 'Taxonomy General Name', 'luxus-core' ),
		'singular_name'              => _x( 'Property Province', 'Taxonomy Singular Name', 'luxus-core' ),
		'menu_name'                  => __( 'Property Provinces', 'luxus-core' ),
		'all_items'                  => __( 'All Provinces', 'luxus-core' ),
		'parent_item'                => __( 'Parent Province', 'luxus-core' ),
		'parent_item_colon'          => __( 'Parent Province:', 'luxus-core' ),
		'new_item_name'              => __( 'New Province Name', 'luxus-core' ),
		'add_new_item'               => __( 'Add New Province', 'luxus-core' ),
		'edit_item'                  => __( 'Edit Province', 'luxus-core' ),
		'update_item'                => __( 'Update Province', 'luxus-core' ),
		'view_item'                  => __( 'View Province', 'luxus-core' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'luxus-core' ),
		'add_or_remove_items'        => __( 'Add or remove Provinces', 'luxus-core' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'luxus-core' ),
		'popular_items'              => __( 'Popular Provinces', 'luxus-core' ),
		'search_items'               => __( 'Search Provinces', 'luxus-core' ),
		'not_found'                  => __( 'Not Found', 'luxus-core' ),
		'no_terms'                   => __( 'No items', 'luxus-core' ),
		'items_list'                 => __( 'Provinces list', 'luxus-core' ),
		'items_list_navigation'      => __( 'Provinces list navigation', 'luxus-core' ),
	);

	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => false,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'show_in_rest'               => false,
		'show_in_quick_edit'         => false,
    	'meta_box_cb'                => false,
	);

	register_taxonomy( 'property_province', array( 'property' ), $args );
}

// Register Custom Taxonomy 'Property Countries'
add_action( 'init', 'luxus_property_country', 0 );
function luxus_property_country() {

	$labels = array(
		'name'                       => _x( 'Property Countries', 'Taxonomy General Name', 'luxus-core' ),
		'singular_name'              => _x( 'Property Country', 'Taxonomy Singular Name', 'luxus-core' ),
		'menu_name'                  => __( 'Property Countries', 'luxus-core' ),
		'all_items'                  => __( 'All Countries', 'luxus-core' ),
		'parent_item'                => __( 'Parent Country', 'luxus-core' ),
		'parent_item_colon'          => __( 'Parent Country:', 'luxus-core' ),
		'new_item_name'              => __( 'New Country Name', 'luxus-core' ),
		'add_new_item'               => __( 'Add New Country', 'luxus-core' ),
		'edit_item'                  => __( 'Edit Country', 'luxus-core' ),
		'update_item'                => __( 'Update Country', 'luxus-core' ),
		'view_item'                  => __( 'View Country', 'luxus-core' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'luxus-core' ),
		'add_or_remove_items'        => __( 'Add or remove Countries', 'luxus-core' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'luxus-core' ),
		'popular_items'              => __( 'Popular Countries', 'luxus-core' ),
		'search_items'               => __( 'Search Countries', 'luxus-core' ),
		'not_found'                  => __( 'Not Found', 'luxus-core' ),
		'no_terms'                   => __( 'No items', 'luxus-core' ),
		'items_list'                 => __( 'Countries list', 'luxus-core' ),
		'items_list_navigation'      => __( 'Countries list navigation', 'luxus-core' ),
	);

	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => false,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'show_in_rest'               => false,
		'show_in_quick_edit'         => false,
    	'meta_box_cb'                => false,
	);

	register_taxonomy( 'property_country', array( 'property' ), $args );
}

// Register Custom Taxonomy 'Property Features'
add_action( 'init', 'luxus_property_features', 0 );
function luxus_property_features() {

	$labels = array(
		'name'                       => _x( 'Property Features', 'Taxonomy General Name', 'luxus-core' ),
		'singular_name'              => _x( 'Property Feature', 'Taxonomy Singular Name', 'luxus-core' ),
		'menu_name'                  => __( 'Property Features', 'luxus-core' ),
		'all_items'                  => __( 'All Features', 'luxus-core' ),
		'parent_item'                => __( 'Parent Feature', 'luxus-core' ),
		'parent_item_colon'          => __( 'Parent Feature:', 'luxus-core' ),
		'new_item_name'              => __( 'New Feature Name', 'luxus-core' ),
		'add_new_item'               => __( 'Add New Feature', 'luxus-core' ),
		'edit_item'                  => __( 'Edit Feature', 'luxus-core' ),
		'update_item'                => __( 'Update Feature', 'luxus-core' ),
		'view_item'                  => __( 'View Feature', 'luxus-core' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'luxus-core' ),
		'add_or_remove_items'        => __( 'Add or remove Features', 'luxus-core' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'luxus-core' ),
		'popular_items'              => __( 'Popular Features', 'luxus-core' ),
		'search_items'               => __( 'Search Features', 'luxus-core' ),
		'not_found'                  => __( 'Not Found', 'luxus-core' ),
		'no_terms'                   => __( 'No items', 'luxus-core' ),
		'items_list'                 => __( 'Features list', 'luxus-core' ),
		'items_list_navigation'      => __( 'Features list navigation', 'luxus-core' ),
	);

	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => false,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'show_in_rest'               => true,
		'show_in_quick_edit'         => false,
	);

	register_taxonomy( 'property_feature', array( 'property' ), $args );
}

// Add Thumbnail Column To Properties List
add_filter( 'manage_property_posts_columns', 'property_posts_columns' );
add_filter( 'manage_property_posts_custom_column', 'property_posts_custom_column', 10, 2 );
function property_posts_columns($columns) {

    $columns = array_slice( $columns, 0, 1, true ) + array( 'featured-image' => __('Featured Image', 'luxus-core') ) + array_slice( $columns, 1, count( $columns ) - 1, true );

    return $columns;
}

function property_posts_custom_column($column, $post_id) {

    if( $column == 'featured-image' ) {

        echo get_the_post_thumbnail( $post_id, array( 100, 100 ) );
    }

    return $column;
}