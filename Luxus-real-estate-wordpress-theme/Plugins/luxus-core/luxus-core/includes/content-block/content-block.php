<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

/**
 * Luxus Content Block For Headers / Footers & Reusable Blocks
 * 
 */

// Register Custom Post Type Content Block
add_action( 'init', 'luxus_content_block', 0 );
function luxus_content_block() {

	$labels = array(
		'name' => _x( 'Content Blocks', 'Post Type General Name', 'luxus-core' ),
		'singular_name' => _x( 'Content Block', 'Post Type Singular Name', 'luxus-core' ),
		'menu_name' => _x( 'Content Blocks', 'Admin Menu text', 'luxus-core' ),
		'name_admin_bar' => _x( 'Content Block', 'Add New on Toolbar', 'luxus-core' ),
		'archives' => __( 'Content Block Archives', 'luxus-core' ),
		'attributes' => __( 'Content Block Attributes', 'luxus-core' ),
		'parent_item_colon' => __( 'Parent Content Block:', 'luxus-core' ),
		'all_items' => __( 'All Content Blocks', 'luxus-core' ),
		'add_new_item' => __( 'Add New Content Block', 'luxus-core' ),
		'add_new' => __( 'Add New', 'luxus-core' ),
		'new_item' => __( 'New Content Block', 'luxus-core' ),
		'edit_item' => __( 'Edit Content Block', 'luxus-core' ),
		'update_item' => __( 'Update Content Block', 'luxus-core' ),
		'view_item' => __( 'View Content Block', 'luxus-core' ),
		'view_items' => __( 'View Content Blocks', 'luxus-core' ),
		'search_items' => __( 'Search Content Block', 'luxus-core' ),
		'not_found' => __( 'Not found', 'luxus-core' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'luxus-core' ),
		'featured_image' => __( 'Featured Image', 'luxus-core' ),
		'set_featured_image' => __( 'Set featured image', 'luxus-core' ),
		'remove_featured_image' => __( 'Remove featured image', 'luxus-core' ),
		'use_featured_image' => __( 'Use as featured image', 'luxus-core' ),
		'insert_into_item' => __( 'Insert into Content Block', 'luxus-core' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Content Block', 'luxus-core' ),
		'items_list' => __( 'Content Blocks list', 'luxus-core' ),
		'items_list_navigation' => __( 'Content Blocks list navigation', 'luxus-core' ),
		'filter_items_list' => __( 'Filter Content Blocks list', 'luxus-core' ),
	);

	$args = array(
		'label' => __( 'Content Block', 'luxus-core' ),
		'description' => __( 'Content Blocks', 'luxus-core' ),
		'labels' => $labels,
		'menu_icon' => 'dashicons-screenoptions',
		'supports' => array('title', 'editor', 'thumbnail', 'author'),
		'taxonomies' => array(),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 5,
		'show_in_admin_bar' => true,
		'show_in_nav_menus' => true,
		'can_export' => true,
		'has_archive' => true,
		'hierarchical' => true,
		'exclude_from_search' => true,
		'show_in_rest' => true,
		'publicly_queryable' => true,
		'capability_type' => 'post',
		'capabilities' => array(
		    'edit_post'          => 'edit_pages',
		    'read_post'          => 'edit_pages',
		    'delete_post'        => 'edit_pages',
		    'edit_posts'         => 'edit_pages',
		    'edit_others_posts'  => 'edit_pages',
		    'delete_posts'       => 'edit_pages',
		    'publish_posts'      => 'edit_pages',
		    'read_private_posts' => 'edit_pages'
		),
	);

	register_post_type( 'luxus_content_block', $args );

	// Remove Thumbnail
	remove_post_type_support('luxus_content_block', 'thumbnail');

}


// Content Block Meta Radio Box
add_action( 'add_meta_boxes', 'luxus_content_block_type' );
function luxus_content_block_type() {

	add_meta_box('luxus_content_block_type', 'Content Block Type', 'luxus_content_block_type_meta', 'luxus_content_block', 'side' );
}

function luxus_content_block_type_meta( $post ) {

	 wp_nonce_field( 'luxus_content_block_type', 'luxus_content_block_type_nonce' );

	 $value = get_post_meta( $post->ID, 'luxus_content_block_type', true );
	 //luxus_content_block_type is a meta_key.

?>
	<p><input id="cbt-header" type="radio" name="content_block_type" value="header" <?php checked( $value, 'header' ); ?> >
	<label for="cbt-header"><?php esc_html_e('Header', 'luxus-core'); ?></label></p>
	<p><input id="cbt-footer" type="radio" name="content_block_type" value="footer" <?php checked( $value, 'footer' ); ?> >
	<label for="cbt-footer"><?php esc_html_e('Footer', 'luxus-core'); ?></label></p>
	<p><input id="cbt-reusable-block" type="radio" name="content_block_type" value="reusable_block" <?php checked( $value, 'reusable_block' ); ?> >
	<label for="cbt-reusable-block"><?php esc_html_e('Reusable Block', 'luxus-core'); ?></label></p>

<?php
}

add_action( 'save_post', 'luxus_content_block_type_save_meta_box_data' );
function luxus_content_block_type_save_meta_box_data( $post_id ) {
 
    /*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( !isset( $_POST['luxus_content_block_type_nonce'] ) ) {
            return;
    }

    // Verify that the nonce is valid.
    if ( !wp_verify_nonce( $_POST['luxus_content_block_type_nonce'], 'luxus_content_block_type' ) ) {
            return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
    }

    // Check the user's permissions.
    if ( !current_user_can( 'edit_post', $post_id ) ) {
            return;
    }

    // Sanitize user input.
    $new_meta_value = ( isset( $_POST['content_block_type'] ) ? sanitize_html_class( $_POST['content_block_type'] ) : '' );

    // Update the meta field in the database.
    update_post_meta( $post_id, 'luxus_content_block_type', $new_meta_value );
 
}

// Add Custom Column 'block_type' To Content Block List
add_filter( 'manage_luxus_content_block_posts_columns', 'luxus_content_block_columns' );
add_action( 'manage_luxus_content_block_posts_custom_column' , 'luxus_content_block_shortcode_column', 10, 2 );
function luxus_content_block_columns($columns) {

	// Return Column and shift Possition
    $columns = array_slice( $columns, 0, 3, true ) + array( 'block_type' => __('Block Type', 'luxus-core'), 'shortcode' => __('Shortcode', 'luxus-core') ) + array_slice( $columns, 3, count( $columns ) - 3, true );

    return $columns;
}

function luxus_content_block_shortcode_column( $column, $post_id ) {

    if ( $column == 'block_type' ) {

        // Get Post Meta
        $block_type = get_post_meta( $post_id, 'luxus_content_block_type', true );
        
        // Output
        echo '<span>' .  ucfirst( $block_type ) . '</span>';
    }

    if ( $column == 'shortcode' ) {

    	$type = get_post_meta( $post_id, 'luxus_content_block_type', true );

    	if ($type == 'reusable_block') :

    ?>
	   
	    <input type='text' onfocus='this.select();' readonly='readonly' value='[luxus_content_block id="<?php echo esc_attr( $post_id ); ?>"]'>

    <?php
    	endif;
    }
}

// Remove Columns From Content Block List
add_filter( 'manage_luxus_content_block_posts_columns', 'luxus_content_block_columns_filter', 10, 1 );
function luxus_content_block_columns_filter( $columns ) {

    unset($columns['post_views']);
    
    return $columns;
}
