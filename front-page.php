<?php get_header(); // Loads the header.php template. ?>

<main <?php hybrid_attr( 'content' ); ?>>

	<?php locate_template( array( 'sidebar/home-blocks.php' ), true ); // Loads the sidebar/home-blocks.php template. ?>

</main><!-- #content -->

<?php locate_template( array( 'misc/loop-nav.php' ), true ); // Loads the misc/loop-nav.php template. ?>

<?php get_footer(); // Loads the footer.php template. ?>