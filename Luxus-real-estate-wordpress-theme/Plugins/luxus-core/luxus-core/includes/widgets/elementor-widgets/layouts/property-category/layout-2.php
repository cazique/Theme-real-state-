<?php

$taxonomy = $settings['select_category'];

switch ($taxonomy) {

    case "property_type":
        $taxonomy_slug = $settings['property_type'];
        break;
    case "property_feature":
        $taxonomy_slug = $settings['property_feature'];
        break;
    case "property_status":
        $taxonomy_slug = $settings['property_status'];
        break;
    case "property_city":
        $taxonomy_slug = $settings['property_city'];
        break;
    case "property_province":
        $taxonomy_slug = $settings['property_province'];
        break;
    case "property_country":
        $taxonomy_slug = $settings['property_country'];
        break;
    default:
        $taxonomy_slug = '';
}

if ( !$taxonomy == NULL && !$taxonomy_slug == NULL ) :

    $category = get_term_by('slug', $taxonomy_slug, $taxonomy);

    $category_link = !is_wp_error($category) && !empty($category) ? get_term_link($category->term_id) : null;

    echo '<div class="sl-category sl-cat-two">';

    echo '<p class="cat-count">' . esc_html(!empty($category) ? $category->count : '') . ' ' . esc_html($settings['posts_count_postfix']) . '</p>';

    echo '<img src="'. esc_url($settings['category_image']['url']) .'" class="cat-image" alt="'. esc_attr(!empty($category) ? $category->name : '') .'">';

    if ( !$category == NULL ) {
        
    ?>

    <div class="cat-info">
        <h5 class="cat-name"><?php echo esc_html($category->name); ?></h5>
        <a href="<?php echo esc_url($category_link); ?>" class="tax-explore"><?php echo esc_html($settings['link_text']); ?></a>
    </div>

    <?php

    }

    echo '</div>';

else:

    esc_html_e('Please Select Category', 'luxus-core');

endif;

?>



