<?php
/**
 * Classic Header
 *
 * @package luxus
 */

// Get options

$footer_col_opt = luxus_options('footer-columns');
$footer_col = !$footer_col_opt == null ? $footer_col_opt : 'four';

if ( $footer_col == 'one') {
	$col = 'col-lg-12';
}
if ( $footer_col == 'two') {
	$col = 'col-lg-6';
}
if ( $footer_col == 'three') {
	$col = 'col-lg-4';
}
if ( $footer_col == 'four') {
	$col = 'col-lg-3';
}

$classic_footer_width = luxus_options('footer-width');

if ( is_active_sidebar( 'footer-widget-one' ) || is_active_sidebar( 'footer-widget-two' ) || is_active_sidebar( 'footer-widget-three' ) || is_active_sidebar( 'footer-widget-four' ) ) :
?>

<footer class="classic-footer dark">
	<div class="<?php echo esc_attr(!$classic_footer_width == null ? $classic_footer_width : 'container'); ?>">
		<div class="row">
			<?php if ( $footer_col == 'one' || $footer_col == 'two' || $footer_col == 'three' || $footer_col == 'four' ) : ?>
				<div class="<?php echo esc_attr($col); ?>">
					<?php dynamic_sidebar( 'footer-widget-one' ); ?>
				</div>
			<?php endif;
			if ( $footer_col == 'two' || $footer_col == 'three' || $footer_col == 'four' ) : ?>
				<div class="<?php echo esc_attr($col); ?>">
					<?php dynamic_sidebar( 'footer-widget-two' ); ?>
				</div>
			<?php endif;
			if ( $footer_col == 'three' || $footer_col == 'four' ) : ?>
				<div class="<?php echo esc_attr($col); ?>">
					<?php dynamic_sidebar( 'footer-widget-three' ); ?>
				</div>
			<?php endif;
			if ( $footer_col == 'four' ) : ?>
				<div class="<?php echo esc_attr($col); ?>">
					<?php dynamic_sidebar( 'footer-widget-four' ); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</footer>
<!-- Footer -->

<!-- Footer Bottom -->
<?php endif;

if(class_exists('CSF')){

	$enable_footer_bottom = luxus_options('enable-footer-bottom');
	
	if( $enable_footer_bottom == true ) : ?>
		<div class="footer-bottom">
			<div class="container">
				<p><?php echo esc_html(luxus_options('footer-bottom-text')); ?></p>
			</div>	
		</div>
	<?php endif;

}  else { ?>

	<div class="footer-bottom">
		<div class="container">
			<p><?php esc_html_e('&copy Copyright 2022. All Rights Reserved', 'luxus'); ?></p>
		</div>	
	</div>

<?php
}