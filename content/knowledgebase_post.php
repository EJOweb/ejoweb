<article <?php hybrid_attr( 'post' ); ?>>

	<?php if ( is_singular() ) : // If a single knowledgebase post. ?>

		<header class="entry-header">
			<h1 <?php hybrid_attr( 'entry-title' ); ?>><?php the_title(); ?></h1>
		</header>

		<div <?php hybrid_attr( 'entry-content' ); ?>>

			<?php the_content(); ?>

		</div><!-- .entry-content -->

	<?php elseif (is_post_type_archive()) : // Check if knowledgebase archive ?>

		<header class="entry-header">
			<h4 <?php hybrid_attr( 'entry-title' ); ?>><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark" itemprop="url"><?php the_title(); ?></a></h4>
		</header><!-- .entry-header -->

	<?php else : // If not a single knowledgebase post or archive. ?>

		<header class="entry-header">
			<h2 <?php hybrid_attr( 'entry-title' ); ?>><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark" itemprop="url"><?php the_title(); ?></a></h2>
		</header><!-- .entry-header -->
	
	<?php endif; // End knowledgebase post check. ?>

</article><!-- .entry -->