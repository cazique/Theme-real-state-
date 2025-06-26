<?php 
while ( $luxus_blog_grid->have_posts() ) :

    $luxus_blog_grid->the_post(); ?>

    <div class="blog-item blog-one">
		<?php

		$posted_year  = get_the_time('Y'); 
		$posted_month = get_the_time('m'); 
		$podted_day   = get_the_time('d');

		if ( has_post_thumbnail() ) : ?>
		<div class="image">
			<a href="<?php the_permalink(); ?>" class="view-detail"><i class="sl-icon sl-next-arrow"></i></a>
			<div class="tags">
				<?php $categories = get_the_category();
					if ( ! empty( $categories ) ) {
						echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
				}?>
			</div>
			<a href="<?php the_permalink(); ?>" class="post-link"><?php the_post_thumbnail('luxus-thumb-md', array('class' => 'img')); ?></a>
			<div class="meta">
				<p class="date">
					<i class="sl-icon sl-calendar"></i>
					<a href="<?php echo esc_url( get_day_link( $posted_year, $posted_month, $podted_day ) ); ?>">
						<?php echo esc_html( get_the_date() ); ?>
					</a>
				</p>
			</div>
		</div>
		<?php endif; ?>
		
		<div class="content">
			<?php if ( !has_post_thumbnail() ) : ?>
				<p class="post-tag">
					<?php $categories = get_the_category();
						if ( ! empty( $categories ) ) {
							echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
					}?>
				</p>
				<p class="post-date">
					<i class="sl-icon sl-calendar"></i>
					<a href="<?php echo esc_url( get_day_link( $posted_year, $posted_month, $podted_day ) ); ?>">
						<?php echo esc_html( get_the_date() ); ?>
					</a>
				</p>
			<?php endif;

			the_title( '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark"><h2 class="title">', '</h2></a>' );

			?>

			<p class="excerpt">
				<?php
					if ( ! has_excerpt() ) {
						echo wp_trim_words( get_the_content(), esc_html($excerpt_length), ' ...');
					} else {
						echo wp_trim_words( get_the_excerpt(), esc_html($excerpt_length), ' ...');
					}
				?>
			</p>
			<a href="<?php the_permalink() ?>" class="more"><?php echo esc_html($read_more_text);?></a>
		</div>
    </div>

    <?php

endwhile;