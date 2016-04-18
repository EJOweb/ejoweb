<article <?php hybrid_attr( 'post' ); ?>>

	<?php if ( is_singular() ) : // If a single knowledgebase post. ?>

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

		<div class="content-main">
			<div class="wrap">

				<div <?php hybrid_attr( 'entry-content' ); ?>>

					<?php the_content(); ?>
					
				</div><!-- .entry-content -->
				
			</div><!-- .wrap -->
		</div><!-- .content-main -->

	<?php elseif (is_post_type_archive()) : // Check if knowledgebase archive ?>

		<header class="entry-header">
			<h3 <?php hybrid_attr( 'entry-title' ); ?>><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark" itemprop="url"><?php the_title(); ?></a></h3>
		</header><!-- .entry-header -->

	<?php else : // If not a single knowledgebase post or archive. ?>

		<header class="entry-header">
			<h2 <?php hybrid_attr( 'entry-title' ); ?>><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark" itemprop="url"><?php the_title(); ?></a></h2>
		</header><!-- .entry-header -->
	
	<?php endif; // End knowledgebase post check. ?>

</article><!-- .entry -->