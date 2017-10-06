<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>
</div><!-- .site-content -->
	<div id="page-back"></div>
	<footer class="site-footer" role="contentinfo">
		<div id="footer">
			<div class="footer-col">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<img class="ftr-logo" src="<?php echo img_src_uri('logo_lokaal_01.svg'); ?>">
				</a>
				
			</div>
			<?php dynamic_sidebar('sidebar_footr'); ?>
		</div>
	</footer><!-- .site-footer -->
</div><!-- .site -->

<script src="<?php echo get_template_directory_uri() . '/js/setfootr.js'?>"></script>
<script src="<?php echo get_template_directory_uri() . '/js/setcolor.js'?>"></script>
</body>
</html>
