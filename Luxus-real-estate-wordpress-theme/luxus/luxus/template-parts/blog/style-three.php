<div class="blog-three">
    <div class="tags">
        <?php $categories = get_the_category();
            if ( ! empty( $categories ) ) {
                echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
        }?>
    </div>
    <div class="image">
        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('luxus-thumb-md', array('class' => 'img')); ?></a>
    </div>
    <div class="content">
        <div class="meta">
	        <p class="name">
	        	<i class="sl-icon sl-user-o"></i>
	        	<?php $author  = ucfirst( get_the_author() ); ?>
				<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta('ID') ) ); ?>">
					<?php echo esc_html( $author ); ?>
				</a>

	        </p>
	        <p class="date">
	        	<i class="sl-icon sl-calendar"></i>
	        	<?php

					$posted_year  = get_the_time('Y'); 
					$posted_month = get_the_time('m'); 
					$podted_day   = get_the_time('d');

				?>
				<a href="<?php echo esc_url( get_day_link( $posted_year, $posted_month, $podted_day ) ); ?>">
					<?php echo esc_html( get_the_date() ); ?>
				</a>
	        </p>
	    </div>
        <?php the_title( '<h6 class="title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h6>' ); ?>
    </div>
</div>