<div class="loga-slider"> <?php
if ( is_front_page() ) {
    // This is a homepage
} else {
echo do_shortcode('[sp-carousel id="5641"]');
}
?> </div>		

		<?php do_action( 'sp_before_main_footer_container' ); ?>
		<footer id="footer-wrap">
			<?php get_sidebar( 'footer' ); ?>

			<section class="footer-bar">
				<div class="container">
					<div class="row">
						<div class="<?php echo sp_column_css( '12', '6', '', '6' ); ?>">
							<?php echo sp_copyright_html(); ?>
						</div><!--close .column-->

						<div class="<?php echo sp_column_css( '12', '6', '', '6' ); ?>">
							<?php sp_get_menu( 'footer-bar-menu' ); ?> 
						</div><!--close .column-->			
					</div><!--close .row-->
				</div><!--close .container-->
			</section><!--close .footer-bar-->
		</footer><!--close #footer-wrap-->
		<?php do_action( 'sp_after_main_footer_container' ); ?>

	</div><!--close .layout-container-->
</div><!--close #wrap-all-->

<?php echo sp_back_to_top_html(); ?>

<?php wp_footer(); ?><!--test-->
</body>
</html>