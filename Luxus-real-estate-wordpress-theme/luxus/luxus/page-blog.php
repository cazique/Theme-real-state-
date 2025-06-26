<?php
/**
 * Template Name: Blog Page
 *
 * This is the template that displays all posts by default.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package luxus
 */

get_header();

// Page Options
$page_title  = !is_null(luxus_page_meta('_enable_page_title')) ? luxus_page_meta('_enable_page_title') : true;
$custom_title  = !is_null(luxus_page_meta('_custom_page_title' )) ? luxus_page_meta( '_custom_page_title') : null;
$page_breadcrumb  = !is_null(luxus_page_meta('_enable_breadcrumb')) ? luxus_page_meta('_enable_breadcrumb') : true;

// Theme Options
$enable_page_title = !is_null(luxus_options('enable-page-title')) ? luxus_options('enable-page-title') : true;
$enable_breadcrumb  = !is_null(luxus_options('enable-breadcrumb')) ? luxus_options('enable-breadcrumb') : false;


$sidebar_position = luxus_options('sidebar-position');
$is_active_sidebar = ( is_active_sidebar( 'template-sidebar' ) ? true : false );
$active_col = ( $is_active_sidebar == true ? '8' : '12' );

if ( $page_title == false ):
	// Display None
	else:

	if( $enable_page_title == true ) { ?>

		<div class="page-header">
			<div class="container">
				<?php

					// Page Title
					if ( !$custom_title == null ) {
						echo '<h2 class="page-title">' . esc_html($custom_title) . '</h2>';
					}else{

						the_title( '<h2 class="page-title">', '</h2>' );
					}

					// Breadcrumbs
					if ( $page_breadcrumb == false ) {
						// Display None
					} else {
						if( $enable_breadcrumb == true ) {
							echo '<p class="sl_breadcrumb">';
							echo luxus_get_breadcrumb();
							echo '</p>';
						}
					}
				?>
			</div>
		</div><!-- .page-header -->
	<?php }

endif; ?>

<!-- Main Content -->
<div class="page-content blog-page-content">
	 <div class="container">
		<div class="row">
			<div class="col-lg-<?php echo esc_attr($active_col); ?>">
				<div class="row" data-masonry='{"percentPosition": true }'>

					<?php

					$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

					$args = array(
						'post_type'  => 'post',
						'post_status' => 'publish',
			    		'posts_per_page' => 10,
			    		'paged' => $paged,
					);

					// The Query
					$luxus_blog = new WP_Query( $args );

					if ( $luxus_blog->have_posts() ) :
						while ( $luxus_blog->have_posts() ) :
								$luxus_blog->the_post();

							/*
							 * Include the Post-Type-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
							 */
							get_template_part( 'template-parts/content');

						endwhile;
						
							// Custom Pagination
							echo '<div class="col-lg-12">';
								luxus_pagination_bar( $luxus_blog );
							echo '</div>';

						else :

							get_template_part( 'template-parts/content', 'none' );

					endif;

						wp_reset_postdata();
					?>

				</div>
			</div>

			<?php if( $is_active_sidebar == true ) : ?>
				<!-- This Class order-xl-first is for float sidebar left -->
				<div class="col-lg-4 sl-sticky <?php echo esc_attr( $sidebar_position == 'left-sidebar' ? 'order-lg-first' : '' ); ?>">
					<?php get_sidebar();?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<!-- Main Content End -->

<?php
get_footer();
