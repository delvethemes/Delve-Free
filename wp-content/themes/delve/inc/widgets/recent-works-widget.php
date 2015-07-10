<?php
/**
 * The custom widget for displaying Recent Works Slider
 *
 * @package WordPress
 * @subpackage Delve_Theme
 * @since Delve Theme 1.0
 */

add_action('widgets_init', 'recent_works_load_widgets');
function recent_works_load_widgets()
{
	register_widget('Recent_Works_Widget');
}
class Recent_Works_Widget extends WP_Widget {
	
	function Recent_Works_Widget()
	{
		$widget_ops = array('classname' => 'recent_works', 'description' => 'Recent works from the portfolio.');
		$control_ops = array('id_base' => 'recent_works-widget');
		$this->WP_Widget('recent_works-widget', 'Delve: Recent Works', $widget_ops, $control_ops);
	}
	
	function widget($args, $instance)
	{
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$number = $instance['number'];
		
		echo $before_widget;
		if($title) {
			echo $before_title . $title . $after_title;
		}
		?>
	<div id="myCarousel" class="carousel slide recent-works clearfix"> 
   <!-- Carousel items -->
   <div class="carousel-inner">
      <?php $args = array(
			'post_type' => 'portfolio',
			'posts_per_page' => $number
		);
		$portfolio = new WP_Query($args); 
		
		$active = true;
		if($portfolio->have_posts()):
			while($portfolio->have_posts()): $portfolio->the_post();
				if(has_post_thumbnail()): 
					if( $active ) { 
						$active = false; ?>
                    	<div class="item active">
                    <?php }else { ?>
                    	<div class="item">
					<?php } ?>
					
					<?php the_post_thumbnail('recent-works-thumbnail'); ?>
					</div>	        
      	<?php endif; endwhile; endif; ?>
   </div>
   <!-- Carousel nav -->
   <a class="carousel-control left" href="#myCarousel" 
      data-slide="prev">&lsaquo;</a>
   <a class="carousel-control right" href="#myCarousel" 
      data-slide="next">&rsaquo;</a>
</div> 
		<?php echo $after_widget;
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = $new_instance['number'];
		
		return $instance;
	}
	function form($instance)
	{
		$defaults = array('title' => 'Recent Works', 'number' => 6);
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>">Number of items to show:</label>
			<input class="widefat" style="width: 30px;" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" value="<?php echo $instance['number']; ?>" />
		</p>
	<?php
	}
}
?>