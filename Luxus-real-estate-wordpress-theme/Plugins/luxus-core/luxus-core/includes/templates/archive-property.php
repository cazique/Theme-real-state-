<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

/**
 * The template for displaying all archive posts of 'property post type'
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package luxus
 */

get_header();

// Get options
$sidebar_position = luxus_options('property-archive-sidebar-position');
$is_active_sidebar = ( is_active_sidebar( 'property-pages-widget' ) ? true : false );
$active_col = ( $is_active_sidebar == true ? '8' : '12' );

?>

<div class="property-archive-page-header">
	<div class="container">
		<?php
			if (is_author()) {

				$author = (isset($_GET['author_name'])) ? 
				    get_user_by('slug', $author_name) : 
				    get_userdata(intval($author));

				$author_name  = ucfirst( $author->nickname );
		?>

		<h2 class="property-archive-title title"><?php echo esc_html__('Properties By: ', 'luxus-core') . $author_name; ?></h2>

		<?php } else {

				the_archive_title( '<h1 class="property-archive-title">', '</h1>' );
			}
		?>
	</div>
</div><!-- .page-header -->

<!-- Main Content -->
<div class="page-content properties-archive">
	<div class="container">
		<div class="row">
            <div class="col-lg-<?php echo esc_attr($active_col); ?>">
	            <div  class="filter-properties">
	                <!-- List View / Grid View -->
	                <div class="list-grid-view">
	                    <a href="#" id="grid"><i class="sl-icon sl-grid-view"></i></a>
	                    <a href="#" id="list"><i class="sl-icon sl-list-view"></i></a>
	                </div>
	                <div class="sort-by">
	                    <form id="set_sort_filter" action="" method="get" novalidate="novalidate">
			                <div class="sl-select">
			                	<?php if (is_author()) : ?>
			                		
								<select class="dropdown-class" name="sort_by" onchange="document.location.search=this.options[this.selectedIndex].value;">
									<option disabled><?php esc_html_e('Sort by', 'luxus-core')?></option>
									<option <?php if( isset($_GET["orderby"]) && trim($_GET["orderby"]) == 'date' && isset($_GET["order"]) && trim($_GET["order"]) == 'DESC' ){ echo 'selected'; } ?> value="?post_type=property&orderby=date&order=DESC"><?php esc_html_e('Newest', 'luxus-core')?></option>
									<option <?php if( isset($_GET["orderby"]) && trim($_GET["orderby"]) == 'date' && isset($_GET["order"]) && trim($_GET["order"]) == 'ASC' ){ echo 'selected'; } ?>  value="?post_type=property&orderby=date&order=ASC"><?php esc_html_e('Oldest', 'luxus-core')?></option>
									<option <?php if( isset($_GET["orderby"]) && trim($_GET["orderby"]) == 'title' && isset($_GET["order"]) && trim($_GET["order"]) == 'ASC' ){ echo 'selected'; } ?> value="?post_type=property&orderby=title&order=ASC" value="?orderby=title&order=ASC"><?php esc_html_e('A-Z Asc', 'luxus-core')?></option>
									<option <?php if( isset($_GET["orderby"]) && trim($_GET["orderby"]) == 'title' && isset($_GET["order"]) && trim($_GET["order"]) == 'DESC' ){ echo 'selected'; } ?>  value="?post_type=property&orderby=title&order=DESC"><?php esc_html_e('A-Z Desc', 'luxus-core')?></option>
								</select>

								<?php else: ?>

								<select class="dropdown-class" name="sort_by" onchange="document.location.search=this.options[this.selectedIndex].value;">
									<option disabled><?php esc_html_e('Sort by', 'luxus-core')?></option>
									<option <?php if( isset($_GET["orderby"]) && trim($_GET["orderby"]) == 'date' && isset($_GET["order"]) && trim($_GET["order"]) == 'DESC' ){ echo 'selected'; } ?> value="?orderby=date&order=DESC"><?php esc_html_e('Newest', 'luxus-core')?></option>
									<option <?php if( isset($_GET["orderby"]) && trim($_GET["orderby"]) == 'date' && isset($_GET["order"]) && trim($_GET["order"]) == 'ASC' ){ echo 'selected'; } ?>  value="?orderby=date&order=ASC"><?php esc_html_e('Oldest', 'luxus-core')?></option>
									<option <?php if( isset($_GET["orderby"]) && trim($_GET["orderby"]) == 'title' && isset($_GET["order"]) && trim($_GET["order"]) == 'ASC' ){ echo 'selected'; } ?> value="?orderby=title&order=ASC" value="?orderby=title&order=ASC"><?php esc_html_e('A-Z Asc', 'luxus-core')?></option>
									<option <?php if( isset($_GET["orderby"]) && trim($_GET["orderby"]) == 'title' && isset($_GET["order"]) && trim($_GET["order"]) == 'DESC' ){ echo 'selected'; } ?>  value="?orderby=title&order=DESC"><?php esc_html_e('A-Z Desc', 'luxus-core')?></option>
								</select>

								<?php endif;?>
		                	</div>
	                    </form>
	                </div>

	            </div>
                <div id="properties">
	                <div class="row">
	                    <?php

                        $post_view = luxus_options('property-archive-post-view');
                        $sl_col = ( $post_view == 'grid-view' ? 'col-sm-12 col-md-6 col-lg-6' : 'col-lg-12' );
                        $sl_col_item = ( $post_view == 'grid-view' ? 'property-grid' : 'property-list' );

	                    if ( have_posts() ) :
	                        /* Start the Loop */
	                        while ( have_posts() ) :
	                            the_post();

	                    ?>
		                        <div class="sl-col <?php echo esc_attr($sl_col); ?>">
                                    <div class="sl-item <?php echo esc_attr($sl_col_item); ?>">
			                            <?php

			                            // Property Template Parts
			                            require dirname( __FILE__ ) . '/template-parts/property-style-one.php';

			                            ?>
			                        </div>
		                        </div>
	           			<?php
							
							endwhile;

								// Custom Pagination
								echo '<div class="col-lg-12">';
                                luxus_pagination();
                                echo '</div>';

                                else :

                                $not_found_img = SL_PLUGIN_URL . 'public/images/error.png';
                        ?>
                                <div class="col-xl-12">
                                    <div class="not-found-result">
                                        <img src="<?php echo esc_url($not_found_img); ?>">
                                        <h6><?php esc_html_e( 'Sorry, No Properties Found.', 'luxus-core' ); ?></h6>
                                    </div>
                                </div>

                        <?php 

	                    endif;
	                    	wp_reset_postdata();
	                    ?>
	                </div>
	            </div>
	        </div>

            <?php if( $is_active_sidebar == true ) : ?>
			<!-- This Class order-xl-first is for float sidebar left -->
			<div class="col-lg-4 sl-sticky <?php echo esc_attr( $sidebar_position == 'left-sidebar' ? 'order-lg-first' : '' ); ?>">
				<aside id="secondary" class="widget-area">
                    <?php dynamic_sidebar( 'property-pages-widget' ); ?>
                </aside><!-- #secondary -->
			</div>
			<?php endif; ?>

		</div>
	</div>
</div>
<!-- Main Content End -->

<?php
get_footer();
