<?php get_header(); // Loads the header.php template. ?>

<main <?php hybrid_attr( 'content' ); ?>>

	<?php
	/**
	 * Remove 'Blog' crumb from breadcrumbs on 404 pages
	 */
	add_filter( 'wpseo_breadcrumb_links', 'ejo_wpseo_breadcrumbs_filter' );
	function ejo_wpseo_breadcrumbs_filter($crumbs)
	{
		if (count($crumbs) > 2) {
			unset($crumbs[1]);
		}

		return $crumbs;
	}
	?>

	<?php hybrid_get_menu( 'breadcrumbs' ); // Loads the menu/breadcrumbs.php template. ?>	
	
	<?php locate_template( array( 'content/error.php' ), true ); // Loads the content/error.php template. ?>

</main><!-- #content -->

<?php get_footer(); // Loads the footer.php template. ?>