<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package luxus
 */


//If the post is password protected
if (post_password_required()) : ?>
	<p><?php _e( 'This post is password protected. Enter the password to view the comments.', 'luxus-core'); return;?></p>

<?php endif; 

//If we have comments to display
if (have_comments()) : ?>

	<div class="comments-area">
		
		<a href="#respond" class="article-add-comment"></a>
		<h4><?php comments_number(__('No Comments', 'luxus-core'), __('One Review', 'luxus-core'), __('% Reviewss', 'luxus-core')); ?></h4>

		<ol class="comments-list">
			<?php wp_list_comments('callback=luxus_comments'); ?>
		</ol>

		<?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
		
			<div class="comment-nav-section clearfix">
			
				<p class="fl"><?php previous_comments_link(__( '&larr; Older Reviews', 'luxus-core')); ?></p>
				<p class="fr"><?php next_comments_link(__( 'Newer Reviews &rarr;', 'luxus-core')); ?></p>
				
			</div>

		<?php endif; ?>

	</div>

<?php elseif ( !comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments') ) : ?>
	
<?php endif; ?>

<?php comment_form(); 
