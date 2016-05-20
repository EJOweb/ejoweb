			<?php locate_template( array( 'sidebar/call-to-action-bar.php' ), true ); // Loads the sidebar/call-to-action-bar.php template. ?>

		</main><!-- #content -->

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