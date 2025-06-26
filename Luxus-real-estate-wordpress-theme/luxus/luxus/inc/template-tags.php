<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Luxus
 */


if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12563
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
endif;

if ( ! function_exists( 'luxus_post_tags' ) ) :

	// Post Tags

	function luxus_post_tags() {

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', ' ' );
		if ( $tags_list ) {
			/* translators: 1: list of tags. */
			printf( '<p class="tags-list">' . esc_html__( 'Tagged: %1$s', 'luxus' ) . '</p>', $tags_list );
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}

endif;
