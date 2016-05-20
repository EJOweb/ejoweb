<?php get_header(); // Loads the header.php template. ?>

<?php locate_template( array( 'misc/archive-header.php' ), true ); // Loads the misc/archive-header.php template. ?>

<div class="content-main">
	<div class="wrap">

		<div class="kennisbank">
			<?php

			/* Get knowledgebase categories */
			$categories = get_terms( 
				'knowledgebase_category',
				array(
				    'orderby' => 'name',
				    'order'   => 'ASC',
				)
			);

			/* Loop through each knowledgebase category */
			foreach( $categories as $category ) {

				/* Get Knowledgebase ategory url */
				$category_url = esc_url( get_term_link( $category ) );

				/* Fabricate knowledgebase category link */
			    $category_link = sprintf( '<a href="%s" alt="%s">%s</a>',
			        $category_url,
			        esc_attr( sprintf( 'View all posts in %s', $category->name ) ),
			        esc_html( $category->name )
			    );

			    /* Get articles of current knowledgebase category */
			    $category_posts_query = new WP_Query( array(
			    	'post_type' => 'knowledgebase_post',
			    	'tax_query' => array(
						array(
							'taxonomy' => 'knowledgebase_category',
							'field'    => 'name',
							'terms'    => $category->name,
						),
					),
			    	'posts_per_page' => 3	
			    ) );

				?>

			    <?php if ( $category_posts_query->have_posts() ) : // Checks if any posts were found. ?>

			    	<section class="kennisbank-category">

				    	<h2 <?php hybrid_attr( 'category-title' ); ?>><a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" title="<?php echo esc_attr( 'Bekijk alle '. $category->name .' artikelen' ); ?>" rel="bookmark" itemprop="url"><?php echo $category->name; ?></a></h2>

				    	<div class="category-list">

						<?php while ( $category_posts_query->have_posts() ) : // Begins the loop through found posts. ?>

							<?php $category_posts_query->the_post(); // Loads the post data. ?>

							<?php hybrid_get_content_template(); // Loads the content/*.php template. ?>

						<?php endwhile; // End found posts loop. ?>

						</div>

						<footer>
							<?php 

							/* Show link to knowledgebase category including total amount of articles */
							printf( '<a href="%s" alt="%s" class="">%s</a>',
								$category_url,
								esc_attr( sprintf( 'Bekijk alle %s artikelen (%s)', $category->name, $category->count ) ),
								sprintf( 'Alle artikelen (%s)', $category->count )
							);
							
				        	?>
			        	</footer>

					</section><!-- kennisbank-category -->

				<?php endif; // End check for posts. ?>

				<?php
			}  

			?>

		</div><!-- .kennisbank -->

	</div><!-- .wrap -->
</div><!-- .content -->

<?php get_footer(); // Loads the footer.php template. ?>
