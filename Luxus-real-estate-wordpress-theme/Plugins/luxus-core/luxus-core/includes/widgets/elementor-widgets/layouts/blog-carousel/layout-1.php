<div class="sl-item">
    <div class="blog-item blog-one">
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
					<?php
						$posted_year  = get_the_time('Y'); 
						$posted_month = get_the_time('m'); 
						$podted_day   = get_the_time('d');
					?>
					<a href="<?php echo esc_url(get_day_link( $posted_year, $posted_month, $podted_day )); ?>">
						<?php echo esc_html(get_the_date()); ?>
					</a>
				</p>
			</div>
		</div>
		<div class="content">
			<a href="<?php the_permalink() ?>"><h6 class="title" ><?php the_title(); ?></h6></a>
			<p class="excerpt"><?php echo wp_trim_words( get_the_content(), esc_html($excerpt_length));?></p>
			<a href="<?php the_permalink() ?>" class="more"><?php echo esc_html($read_more_text);?></a>
		</div>
    </div>
</div>