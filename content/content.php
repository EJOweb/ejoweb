<?php $time = sprintf( "<time %s>%s</time>", hybrid_get_attr( 'entry-published' ), get_the_date( 'j F Y' ) ); ?>
<article <?php hybrid_attr( 'post' ); ?>>

	<?php if ( is_singular() ) : // If a single post. ?>

		<div class="content-header box-colored">
			<div class="wrap">

				<?php locate_template( array( 'menu/breadcrumbs.php' ), true ); // Loads the menu/breadcrumbs.php template. ?>

				<header class="entry-header">

					<h1 <?php hybrid_attr( 'entry-title' ); ?>><?php the_title(); ?></h1>

				</header>

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
				
					<div class="entry-byline">
						<?php echo $time; ?> &bullet; <?php hybrid_post_terms( array( 'taxonomy' => 'category' ) ); ?>
					</div>

					<?php the_content(); ?>
					
				</div><!-- .entry-content -->
				
			</div><!-- .wrap -->
		</div><!-- .content -->

	<?php else : // If not a single post. ?>

		<header class="entry-header">

			<div class="entry-byline">
				<?php echo $time; ?> &bullet; <?php hybrid_post_terms( array( 'taxonomy' => 'category' ) ); ?>
			</div>

			<h2 <?php hybrid_attr( 'entry-title' ); ?>><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark" itemprop="url"><?php the_title(); ?></a></h2>

		</header><!-- .entry-header -->

		<div <?php hybrid_attr( 'entry-content' ); ?>>

			<?php ejo_the_post_summary(); ?>

		</div><!-- .entry-content -->

		<footer class="entry-footer">

			<a href="<?php the_permalink(); ?>" class="button" title="<?php the_title_attribute(); ?>" rel="bookmark" itemprop="url">Lees verder</a>

		</footer>

	<?php endif; // End single post check. ?>

</article><!-- .entry -->