<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

// User Capabilities
$capabilities = array(
		'upload_files' => true,
		'delete_posts' => true,
		'delete_published_posts' => true,
		'edit_posts' => true,
		'edit_published_posts' => true,
		'publish_posts' => true,
		'read' => true,
	);


// Register Custom Role Agent
add_role( 'agent', __('Agent', 'luxus-core'), $capabilities );

// Register Custom Role Agency
add_role( 'agency', __('Agency', 'luxus-core'), $capabilities );