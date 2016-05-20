<?php
defined('ABSPATH') or die("Direct access to the script does not allowed");

/* Register Widget */
add_action( 'widgets_init', function() {
    register_widget( 'EJO_Call_To_Action_Widget' ); 
});

/**
 * Class used to implement a Text Widget widget.
 */
final class EJO_Call_To_Action_Widget extends WP_Widget
{
	/**
	 * Sets up a new widget instance.
	 */
	function __construct() 
	{
		$widget_title = __('Call To Action Widget', 'ejoweb');

		$widget_info = array(
			'classname'   => 'call-to-action-widget',
			'description' => __('Call to action...', 'ejoweb'),
		);

		$widget_control = array( 'width' => 600 );

		parent::__construct( 'ejo-call-to-action-widget', $widget_title, $widget_info, $widget_control );
	}

	/**
	 * Outputs the content for the current widget instance.
	 */
	public function widget( $args, $instance ) 
	{
        /**
         * 1. Skip output if post has disabled the call to action
         * 2. Show post_metadata with $instance data as fallback
         */

		/* Get Call To Action post_metadata */
        $ejo_call_to_action = get_post_meta( get_the_ID(), '_ejo-call-to-action', true ); 

        /** 
		 * Combine $post_meta data with defaults
		 * Then extract variables of this array
		 */
        extract( wp_parse_args( $ejo_call_to_action, array( 
            'enabled' => 1,
            'title' => '',
            'text' => '',
            'post_id' => '',
            'link_text' => '',
		)));

        /** 
		 * Combine $instance data with defaults
		 * Then extract variables of this array with 'fallback' prefix
		 */
        extract(
        	wp_parse_args( $instance, array( 
	            'title' => '',
	            'text' => '',
	            'post_id' => '',
	            'link_text' => '',
			)),
			EXTR_PREFIX_ALL,
			'fallback'
		);

        /* 1. Skip output if post has disabled the call to action */
        if (!$enabled)
        	return;

        echo $args['before_widget'];


        /**
         * 2. Show post_metadata with $instance data as fallback 
         */

        /* Process data */
        $title = (!empty($title)) ? $title : $fallback_title;
        $text = (!empty($text)) ? $text : $fallback_text;
        $post_id = (!empty($post_id)) ? $post_id : $fallback_post_id;
        $link_text = (!empty($link_text)) ? $link_text : $fallback_link_text;

        /* Output data */
        ?>

		<h2 <?php hybrid_attr( 'entry-title' ); ?>><?php echo $title; ?></h2>

		<a href="<?php echo get_permalink($post_id); ?>" class="button highlight"><?php echo $link_text; ?></a>

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
            'text' => '',
            'post_id' => '',
            'link_text' => '',
        )));

		?>
		<p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:') ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text:') ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" value="<?php echo $text; ?>" />
        </p>

        <?php $all_pages = get_pages(); // Get all pages ?>

        <p>
            <label for="<?php echo $this->get_field_id('post_id'); ?>">Link naar pagina:</label>
            <select id="<?php echo $this->get_field_id('post_id'); ?>" class="widefat" name="<?php echo $this->get_field_name('post_id'); ?>">
                <?php
                //* Show all pages as an option
                foreach ($all_pages as $page) {
                    printf( 
                        '<option value="%s" %s>%s</option>',
                        $page->ID,
                        selected($post_id, $page->ID, false),
                        $page->post_title
                    );
                } 
                ?>
            </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('link_text'); ?>"><?php _e('Link text:') ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('link_text'); ?>" name="<?php echo $this->get_field_name('link_text'); ?>" value="<?php echo $link_text; ?>" placeholder="Default" />
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

		/* Store text */
		if ( current_user_can('unfiltered_html') )
			$instance['text'] =  $new_instance['text'];
		else
			$instance['text'] = wp_kses_post( stripslashes( $new_instance['text'] ) );

		/* Store post_id */
		$instance['post_id'] = $new_instance['post_id'];

		/* Store new link_text */
		$instance['link_text'] = strip_tags( $new_instance['link_text'] );

		/* Return updated instance */
		return $instance;
	}
}
