<?php

add_action( 'widgets_init', 'register_featured_service_widget' );

//* Register Widget
function register_featured_service_widget() 
{ 
    //* Include Widget Class
    register_widget( 'Featured_Service_Widget' ); 
}

final class Featured_Service_Widget extends WP_Widget
{
	//* Constructor. Set the default widget options and create widget.
	function __construct() 
	{
		$widget_title = 'Featured Service';

		$widget_info = array(
			'classname'   => 'featured-service-widget',
			'description' => 'Korte informatie met een button',
		);

		parent::__construct( 'featured-service-widget', $widget_title, $widget_info );
	}

	public function widget( $args, $instance ) 
	{
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$text = isset( $instance['text'] ) ? $instance['text'] : '';
		$link_text = isset( $instance['link-text'] ) ? $instance['link-text'] : '';
		$linked_page = isset( $instance['linked-page'] ) ? $instance['linked-page'] : '';
		$color1 = isset( $instance['color1'] ) ? $instance['color1'] : '';
		$color2 = isset( $instance['color2'] ) ? $instance['color2'] : '';

		// $title = 'Diensten';
		// $text = "De dienstensectie is nog in opbouw. Later meer.";
		// $link_text = 'Lees verder';
		// $linked_page = '31';
		// $color1 = '#000';
		// $color2 = '#555';

		?>
		<style>
			#<?php echo $args['widget_id']; ?> {
				background-color: <?php echo $color1; ?>
			}
		</style>

		<?php echo $args['before_widget']; ?>

		<div class="table-cell">
			<header class="entry-header">
				<h2 class="entry-title"><?php echo $title; ?></h2>
			</header>
			<div class="entry-content">
				<?php echo wpautop($text); ?>
			</div>
		</div>
		<div class="table-cell">
			<footer class="entry-footer">
				<a href="<?php echo get_permalink($linked_page); ?>" class="button"><?php echo $link_text; ?></a>
			</footer>
		</div>
		
		<?php
		echo $args['after_widget'];
	}

 	public function form( $instance ) 
 	{
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$text = isset( $instance['text'] ) ? $instance['text'] : '';
		$link_text = isset( $instance['link-text'] ) ? $instance['link-text'] : '';
		$linked_page = isset( $instance['linked-page'] ) ? $instance['linked-page'] : '';
		$color1 = isset( $instance['color1'] ) ? $instance['color1'] : '';
		$color2 = isset( $instance['color2'] ) ? $instance['color2'] : '';

		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Tekst:') ?></label>
			<textarea class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('link-text'); ?>">Link tekst:</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('link-text'); ?>" name="<?php echo $this->get_field_name('link-text'); ?>" value="<?php echo $link_text; ?>" />
		</p>
		<?php

		//* Get all pages
		$all_pages = get_pages();

		?>
		<p>
			<label for="<?php echo $this->get_field_id('linked-page'); ?>">Linken naar pagina:</label>
			<select name="<?php echo $this->get_field_name('linked-page'); ?>" id="<?php echo $this->get_field_id('linked-page'); ?>" class="widefat">
				<?php
				//* Show all pages as an option
				foreach ($all_pages as $page) {
					printf( 
						'<option value="%s" %s>%s</option>',
						$page->ID,
						selected($linked_page, $page->ID, false),
						$page->post_title
					);
				} 
				?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('color1'); ?>">Kleur 1:</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('color1'); ?>" name="<?php echo $this->get_field_name('color1'); ?>" value="<?php echo $color1; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('color2'); ?>">Kleur 2:</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('color2'); ?>" name="<?php echo $this->get_field_name('color2'); ?>" value="<?php echo $color2; ?>" />
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) 
	{
		//* Store old instance as defaults
		$instance = $old_instance;

		var_dump($new_instance);

		//* Store new title
		$instance['title'] = strip_tags( $new_instance['title'] );

		//* Moet nog SANITIZEN!
		$instance['text'] = isset( $new_instance['text'] ) ? $new_instance['text'] : '';
		$instance['link-text'] = isset( $new_instance['link-text'] ) ? $new_instance['link-text'] : '';
		$instance['linked-page'] = isset( $new_instance['linked-page'] ) ? $new_instance['linked-page'] : '';
		$instance['color1'] = isset( $new_instance['color1'] ) ? $new_instance['color1'] : '';
		$instance['color2'] = isset( $new_instance['color2'] ) ? $new_instance['color2'] : '';

		return $instance;
	}
}