<article <?php hybrid_attr( 'post' ); ?>>

	<div class="content-header box-colored">
		<div class="wrap">

			<?php locate_template( array( 'menu/breadcrumbs.php' ), true ); // Loads the menu/breadcrumbs.php template. ?>

			<header class="entry-header">

				<h1 <?php hybrid_attr( 'entry-title' ); ?>><?php the_title(); ?></h1>

			</header><!-- .entry-header -->

			<?php if ($intro_content = ejo_get_intro_content()) : // Check if there's intro content ?>

				<div <?php hybrid_attr( 'entry-content' ); ?>>

					<?php echo $intro_content; ?>
					
				</div><!-- .entry-content -->
				
			<?php endif; // End intro content check ?>

		</div><!-- .wrap -->
	</div><!-- .content-header -->

	<div class="content">
		<div class="wrap">

			<div <?php hybrid_attr( 'entry-content' ); ?>>

				<?php the_content(); ?>
				
			</div><!-- .entry-content -->
			
		</div><!-- .wrap -->
	</div><!-- .content -->

</article><!-- .entry -->