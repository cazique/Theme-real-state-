<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package luxus
 */

get_header();

$sidebar_position = luxus_options('sidebar-position');
$is_active_sidebar = ( is_active_sidebar( 'template-sidebar' ) ? true : false );
$active_col = ( is_active_sidebar( 'template-sidebar' ) ? '8' : '12' );

?>

<!-- Main Content -->
<div class="page-content default-single-content">
	<div class="container">
		<div class="row">
			<div class="col-lg-<?php echo esc_attr($active_col); ?> <?php post_class(); ?>">
				<?php while ( have_posts() ) : the_post(); ?>
					<div id="<?php the_ID(); ?>" <?php post_class( 'blog-post' ); ?>>
						<div class="post-image"><?php the_post_thumbnail('luxus-thumb-lg'); ?></div>
						<div class="content-area">
							<h2 class="title"><?php the_title(); ?></h2>
							<p class="post-meta">
								<?php $author  = ucfirst( get_the_author() ); ?>
								<i class="sl-icon sl-user-o"></i>
								<a class="author" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta('ID')) ); ?>"><?php echo esc_html( $author ); ?></a>
								<?php

									$posted_year  = get_the_time('Y'); 
									$posted_month = get_the_time('m'); 
									$podted_day   = get_the_time('d');

								?>
								<i class="sl-icon sl-calendar"></i>
								<a class="posted-date" href="<?php echo esc_url( get_day_link( $posted_year, $posted_month, $podted_day ) ); ?>"><?php echo esc_html( get_the_date() ); ?></a>
								<i class="sl-icon sl-folder-o"></i>
								<span class="post-cat"><?php the_category( ' , ' ); ?></span>
							</p>

							<?php the_content(); ?>

							<div class="post-tags">
								<?php echo luxus_post_tags(); ?>
							</div>
						</div>
					</div>

				<?php

					wp_link_pages();

					endwhile;

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template('', true);
					}
				?>
			</div>
			<?php if( $is_active_sidebar == true ) : ?>
				<!-- This Class order-xl-first is for float sidebar left -->
				<div class="col-lg-4 sl-sticky <?php echo esc_attr( $sidebar_position == 'left-sidebar' ? 'order-lg-first' : '' ); ?>">
					<?php get_sidebar(); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<!-- Main Content End -->

<?php
get_footer();