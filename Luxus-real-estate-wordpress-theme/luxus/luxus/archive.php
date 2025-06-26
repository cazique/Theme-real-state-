<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package luxus
 */

get_header();

$sidebar_position = luxus_options('sidebar-position');
$is_active_sidebar = ( is_active_sidebar( 'template-sidebar' ) ? true : false );
$active_col = ( is_active_sidebar( 'template-sidebar' ) ? '8' : '12' );

?>

<div class="page-header">
	<div class="container">
		<?php the_archive_title( '<h2 class="page-title">', '</h2>' ); ?>
	</div>
</div>

<!-- Main Content -->
<div class="page-content archive-page-content">
	<div class="container">
		<div class="row">
			<div class="col-xl-<?php echo esc_attr($active_col); ?>">
				<div class="row" data-masonry='{"percentPosition": true }'>

					<?php if ( have_posts() ) :
						
						/* Start the Loop */
						while ( have_posts() ) :
							the_post();

							/*
							 * Include the Post-Type-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
							 */
							get_template_part( 'template-parts/content-archive');

						endwhile;
						
							// Custom Pagination
							echo '<div class="col-lg-12">';
							luxus_pagination();
							echo '</div>';

						else :

							get_template_part( 'template-parts/content', 'none' );

						endif;
					?>

				</div>
			</div>

			<?php if( $is_active_sidebar == true ) : ?>
				<!-- This Class order-xl-first is for float sidebar left -->
				<div class="col-xl-4 sl-sticky <?php echo esc_attr( $sidebar_position == 'left-sidebar' ? 'order-xl-first' : '' ); ?>">
					<?php get_sidebar();?>
				</div>
			<?php endif; ?>
		</div>
	</div>

</div>
<!-- Main Content End -->

<?php
get_footer();
