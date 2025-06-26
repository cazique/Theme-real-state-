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
	<p><?php _e( 'This post is password protected. Enter the password to view the Reviews.', 'luxus'); return;?></p>

<?php endif; 

//If we have comments to display
if ( have_comments() ) :

//Custom Function for Displaying Reviews
function luxus_reviews( $comment, $args, $depth ) {
	
	$GLOBALS['comment'] = $comment;

	if ( get_comment_type() == 'comment' ) : ?>

		<!-- Custom Html Output -->
		<li id="comment-<?php comment_ID(); ?>">
			<div class="comment-box">
				<div class="author-image">
					<?php echo get_avatar($comment); ?>
				</div>
				<div class="comment-content">
					<span class="author"><?php esc_html(comment_author_link()); ?></span>
					<span class="date">
						<?php
							esc_html(comment_date());
							/* translators: used between date and time, there is space before and after the 'at' */
							_e(' at ', 'luxus');
							esc_html(comment_time());
						?>
					</span>
					<?php esc_html(comment_text()); ?>
				</div>
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<p class="awaiting-moderation"><?php _e( 'Your Review is awaiting moderation.', 'luxus' ); ?></p>
				<?php endif; ?>
			</div>
		</li>
	<?php endif;
}

?>

	<div class="comments-area">
		
		<a href="#respond" class="article-add-comment"></a>
		<h4><?php comments_number(__('No Reviews', 'luxus'), __('One Review', 'luxus'), __('% Reviews', 'luxus')); ?></h4>

		<ol class="comments-list">
			<?php wp_list_comments('callback=luxus_reviews'); ?>
		</ol>

		<?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
		
			<div class="comment-nav-section clearfix">
			
				<p class="fl"><?php previous_comments_link(__( '&larr; Older Reviews', 'luxus')); ?></p>
				<p class="fr"><?php next_comments_link(__( 'Newer Reviews &rarr;', 'luxus')); ?></p>
				
			</div>

		<?php endif; ?>

	</div>

<?php elseif ( !comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments') ) : ?>
	
<?php endif;

$title_reply = get_the_title();
$comments_args = array(

        'title_reply' => __( 'Leave a review for', 'luxus' ) . ' ' . esc_html($title_reply),
        'label_submit' => __( 'Submit Review', 'luxus' ),
        'comment_field' => '<textarea id="review-textarea" name="comment" aria-required="true" placeholder="' . esc_attr__( 'Write a Review', 'luxus' ) .'"></textarea>',
);

 comment_form( $comments_args );