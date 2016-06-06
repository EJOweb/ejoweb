<?php get_header(); // Loads the header.php template. ?>

<section class="content-header">
	<?php locate_template( array( 'misc/header-image.php' ), true ); // Loads the misc/header-image.php template. ?>
	<div class="wrap">

		<article <?php hybrid_attr( 'post' ); ?>>

			<header class="entry-header">

				<h1 <?php hybrid_attr( 'entry-title' ); ?>><?php the_title(); ?><?php the_subtitle('<span class="subtitle">', '</span>'); ?></h1>

			</header><!-- .entry-header -->

			<?php if ($intro_content = ejo_get_intro_content()) : // Check if there's intro content ?>

				<div <?php hybrid_attr( 'entry-content' ); ?>>

					<?php echo $intro_content; ?>
					
				</div><!-- .entry-content -->
				
			<?php endif; // End intro content check ?>

		</article>

	</div><!-- .wrap -->
</section><!-- .content-header -->

<section class="content-main">
	<div class="wrap">

		<article <?php hybrid_attr( 'post' ); ?>>

			<header class="entry-header">

				<?php dynamic_sidebar('home-main-title'); ?>

			</header><!-- .entry-header -->

			<div <?php hybrid_attr( 'entry-content' ); ?>>
				<div class="columns columns-3">

					<?php dynamic_sidebar('home-main'); ?>
				
				</div>
			</div><!-- .entry-content -->

		</article>
		
	</div><!-- .wrap -->
</section><!-- .content-main -->

<?php get_footer(); // Loads the footer.php template. ?>