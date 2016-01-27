<!DOCTYPE html>
<html <?php language_attributes( 'html' ); ?>>

<head>
<?php wp_head(); // Hook required for scripts, styles, and other <head> items. ?>
</head>

<body <?php hybrid_attr( 'body' ); ?>>

	<div id="container">

		<header <?php hybrid_attr( 'header' ); ?>>
			<div class="header-image"></div>

			<div class="wrap">

				<div <?php hybrid_attr( 'branding' ); ?>>
					<?php $logo = '<img itemprop="logo" alt="EJOweb" src="' . THEME_IMG_URI . 'logo.png">'; ?>
					<?php printf( '<h1 %s><a href="%s" rel="home">%s</a></h1>', hybrid_get_attr( 'site-title' ), esc_url( home_url() ), $logo ); ?>
					<span class="screen-reader-text" itemprop="name"><?php bloginfo( 'name' ); ?></span>
				</div><!-- #branding -->

				<?php hybrid_get_menu( 'primary' ); // Loads the menu/primary.php template. ?>
				<?php //hybrid_get_menu( 'primary-mobile' ); // Loads the menu/primary-mobile.php template. ?>
				
			</div><!-- .wrap -->

		</header><!-- #header -->


		<div id="main" class="main">
			<div class="wrap">			
