<?php /* <article <?php hybrid_attr( 'post' ); ?>> */ ?>
<article id="post-0" class="entry">

	<?php if (is_search()): // Check if Search page ?>

		<div class="content-main">
			<div class="wrap">

				<div <?php hybrid_attr( 'entry-content' ); ?>>

					<?php echo wpautop( esc_html( 'Geen resultaten.' ) ); ?>
					
				</div><!-- .entry-content -->
				
			</div><!-- .wrap -->
		</div><!-- .content -->

	<?php elseif (is_404()): ?>

		<div class="content-header box-colored">
			<div class="wrap">

				<?php locate_template( array( 'menu/breadcrumbs.php' ), true ); // Loads the menu/breadcrumbs.php template. ?>

				<header class="entry-header">
					<h1 class="entry-title"><?php echo esc_html( 'Pagina niet gevonden' ); ?></h1>
				</header>

			</div><!-- .wrap -->
		</div><!-- .content-header -->

		<div class="content-main">
			<div class="wrap">

				<div <?php hybrid_attr( 'entry-content' ); ?>>

					<?php echo wpautop( esc_html( 'De pagina waar u naar zoekt bestaat niet (meer). Misschien vindt u wat u zoekt via de homepagina.' ) ); ?>
					
				</div><!-- .entry-content -->
				
			</div><!-- .wrap -->
		</div><!-- .content -->

	<?php else: ?>

		<div class="content-header box-colored">
			<div class="wrap">

				<?php locate_template( array( 'menu/breadcrumbs.php' ), true ); // Loads the menu/breadcrumbs.php template. ?>

				<header class="entry-header">
					<h1 class="entry-title"><?php echo esc_html( 'Pagina niet gevonden' ); ?></h1>
				</header>

			</div><!-- .wrap -->
		</div><!-- .content-header -->

		<div class="content-main">
			<div class="wrap">

				<div <?php hybrid_attr( 'entry-content' ); ?>>

					<?php echo wpautop( esc_html( 'De pagina waar u naar zoekt bestaat niet (meer). Misschien vindt u wat u zoekt via de homepagina.' ) ); ?>
					
				</div><!-- .entry-content -->
				
			</div><!-- .wrap -->
		</div><!-- .content -->

	<?php endif; // End check Search ?>


</article><!-- .entry -->