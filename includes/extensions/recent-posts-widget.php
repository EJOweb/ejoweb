<?php

add_action( 'widgets_init', 'register_recent_posts_widget' );

//* Register Widget
function register_recent_posts_widget() 
{ 
    //* Include Widget Class
    register_widget( 'EJO_Recent_Posts_Widget' ); 
}


/**
 * Class used to implement a Recent Posts widget.
 */
final class EJO_Recent_Posts_Widget extends WP_Widget
{
	/**
	 * Sets up a new widget instance.
	 */
	function __construct() 
	{
		$widget_title = __('Recent Posts Widget', 'ejoweb');

		$widget_info = array(
			'classname'   => 'recent-posts-widget',
			'description' => __('Displays latest blog posts', 'ejoweb'),
		);

		$widget_control = array( 'width' => 600 );

		parent::__construct( 'recent-posts-widget', $widget_title, $widget_info, $widget_control );
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
            'number_of_posts' => 3,
        )));

        /* Run $text through filter */
		$text = apply_filters( 'widget_text', $text, $instance, $this );

		/* Get Url of blog section */
		$url = ( get_option( 'show_on_front' ) == 'page' ) ? get_permalink( get_option('page_for_posts' ) ) : bloginfo('url');
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

		<?php if (!empty($text)) : // Check if there is text ?>

			<div class="textwidget"><?php echo wpautop($text); ?></div>

		<?php endif; // END text check ?>

		<?php

		/* Get articles of current knowledgebase category */
	    $recent_posts_query = new WP_Query( array(
	    	'post_type' => 'post',
	    	'posts_per_page' => $number_of_posts,
	    	'orderby' => 'post_date',
			'order' => 'DESC',	
	    ) );

		?>

		<?php if ( $recent_posts_query->have_posts() ) : // Checks if any posts were found. ?>

	    	<div class="recent-posts">

				<?php while ( $recent_posts_query->have_posts() ) : // Begins the loop through found posts. ?>

					<?php $recent_posts_query->the_post(); // Loads the post data. ?>
    
		    		<?php $post_date = sprintf( "<time %s>%s</time>", hybrid_get_attr( 'entry-published' ), get_the_date( 'j F Y' ) ); ?>

					<article <?php hybrid_attr( 'post' ); ?>>

						<header class="entry-header">
							<div class="entry-byline">
								<?php echo $post_date; ?> &bullet; <?php hybrid_post_terms( array( 'taxonomy' => 'category' ) ); ?>
							</div>
							<h4 <?php hybrid_attr( 'entry-title' ); ?>><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark" itemprop="url"><?php the_title(); ?></a></h4>
						</header>

					</article>

				<?php endwhile; // End found posts loop. ?>

			</div>

			<?php wp_reset_postdata(); ?>

		<?php endif; // End check for posts. ?>
	
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
            'number_of_posts' => 3,
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
			<label for="<?php echo $this->get_field_id('number_of_posts'); ?>"><?php _e('Aantal berichten:') ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id('number_of_posts'); ?>" name="<?php echo $this->get_field_name('number_of_posts'); ?>">
				<option value="1" <?php selected($number_of_posts, 1); ?>>1</option>
				<option value="2" <?php selected($number_of_posts, 2); ?>>2</option>
				<option value="3" <?php selected($number_of_posts, 3); ?>>3</option>
				<option value="4" <?php selected($number_of_posts, 4); ?>>4</option>
				<option value="5" <?php selected($number_of_posts, 5); ?>>5</option>
			</select>
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

		/* Store number of posts */
		$instance['number_of_posts'] = strip_tags( $new_instance['number_of_posts'] );

		/* Return updated instance */
		return $instance;
	}
}