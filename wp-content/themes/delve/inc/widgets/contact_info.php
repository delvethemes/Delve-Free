<?php
/**
 * The custom widget for displaying contact info style content
 *
 * @package WordPress
 * @subpackage Delve_Theme
 * @since Delve Theme 1.0
 */

add_action('widgets_init', 'contact_info_load_widgets');
function contact_info_load_widgets()
{
	register_widget('Contact_Info_Widget');
}
class Contact_Info_Widget extends WP_Widget {
	
	function Contact_Info_Widget()
	{
		$widget_ops = array('classname' => 'contact_info', 'description' => '');
		$control_ops = array('id_base' => 'contact_info-widget');
		$this->WP_Widget('contact_info-widget', 'Delve: Contact Info', $widget_ops, $control_ops);
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
		<?php if($instance['address']): ?>
		<div class="contact_info_item address"><?php _e('<i class="fa fa-home"></i> ', 'Delve'); ?> <?php echo $instance['address']; ?></div>
		<?php endif; ?>
		<?php if($instance['phone']): ?>
		<div class="contact_info_item phone"><?php _e('<i class="fa fa-phone"></i> ', 'Delve'); ?> <?php echo $instance['phone']; ?></div>
		<?php endif; ?>
		<?php if($instance['fax']): ?>
		<div class="contact_info_item fax"><?php _e('<i class="fa fa-fax"></i> ', 'Delve'); ?> <?php echo $instance['fax']; ?></div>
		<?php endif; ?>
		<?php if($instance['email']): ?>
		<div class="contact_info_item email"><?php _e('<i class="fa fa-envelope-o"></i> ', 'Delve'); ?> <a href="mailto:<?php echo $instance['email']; ?>"><?php if($instance['emailtxt']) { echo $instance['emailtxt']; } else { echo $instance['email']; } ?></a></div>
		<?php endif; ?>
		<?php if($instance['web']): ?>
		<div class="contact_info_item web"><?php _e('<i class="fa fa-globe"></i> ', 'Delve'); ?> <a href="<?php echo $instance['web']; ?>"><?php if($instance['webtxt']) { echo $instance['webtxt']; } else { echo $instance['web']; } ?></a></div>
		<?php endif; ?>
		<?php
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['address'] = $new_instance['address'];
		$instance['phone'] = $new_instance['phone'];
		$instance['fax'] = $new_instance['fax'];
		$instance['email'] = $new_instance['email'];
		$instance['emailtxt'] = $new_instance['emailtxt'];
		$instance['web'] = $new_instance['web'];
		$instance['webtxt'] = $new_instance['webtxt'];
		return $instance;
	}
	function form($instance)
	{
		$defaults = array('title' => 'Contact Info');
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('address'); ?>">Address:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('address'); ?>" name="<?php echo $this->get_field_name('address'); ?>" value="<?php if( isset($instance['address']) ) echo $instance['address']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('phone'); ?>">Phone:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('phone'); ?>" name="<?php echo $this->get_field_name('phone'); ?>" value="<?php if( isset($instance['phone']) ) echo $instance['phone']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('fax'); ?>">Fax:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('fax'); ?>" name="<?php echo $this->get_field_name('fax'); ?>" value="<?php if( isset($instance['fax']) ) echo $instance['fax']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('email'); ?>">Email:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" value="<?php if( isset($instance['email']) ) echo $instance['email']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('emailtxt'); ?>">Email Link Text:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('emailtxt'); ?>" name="<?php echo $this->get_field_name('emailtxt'); ?>" value="<?php if( isset($instance['emailtxt']) ) echo $instance['emailtxt']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('web'); ?>">Website URL (with HTTP):</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('web'); ?>" name="<?php echo $this->get_field_name('web'); ?>" value="<?php if( isset($instance['web']) ) echo $instance['web']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('webtxt'); ?>">Website URL Text:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('webtxt'); ?>" name="<?php echo $this->get_field_name('webtxt'); ?>" value="<?php if( isset($instance['webtxt']) ) echo $instance['webtxt']; ?>" />
		</p>
	<?php
	}
}
?>