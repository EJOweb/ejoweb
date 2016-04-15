<?php
/**
 * Extension for supporting Intro Content
 * Tag: ejoic
 */

/* Add Metabox */
add_action( 'add_meta_boxes', 'ejoic_add_metabox', 9 ); // Before Wordpress SEO metabox

/* Save Metabox */
add_action( 'save_post', 'ejoic_save_metabox', 1, 1 ); 


/* Add Intro Metabox */
function ejoic_add_metabox() 
{
	/* Get post types from theme-support arguments. If none, then use posts and pages. */
	$post_types = get_post_types( array( 'public' => true ) );

    /* Add metabox for every give post_type */
    foreach ($post_types as $post_type) {
        add_meta_box( 'ejoic_metabox', 'Intro Content', 'ejoic_render_metabox', $post_type, 'normal', 'high' );
    }
}

/* The post scripts metabox */
function ejoic_render_metabox( $post ) 
{
	/* Noncename needed to verify where the data originated */
	wp_nonce_field( 'ejo-intro-content-metabox-' . $post->ID, 'ejo-intro-content-meta-nonce' );

	/* Get Content */
	$ejo_intro_content = stripslashes(get_post_meta( $post->ID, '_ejo-intro-content', true )); 

	$suffix = hybrid_get_min_suffix();

	$settings = array(
		'textarea_name' => 'ejo-intro-content',
		'textarea_rows' => '8',
		'tinymce' => array(
			'content_css' => THEME_CSS_URI . "editor-style{$suffix}.css"
		)
	);

	wp_editor( $ejo_intro_content, 'introcontent', $settings );
}

/* Manage saving Metabox Data */
function ejoic_save_metabox($post_id) 
{
	/* Don't try to save the data under autosave, ajax, or future post. */
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return;
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX )
		return;
	if ( defined( 'DOING_CRON' ) && DOING_CRON )
		return;

	/* Don't save if WP is creating a revision (same as DOING_AUTOSAVE?) */
	if ( wp_is_post_revision( $post_id ) )
		return;

	/* Check that the user is allowed to edit the post */
	if ( ! current_user_can( 'edit_post', $post_id ) )
		return;

	/* Verify where the data originated */
	if ( !isset($_POST['ejo-intro-content-meta-nonce']) || !wp_verify_nonce( $_POST['ejo-intro-content-meta-nonce'], 'ejo-intro-content-metabox-' . $post_id ) )
		return;

	/* Save */
	if ( isset( $_POST['ejo-intro-content'] ) )
		update_post_meta( $post_id, '_ejo-intro-content', $_POST['ejo-intro-content'] );
}

function ejo_get_intro_content( $post_id = NULL )
{
	if (empty($post_id))
		$post_id = get_the_ID();

	$content = get_post_meta( $post_id, '_ejo-intro-content', true );

	if (empty($content))
		return '';

	$content = apply_filters( 'the_content', $content );
	$content = str_replace(']]>', ']]&gt;', $content);

	return $content;
}



// /* Do Metabox After Title */
// add_action( 'edit_form_after_title', 'ejo_do_metaboxes_after_title' );

// /* Do Metabox After Title */
// function ejo_do_metaboxes_after_title()
// {
//     global $post, $wp_meta_boxes;

//     do_meta_boxes(get_current_screen(), 'after_title', $post);

//     unset($wp_meta_boxes[get_post_type($post)]['after_title']);
// }