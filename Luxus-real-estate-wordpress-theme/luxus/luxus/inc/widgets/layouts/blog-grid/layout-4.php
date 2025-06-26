<?php 
while ( $luxus_blog_grid->have_posts() ) :

    $luxus_blog_grid->the_post(); ?>

	<div class="blog-four">

		<?php
		
			$posted_year  = get_the_time('Y'); 
			$posted_month = get_the_time('m'); 
			$podted_day   = get_the_time('d');
		?>

		<div class="image" style="background-image: url(<?php esc_url( the_post_thumbnail_url('luxus-thumb-md', array('class' => 'img') ) ); ?>)"></div>
		<div class="blog-grid-content">
			<div class="top">
				<?php $categories = get_the_category();
					if ( ! empty( $categories ) ) {
						echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '" class="meta">' . esc_html( $categories[0]->name ) . '</a>';
				}?>
				<p class="date">
					<i class="sl-icon sl-calendar"></i>
					<a href="<?php echo esc_url( get_day_link( $posted_year, $posted_month, $podted_day ) ); ?>">
						<?php echo esc_html( get_the_date() ); ?>
					</a>
				</p>
			</div>
			<?php the_title( '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark" class="clear-both"><h2 class="title">', '</h2></a>' ); ?>
			<p class="discription">
				<?php
					if ( ! has_excerpt() ) {
						echo wp_trim_words( get_the_content(), esc_html($excerpt_length), ' ...');
					} else {
						echo wp_trim_words( get_the_excerpt(), esc_html($excerpt_length), ' ...');
					}
				?>
			</p>
			<div class="bottom">
				<div class="author">
					<img src="<?php echo esc_url( get_avatar_url(get_the_author_meta('ID')) ) ; ?>" alt="<?php echo esc_attr( get_the_author() ); ?>" class="author-img"><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="name"><?php the_author(); ?></a></div>
				
				<a href="<?php the_permalink() ?>" class="more"><?php echo esc_html($read_more_text);?></a>
			</div>
		</div>
	</div>

    <?php

endwhile;