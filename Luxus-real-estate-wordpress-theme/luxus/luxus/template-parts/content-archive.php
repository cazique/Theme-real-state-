<?php
/**
 * Template part for displaying archive posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package luxus
 */

	$posts_active_sidebar_col = ( is_active_sidebar( 'template-sidebar' ) ? 'col-lg-12' : 'col-lg-6' );

	$post_view = luxus_options('post-view');
	$sl_col = ( $post_view == 'grid-view' ? 'col-lg-6' : $posts_active_sidebar_col );

	$select_post_style = luxus_options('post-style');
	$post_style = ( $select_post_style == 'style-two' ? 'two' : 'one' );

	$post_excerpt = luxus_options('post-excerpt-length');

?>

<div id="post-<?php the_ID(); ?>" <?php post_class( $sl_col ); ?> >
	<?php get_template_part( 'template-parts/blog/style', $post_style ); ?>
</div>
