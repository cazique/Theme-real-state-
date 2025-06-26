<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
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
		<h3 class="page-title">
			<?php
				/* translators: %s: search query. */
				printf( esc_html__( 'Search Results for: %s', 'luxus' ), '<span>' . get_search_query() . '</span>' );
			?>
		</h3>
	</div>
</div>

<!-- Main Content -->
<div class="page-content search-page-content">
	<div class="container">
		<div class="row">
			<div class="col-lg-<?php echo esc_attr($active_col); ?>">
				<div class="row" data-masonry='{"percentPosition": true }'>

					<?php
					
						if ( have_posts() ) :

							/* Start the Loop */
							while ( have_posts() ) :
								the_post();

							/**
							* Run the loop for the search to output the results.
							* If you want to overload this in a child theme then include a file
							* called content-search.php and that will be used instead.
							*/
							get_template_part( 'template-parts/content-archive');

							endwhile;
							
								// Custom Pagination
								luxus_pagination();

							else :

								get_template_part( 'template-parts/content', 'none' );

						endif;
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

