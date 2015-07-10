<?php
/**
 * The template for displaying Comments
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package WordPress
 * @subpackage Delve_Themes
 * @since Delve Themes 1.0
 */

/******* Protecting comments *******/
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Direct Access Not Allowed. Thanks!');
	
if ( post_password_required() ) { ?>
    <p class="no-comments"><?php echo __('This post is password protected. Enter the password to view comments.', 'delve'); ?></p>
	<?php return;
} ?>

<div id="comments" class="comments-area">
	<?php if ( have_comments() ) : ?>
		<div id="comments" class="comments-container">
			<div class="title delve-commnt-title">
				<h2 class="title-heading-left">
					<?php comments_number(__('No Comments', 'delve'), __('One Comment', 'delve'), '% '.__('Comments', 'delve'));?>
				</h2>
			</div>
		
			<ol class="comment-list">
				<?php wp_list_comments('callback=delve_comment_list'); ?>
			</ol><!-- .comment-list -->

			<div class="comments-navigation">
				<div><?php previous_comments_link(); ?></div>
				<div><?php next_comments_link(); ?></div>
			</div>
		</div>
        
	<?php else : 
			if ( comments_open() ) :
		else :  ?>
			<!-- If comments are closed. -->
			<p class="no-comments"><?php echo __('Comments are closed.', 'delve'); ?></p>
		<?php endif; ?>
	<?php endif; // have_comments() ?>

	<?php //comment_form(); ?>
    
    
<?php if ( comments_open() ) : 

	function modify_comment_form_fields($fields){
		$commenter = wp_get_current_commenter();
		$req       = get_option( 'require_name_email' );

		$fields['author'] = '<div id="delve-comment-inputs"><input type="text" name="author" id="author" value="'. esc_attr( $commenter['comment_author'] ) .'" placeholder="'. __("Name (required)", "delve").'" size="22" tabindex="1"'. ( $req ? 'aria-required="true"' : '' ).' class="comment-name" required />';

		$fields['email'] = '<input type="email" name="email" id="email" value="'. esc_attr( $commenter['comment_author_email'] ) .'" placeholder="'. __("Email (required)", "delve").'" size="22" tabindex="2"'. ( $req ? 'aria-required="true"' : '' ).' class="comment-email" required />';

		$fields['url'] = '<input type="text" name="url" id="url" value="'. esc_attr( $commenter['comment_author_url'] ) .'" placeholder="'. __("Website", "delve").'" size="22" tabindex="3" class="comment-website" /></div>';

		return $fields;
	}
	add_filter('comment_form_default_fields','modify_comment_form_fields');

	$comments_args = array(
		'title_reply' => '<div class="title"><h2>'. __("Leave a Comment", "delve").'</h2></div>',
		'title_reply_to' => '<div class="title"><h2>'. __("Leave a Comment", "delve").'</h2></div>',
		'must_log_in' => '<p class="must-log-in">' .  sprintf( __( "You must be %slogged in%s to post a comment.", "delve" ), '<a href="'.wp_login_url( apply_filters( 'the_permalink', get_permalink( ) ) ).'">', '</a>' ) . '</p>',
		'logged_in_as' => '<p class="logged-in-as">' . __( "Logged in as","delve" ).' <a href="' .admin_url( "profile.php" ).'">'.$user_identity.'</a>. <a href="' .wp_logout_url(get_permalink()).'" title="' . __("Log out of this account", "delve").'">'. __("Log out &raquo;", "delve").'</a></p>',
		'comment_notes_before' => '',
		'comment_notes_after' => '',
		'comment_field' => '<div id="delve-comment-textarea"><textarea name="comment" id="comment" cols="39" rows="4" tabindex="4" class="textarea-comment" placeholder="'. __("Comment...", "delve").'" required></textarea></div>',
		'id_submit' => 'comment-submit',
		'label_submit'=> __("Post Comment", "delve"),
	);

	comment_form($comments_args);
	
endif; // if you delete this the sky will fall on your head ?>

</div><!-- #comments -->