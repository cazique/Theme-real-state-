<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

/**
 * Template Name: Signup
 */

get_header();

// Get options
$sidebar_position = luxus_options('sidebar-position');
$enable_page_title = luxus_options('enable-page-title');
$enable_breadcrumb  = luxus_options('enable-breadcrumb');

if( $enable_page_title == true ): ?>

<div class="page-header">
	<div class="container">
		<?php

			the_title( '<h2 class="page-title">', '</h2>' );

			if( $enable_breadcrumb == true ): ?>

				<p class="sl_breadcrumb"><?php echo luxus_get_breadcrumb(); ?></p>

			<?php endif;?>
	</div>
</div><!-- .page-header -->

<?php endif; ?>

<!-- Main Content -->
<div class="page-content">
	<div class="container">
		<div class="row">
            <div class="offset-lg-2 col-lg-8">
				<?php luxus_registration_form_function(); ?>
            </div>
		</div>
	</div>
</div>
<!-- Main Content End -->

<?php
get_footer();