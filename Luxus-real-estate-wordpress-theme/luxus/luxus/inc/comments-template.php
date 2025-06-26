<?php

//Custom Function for Displaying Comments
function luxus_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;

	if (get_comment_type() == 'comment') : ?>

		<!-- Custom Html Output -->
		<li id="comment-<?php comment_ID(); ?>">
			<div class="comment-box">
				<div class="author-image">
					<?php 

						$avatar = get_avatar( $comment->comment_author_email );

						if( $avatar !== false ) {
						    echo get_avatar( $comment->comment_author_email, $size = '70' );
						}

					?>

				</div>
				<div class="comment-content">
					<span class="author"><?php comment_author_link(); ?></span>
					<span class="date"><?php comment_date(); ?> at <?php comment_time(); ?></span>
					<?php comment_text(); ?>
					<p class="comment-reply"><?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?></p>
				</div>

				<?php if ($comment->comment_approved == '0') : ?>
					<p class="awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'luxus'); ?></p>
				<?php endif; ?>
			</div>
		</li>
	<?php endif;	
}

// Custom Comment Form Fields
function luxus_custom_comment_fields() {
	$commenter = wp_get_current_commenter();
	$req = get_option('require_name_email');
	$aria_req = ($req ? " aria-required='true'" : '');
	
	$fields = array(
		'author' => '<input id="author" name="author" type="text" class="form-control" placeholder="' . esc_attr__('Name *', 'luxus') . '" value="' . esc_attr($commenter['comment_author']) . '" ' . $aria_req . ' />',

		'email' => '<input id="email" name="email" type="text" class="form-control" placeholder="' . esc_attr__('Email *', 'luxus') . '" value="' . esc_attr($commenter['comment_author_email']) . '" ' . $aria_req . ' />',

	);

	return $fields;
}
add_filter('comment_form_default_fields', 'luxus_custom_comment_fields');

//Custom Comment Form
function luxus_custom_comment_form($defaults) {

	$defaults['id_form'] = 'comment-form';
	$defaults['comment_field'] = '<textarea name="comment" id="comment" class="form-control" placeholder="' . esc_attr__('Write your comment!', 'luxus') . '" rows="5"></textarea>';

	return $defaults;
}
add_filter('comment_form_defaults', 'luxus_custom_comment_form');

// Move the comment text field to the bottom
function luxus_move_comment_field_to_bottom( $fields ) {
 
    $comment_field = $fields['comment'];
    unset( $fields['comment'] );
    $fields['comment'] = $comment_field;
    return $fields;
}
add_filter( 'comment_form_fields', 'luxus_move_comment_field_to_bottom', 10, 1 );