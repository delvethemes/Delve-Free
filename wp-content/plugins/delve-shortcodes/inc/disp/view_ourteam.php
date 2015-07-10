<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Delve_Theme
 * @since Delve Theme 1.0
 */
?>

<div class="row">
<?php
	//print_r($atts);
	if( $atts['column'] == 1 ) { $columns = 'col-md-12'; }
	else if ( $atts['column'] == 2 ) { $columns = 'col-md-6'; }
	else if ( $atts['column'] == 3 ) { $columns = 'col-md-4'; }
	else { $columns = 'col-md-3'; }
	
	$ourteam = new WP_Query(array('post_type' => 'ourteam', 'posts_per_page' => $atts['show_members']));
	
	while ($ourteam->have_posts()) : $ourteam->the_post();
		$postid = get_the_ID();
		$meta = get_post_custom($postid);
?>

<div class="<?php echo $columns; ?> ourteam_item_container">	
	<div class="ourteam_item">
		<?php the_post_thumbnail(); ?>
  
		<div class="ourteam_social">
			<?php 
			if( isset($meta['delve_meta_ot_facebook'][0] )) { ?>
				<a href="<?php echo $meta['delve_meta_ot_facebook'][0]; ?>"> 
					<span class="ot_soc fb">
       					<i class="fa fa-facebook-square"></i>
					</span>
				</a>
			<?php }
	   
			if( isset($meta['delve_meta_ot_twitter'][0] )) { ?>
				<a href="<?php echo $meta['delve_meta_ot_twitter'][0]; ?>"> 
					<span class="ot_soc tw">
       					<i class="fa fa-twitter-square"></i>
					</span>
				</a>
			<?php }
	   
			if( isset($meta['delve_meta_ot_gplus'][0] )) { ?>
				<a href="<?php echo $meta['delve_meta_ot_gplus'][0]; ?>"> 
					<span class="ot_soc gp">
       					<i class="fa fa-google-plus-square"></i>
					</span>
				</a>
			<?php }
	   
			if( isset($meta['delve_meta_ot_linkedin'][0] )) { ?>
				<a href="<?php echo $meta['delve_meta_ot_linkedin'][0]; ?>"> 
					<span class="ot_soc ln">
       					<i class="fa fa-linkedin-square"></i>
					</span>
				</a>
			<?php }?> 
		</div> <!-- .ourteam_social -->
	</div> <!-- .ourteam_item -->
   
	<div class="ourteam_info_container">
    	<div class="ourteam_info">
		<h4><?php the_title(); ?></h4>
		<span class="designation"><i><?php echo $meta['delve_meta_ourteam_designation'][0]; ?></i></span><br />
        <span class="description"><?php echo $meta['delve_meta_ourteam_description'][0]; ?></span>
        </div>
	</div>

</div> <!-- .ourteam_item_container -->
    
<?php endwhile; ?>
<div class="clear"></div>
</div>
<div class="container">
  <h2>Modal Example</h2>
  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          <p>Some text in the modal.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>