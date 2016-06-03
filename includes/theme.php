<?php
/**
 * Sets up custom filters and actions for the theme.  This does things like sets up sidebars, menus, scripts, 
 * and lots of other awesome stuff that WordPress themes do.
 *
 * @package    EJOweb
 * @author     Erik Joling <erik@ejoweb.nl>
 * @copyright  Copyright (c) 2015, Erik Joling
 * @link       http://www.ejoweb.nl/
 */

/* Register custom image sizes. */
add_action( 'init', 'ejo_register_image_sizes', 5 );

/* Add custom image sizes to media dropdown */
add_filter('image_size_names_choose', 'post_image_sizes');

/* Register custom menus. */
add_action( 'init', 'ejo_register_menus', 5 );

/* Register sidebars. */
add_action( 'widgets_init', 'ejo_register_sidebars', 5 );

//* Remove styles & scripts
add_action( 'wp_print_styles', 'ejo_remove_styles_and_scripts', 99 );

//* Add custom styles & scripts
add_action( 'wp_enqueue_scripts', 'ejo_add_styles_and_scripts', 20 );

/* Add editor style */
add_action( 'admin_init', 'ejo_add_editor_styles' );

//* Filter excerpt_more
add_filter( 'excerpt_more', function() { return '...'; } );

//* Add style formats
add_filter( 'ejo_tinymce_style_formats', 'ejo_extra_style_formats' );

/* Add custom header style to `head` */
add_action( 'wp_head', 'ejo_header_image' );

/* Remove Subtitles inline css */
if ( class_exists( 'Subtitles' ) &&  method_exists( 'Subtitles', 'subtitle_styling' ) ) {
    remove_action( 'wp_head', array( Subtitles::getInstance(), 'subtitle_styling' ) );
}

//* Extensions
// include_once( THEME_LIB_DIR . 'extensions/featured-service-widget.php' );
include_once( THEME_LIB_DIR . 'extensions/recent-posts-widget.php' );
include_once( THEME_LIB_DIR . 'extensions/ejo-text-widget.php' );
// include_once( THEME_LIB_DIR . 'extensions/edited-knowledgebase-widget.php' );
include_once( THEME_LIB_DIR . 'extensions/intro-content.php' );
include_once( THEME_LIB_DIR . 'extensions/call-to-action/index.php' );
// include_once( THEME_LIB_DIR . 'extensions/columns-shortcode.php' );

/**
 * Registers custom image sizes for the theme. 
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function ejo_register_image_sizes() 
{
	add_image_size( 'banner', 960, 240, true ); 
	add_image_size( 'featured', 480, 200, true ); 
}

/**
 * Add custom image sizes to media dropdown 
 */
function post_image_sizes($sizes)
{
    $custom_sizes = array(
        'banner' => 'Banner'
    );
    return array_merge( $sizes, $custom_sizes );
}


/**
 * Registers nav menu locations.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function ejo_register_menus() 
{
	register_nav_menu( 'primary', 'Primary' );
}

/**
 * Registers sidebars.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function ejo_register_sidebars() 
{
	hybrid_register_sidebar(
		array(
			'id'          => 'home-main-title',
			'name'        => 'Home - Main Title',
			'description' => 'Drag widgets to here',
			'before_widget' => '',
			'after_widget'  => '',
		)
	);

	hybrid_register_sidebar(
		array(
			'id'          => 'home-main',
			'name'        => 'Home - Main',
			'description' => 'Drag widgets to here',
			'before_widget' => '<div class="column">',
			'after_widget'  => '</div>',
			'before_title' => '<h4>',
			'after_title'  => '</h4>',
		)
	);

	hybrid_register_sidebar(
		array(
			'id'          => 'call-to-action-bar',
			'name'        => 'Call To Action Balk',
			'description' => 'Drag widgets to here',
			'before_widget' => '',
			'after_widget'  => '',
		)
	);

	hybrid_register_sidebar(
		array(
			'id'          => 'footer-widgets',
			'name'        => 'Footer Widgets',
			'description' => 'Drag widgets to here',
		)
	);

	hybrid_register_sidebar(
		array(
			'id'          => 'footer-line',
			'name'        => 'Footer Line',
			'description' => 'Drag widgets to here',
		)
	);
}


/**
 * Remove scripts & stylesheets for the front end.
 */
function ejo_remove_styles_and_scripts() 
{
	/* Gets ".min" suffix. */
	$suffix = hybrid_get_min_suffix();
}

/**
 * Load scripts & styles for the front end.
 */
function ejo_add_styles_and_scripts() 
{
	$suffix = hybrid_get_min_suffix();

	//* Scripts
	wp_enqueue_script( 'ejo', THEME_JS_URI . "theme{$suffix}.js", array( 'jquery' ), THEME_VERSION, true );

	//* Styles
	/* Load Font */
	wp_enqueue_style( 'font', 'https://fonts.googleapis.com/css?family=Roboto:400,400italic,700,700italic|Roboto+Slab:400,700' );

	/* Load active theme stylesheet. */
	wp_enqueue_style( 'theme', THEME_CSS_URI . "theme{$suffix}.css", false, THEME_VERSION );
}

/**
 * Add editor style
 */
function ejo_add_editor_styles()
{
	$suffix = hybrid_get_min_suffix();

	/* External font */
	$font_url = str_replace( ',', '%2C', 'https://fonts.googleapis.com/css?family=Roboto:400,400italic,700,700italic|Roboto+Slab:400,700' );
	add_editor_style( $font_url );

	/* Editor Style */
	add_editor_style( THEME_CSS_URI . "editor-style{$suffix}.css?" . THEME_VERSION );
}


/** 
 * Add theme style formats
 */
function ejo_extra_style_formats($style_formats)
{
	/* Subtitle `span` inside heading-tags */
	$style_formats[] =  array(
        'title' => 'Subtitle',
        'inline' => 'span',
        'classes' => 'subtitle'
    );

	/* Add button-class to anchors */
    $style_formats[] =  array(
        'title' => 'Button',
        'selector' => 'a',
        'classes' => 'button'
    );

    return $style_formats;
}

/* Add header image to .content-header */
function ejo_header_image()
{
	?>
	<style type="text/css">
		.content-header::before {
			background-image: url(<?php header_image(); ?>);
		}
		
		<?php 
		// header_image();
		// echo get_custom_header()->height;
		// echo get_custom_header()->width;
		?>
	</style>
	<?php
}
