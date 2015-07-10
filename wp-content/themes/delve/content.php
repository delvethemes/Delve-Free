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
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
    <header class="delve-entry-header">
    	<?php if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) : 
			$link = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );?>
			<div class="delve-entry-thumbnail">
               	<a href="<?php echo $link[0]; ?>" data-gal="prettyPhoto['blog']"><?php the_post_thumbnail(); ?></a>
			</div>
		<?php endif; ?>
	</header><!-- .entry-header -->	
     
	<?php if ( is_single() ) { 
		the_title( '<div class="delve_heading"><h2 class="delve-entry-title">', '</h2></div>' );  
	} else {
		the_title( '<div class="delve_heading"><h2 class="delve-entry-title">
			<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>
			</div>' );  
	}?>	
    
	<?php edit_post_link( __( 'Edit', 'delve' ), '<span class="edit-link"><i class="fa fa-edit"></i>', '</span>' ); ?>
	<div class="post_meta">
		<span class="post-icon"><i class="fa fa-user"></i></i></span>
		<?php echo __('By', 'delve'); ?>
		<?php the_author_posts_link(); ?>
                   
		<span class="post-icon"><i class="fa fa-calendar"></i></span>
		<?php the_date('F j, Y');
		echo " - ";
		the_time(); ?>
                    
		<span class="post-icon"><i class="fa fa-file-text"></i></span>
		<?php the_category(', '); ?>
                    
		<?php if(get_tags()) { ?>
		<?php the_tags('<i class="fa fa-tags"></i> ',', '); } ?>
                    
		<span class="post-icon"><i class="fa fa-comments"></i></span>
		<?php comments_popup_link(__('No Comments', 'delve'), __('1 Comment', 'delve'), '% '.__('Comments', 'delve')); ?>         	
	</div> 
                   
    <?php if ( is_search() ) : ?>
		<div class="entry-summary"><?php the_excerpt(); ?></div><!-- .entry-summary -->
	<?php else : ?>
		<div class="entry-content">
			<?php
			the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'delve' ) );
			bootstrap_link_pages();

            /*wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'delve' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );*/
			?>
		</div><!-- .entry-content -->
	<?php endif; ?>
    
    <footer class="entry-meta">
                
		<?php if ( comments_open() && ! is_single() ) : ?>
			<div class="comments-link">
				<?php comments_popup_link( ' ' . __( 'Leave a comment', 'delve' ) . ' '
						, __( 'One comment so far', 'delve' ), __( 'View all % comments', 'delve' ) ); ?>
			</div><!-- .comments-link -->
		<?php endif; ?>
        
		<?php if ( is_single() && get_the_author_meta( 'description' ) && is_multi_author() ) : ?>
			<?php 
			$author_id    = get_the_author_meta('ID');
			$name         = get_the_author_meta('display_name', $author_id);
			$avatar       = get_avatar( get_the_author_meta('email', $author_id), '82' );
			$description  = get_the_author_meta('description', $author_id);
							
			if(empty($description)) {
				$description  = __("This author has not yet filled in any details.", 'delve' );
				$description .= '</br>'.sprintf( __( 'So far %s has created %s entries.', 'delve' ),
					 $name, count_user_posts( $author_id ) );
			} ?>
                   
			<div class="author_info">
				<div class="avatar">
					<?php echo $avatar ?>
				</div>
							
				<div class="author_description">
					<h3 class='author_title'>
						<span class="author_name"><?php the_author_posts_link(); ?></span>
									
						<?php if(current_user_can('edit_users') || get_current_user_id() == $author_id): ?>
							<span class="edit_profile">
								<a href="<?php echo admin_url( 'profile.php?user_id=' . $author_id ); ?>">
									<?php echo __( 'Edit profile', 'delve' ) ?></a>
							</span>
						<?php endif; ?>
					</h3>
					<?php echo $description; ?>
				</div>
                
			</div>
		<?php endif; ?>
       
	</footer><!-- .entry-meta -->
</article>