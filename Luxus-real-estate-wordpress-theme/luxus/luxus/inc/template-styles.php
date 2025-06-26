<?php
/**
 * Luxus Style File
 *
 * @package luxus
 */

// Color Option In Wp Customizer
function luxus_theme_customize_register( $wp_customize ) {

	// Theme color
	$wp_customize->add_setting( 'sl_theme_color', array(
	  'default'   => '',
	  'transport' => 'refresh',
	  'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sl_theme_color', array(
	  'section' => 'colors',
	  'label'   => esc_html__( 'Theme Color', 'luxus' ),
	) ) );

	// Secondary color
	$wp_customize->add_setting( 'sl_secondary_color', array(
	  'default'   => '',
	  'transport' => 'refresh',
	  'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sl_secondary_color', array(
	  'section' => 'colors',
	  'label'   => esc_html__( 'Secondary Color', 'luxus' ),
	) ) );

	// Light color
	$wp_customize->add_setting( 'sl_light_color', array(
	  'default'   => '',
	  'transport' => 'refresh',
	  'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sl_light_color', array(
	  'section' => 'colors',
	  'label'   => esc_html__( 'Light Color', 'luxus' ),
	) ) );

	// Dark color
	$wp_customize->add_setting( 'sl_dark_color', array(
	  'default'   => '',
	  'transport' => 'refresh',
	  'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sl_dark_color', array(
	  'section' => 'colors',
	  'label'   => esc_html__( 'Dark Color', 'luxus' ),
	) ) );

	// Text color
	$wp_customize->add_setting( 'sl_text_color', array(
	  'default'   => '',
	  'transport' => 'refresh',
	  'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sl_text_color', array(
	  'section' => 'colors',
	  'label'   => esc_html__( 'Text Color', 'luxus' ),
	) ) );

	// Link color
	$wp_customize->add_setting( 'sl_btn_color', array(
	  'default'   => '',
	  'transport' => 'refresh',
	  'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sl_btn_color', array(
	  'section' => 'colors',
	  'label'   => esc_html__( 'Button Color', 'luxus' ),
	) ) );

	// Link color
	$wp_customize->add_setting( 'sl_btn_hcolor', array(
	  'default'   => '',
	  'transport' => 'refresh',
	  'sanitize_callback' => 'sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sl_btn_hcolor', array(
	  'section' => 'colors',
	  'label'   => esc_html__( 'Button Hover Color', 'luxus' ),
	) ) );

}
add_action( 'customize_register', 'luxus_theme_customize_register' );

// Custom Color Scheme
function luxus_theme_get_customizer_css() {
	
	ob_start();

	// Theme Color
 	$sl_opt_theme_color = luxus_options('sl-theme-color');
	$sl_theme_color = !empty($sl_opt_theme_color) ? $sl_opt_theme_color : get_theme_mod( 'sl_theme_color', '' );

	// Secondary Color
 	$sl_opt_secondary_color = luxus_options('sl-secondary-color');
	$sl_secondary_color = !empty( $sl_opt_secondary_color ) ? $sl_opt_secondary_color : get_theme_mod( 'sl_secondary_color', '' );
	
	// Light Color
 	$sl_opt_light_color = luxus_options('sl-light-color');
	$sl_light_color = !empty( $sl_opt_light_color ) ? $sl_opt_light_color : get_theme_mod( 'sl_light_color', '' );

	// Dark Color
 	$sl_opt_dark_color = luxus_options('sl-dark-color');
	$sl_dark_color = !empty( $sl_opt_dark_color ) ? $sl_opt_dark_color : get_theme_mod( 'sl_dark_color', '' );

	// Text Color
 	$sl_opt_text_color = luxus_options('sl-text-color');
	$sl_text_color = !empty( $sl_opt_text_color ) ? $sl_opt_text_color : get_theme_mod( 'sl_text_color', '' );

 	// Links Color
 	$sl_opt_btn_color = luxus_options('sl-btn-color');
	$sl_btn_color = !empty( $sl_opt_btn_color ) ? $sl_opt_btn_color : get_theme_mod( 'sl_btn_color', '' );

 	// Links Hover Color
 	$sl_opt_btn_hcolor = luxus_options('sl-btn-hcolor');
	$sl_btn_hcolor = !empty( $sl_opt_btn_hcolor ) ? $sl_opt_btn_hcolor : get_theme_mod( 'sl_btn_hcolor', '' );

	?>

		:root {

			<?php

				// Theme Colors
				if ( !empty( $sl_theme_color ) ) {
					$theme_color = sanitize_hex_color( $sl_theme_color );
					echo '--theme-color :' . $theme_color . ';';
				}

				// Secondary Colors
				if ( !empty( $sl_secondary_color ) ) {
					$secondary_color = sanitize_hex_color( $sl_secondary_color );
					echo '--secondary-color :' . $secondary_color . ';';
				}

				// Light Colors
				if ( !empty( $sl_light_color ) ) {
					$light_color = sanitize_hex_color( $sl_light_color );
					echo '--light-color :' . $light_color . ';';
				}

				// Dark Colors
				if ( !empty( $sl_dark_color ) ) {
					$dark_color = sanitize_hex_color( $sl_dark_color );
					echo '--dark-color :' . $dark_color . ';';
				}

				// Text Colors
				if ( !empty( $sl_text_color ) ) {
					$text_color = sanitize_hex_color( $sl_text_color );
					echo '--text-color :' . $text_color . ';';
				}

				// Buttons Color
				if ( !empty( $sl_btn_color ) ) {
					$btn_color = sanitize_hex_color( $sl_btn_color );
					echo '--btn-color :' . $btn_color . ';';
				}

				// Buttons Hover Color
				if ( !empty( $sl_btn_hcolor ) ) {
					$btn_hcolor = sanitize_hex_color( $sl_btn_hcolor );
					echo '--btn-hcolor :' . $btn_hcolor . ';';
				}

			?>
		}

	<?php

	$css = ob_get_clean();
	return $css;
}

// Enqueue Theme Color Scheme:
function luxus_theme_colors_enqueue_style() {
	
	$custom_css = luxus_theme_get_customizer_css();
	wp_add_inline_style( 'style', $custom_css );
	
}
add_action( 'wp_enqueue_scripts', 'luxus_theme_colors_enqueue_style' );
