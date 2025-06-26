<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
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
		</div>

	<?php }
endif;
?>

<!-- Main Content -->
<div class="page-content default-page-content">
	<div class="container">
		<?php
		while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

		endwhile; // End of the loop.
		?>
	 </div>
</div>
<!-- Main Content End -->

<?php
get_footer();
