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

		parent::__construct( 'recent-posts-widget', $widget_title, $widget_info );
	}

	/**
	 * Outputs the content for the current widget instance.
	 */
	public function widget( $args, $instance ) 
	{
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$text = isset( $instance['text'] ) ? $instance['text'] : '';
		$text = apply_filters( 'widget_text', $text, $instance, $this );
		$number_of_posts = isset( $instance['number-of-posts'] ) ? $instance['number-of-posts'] : 3;

		$url = ( get_option( 'show_on_front' ) == 'page' ) ? get_permalink( get_option('page_for_posts' ) ) : bloginfo('url');
		?>

		<?php echo $args['before_widget']; ?>

		<?php echo $args['before_title']; ?><a href="<?php echo $url; ?>"><?php echo $title; ?></a><?php echo $args['after_title']; ?>

		<?php if (!empty($text)) : // Check if there is text ?>

			<div class="textwidget">
				<?php echo wpautop($text); ?>
			</div>

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

						<div class="entry-byline">
							<?php echo $post_date; ?> &bullet; <?php hybrid_post_terms( array( 'taxonomy' => 'category' ) ); ?>
						</div>

						<header class="entry-header">
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
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$text = isset( $instance['text'] ) ? $instance['text'] : '';
		$number_of_posts = isset( $instance['number-of-posts'] ) ? $instance['number-of-posts'] : '';

		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text:') ?></label>
			<textarea class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>
			<?php //wp_editor( $text, $this->get_field_id('text'), array(	'textarea_name' => $this->get_field_name('text') ) ); ?>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('number-of-posts'); ?>"><?php _e('Aantal berichten:') ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id('number-of-posts'); ?>" name="<?php echo $this->get_field_name('number-of-posts'); ?>">
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

		/* Store text */
		$instance['text'] = stripslashes( wp_filter_post_kses( addslashes( $new_instance['text'] ) ) ); // wp_filter_post_kses() expects slashed

		/* Store number of posts */
		$instance['number-of-posts'] = strip_tags( $new_instance['number-of-posts'] );

		/* Return updated instance */
		return $instance;
	}
}