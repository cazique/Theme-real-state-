<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package luxus
 */

$sidebar_active = is_active_sidebar( 'template-sidebar' );

if ( $sidebar_active == false ) {
	$sl_col = 'col-lg-4';
} else {

	$post_view = luxus_options('post-view');

	if ( !empty( $post_view ) ) {
		$sl_col = ( $post_view == 'grid-view' ? 'col-lg-6' : 'col-lg-12' );
	} else{
		$sl_col = 'col-lg-6';
	}
}

$select_post_style = luxus_options('post-style');
$post_style = ( $select_post_style == 'style-two' ? 'two' : 'one' );

$post_excerpt = luxus_options('post-excerpt-length');

$sticky_posts = get_option( 'sticky_posts' );

if ( in_array( get_the_ID(), $sticky_posts ) ){
   $sticky_class = 'sticky';
  }
else{
  $sticky_class = '';
 }

 $classes = array(
	    $sl_col,
	    $sticky_class,
);

?>

<div id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?> >
	<?php get_template_part( 'template-parts/blog/style', $post_style ); ?>
</div>