<?php
/**
 * Delve functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * @package WordPress
 * @subpackage Delve_Theme
 * @since Delve Theme 1.0
 */
/*** Defining Content width ***/
if ( ! isset( $content_width ) ) {
	$content_width = 1280;
}
/******* Limit String *******/
if( !function_exists( 'string_limit_words' ) ):
function string_limit_words( $string, $word_limit ) {
	$words = explode(' ', $string, ( $word_limit + 1 ));
	if(count( $words ) > $word_limit ) {
		array_pop( $words );
	}
	
	return implode(' ', $words);
}
endif;
if( !function_exists( 'string_limit_chars' ) ):
function string_limit_chars( $string, $char_limit ) {
	return substr( $string, 0, $char_limit ); 
}
endif;
/******* Theme support ********/
if ( !function_exists('delve_nav_walker') ):
    function delve_nav_walker() {
        load_theme_textdomain('delve', get_template_directory() . '/lang');
		add_theme_support( 'title-tag' );
        add_theme_support('automatic-feed-links');
        add_theme_support( 'post-thumbnails' ); 
        add_theme_support('post-formats',array( 'aside', 'image', 'gallery', 'link', 'quote', 'status', 'video', 'audio', 'chat' ));
		add_image_size( 'tabs-img', 52, 50, true );
		add_image_size( 'recent-works-thumbnail', 300, 250, true );
		
        register_nav_menus(
            array(
                'primary-menu' => __('Primary Menu', 'primary_menu'),
				'secondary-menu' => __('Secondary Menu', 'secondary_menu'),
				'singlepage-menu' => __('Single Page Menu', 'singlepage_menu'),
				'footer-menu' => __('Footer Menu', 'footer_menu'),
            )
		);
		require( 'class-delve_nav_walker.php' );
    }
endif;
add_action('after_setup_theme', 'delve_nav_walker');
/* scripts and styles registration */
if ( !function_exists('delve_scripts') ):
function delve_scripts() {	
	
	wp_enqueue_script('jquery-ui', TEMPLATE_PATH. '/js/jquery-ui.min.js' , array('jquery') );//jQuery ui	
	
	// isotop plugin
	wp_enqueue_script('isotopmain', TEMPLATE_PATH. '/plugins/isotope-docs/isotope.pkgd.min.js' , array('jquery') );
	wp_enqueue_script('isotopfile', TEMPLATE_PATH. '/plugins/isotope-docs/bower_components/classie/classie.js' , array('jquery') );
	
	wp_enqueue_script('delve-bootstrap', TEMPLATE_PATH. '/js/bootstrap.min.js' , array('jquery') );	//bootstrap
	wp_enqueue_script('delve-script', TEMPLATE_PATH. '/js/delve-script.js' , array('jquery') );	//delve script
	
	if(is_page_template( 'page-templates/single-page.php' )) {
		wp_enqueue_script('easing-js', TEMPLATE_PATH. '/js/jquery.easing.min.js' , array('jquery') );
		wp_enqueue_script('scorll-js', TEMPLATE_PATH. '/js/scrolling-nav.js' , array('jquery') );
	}
	
	// Styles
	if( class_exists( 'Woocommerce' ) ) 
		wp_enqueue_style( 'delve_woocommerce', TEMPLATE_PATH."/woocommerce/delve-woocommerce.css" );
	
	wp_enqueue_style( 'delve_style', TEMPLATE_PATH."/style.css" );
	
	// applying skin
	global $data;
	$delve_skin = "default.css";
	if( isset($data['delve-skins']) )
	$delve_skin = $data['delve-skins'];
	
	wp_enqueue_style( 'delve_skin', TEMPLATE_PATH."/skins/".$delve_skin );
	
	// dark theme
	if( $data['delve-dark'] == 'dark.min.css' ) {
		wp_enqueue_style( 'delve_dark_theme', TEMPLATE_PATH."/css/".$data['delve-dark'] );
	}
	
	/******** comment replay script ********/
	function delve_enqueue_comments_reply() {
		if( get_option( 'thread_comments' ) )  {
			wp_enqueue_script( 'comment-reply' );
		}
	}
	add_action( 'comment_form_before', 'delve_enqueue_comments_reply' );
}
endif;
add_action( 'wp_enqueue_scripts', 'delve_scripts' );
/**
 * Get Logo function for header.
*/
if ( !function_exists( 'delve_set_navbar_header' ) ):
function delve_set_navbar_header() { ?>
	
	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
    	<span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
	</button>
    
    <!-- You'll want to use a responsive image option so this logo looks good on devices -
	We recommend using something like retina.js (do a quick Google search for it and you'll find it) -->
	
     <?php	
    global $data;
	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) )  && $data['place_cart_icon']['cart_menu'] ) { 
    	global $woocommerce;
		$cart_url = $woocommerce->cart->get_cart_url(); ?>
		
        <a class="cart-button" href="<?php echo $cart_url; ?>" ><i class="fa fa-shopping-cart"></i></a>
	<?php } 
	global $data;
	$logo_navigation = get_site_url();
		
	if( $data['site-logo-navigation'] ) {
		$logo_navigation = $data['site-logo-navigation'];
	} ?>
    <a class="subNavBtn navbar-brand" href="<?php echo $logo_navigation; ?>"> 
		<?php
			if(isset($data['site-logo']) && $data['site-logo']['url']){ ?>
			<img src="<?php echo $data['site-logo']['url']; ?>" alt="Header Logo" class="delve-logo"/>           
		<?php }else { ?>
			<span><?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?></span>
		<?php } ?>
	</a>
<?php  if( $data['site-tagline'] != "" ){?>	
			<div class="tagline"><?php echo esc_attr( $data['site-tagline'] ); ?></div>
<?php	}
}
endif;
/******* Delve Navigation Fallback Function ******/
if( !function_exists( 'delve_nav_fallback' ) ):
function delve_nav_fallback() {
	return "Please set menu from wordpress backend.";
}
endif;
/******* Delve Secondary Nav *******/
if( !function_exists( 'delve_secondary_nav' ) ):
function delve_secondary_nav() {
?>
<div class="delve-secondary-nav-container">
	<?php 
	$delve_secoundry_nav = array(
		'theme_location'  => 'secondary-menu',
		'fallback_cb'     => false
	);
				
	wp_nav_menu( $delve_secoundry_nav ); ?>
</div>
<?php }
endif;


/******* Delve Footer Nav *******/
if( !function_exists( 'delve_footer_nav' ) ):
function delve_footer_nav() {
?>
<div class="delve-secondary-nav-container">
	<?php 
	$delve_footer_nav = array(
		'theme_location'  => 'footer-menu',
		'fallback_cb'     => false
	);
				
	wp_nav_menu( $delve_footer_nav ); ?>
</div>
<?php }
endif;

/****** Create title bar function *******/
if( !function_exists( 'delve_titlebar' ) ):
function delve_titlebar( $c_page_ID ) {
	
	$meta = get_post_custom( $c_page_ID );
	$title = get_the_title();
		
	if( is_home() ) {
		$title = "Home";
	}
	if( is_search() ) {
		$title = __('Search results for : ', 'delve') . get_search_query();
	}
	if( is_404() ) {
		$title = __('404 Not Found!', 'delve');
	}
	if( is_archive() ) {
		if ( is_day() ) {
			$title = __( 'Daily Archives:', 'delve' ) . '<span> ' . get_the_date() . '</span>';
		} else if ( is_month() ) {
			$title = __( 'Monthly Archives:', 'delve' ) . '<span> ' . get_the_date( _x( 'F Y', 'monthly archives date format', 'delve' ) ) . '</span>';
		} elseif ( is_year() ) {
			$title = __( 'Yearly Archives:', 'delve' ) . '<span> ' . get_the_date( _x( 'Y', 'yearly archives date format', 'delve' ) ) . '</span>';
		} elseif ( is_author() ) {
			$curauth = ( isset( $_GET['author_name'] ) ) ? get_user_by( 'slug', $_GET['author_name'] ) : get_user_by(  'id', get_the_author_meta('ID') );
			$title = $curauth->nickname;
		} else {
			$title = single_cat_title( '', false );
		}
	}
	if( class_exists( 'Woocommerce' ) && is_woocommerce() && ( is_product() || is_shop() ) && ! is_search() ) {
		if( ! is_product() ) {
			$title = woocommerce_page_title( false );
		}
	}
	
	global $data;
	if( is_page() ) {
		if($data['show-page-title-bar']==1) {
			if( $meta['delve_meta_show_heading'][0]) {				
				delve_add_page_titlebar( $title );
			}
		}
		else {
			if( $meta['delve_meta_show_heading'][0])  {
				delve_add_page_titlebar( $title );
			}	
		}
		
	} else {
		if($data['show-page-title-bar']==1) {
			delve_add_page_titlebar( $title );
		}
	}
}
endif;
if( !function_exists( 'delve_add_page_titlebar' ) ):
function delve_add_page_titlebar( $title ) { ?>
<header>
	<div class="container-header">
		<div class="row page-title">
			<div class="col-md-6 page-title-container">
				<h2><?php echo $title; ?></h2>
			</div>
			<div class="col-md-6 delve-breadcrumb">
            	<?php 
				if( ( class_exists( 'Woocommerce' ) && is_woocommerce() ) || ( is_tax( 'product_cat' ) || is_tax( 'product_tag' ) ) ) {
					woocommerce_breadcrumb(array(
						'wrap_before' => '<ul class="breadcrumbs">',
						'wrap_after' => '</ul>',
						'before' => '<li>',
						'after' => '</li>',
						'delimiter' => ''
					));
				} else {	
					delve_breadcrumb();
				}?>
			</div>
		</div><!-- row -->
	</div>
</header> <!-- Header -->
<?php }
endif;
/******* Content style *******/
if( !function_exists( 'delve_content_layout' ) ):
function delve_content_layout( $c_page_ID ) {
	
	global $data;
	$content_class = 'col-md-9';
	$sidebar_pos = 'right';
	$content_style = '';
	$sidebar_style = '';
	$meta = get_post_custom( $c_page_ID );
	
	$sidebar_pos = $meta['delve_meta_sidebar_position'][0];
	if( class_exists( 'Woocommerce' ) && ( is_shop() || is_product() || is_product_category() || is_product_tag() || is_checkout() ) ) {
		if( is_shop() ) {
			if( $sidebar_pos == 'none' ) {
				$content_class = 'col-md-12';
				$sidebar_style = 'style="display:none"';
			} else if( $sidebar_pos == 'left' ) {
				$sidebar_style = 'style="float:left"';
				$content_style = 'style="float:right"';
			}
		}
		
		if( is_product() ) {
			$sidebar_pos = $data['s_product-sidebar-position'];
			if( $sidebar_pos == 'none' ) {
				$content_class = 'col-md-12';
				$sidebar_style = 'style="display:none"';
			} else if( $sidebar_pos == 'left' ) {
				$sidebar_style = 'style="float:left"';
				$content_style = 'style="float:right"';
			}
		}
		
		if( is_product_category() || is_product_tag() ) {
			$sidebar_pos = $data['a_product-sidebar-position'];
			if( $sidebar_pos == 'none' ) {
				$content_class = 'col-md-12';
				$sidebar_style = 'style="display:none"';
			} else if( $sidebar_pos == 'left' ) {
				$sidebar_style = 'style="float:left"';
				$content_style = 'style="float:right"';
			}
		}
		
		if( is_checkout() ) {
			$content_class = 'col-md-12';
			$sidebar_style = 'style="display:none"';
		}
		
	}else {
		if( $sidebar_pos == 'none' ) {
			$content_class = 'col-md-12';
			$sidebar_style = 'style="display:none"';
		} else if( $sidebar_pos == 'left' ) {
			$sidebar_style = 'style="float:left"';
			$content_style = 'style="float:right"';
		}
	}
	
	$delve_content_style['background'] = "";
	if( isset($meta['delve_meta_page_bg_color'][0]) ) {
		$delve_content_style['background'] = "style = 'background-color : ".$meta['delve_meta_page_bg_color'][0].";'";
	}
	if(isset($meta['delve_meta_page_columns'][0]))
		$delve_content_style['columns'] = $meta['delve_meta_page_columns'][0];
	
	if( isset($delve_content_style['columns']) == 'col-md-12 delve-col-1' ) {
		$delve_content_style['string'] = 70;
	}
	
	if( isset($delve_content_style['columns']) == 'col-md-6 delve-col-2' ) {
		$delve_content_style['string'] = 35;
	}
	
	if( isset($delve_content_style['columns']) == 'col-md-4 delve-col-3' ) {
		$delve_content_style['string'] = 17;
	}
	
	if( isset($delve_content_style['columns']) == 'col-md-3 delve-col-4' ) {
		$delve_content_style['string'] = 10;
	}
	
	$delve_content_style['c_class'] = $content_class;
	$delve_content_style['c_style'] = $content_style;
	$delve_content_style['s_style'] = $sidebar_style;
	
	return $delve_content_style;
}
endif;
/****** Social Icon *******/
if( !function_exists( 'delve_social_icon' ) ):
function delve_social_icon($carticon = true) { ?>
    <div class="social-icon-container">
    
    	<?php global $data;
		 if($data['switch-social'][0]) { ?>
        	<ul class="delve-social">
            	<?php global $delve_social;
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
                                                    
				foreach ( $delve_social as $key => $value ){ ?>
                	<?php if( $data[$key] ) { ?>
                    	<li class="<?php echo $value; ?>">
                        	<a class="tooltipa" target="_blank" title=<?php echo $value; ?> data-toggle="tooltip" 
                        	data-placement="top" href="<?php echo $data[$key]; ?>">
                                <span><i class="fa <?php echo $delve_social_ico[$key] ?>"></i></span>
                        	</a>
                    	</li>
                	<?php } ?>
            	<?php } 
				if($data['place_cart_icon']['cart_top_bar'] && $carticon == true ) {
					global $woocommerce;
				?>
                <li class="menu-item menu-item-has-children dropdown delve-cart-btn">
                	<?php if($woocommerce) { ?>
                    <span class="cart-btn"><a href="<?php echo $woocommerce->cart->get_cart_url(); ?>">
                        <i class="fa fa-shopping-cart"></i></a>
                    </span> <?php } ?>
                    <ul class="dropdown-menu">
                        <li class="dropdown">
                            <div class="cart-contents">
                                <ul>
                                    <li class="cart-content"></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </li>
				<?php } ?>
        	</ul>
        <?php } else {
			echo __("Please, set social icons option from backend.", 'delve');	
		}?>
    </div>
<?php }
endif;
/***** Comment list displays ****/
if( !function_exists( 'delve_comment_list' ) ):
function delve_comment_list($comment, $args, $depth) { ?>
	<?php $add_below = ''; ?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
		<div class="the-comment">
			<div class="avatar">
				<?php echo get_avatar($comment, 54); ?>
			</div>
			<div class="comment-box">
				<div class="comment-author meta">
					<strong><?php comment_author_link() ?></strong>
					<?php printf(__('%1$s at %2$s', 'delve'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__(' Edit', 'delve'),'  ','') ?><?php comment_reply_link(array_merge( $args, array('reply_text' => __(' Reply', 'delve'), 'add_below' => 'comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
				</div>
				<div class="comment-text">
					<?php if ($comment->comment_approved == '0') : ?>
					<em><?php echo __('Your comment is awaiting moderation.', 'delve') ?></em>
					<br />
					<?php endif; ?>
					<?php comment_text() ?>
				</div>
			</div>
		</div>
	</li>
<?php }
endif;
// Single Portfolio Page Category List
if( !function_exists( 'delve_single_pf_cat' ) ):
function delve_single_pf_cat() {
    $_categories = get_categories('taxonomy=portfolio_categories');
	$_length = count($_categories);
	$flag = 0;
    foreach ($_categories as $_cat) {
		if( $flag == $_length-1 ) { echo ", ".$_cat->name."."; }
		else if( $flag ) { echo ", ".$_cat->name; $flag++; }
		else { echo $_cat->name; $flag++; }
    }
}
endif;
/******* Breadcrumb function ********/
if(!function_exists('delve_breadcrumb')):
function delve_breadcrumb() {
        global $post;
        echo '<ul class="breadcrumbs">';
         if ( !is_front_page() ) {
        echo '<li><a href="';
        echo home_url();
        echo '">'.__('Home', 'delve');
        echo "</a></li>";
        }
        $params['link_none'] = '';
        $separator = '';
        if (is_category() && !is_singular('delve_portfolio')) {
            $category = get_the_category();
            $ID = $category[0]->cat_ID;
            echo is_wp_error( $cat_parents = get_category_parents($ID, TRUE, '', FALSE ) ) ? '' : '<li>'.$cat_parents.'</li>';
        }
        if(is_singular('delve_portfolio')) {
            echo get_the_term_list($post->ID, 'portfolio_category', '<li>', '&nbsp;/&nbsp;&nbsp;', '</li>');
            echo '<li>'.get_the_title().'</li>';
        }
        if(is_singular('event')) {
            $terms = get_the_term_list($post->ID, 'event-categories', '<li>', '&nbsp;/&nbsp;&nbsp;', '</li>');
            if( ! is_wp_error( $terms ) ) {
                echo get_the_term_list($post->ID, 'event-categories', '<li>', '&nbsp;/&nbsp;&nbsp;', '</li>');
            }
            echo '<li>'.get_the_title().'</li>';
        }
        if (is_tax()) {
            $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
            echo '<li>'.$term->name.'</li>';
        }
        if(is_home()) { echo '<li>'.get_bloginfo('name').'</li>'; }
        if(is_page() && !is_front_page()) {
            $parents = array();
            $parent_id = $post->post_parent;
            while ( $parent_id ) :
                $page = get_page( $parent_id );
                if ( $params["link_none"] )
                    $parents[]  = get_the_title( $page->ID );
                else
                    $parents[]  = '<li><a href="' . get_permalink( $page->ID ) . '" title="' . get_the_title( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a></li>' . $separator;
                $parent_id  = $page->post_parent;
            endwhile;
            $parents = array_reverse( $parents );
            echo join( '', $parents );
            echo '<li>'.get_the_title().'</li>';
        }
        if(is_single() && !is_singular('delve_portfolio')  && !is_singular('event') && !is_singular('wpfc_sermon')) {
            $categories_1 = get_the_category($post->ID);
            if($categories_1):
                foreach($categories_1 as $cat_1):
                    $cat_1_ids[] = $cat_1->term_id;
                endforeach;
                $cat_1_line = implode(',', $cat_1_ids);
            endif;
            if( isset($cat_1_line )) {
                $categories = get_categories(array(
                    'include' => $cat_1_line,
                    'orderby' => 'id'
                ));
                if ( $categories ) :
                    foreach ( $categories as $cat ) :
                        $cats[] = '<li><a href="' . get_category_link( $cat->term_id ) . '" title="' . $cat->name . '">' . $cat->name . '</a></li>';
                    endforeach;
                    echo join( '', $cats );
                endif;
            }
            echo '<li>'.get_the_title().'</li>';
        }
        if(is_tag()){ echo '<li>'."Tag: ".single_tag_title('',FALSE).'</li>'; }
        if(is_404()){ echo '<li>'.__("404 - Page not Found", 'delve').'</li>'; }
        if(is_search()){ echo '<li>'.__("Search", 'delve').'</li>'; }
        if(is_year()){ echo '<li>'.get_the_time('Y').'</li>'; }
        echo "</ul>";
}
endif;
/**
 * woocommerce Config
 */
add_theme_support( 'woocommerce' );
if( class_exists('Woocommerce') ) {
	include(locate_template('woocommerce/woo-setup.php'));
	//include_once( get_template_directory() . '/woocommerce/woo-setup.php' );
}
//deactivating woo css
add_filter( 'woocommerce_enqueue_styles', '__return_false' );
/***** add cart menu in header ******/
add_filter('wp_nav_menu_items','delve_cart_button_in_menu', 10, 2);
function delve_cart_button_in_menu($menu, $args) {
	
	global $data;
	$primary_menu = 'false';
	
	if( $data['place_cart_icon']['cart_menu'] ) {
		$primary_menu = 'primary-menu';
	}
	
	// Check if WooCommerce is active and add a new item to a menu assigned to Primary Navigation Menu location
	if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || $primary_menu !== $args->theme_location )
		return $menu;
			
	global $woocommerce;
	$cart_url = $woocommerce->cart->get_cart_url();
	$shop_page_url = get_permalink( woocommerce_get_page_id( 'shop' ) );
	$cart_contents_count = $woocommerce->cart->cart_contents_count;
	$cart_contents = sprintf(_n('%d item', '%d items', $cart_contents_count, 'delve'), $cart_contents_count);
	$cart_total = $woocommerce->cart->get_cart_total();
	ob_start(); ?>
		
	<li class="menu-item menu-item-has-children dropdown delve-cart-btn">
			<span class="cart-btn"><a href="<?php echo $cart_url; ?>"><i class="fa fa-shopping-cart"></i></a></span>
			<ul class="dropdown-menu">
            <li>
            <div class="cart-contents">
				<?php		
				  /*foreach($woocommerce->cart->cart_contents as $cart_item): ?>
					<li class="cart-content">
						<a href="<?php echo get_permalink($cart_item['product_id']); ?>">
							<?php $thumbnail_id = ($cart_item['variation_id']) ? $cart_item['variation_id'] : $cart_item['product_id']; ?>
							<?php echo get_the_post_thumbnail($thumbnail_id, 'recent-works-thumbnail'); ?>
							<div class="cart-desc">
								<span class="cart-title"><?php echo $cart_item['data']->post->post_title; ?></span>
								<span class="product-quantity"><?php echo $cart_item['quantity']; ?> x <?php echo $woocommerce->cart->get_product_subtotal($cart_item['data'], 1); ?></span>
							</div>
						</a>
					</li>
				<?php  endforeach;  */?>
            </div>
            </li>
			</ul>
		</li>
	<?php		
	$social = ob_get_clean();
	return $menu . $social;
}
/**
* Fix tiny mce rev slider listbox postion in backend
**/
function rev_slider_floating_css() {
	echo '<style>.mce-toolbar .mce-btn-group .mce-btn.mce-listbox{float:left; }</style>';
}
add_action( 'admin_head', 'rev_slider_floating_css' );
/**
 * Add "first" and "last" CSS classes to dynamic sidebar widgets. Also adds numeric index class for each widget (widget-1, widget-2, etc.)
 */
function widget_first_last_classes($params) {
	global $my_widget_num; // Global a counter array
	$this_id = $params[0]['id']; // Get the id for the current sidebar we're processing
	$arr_registered_widgets = wp_get_sidebars_widgets(); // Get an array of ALL registered widgets	
	if(!$my_widget_num) {// If the counter array doesn't exist, create it
		$my_widget_num = array();
	}
	if(!isset($arr_registered_widgets[$this_id]) || !is_array($arr_registered_widgets[$this_id])) { // Check if the current sidebar has no widgets
		return $params; // No widgets in this sidebar... bail early.
	}
	if(isset($my_widget_num[$this_id])) { // See if the counter array has an entry for this sidebar
		$my_widget_num[$this_id] ++;
	} else { // If not, create it starting with 1
		$my_widget_num[$this_id] = 1;
	}
	$class = 'class="widget-' . $my_widget_num[$this_id] . ' '; // Add a widget number class for additional styling options
	if($my_widget_num[$this_id] == 1) { // If this is the first widget
		$class .= 'widget-first ';
	} elseif($my_widget_num[$this_id] == count($arr_registered_widgets[$this_id])) { // If this is the last widget
		$class .= 'widget-last ';
	}
	$params[0]['before_widget'] = str_replace('class="', $class, $params[0]['before_widget']); // Insert our new classes into "before widget"
	return $params;
}
add_filter('dynamic_sidebar_params','widget_first_last_classes');
add_action( 'wp_head', 'delve_insert_css' );
/**
 * Load dynamic styles of theme.
 */
function delve_insert_css() {
	?>
	<style type='text/css'>
	<?php include(locate_template('inc/custom.css.php')); ?>
	</style>
	<?php
}
/*
* Return a new number of maximum columns for shop archives
* @param int Original value
* @return int New number of columns
*/
function wc_loop_shop_columns( $number_columns ) {
 global $data;
 if( $data['s_shop_page_columns'] )
  return $data['s_shop_page_columns'];
 else
  return 4;
}
add_filter( 'loop_shop_columns', 'wc_loop_shop_columns', 1, 10 );
/*
 * wc_remove_related_products
 * 
 * Clear the query arguments for related products so none show.
 * Add this code to your theme functions.php file.  
 */
function wc_remove_related_products( $args ) {
 return array();
}
if( isset($data['p_display_related_products']) && $data['p_display_related_products'] != 1 )
add_filter('woocommerce_related_products_args','wc_remove_related_products', 10);