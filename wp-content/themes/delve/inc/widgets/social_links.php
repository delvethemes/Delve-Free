<?php
/**
 * The custom widget for displaying Social Links
 *
 * @package WordPress
 * @subpackage Delve_Theme
 * @since Delve Theme 1.0
 */
add_action('widgets_init', 'social_links_load_widgets');
function social_links_load_widgets()
{
	register_widget('Social_Links_Widget');
}
class Social_Links_Widget extends WP_Widget {
	
	function Social_Links_Widget()
	{
		$widget_ops = array('classname' => 'social_links', 'description' => '');
		$control_ops = array('id_base' => 'social_links-widget');
		$this->WP_Widget('social_links-widget', 'Delve: Social Links', $widget_ops, $control_ops);
	}
	
	function widget($args, $instance)
	{
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		echo $before_widget;
		if($title) {
			echo $before_title.$title.$after_title;
		}
		?>
		
		<div class="social-icon-container">
			<ul class="delve-social delve-widget-social">
				<?php
				global $delve_social;
				$delve_social_ico = array(	'social-facebook' 		=> 'fa-facebook',
					'social-twitter'		=> 'fa-twitter',
					'social-pinterest'		=> 'fa-pinterest-square',
					'social-google-plus'	=> 'fa-google-plus',
					'social-tumblr'			=> 'fa-tumblr',
					'social-stumbleupon'	=> 'fa-stumbleupon',
					'social-instagram'		=> 'fa-instagram',
					'social-dribbble'		=> 'fa-dribbble',
					'social-youtube'		=> 'fa-youtube',
					'social-be'				=> 'fa-behance' );
					
				foreach ( $delve_social as $key => $value ){ 
					if( $instance[$key] ) { ?>
			
						<li class="<?php echo $value; ?>">
							<a class="socialeffectssize tooltipa" target="_blank" title="<?php echo $value; ?>" 
                            data-toggle="tooltip" data-placement="bottom" href="<?php echo $instance[$key]; ?>">
								<span><i class="fa <?php echo $delve_social_ico[$key] ?>"></i></span>
							</a>
						</li>
					<?php }
				} ?>
			</ul>
		</div>
		<?php
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		
		 global $delve_social;
		 foreach ( $delve_social as $key => $value ){ 
		 	$instance[$key] = $new_instance[$key];
		 } 
		
		return $instance;
	}
	function form($instance)
	{
		$defaults = array('title' => 'Get Social');
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
       <?php  
       
	    global $delve_social;
		foreach ( $delve_social as $key => $value ){ ?>
			<p>
				<label for="<?php echo $key ?>"><?php echo $value; ?></label>
				<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id($key); ?>" name="<?php echo $this->get_field_name($key); ?>" value="<?php if( isset($instance[$key])) echo $instance[$key]; ?>" />
			</p>
                
		<?php } ?>
            
        <style type="text/css">
        .widefat{display:block;}
        </style>
	<?php
	}
}