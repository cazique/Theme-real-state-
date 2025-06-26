<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

// Custom Post Type Templates.
function luxus_load_cpt_templates( $template ) {

    global $post;

    // Load Property Single Page
    if ( is_singular( 'property' ) && locate_template( array( 'single-property.php' ) ) !== $template ) {
        /*
         * This is a 'property' post
         * AND a 'single property template' is not found on
         * theme or child theme directories, so load it
         * from our plugin directory.
         */
        return dirname( __FILE__ ) . '/single-property.php';
    }
    // Load Property Archive Page
    if ( is_post_type_archive( 'property' ) && locate_template( array( 'archive-property.php' ) ) !== $template ) {
        /*
         * This is a 'property' post
         * AND a 'arvhive property template' is not found on
         * theme or child theme directories, so load it
         * from our plugin directory.
         */
        return dirname( __FILE__ ) . '/archive-property.php';
    }

    // Property Taxonomy
    $property_tax = array(
        'property_type',
        'property_feature',
        'property_city',
        'property_province',
        'property_status',
        'property_label',
        'property_nearby',
    );

    // Property Taxonomy Pages
    $property_tax_pages = array(
        'archive-property_type.php',
        'archive-property_feature.php',
        'archive-property_city.php',
        'archive-property_province.php',
        'archive-property_status.php',
        'archive-property_label.php', 
        'archive-property_nearby.php',
    );

    // Load Taxonomy Archive Page
    if ( is_tax( $property_tax ) && locate_template( $property_tax_pages ) !== $template ) {
        /*
         * This is Property Taxonomy Archive Page
         * AND Taxonomy Archive Page is not found on
         * theme or child theme directories, so load it
         * from our plugin directory.
         */
        return dirname( __FILE__ ) . '/archive-property.php';
    }

    return $template;
}
add_filter( 'template_include', 'luxus_load_cpt_templates' );


// Load Page Templates.
function luxus_page_template( $page_template ){

    // Load Properties Template
    if ( get_page_template_slug() == 'page-template-properties.php' ) {
        $page_template = dirname( __FILE__ ) . '/page-template-properties.php';
    }

    // Load Agents Template
    if ( get_page_template_slug() == 'page-template-agents.php' ) {
        $page_template = dirname( __FILE__ ) . '/page-template-agents.php';
    }

    // Load Agencies Template
    if ( get_page_template_slug() == 'page-template-agencies.php' ) {
        $page_template = dirname( __FILE__ ) . '/page-template-agencies.php';
    }

    // Load signup Template
    if ( get_page_template_slug() == 'page-signup.php' ) {
        $page_template = dirname( __FILE__ ) . '/page-signup.php';
    }

    // Load Half Map Template
    if ( get_page_template_slug() == 'page-half-map.php' ) {
        $page_template = dirname( __FILE__ ) . '/page-half-map.php';
    }

    // Load Full Width Map Template
    if ( get_page_template_slug() == 'page-compare-properties.php' ) {
        $page_template = dirname( __FILE__ ) . '/page-compare-properties.php';
    }

    return $page_template;
}
add_filter( 'page_template', 'luxus_page_template' );


// Add Custom Template to page attirbute template section.
function luxus_add_template_to_select( $post_templates, $wp_theme, $post, $post_type ) {

    // Add custom template 'Properties Template' to select dropdown 
    $post_templates['page-template-properties.php'] = __('Properties Template');

    // Add custom template 'Agents Template' to select dropdown 
    $post_templates['page-template-agents.php'] = __('Agents Template');
    
    // Add custom template 'Agencies Template' to select dropdown 
    $post_templates['page-template-agencies.php'] = __('Agencies Template');

    // Add custom template 'signup' to select dropdown 
    $post_templates['page-signup.php'] = __('Signup');

    // Add custom template 'Half Map' to select dropdown 
    $post_templates['page-half-map.php'] = __('Half Map');

    return $post_templates;
}
add_filter( 'theme_page_templates', 'luxus_add_template_to_select', 10, 4 );


// Load Custom Templates Directely By Url Without Creating Pages.
function luxus_load_custom_templates( $template ) {

    $url_path = trim( parse_url( add_query_arg(array()), PHP_URL_PATH ), '/' );

    // When any Author page is being displayed
    if ( is_author() ) {

        // get the user page being requested
        $user = get_user_by('slug', get_query_var('author_name'));
        $user_role = array_shift($user->roles);

        if ( $user_role == 'agent' ) {

            return dirname( __FILE__ ) . '/single-agent.php';

        } elseif ( $user_role == 'agency' ) {

            return dirname( __FILE__ ) . '/single-agency.php';

        }
    } 

    // User Dashboard Page
    $template_user_dashboard = 'user-dashboard';
    $pos_user_dashboard = strpos( $url_path, $template_user_dashboard );

    if ( $pos_user_dashboard !== false ) {
        return dirname( __FILE__ ) . '/page-user-dashboard.php';
    }

    // Add Property Page
    $template_add_property = 'add-property';
    $pos_add_property = strpos( $url_path, $template_add_property );

    if ( $pos_add_property !== false ) {
        return dirname( __FILE__ ) . '/page-add-property.php';
    }

    // Edit Property Page
    $template_edit_property = 'edit-property';
    $pos_edit_property = strpos( $url_path, $template_edit_property );

    if ( $pos_edit_property !== false ) {
        return dirname( __FILE__ ) . '/page-edit-property.php';
    }

    // Published Property Page
    $template_published_properties = 'published-properties';
    $pos_published_properties = strpos( $url_path, $template_published_properties );

    if ( $pos_published_properties !== false ) {
        return dirname( __FILE__ ) . '/page-published-properties.php';
    }

    // Pending Property Page
    $template_pending_properties = 'pending-properties';
    $pos_pending_properties = strpos( $url_path, $template_pending_properties );

    if ( $pos_pending_properties !== false ) {
        return dirname( __FILE__ ) . '/page-pending-properties.php';
    }

    // Draft Property Page
    $template_draft_properties = 'draft-properties';
    $pos_draft_properties = strpos( $url_path, $template_draft_properties );

    if ( $pos_draft_properties !== false ) {
        return dirname( __FILE__ ) . '/page-draft-properties.php';
    }

    // Trash Property Page
    $template_trash_properties = 'trash-properties';
    $pos_trash_properties = strpos( $url_path, $template_trash_properties );

    if ( $pos_trash_properties !== false ) {
        return dirname( __FILE__ ) . '/page-trash-properties.php';
    }

    // My Profile Page
    $template_my_profile = 'my-profile';
    $pos_my_profile = strpos( $url_path, $template_my_profile );

    if ( $pos_my_profile !== false ) {
        return dirname( __FILE__ ) . '/page-my-profile.php';
    }

    // Messages Inbox Page
    $template_messages_inbox = 'inbox';
    $pos_messages_inbox = strpos( $url_path, $template_messages_inbox );

    if ( $pos_messages_inbox !== false ) {
        return dirname( __FILE__ ) . '/page-messages-inbox.php';
    }
    // Messages Sent Page
    $template_messages_sent = 'sent';
    $pos_messages_sent = strpos( $url_path, $template_messages_sent );

    if ( $pos_messages_sent !== false ) {
        return dirname( __FILE__ ) . '/page-messages-sent.php';
    }
    // Messages Detail Page
    $template_message_detail = 'message';
    $pos_message_detail = strpos( $url_path, $template_message_detail );

    if ( $pos_message_detail !== false ) {
        return dirname( __FILE__ ) . '/page-message-detail.php';
    }

    // Schedule Page
    $template_schedule_inbox = 'schedules';
    $pos_template_schedule_inbox = strpos( $url_path, $template_schedule_inbox );

    if ( $pos_template_schedule_inbox !== false ) {
        return dirname( __FILE__ ) . '/page-schedule-tour-inbox.php';
    }
    // Schedule Sent Page
    $template_schedule_sent = 'schedule-requests';
    $pos_template_schedule_sent = strpos( $url_path, $template_schedule_sent );

    if ( $pos_template_schedule_sent !== false ) {
        return dirname( __FILE__ ) . '/page-schedule-tour-sent.php';
    }
    // Schedule Detail Page
    $template_schedule_detail = 'schedule';
    $pos_schedule_detail = strpos( $url_path, $template_schedule_detail );

    if ( $pos_schedule_detail !== false ) {
        return dirname( __FILE__ ) . '/page-schedule-tour-detail.php';
    }

    // Packages Page
    $template_packages = 'packages';
    $pos_packages = strpos( $url_path, $template_packages );

    if ( $pos_packages !== false ) {
        return dirname( __FILE__ ) . '/page-packages.php';
    }

    // Saved Seaches Page
    $template_save_searches = 'searches';
    $pos_save_searches = strpos( $url_path, $template_save_searches );

    if ( $pos_save_searches !== false ) {
        return dirname( __FILE__ ) . '/page-save-searches.php';
    }

    // Posts Reviews Page
    $template_posts_reviews = 'posts-ratings';
    $pos_posts_reviews = strpos( $url_path, $template_posts_reviews );

    if ( $pos_posts_reviews !== false ) {
        return dirname( __FILE__ ) . '/page-reviews-posts.php';
    }

    // Orders Page
    $template_user_orders = 'my-orders';
    $pos_user_orders = strpos( $url_path, $template_user_orders );

    if ( $pos_user_orders !== false ) {
        return dirname( __FILE__ ) . '/page-user-orders.php';
    }
    // Orders Detail Page
    $template_user_orders_detail = 'my-order';
    $pos_user_orders_detail = strpos( $url_path, $template_user_orders_detail );

    if ( $pos_user_orders_detail !== false ) {
        return dirname( __FILE__ ) . '/page-user-orders-detail.php';
    }

    // Favorite Properties Page
    $template_favorite_properties = 'favorite-properties';
    $pos_favorite_properties = strpos( $url_path, $template_favorite_properties );

    if ( $pos_favorite_properties !== false ) {
        return dirname( __FILE__ ) . '/page-favorite-properties.php';
    }

    // Compare Properties Page
    $template_compare_properties = 'compare-properties';
    $pos_compare_properties = strpos( $url_path, $template_compare_properties );

    if ( $pos_compare_properties !== false ) {
        return dirname( __FILE__ ) . '/page-compare-properties.php';
    }

    return $template;
}
add_filter( 'template_include', 'luxus_load_custom_templates', 99 );

// Author Slug Rewrite for Custom Roles
function luxus_add_slugs_author_endpoint() {

    // Agent Slug
    add_permastruct( '%agent%', 'agent/%author%', [ 'ep_mask' => EP_AUTHORS,] );
    add_permastruct( '%agency%', 'agency/%author%', [ 'ep_mask' => EP_AUTHORS,] );
}
add_filter( 'init', 'luxus_add_slugs_author_endpoint', 99 );

function luxus_author_slug_rewrite( $link, $author_id, $author_nicename ) {
    
    // get the user page being requested
    $user = get_user_by('slug', get_query_var('author_name'));

    if ( user_can( $user, 'agent' ) ) {
        $link = '/agent/' . $author_nicename;
        $link = home_url( user_trailingslashit( $link ) );
    }

    if ( user_can( $user, 'agency' ) ) {
        $link = '/agency/' . $author_nicename;
        $link = home_url( user_trailingslashit( $link ) );
    }

    return $link;
}
add_filter( 'author_link', 'luxus_author_slug_rewrite', 10, 3 );

// Redirect Custom Roles
function luxus_authors_slug_redirect( $wp ) {

      if ( preg_match( '#^(author|agent|agency)/([^/]+)#', $wp->request, $matches ) ) {

        $user = get_user_by( 'login', $matches[2] );

        if ( ( 'author' === $matches[1] && user_can($user, 'agent') ) || ( 'agency' === $matches[1] && user_can($user, 'agent') ) ) {

            wp_redirect( home_url( '/agent/' . $matches[2] ) );
            exit;

        } elseif ( ('author' === $matches[1] && user_can( $user, 'agency') ) || ( 'agent' === $matches[1] && user_can( $user, 'agency') ) ) {

            wp_redirect( home_url( '/agency/' . $matches[2] ) );
            exit;
        }
    }
}
add_filter( 'parse_request', 'luxus_authors_slug_redirect' );
