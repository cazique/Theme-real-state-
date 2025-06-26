<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Luxus
 */

get_header();
?>

<div class="page-content fzf-page-content">
	<div class="container">
		<div class="row text-center">
			<div class="col-lg-12">
				<div class="fzf-error">
					<h1 class="fzf-text"><?php esc_html_e( '404', 'luxus' ); ?></h1>
					<h2 class="fzf-title"><?php esc_html_e( 'PAGE NOT FOUND!', 'luxus' ); ?></h2>
					<p class="fzf-description">
						<?php esc_html_e( 'Oops! The page you are looking for does not exist. It might have been moved or deleted.', 'luxus' ); ?>
					</p>
					<div class="back-to-home">
						<a href="<?php echo esc_url( home_url() ); ?>"><?php esc_html_e( 'Back To Home Page', 'luxus' ); ?></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
get_footer();
