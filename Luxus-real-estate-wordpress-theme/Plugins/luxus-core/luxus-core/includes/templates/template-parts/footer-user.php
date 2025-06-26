<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package luxus
 */

?>
	        <!-- Footer -->
	        <footer class="site-footer user-footer">
	            <div class="container">
	                <div class="row">
	                    <div class="col-lg-12">
	                        <p class="copyright">
	          					<?php echo esc_html__('Copyright ©','luxus-core') . date('Y') . ' - <a href="'. esc_url(get_home_url()). '">'. get_bloginfo() .'</a>'; ?>
	                        </p>
	                    </div>
	                </div>
	            </div>
	        </footer>
		</div>
	</div>

	<?php wp_footer(); ?>
</body>
</html>