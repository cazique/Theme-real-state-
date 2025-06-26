<div class="blog-two">
	<?php if ( has_post_thumbnail() ) : ?>
	<div class="image">
		<a href="<?php the_permalink(); ?>" class="view-detail"><i class="sl-icon sl-next-arrow"></i></a>
		<div class="tags">
			<?php $categories = get_the_category();
			if ( ! empty( $categories ) ) {
				echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
			}?>
		</div>
		<div class="img-bottom"> 
			<div class="author">
				<img src="<?php echo esc_url( get_avatar_url(get_the_author_meta('ID') ) ) ; ?>" class="author-img">
				<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="name"><?php the_author(); ?></a>
			</div>
		</div>
		<a href="<?php the_permalink() ?>"><?php the_post_thumbnail('luxus-thumb-md'); ?></a>
	</div>
	<?php endif; ?>
	<div class="content">
		<?php
		
			the_title( '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark"><h2 class="title">', '</h2></a>' );
		
			$post_excerpt_opt = luxus_options('post-excerpt-length');
			$post_excerpt = !empty( $post_excerpt_opt ) ? $post_excerpt_opt : 200;
		
			echo '<p class="excerpt">' . substr( wp_strip_all_tags( get_the_excerpt() ), 0, $post_excerpt ) . ' ... </p>';
		?>
	</div>

	<div class="meta">
		<p class="date">
			<?php
				$posted_year  = get_the_time('Y'); 
				$posted_month = get_the_time('m'); 
				$podted_day   = get_the_time('d');
			?>
			<i class="sl-icon sl-calendar"></i>
			<a href="<?php echo esc_url( get_day_link( $posted_year, $posted_month, $podted_day ) ); ?>">
				<?php echo esc_html( get_the_date() ); ?>
			</a>
		</p>
		<a href="<?php the_permalink() ?>" class="more"><?php esc_html_e('Read more', 'luxus'); ?></a>
	</div>
</div>