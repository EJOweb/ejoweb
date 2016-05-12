<?php
/**
 * @package    EJOweb
 * @author     Erik Joling <erik@ejoweb.nl>
 * @copyright  Copyright (c) 2015, Erik Joling
 * @link       http://www.ejoweb.nl/
 */

//* Get the template directory and uri and make sure it has a trailing slash.
define( 'THEME_LIB_DIR', trailingslashit( get_template_directory() ) . 'includes/' );
define( 'THEME_LIB_URI', trailingslashit( get_template_directory_uri() ) . 'includes/' );

//* Set custom Hybrid location.
define( 'HYBRID_DIR', THEME_LIB_DIR . 'hybrid/' );
define( 'HYBRID_URI', THEME_LIB_URI . 'hybrid/' );

//* Load the Hybrid Core framework and theme files.
require_once( HYBRID_DIR . 'hybrid.php' );

//* Theme setup ie. menus, sidebars, image-sizes, additional scripts and styles.
require_once( THEME_LIB_DIR . 'theme.php' );

//* Launch the Hybrid Core framework.
new Hybrid();


// *** BEGIN *** //

//* Do theme setup on the 'after_setup_theme' hook.
add_action( 'after_setup_theme', 'ejo_theme_setup', 5 );

/**
 * Theme setup function.  This function adds support for theme features and defines the default theme
 * actions and filters.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function ejo_theme_setup() 
{
	//* Set Version
	define( 'THEME_VERSION', wp_get_theme()->get( 'Version' ) );

	//* Set paths to asset folders.
	define( 'THEME_IMG_URI', trailingslashit( HYBRID_PARENT_URI ) . 'assets/images/' );
	define( 'THEME_JS_URI', trailingslashit( HYBRID_PARENT_URI ) . 'assets/js/' );
	define( 'THEME_CSS_URI', trailingslashit( HYBRID_PARENT_URI ) . 'assets/css/' );

	//* Enable custom template hierarchy.
	add_theme_support( 'hybrid-core-template-hierarchy' );

	//* Better image grabbing
	add_theme_support( 'get-the-image' );

	/* Cleanup Backend */
	add_theme_support( 'ejo-cleanup-backend', array( 'widgets', 'wp-smush' ) );

	/* Cleanup Frontend */
	add_theme_support( 'ejo-cleanup-frontend', array( 'head', 'xmlrpc', 'pingback' ) );

	/* Allow admin to add scripts to entire site and specific posts */
	add_theme_support( 'ejo-site-scripts' );
	add_theme_support( 'ejo-post-scripts' );

	/* Allow admin to add scripts */
	add_theme_support( 'ejo-social-links' );

	/* Improved Visual Editor */
	add_theme_support( 'ejo-tinymce' );

	/* EJO Knowledgebase */
	add_theme_support( 'ejo-knowledgebase' );

	/* Admin Script for Image selecting */
	add_theme_support( 'ejo-admin-image-select' );

	/* Admin Client Cleanup */
	add_theme_support( 'ejo-admin-client-cleanup', array() );

	/* Yoast Breadcrumbs */
	add_theme_support( 'yoast-seo-breadcrumbs' );

	/* Remove Subtitles inline css */
	if ( class_exists( 'Subtitles' ) &&  method_exists( 'Subtitles', 'subtitle_styling' ) ) {
	    remove_action( 'wp_head', array( Subtitles::getInstance(), 'subtitle_styling' ) );
	}

	//* Add style-buttons to visual editor
	add_filter( 'ejo_tinymce_style_formats', 'ejo_add_tinymce_style_formats', 5 );

	//* Remove feeds for the time being
	remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
	remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed
}

/**
 * Add styles to tinymce
 */
function ejo_add_tinymce_style_formats( $style_formats )
{
	$style_formats[] =  array(
        'title' => 'Button',
        'selector' => 'a',
        'classes' => 'button'
    );

	return $style_formats;
}