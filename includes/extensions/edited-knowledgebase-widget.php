<?php

add_action( 'widgets_init', 'register_ejo_edited_knowledgebase_widget', 99 );

//* Register Widget
function register_ejo_edited_knowledgebase_widget() 
{ 
    //* Unregister primary knowledgebase widget
	unregister_widget( 'EJO_Knowledgebase_Widget' );

    //* Include Widget Class
    register_widget( 'EJO_Knowledgebase_Widget_Edited' ); 
}

/**
 * Class used to implement a Knowledgebase widget.
 */
final class EJO_Knowledgebase_Widget_Edited extends WP_Widget
{
	/**
	 * Sets up a new widget instance.
	 */
	function __construct() 
	{
		$widget_title = __('Knowledgebase Widget', 'ejo-core');

		$widget_info = array(
			'classname'   => 'knowledgebase-widget',
			'description' => __('Text followed by knowledgebase categories', 'ejo-core'),
		);

		parent::__construct( 'knowledgebase-widget-edit', $widget_title, $widget_info );
	}

	/**
	 * Outputs the content for the current widget instance.
	 */
	public function widget( $args, $instance ) 
	{
		/** 
		 * Combine $instance data with defaults
		 * Then extract variables of this array
		 */
        extract( wp_parse_args( $instance, array( 
            'title' => '',
            'image_id' => '',
            'icon' => '',
            'text' => '',
            'link_text' => '',
        )));

		/* Run $text through filter */
		$text = apply_filters( 'widget_text', $text, $instance, $this );

		/* Get archive of knowledgebase */
		$url = get_post_type_archive_link( EJO_Knowledgebase::$post_type );
		?>

		<?php echo $args['before_widget']; ?>

		<?php if (!empty($image_id)) : // Check if there is an image_id ?>
			
			<div class="featured-image-container">
				<?php echo wp_get_attachment_image( $image_id, 'featured', false, array('class'=>'featured-image') ); ?>
			</div>

			<?php if (!empty($icon)) : // Check if there is an icon ?>

				<div class="icon-container">
					<i class="fa fa-<?php echo $icon; ?>"></i>
				</div>

			<?php endif; // END icon check ?>

		<?php endif; // END image_id check ?>

		<?php echo $args['before_title']; ?><a href="<?php echo $url; ?>"><?php echo $title; ?></a><?php echo $args['after_title']; ?>

		<div class="textwidget">
			<?php echo wpautop($text); ?>
		</div>

		<?php

		/* Get knowledgebase categories */
		$categories = get_terms( 
			'knowledgebase_category',
			array(
			    'orderby' => 'name',
			    'order'   => 'ASC',
			)
		);

		?>
	    
	    <div class="knowledgebase-categories">

		    <?php foreach( $categories as $category ) : // Loop through each knowledgebase category ?>

		    	<?php

				/* Get Knowledgebase ategory url */
				$category_url = esc_url( get_term_link( $category ) );

				/* Fabricate knowledgebase category link */
			    $category_link = sprintf( '<a href="%s" alt="%s">%s</a>',
			        $category_url,
			        esc_attr( sprintf( 'View all posts in %s', $category->name ) ),
			        esc_html( $category->name )
			    );

				?>

		    	<h4 <?php hybrid_attr( 'category-title' ); ?>><a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" title="<?php echo esc_attr( 'Bekijk alle '. $category->name .' artikelen' ); ?>" rel="bookmark" itemprop="url"><?php echo $category->name; ?></a></h4>


			<?php endforeach; // END foreach category loop ?>

		</div>

		<?php if (!empty($link_text)) : ?>

			<a href="<?php echo $url; ?>" class="read-more"><?php echo $link_text; ?></a>

		<?php endif; // URL check ?>
	
		<?php echo $args['after_widget']; ?>

		<?php
	}

	/**
	 * Outputs the widget settings form.
	 */
 	public function form( $instance ) 
 	{
		/** 
		 * Combine $instance data with defaults
		 * Then extract variables of this array
		 */
        extract( wp_parse_args( $instance, array( 
            'title' => '',
            'image_id' => '',
            'icon' => '',
            'text' => '',
            'link_text' => '',
        )));

		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
		</p>

		<div class="ejo-image-upload">
            <label>Uitgelichte afbeelding</label>
            <p class="image-container">
                <?php if ( $image_id ) : ?>

                    <?php echo wp_get_attachment_image( $image_id, 'thumbnail', false ); ?>

                <?php endif; ?>
            </p>

            <input type="hidden" id="<?php echo $this->get_field_id('image_id'); ?>" name="<?php echo $this->get_field_name('image_id'); ?>" value="<?php echo $image_id; ?>" class="image-id" />
            <a class="button upload-button" href="#">Kies een afbeelding</a>
            <a class="button remove-button" href="#">Verwijder</a>
        </div>

        <p>
			<label for="<?php echo $this->get_field_id('icon'); ?>"><?php _e('Icon:') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('icon'); ?>" name="<?php echo $this->get_field_name('icon'); ?>" value="<?php echo $icon; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text:') ?></label>
			<textarea class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>
			<?php //wp_editor( $text, $this->get_field_id('text'), array(	'textarea_name' => $this->get_field_name('text') ) ); ?>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('link_text'); ?>"><?php _e('Link text:') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('link_text'); ?>" name="<?php echo $this->get_field_name('link_text'); ?>" value="<?php echo $link_text; ?>" />
		</p>
		<?php
	}

	/**
	 * Handles updating settings for the current widget instance.
	 */
	public function update( $new_instance, $old_instance ) 
	{
		/* Store old instance as defaults */
		$instance = $old_instance;

		/* Store new title */
		$instance['title'] = strip_tags( $new_instance['title'] );

		/* Store image id */
		$instance['image_id'] = $new_instance['image_id'];

		/* Store icon */
		$instance['icon'] = $new_instance['icon'];

		/* Store text */
		if ( current_user_can('unfiltered_html') )
			$instance['text'] =  $new_instance['text'];
		else
			$instance['text'] = wp_kses_post( stripslashes( $new_instance['text'] ) );

		/* Store url and link-text */
		$instance['link-text'] = strip_tags( $new_instance['link-text'] );

		/* Return updated instance */
		return $instance;
	}
}