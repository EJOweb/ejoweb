<?php

add_action( 'widgets_init', 'register_ejo_text_widget' );

//* Register Widget
function register_ejo_text_widget() 
{ 
    //* Include Widget Class
    register_widget( 'EJO_Text_Widget' ); 
}


/**
 * Class used to implement a Text Widget widget.
 */
final class EJO_Text_Widget extends WP_Widget
{
	/**
	 * Sets up a new widget instance.
	 */
	function __construct() 
	{
		$widget_title = __('Text Widget', 'ejoweb');

		$widget_info = array(
			'classname'   => 'text-widget',
			'description' => __('Displays a text widget with image and icon', 'ejoweb'),
		);

		$widget_control = array( 'width' => 600 );

		parent::__construct( 'ejo-text-widget', $widget_title, $widget_info, $widget_control );
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
            'image_id' => '',
            'icon' => '',
            'title' => '',
            'text' => '',
            'url' => '',
        )));

        /* Run $text through filter */
		$text = apply_filters( 'widget_text', $text, $instance, $this );
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

		<?php 
		echo $args['before_title']; 
		echo (!empty($url)) ? '<a href="'.esc_url($url).'">' . $title . '</a>' : $title; 
		echo $args['after_title']; 
		?>

		<?php if (!empty($text)) : // Check if there is text ?>

			<div class="textwidget"><?php echo wpautop($text); ?></div>

		<?php endif; // END text check ?>

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
            'image_id' => '',
            'icon' => '',
            'title' => '',
            'text' => '',
            'url' => '',
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
			<textarea class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" rows="5"><?php echo $text; ?></textarea>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('url'); ?>"><?php _e('URL:') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" value="<?php echo $url; ?>" />
			<span class="description"><?php _e('Only if title needs to link to a page'); ?></span>
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

		/* Store url */
		$instance['url'] = $new_instance['url'];

		/* Return updated instance */
		return $instance;
	}
}