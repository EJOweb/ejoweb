<?php if ( is_active_sidebar( 'home-blocks' ) ) : // If the sidebar has widgets. ?>

	<div class="home-blocks">
		<?php dynamic_sidebar( 'home-blocks' ); // Displays the home-block sidebar. ?>
	</div>

<?php endif; // End sidebar active check. ?>
