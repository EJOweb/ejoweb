		<aside class="footer-banner box-colored">
			<div class="wrap">
				<!-- <section class="entry" itemtype="http://schema.org/CreativeWork" itemscope="itemscope"> -->

					<h2 <?php hybrid_attr( 'entry-title' ); ?>>Meer weten over het laten maken van een website?</h2>

					<a href="" class="button highlight">Contact opnemen</a>

				<!-- </section> -->
			</div>
		</aside>

		<footer <?php hybrid_attr( 'footer' ); ?>>
			<div class="wrap">
				<div class="footer-widgets">

					<?php dynamic_sidebar('footer-widgets'); ?>

				</div><!-- .footer-widgets -->
				<div class="footer-line">

					<?php dynamic_sidebar('footer-line'); ?>

				</div><!-- .footer-line -->
			</div>
		</footer><!-- #footer -->

	</div><!-- #container -->

	<?php wp_footer(); // WordPress hook for loading JavaScript, toolbar, and other things in the footer. ?>

</body>
</html>