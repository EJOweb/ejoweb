<div class="page-header box-colored">
	<div class="wrap">

		<section <?php hybrid_attr( 'post' ); ?>>

			<?php if ( is_front_page() ) : // If front-page. ?>			

				<header class="entry-header">
					<h1 <?php hybrid_attr( 'entry-title' ); ?>>Professionele website laten maken?</h1>
				</header>

				<div <?php hybrid_attr( 'entry-content' ); ?>>

					<h3>Vakkundig webdesign</h3>

					<p>Op zoek naar een <a href="#">webdesign-bureau</a> om je website te laten maken? Dan ben je hier aan het juiste adres. <strong>Wij bouwen <strong>professionele websites</strong> voor kleine bedrijven, ZZP’ers en particulieren.</strong> Onze websites zijn zoekmachine vriendelijk en zien er goed uit op desktop, tablet én smartphone!</p>

					<p>Alsof dat nog niet genoeg is zorgen wij met vakkundig programmeerwerk en betrouwbare hosting dat je website razendsnel laadt. En tot slot kun je altijd eenvoudig zelf je website vullen en aanpassen. Met onze jarenlange ervaring in webdesign en ontwikkeling zijn we je graag van dienst.</p>

					<p><a href="" class="button">Webdiensten</a> <a href="" class="button highlight">Direct contact</a></p>

				</div><!-- .entry-content -->				

			<?php else : // If not front-page. ?>

				<header class="entry-header">
					<h1 <?php hybrid_attr( 'entry-title' ); ?>><?php the_title(); ?></h1>
				</header>

				<div <?php hybrid_attr( 'entry-content' ); ?>>

					<?php the_content(); ?>

				</div><!-- .entry-content -->

			<?php endif; // End front-page check. ?>

		</section>
	
	</div>
</div>