<?php
/**
 * Luxus Footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Luxus
 */

    // Page Footer
    $page_footer = luxus_page_meta( '_page_footer' );

    // Geting Custom Footers IDs
    if ( post_type_exists( 'luxus_content_block' ) ) {
        
        // Get All Custom Footer Ids
        $all_footer_ids = get_posts(array(
            'post_type' => 'luxus_content_block',
            'post_status'    => 'publish', 
            'fields'          => 'ids',
            'posts_per_page'  => -1,
            'meta_key'  => 'luxus_content_block_type',
            'meta_value'  => 'footer',
        ));
    }

    // Theme Footer
    if ( !empty($page_footer) ) {

        if ( post_type_exists( 'luxus_content_block' ) && in_array( $page_footer, $all_footer_ids) ) {

            echo '<footer class="custom-footer">';
                do_action( 'luxus_footer' );
            echo '</footer>';

        } else {

            get_template_part( 'template-parts/footer/footer', 'classic');

        }

    } else {

        $site_footer = luxus_options('site-footer');

        if( post_type_exists( 'luxus_content_block' ) && in_array( $site_footer, $all_footer_ids) ) {

            echo '<footer class="custom-footer">';
                do_action( 'luxus_footer' );
            echo '</footer>';

        } else {

            get_template_part( 'template-parts/footer/footer', 'classic');

        }

    }

    ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
