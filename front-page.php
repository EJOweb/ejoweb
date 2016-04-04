<?php get_header(); // Loads the header.php template. ?>

<main <?php hybrid_attr( 'content' ); ?>>

	<?php locate_template( array( 'misc/page-header.php' ), true ); // Loads the misc/page-header.php template. ?>

	<section class="entry" itemtype="http://schema.org/CreativeWork" itemscope="itemscope">

		<header class="entry-header">
			<h2 <?php hybrid_attr( 'entry-title' ); ?>>Professionele website laten maken?</h2>
		</header>

		<div <?php hybrid_attr( 'entry-content' ); ?>>

			<h3>Hier moet een relevante zin staan</h3>

			<div class="columns-3">

				<div class="column">
					<h4>Vakkundige ontwikkeling</h4>
					<p>Dit is een faketekst. Alles wat hier staat is slechts om een indruk te geven van het grafische effect van tekst op deze plek.</p>
				</div>

				<div class="column">
					<h4>Design dat bij u past</h4>
					<p>Dit is een faketekst. Alles wat hier staat is slechts om een indruk te geven van het grafische effect van tekst op deze plek.</p>
				</div>

				<div class="column">
					<h4>Zoekmachine vriendelijk</h4>
					<p>Dit is een faketekst. Alles wat hier staat is slechts om een indruk te geven van het grafische effect van tekst op deze plek.</p>
				</div>

				<div class="column">
					<h4>Zelf je website aanpassen</h4>
					<p>Dit is een faketekst. Alles wat hier staat is slechts om een indruk te geven van het grafische effect van tekst op deze plek.</p>
				</div>

				<div class="column">
					<h4>Desktop, tablet en smartphone</h4>
					<p>Dit is een faketekst. Alles wat hier staat is slechts om een indruk te geven van het grafische effect van tekst op deze plek.</p>
				</div>

				<div class="column">
					<h4>Social media koppeling</h4>
					<p>Dit is een faketekst. Alles wat hier staat is slechts om een indruk te geven van het grafische effect van tekst op deze plek.</p>
				</div>

			</div>

		</div>

	</section>

</main><!-- #content -->

<?php get_footer(); // Loads the footer.php template. ?>