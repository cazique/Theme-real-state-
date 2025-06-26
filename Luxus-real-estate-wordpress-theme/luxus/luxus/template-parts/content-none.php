<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Luxus
 */

?>

<div class="col-lg-12 content-none">
	<?php
	if ( is_home() && current_user_can( 'publish_posts' ) ) :

		printf(
			'<p>' . wp_kses(
				/* translators: 1: link to WP admin new post page. */
				__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'luxus' ),
				array(
					'a' => array(
						'href' => array(),
					),
				)
			) . '</p>',
			esc_url( admin_url( 'post-new.php' ) )
		);

	elseif ( is_search() ) : ?>
		<div class="fzf-error sl-box text-center">

			<?php $error_img = get_template_directory_uri() . '/assets/images/not-found.png'; ?>

			<img src="<?php echo esc_url($error_img); ?>">
			<h2 class="fzf-title"><?php esc_html_e( 'OOPS! NOTHING FOUND.', 'luxus' ); ?></h2>
			<p class="fzf-description">
				<?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'luxus' ); ?>
			</p>
			<?php get_search_form(); ?>
		</div>
	<?php else : ?>
		<div class="fzf-error sl-box text-center">
			<h1 class="fzf-text"><?php esc_html_e( '404', 'luxus' ); ?></h1>
			<h2 class="fzf-title"><?php esc_html_e( 'OOPS! NOTHING FOUND.', 'luxus' ); ?></h2>
			<p class="fzf-description">
				<?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'luxus' ); ?>
			</p>
			<?php get_search_form(); ?>
		</div>
	<?php endif; ?>
</div><!-- .page-content -->