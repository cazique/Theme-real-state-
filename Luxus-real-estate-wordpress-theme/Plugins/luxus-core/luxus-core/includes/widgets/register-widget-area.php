<?php

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
add_action( 'widgets_init', 'luxus_core_widgets_init' );
function luxus_core_widgets_init() {

	register_sidebar( array(
		'name'          => esc_html__( 'Properties Page Widgets', 'luxus-core' ),
		'id'            => 'properties-page-widget',
		'description'   => esc_html__( 'Add widgets here.', 'luxus-core' ),
		'before_widget' => '<div class="widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h6 class="widget-title">',
		'after_title'   => '</h6>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Property Single Page Widgets', 'luxus-core' ),
		'id'            => 'property-pages-widget',
		'description'   => esc_html__( 'Add widgets here.', 'luxus-core' ),
		'before_widget' => '<div class="widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h6 class="widget-title">',
		'after_title'   => '</h6>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Agencies Page Widgets', 'luxus-core' ),
		'id'            => 'agencies-page-widget',
		'description'   => esc_html__( 'Add widgets here.', 'luxus-core' ),
		'before_widget' => '<div class="widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h6 class="widget-title">',
		'after_title'   => '</h6>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Agency Single Page Widgets', 'luxus-core' ),
		'id'            => 'agency-pages-widget',
		'description'   => esc_html__( 'Add widgets here.', 'luxus-core' ),
		'before_widget' => '<div class="widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h6 class="widget-title">',
		'after_title'   => '</h6>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Agents Page Widgets', 'luxus-core' ),
		'id'            => 'agents-page-widget',
		'description'   => esc_html__( 'Add widgets here.', 'luxus-core' ),
		'before_widget' => '<div class="widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h6 class="widget-title">',
		'after_title'   => '</h6>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Agent Page Widgets', 'luxus-core' ),
		'id'            => 'agent-pages-widget',
		'description'   => esc_html__( 'Add widgets here.', 'luxus-core' ),
		'before_widget' => '<div class="widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h6 class="widget-title">',
		'after_title'   => '</h6>',
	) );
	
}

// Custom Post Type 'Property' Advance Search
require_once dirname( __FILE__ ) . '/sidebar-widgets/advance-search.php';

// Custom Post Type 'Property' Featured Widget
require_once dirname( __FILE__ ) . '/sidebar-widgets/featured-property.php';

// Mortgage Calculator Widget
require_once dirname( __FILE__ ) . '/sidebar-widgets/mortgage-calculator.php';