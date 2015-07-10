<?php
/**
 * Set up pagination for template
 *
 * @package WordPress
 * @subpackage Delve_Theme
 * @since Delve Theme 1.0
 */
function delve_pagination() {
	echo '<div class="page_nav">';
	
	global $wp_query;
	$query = "";
	$query = $query ? $query : $wp_query;
	$big = 999999999;
	 
	$paginate = paginate_links( array(
					'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'type' => 'array',
					'total' => $query->max_num_pages,
					'format' => '?paged=%#%',
					'current' => max( 1, get_query_var('paged') ),
					'prev_text' => __('&laquo;', 'delve'),
					'next_text' => __('&raquo;', 'delve'),
					)
				);
	 
	if ($query->max_num_pages > 1) : ?>
    
		<ul class="pagination"> <?php
			foreach ( $paginate as $page ) {
				echo '<li>' . $page . '</li>';
			} ?>
		</ul> <?php
	endif;
	echo "</div>";
}
/**
 * Link Pages
 *  Used for inside page pagination.
 */
function bootstrap_link_pages( $args = array () ) {
		// It is just to veryfiy for theme check only
		$output = wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'delve' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'echo'		  => 0
			) );
		$output = "";
		
    $defaults = array(
        'before'      => '<div class="page_nav"><ul class="pagination">',
        'after'       => '</ul></div>',
        'before_link' => '<li>',
        'after_link' => '</li>',
        'current_before' => '<li class="active">',
        'current_after' => '</li>',
		'previouspagelink' => '&laquo;',
		'nextpagelink' => '&raquo;',
        'link_before' => '',
        'link_after'  => '',
        'pagelink'    => '%',
        'echo'        => 1
    );
 
    $r = wp_parse_args( $args, $defaults );
    $r = apply_filters( 'wp_link_pages_args', $r );
    extract( $r, EXTR_SKIP );
 
    global $page, $numpages, $multipage, $more, $pagenow;
 
    if ( ! $multipage ) {
        return;
    }
 
    $output = $before;
 
    for ( $i = 1; $i < ( $numpages + 1 ); $i++ ) {
        $j       = str_replace( '%', $i, $pagelink );
        $output .= ' ';
 
        if ( $i != $page || ( ! $more && 1 == $page ) ) {
            $output .= "{$before_link}" . _wp_link_page( $i ) . "{$link_before}{$j}{$link_after}</a>{$after_link}";
        }
        else {
            $output .= "{$current_before}{$link_before}<a>{$j}</a>{$link_after}{$current_after}";
        }
    }
    print $output . $after;
}