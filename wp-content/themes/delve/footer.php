<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #wrapper div elements.
 *
 * @package WordPress
 * @subpackage Delve_Theme
 * @since Delve Theme 1.0
 */
?>
</div> <!-- Wrapper -->
<footer class="delve-footer">
	<?php 
	global $data;
	if( $data['switch-fwidgets'] == 1 ) {
		$col = $data['opt-fcolumn'];
		$footercol = 12/$col; ?>
	
    	<div class="footer-widget">
			<div class="row footer-widget-container">
				<?php for($sidebar=1;$sidebar<=$col;$sidebar++){ ?>
					<div class="col-md-<?php echo $footercol; ?> widget-item">
						<?php
							if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('delve-footer-widget-'.$sidebar)): 
							endif;
						?>
					</div>
				<?php } ?>
        	</div><!-- container -->
    	</div><!-- footer widget -->
    <?php } ?>
	
    <div class="footer">
		<div class="row footer-container">
        	
            <div class="col-md-6 copyright-bar">
            	<p><?php if( $data['switch-fcb']==1 && $data['fcb-txt'] ) { 
						echo $data['fcb-txt'];
				} ?> </p>
			</div>
            <div class="col-md-6 footer-right-side">
				<?php if( $data['footer-right-side'] == 'social_icons' ) {
					delve_social_icon( false );
				} else if ( $data['footer-right-side'] == 'footer_menu' ) {
					delve_footer_nav();
				} ?>
			</div>
		</div>
	</div> <!-- /.footer -->
    <?php
		if($data['hide-back-to-top-button'] == 0)			
			echo '<a id="back-to-top" href="#" class="to-top"><i class="fa fa-angle-up fa-2x"></i></a>';
		?>
</footer>
<?php wp_footer(); ?>
<script><?php echo $data['custom-footer-js'];	?></script>
</body>
</html>