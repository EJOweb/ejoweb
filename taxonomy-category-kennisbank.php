<?php get_header(); // Loads the header.php template. ?>

<main <?php hybrid_attr( 'content' ); ?>>

	<?php hybrid_get_menu( 'breadcrumbs' ); // Loads the menu/breadcrumbs.php template. ?>	

	<?php if ( hybrid_is_plural() ) : ?>

		<?php locate_template( array( 'misc/archive-header.php' ), true ); // Loads the misc/archive-header.php template. ?>

	<?php endif; ?>

	<div class="kennisbank">

		<?php

		$categories = get_categories( array(
		    'orderby' => 'name',
		    'order'   => 'ASC',
		    'parent'  => get_queried_object_id()
		) );

		foreach( $categories as $category ) {
		    $category_link = sprintf( '<a href="%s" alt="%s">%s</a>',
		        esc_url( get_category_link( $category->term_id ) ),
		        esc_attr( sprintf( 'View all posts in %s', $category->name ) ),
		        esc_html( $category->name )
		    );

		    $category_posts_query = new WP_Query( array(
		    	'category_name' => $category->name,
		    	'posts_per_page' => 3	
		    ) );
			?>

		    <?php if ( $category_posts_query->have_posts() ) : // Checks if any posts were found. ?>

		    	<div class="kennisbank-category">

			    	<h2 <?php hybrid_attr( 'category-title' ); ?>><a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" title="<?php echo esc_attr( 'Bekijk alle '. $category->name .' artikelen' ); ?>" rel="bookmark" itemprop="url"><?php echo $category->name; ?></a></h2>

			    	<ul class="kennisbank-category-list">

					<?php while ( $category_posts_query->have_posts() ) : // Begins the loop through found posts. ?>

						<?php $category_posts_query->the_post(); // Loads the post data. ?>

						<li><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark" itemprop="url"><?php the_title(); ?></a></li>

						<?php //locate_template( array( 'content/kennisbank-archief-content.php' ), true, false ); // Loads the content/kennisbank-archief-content.php template. ?>

					<?php endwhile; // End found posts loop. ?>

					</ul>

					<?php 
						printf( '<a href="%s" alt="%s" class="read-more">%s</a>',
							esc_url( get_category_link( $category->term_id ) ),
							esc_attr( sprintf( 'Bekijk alle %s artikelen (%s)', $category->name, $category->count ) ),
							sprintf( 'Alle artikelen (%s)', $category->count )
						);
		        	?>

				</div>

			<?php endif; // End check for posts. ?>

			<?php

			// $category->name 
			// $category->term_id
			// $category_link
			// get_category_link( $category->term_id )
			// $category->description
			// $category->count
		}  

		?>

	</div>

</main><!-- #content -->

<?php get_footer(); // Loads the footer.php template. ?>

<?php
	/*
	//* Get knowledgebase categories
	$category_args = array(
		'parent'     => 0, 
		'orderby'    => 'name',
		'order'      => 'ASC',
		'hide_empty' => true
	);
	$kb_categories = get_terms('knowledgebase_category', $category_args);   
	
	echo '<div class="knowledgebase-container">';

	//* Loop throught the categories
	foreach ($kb_categories as $kb_category) { 

		// Define the query
		$args = array(
			'post_type' => 'knowledgebase',
			'knowledgebase_category' => $kb_category->slug
		);
		$kb_posts = new WP_Query( $args );
?>
		<div class="knowledgebase-category-block">
			<h2 class="knowledgebase-category">
				<i class="fa fa-folder-o"><!-- icon --></i><a href="<?php echo get_term_link($kb_category); ?>"><?php echo $kb_category->name; ?></a>
			</h2>	

			<?php while ( $kb_posts->have_posts() ) : $kb_posts->the_post(); ?>
				<div class="knowledgebase-article" id="post-<?php the_ID(); ?>">
					<i class="fa fa-file-text-o"><!-- icon --></i><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</div>
			<?php endwhile; ?>
		</div>
<?php
		// use reset postdata to restore orginal query
		wp_reset_postdata();

	} // END foreach

	echo '</div>';
	*/
?>