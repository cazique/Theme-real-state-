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
$blog_single_sidebar = luxus_options('blog-single-sidebar') !== null ? luxus_options('blog-single-sidebar') : true;

$active_col = ( is_active_sidebar( 'template-sidebar' ) && $blog_single_sidebar == true ? '8' : '10 offset-lg-1' );
$blog_header_center = ( is_active_sidebar( 'template-sidebar' ) && $blog_single_sidebar == true ? 'left' : 'center' );

?>

<div class="blog-header" style="text-align: <?php echo esc_attr($blog_header_center); ?>">
	<div class="container">
		<?php the_title( '<h2 class="post-title">', '</h2>' ); ?>
	</div>
</div>

<!-- Main Content -->
<div class="page-content blog-single-content">
	<div class="container">
		<div class="row">
			<div class="col-lg-<?php echo esc_attr($active_col); ?> <?php post_class(); ?>">
				<?php while ( have_posts() ) : the_post(); ?>
					<div id="<?php the_ID(); ?>" <?php post_class( 'blog-post' ); ?>>
						<div class="content-area">
							<?php

								if ( has_post_thumbnail() ) {
									echo '<div class="post-image">';
								    	the_post_thumbnail('luxus-thumb-lg');
								    echo '</div>';
								}
							?>
							<div class="post-meta">
								<div class="author">
									<img src="<?php echo esc_url( get_avatar_url(get_the_author_meta('ID')) ) ; ?>" class="author-img">
									<a href="<?php echo esc_url( get_author_posts_url(get_the_author_meta('ID')) ); ?>" class="name"><?php echo get_the_author(); ?></a>
								</div>
								<?php
								
									$posted_year  = get_the_time('Y'); 
									$posted_month = get_the_time('m'); 
									$podted_day   = get_the_time('d');

								?>
								
								<div class="post-date">
									<i class="sl-icon sl-calendar"></i>
									<a class="posted-date" href="<?php echo esc_url(  get_day_link( $posted_year, $posted_month, $podted_day ) ); ?>"><?php echo esc_html( get_the_date() ); ?></a>
								</div>
								<div class="post-categories">
									<i class="sl-icon sl-folder-o"></i>
									<span class="post-cat"><?php the_category( ' , ' ); ?></span>
								</div>
							</div>
							
							<div class="post-text"><?php the_content(); ?></div>

							<div class="post-tags">
								<?php echo luxus_post_tags(); ?>
							</div>

						</div>
					</div>

				<?php
				
					wp_link_pages();
				
					endwhile;
				
				// Related Posts
				$related_posts = luxus_get_related_posts( get_the_ID(), 2 );

				if( $related_posts->have_posts() ): ?>

				<div class="row related-posts">
					<div class="col-lg-12">
						<h6 class="heading"><?php esc_html_e('Related Posts', 'luxus') ?></h6>
					</div>
					<?php while( $related_posts->have_posts() ): $related_posts->the_post(); ?>
					<div class="col-lg-6">
						<div class="blog-three">
							<div class="tags">
							<?php $categories = get_the_category();
								if ( ! empty( $categories ) ) {
									echo '<a href="'.esc_url(get_category_link($categories[0]->term_id)).'">'.esc_html($categories[0]->name).'</a>';
								}
							?>
							</div>
							<div class="image">
								<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('luxus-thumb-md', array('class' => 'img')); ?></a>
							</div>
							<div class="content">
								<div class="meta">
									<div class="author">
										<img src="<?php echo esc_url( get_avatar_url(get_the_author_meta('ID')) ) ; ?>" alt="<?php echo esc_attr( get_the_author() ); ?>" class="author-img">
										<a href="<?php echo esc_url( get_author_posts_url(get_the_author_meta('ID')) ); ?>" class="name"><?php echo esc_html( get_the_author() ); ?></a>
									</div>
								</div>
								<?php the_title( '<h6 class="title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h6>' ); ?>
							</div>
						</div>
					</div>
					<?php endwhile; ?>
				</div>
				<?php endif;

					wp_reset_postdata();

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {

					?>
						<div class="col-lg-12 post-review-heading">
							<h6 class="heading"><?php esc_html_e('Reviews', 'luxus') ?></h6>
						</div>

					<?php
						comments_template('', true);
					}
					
				?>
			</div>
			
			<?php if( $is_active_sidebar == true && $blog_single_sidebar == true ) : ?>
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