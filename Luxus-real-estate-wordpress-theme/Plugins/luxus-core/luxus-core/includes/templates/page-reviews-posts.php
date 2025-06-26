<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

/**
 * Template Name: Posts Reviews
 */

//Redirect Subscriber to dashboard
if( current_user_can( 'subscriber' ) ) { wp_redirect( site_url( 'user-dashboard' ) ); }

// Custom Page Title
function luxus_reviews_posts_page_title() {
    return esc_html__('Posts Reviews', 'luxus-core') . ' - ' . get_bloginfo();
}
add_action( 'pre_get_document_title', 'luxus_reviews_posts_page_title' );

// Custom User Header
require dirname( __FILE__ ) . '/template-parts/header-user.php';

$current_user = wp_get_current_user();

$schedule_img = SL_PLUGIN_URL . 'public/images/calendar.png';

?>

<!-- Main Content -->
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="heading-one"><?php esc_html_e('Posts Reviews', 'luxus-core'); ?></h2>
            </div>
        </div>
    	<div class="row">
            <div class="col-xl-12">
                <?php

                    $posts_args = array(
                        'post_type'      => 'property',
                        'post_status'    => 'publish',
                        'author' => $current_user->ID,
                    );
                    $my_posts = get_posts( $posts_args );

                    $my_posts_ids = ( !$my_posts == null ? $my_posts[0]->ID : '' );

                    if ( !$my_posts_ids == null ) {

                        $comments_args = array(
                            'number'  => '20',
                            'post_id' => $my_posts_ids,
                        );
                        $reviews = get_comments( $comments_args );

                    } else {

                        $reviews = '';

                    }

                    if ( !$reviews == null ) {

                ?>
                    <div class="comments-area">
                        <ol class="comments-list">
                            <!-- Custom Html Output -->
                            <?php

                                foreach ( $reviews as $review ) :

                                    $review_post_id = $review->comment_post_ID;

                                    $review_date = date('F j, Y - g:i A', strtotime($review->comment_date));
                                    $rating = get_comment_meta( $review->comment_ID, 'rating', true );

                                    if ($rating) {
                                        $stars = '<p class="stars">';
                                        for ( $i = 1; $i <= $rating; $i++ ) {
                                            $stars .= '<span class="sl-icons sl-star-t"></span>';
                                        }
                                        $stars .= '</p>';
                                        $review_stars = $stars;
                                    } else {
                                        $review_stars = null;
                                    }

                                ?>

                                <li>
                                    <div class="comment-box">
                                        <div class="comment-post">
                                            <h6 class="heading"> 
                                                <?php
                                                    esc_html_e('Review on: ', 'luxus-core');
                                                    echo '<a href="'. esc_url(get_the_permalink($review_post_id)) .'">'.esc_html(get_the_title($review_post_id)) .'</a>';
                                                ?>  
                                            </h6>
                                        </div>
                                        <div class="author-image">
                                            <?php
                                                echo get_avatar( $review, 85);
                                            ?>
                                        </div>
                                        <div class="comment-content">
                                            <span class="author"><?php echo esc_html($review->comment_author); ?></span>
                                            <span class="date"><?php echo esc_html($review_date); ?></span>
                                            <?php echo $review_stars; ?>
                                            <p><?php echo esc_html($review->comment_content); ?></p>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ol>
                    </div>

                <?php } else { ?>
                    <div class="alert-message alert-message-info">
                        <h6><?php esc_html_e('Reviews not found.', 'luxus-core'); ?></h6>
                        <p><?php esc_html_e('Sorry! No Review found in your Properties.', 'luxus-core'); ?></p>
                    </div>
                <?php } ?>

            </div>
    	</div>
    </div>
</div>
<!-- Main Content End -->

<?php

// Custom User Footer
require dirname( __FILE__ ) . '/template-parts/footer-user.php';
