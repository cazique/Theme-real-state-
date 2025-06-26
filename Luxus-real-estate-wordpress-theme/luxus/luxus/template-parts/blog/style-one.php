<div class="blog-one">
	<div class="sticky-post-icon"><img src="<?php echo esc_url(get_template_directory_uri()) . '/assets/images/push-pin.png'; ?>"></div>
	<?php

	$posted_year  = get_the_time('Y'); 
	$posted_month = get_the_time('m'); 
	$podted_day   = get_the_time('d');

	if ( has_post_thumbnail() ) : ?>
	<div class="image">
		<a href="<?php the_permalink(); ?>" class="view-detail"><i class="sl-icon sl-next-arrow"></i></a>
		<div class="tags">
			<?php

				$categories = get_the_category();

				if ( ! empty( $categories ) ) {
					echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
			}?>
		</div>
	    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('luxus-thumb-md', array('class' => 'img')); ?></a>
	    <div class="meta">
	        <p class="date">
	        	<i class="sl-icon sl-calendar"></i>
				<a href="<?php echo esc_url(get_day_link( $posted_year, $posted_month, $podted_day )); ?>">
					<?php echo esc_html(get_the_date()); ?>
				</a>
	        </p>
	    </div>
	</div>
	<?php endif; ?>

	<div class="content">
		<?php if ( !has_post_thumbnail() ) : ?>
			<p class="post-tag">
				<?php

					$categories = get_the_category();

					if ( ! empty( $categories ) ) {
						echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
				}?>
			</p>
			<p class="post-date">
	        	<i class="sl-icon sl-calendar"></i>
				<a href="<?php echo esc_url(get_day_link( $posted_year, $posted_month, $podted_day )); ?>">
					<?php echo esc_html(get_the_date()); ?>
				</a>
	        </p>
		<?php endif;

		the_title( '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark"><h2 class="title">', '</h2></a>' );

		?>

		<p class="excerpt">
		<?php

			$post_excerpt_opt = luxus_options('post-excerpt-length');
			$post_excerpt = !empty( $post_excerpt_opt ) ? $post_excerpt_opt : 200;

			echo substr( wp_strip_all_tags( get_the_excerpt() ), 0, $post_excerpt ) . ' ...';
			
		?>
		</p>
		<a href="<?php the_permalink() ?>" class="more"><?php esc_html_e('Read more', 'luxus'); ?></a>
	</div>
</div>