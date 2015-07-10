<div id="sticky-header" class="sticky-header navbar navbar-inverse">
	<div class="container container_header">
		<div class="navbar-header">
			<?php delve_set_navbar_header(); ?>
		</div>
		
        <div class="collapse navbar-collapse navbar-ex1-collapse">
    
        <?php
              $delve_nav_menu['items_wrap']= '<ul id="sticky-menu" class="%2$s nav navbar-nav menu-menu">%3$s</ul>';
			 if ( is_page_template('page-templates/single-page.php') ) {
			 	$delve_nav_menu['items_wrap']= '<ul id="sticky-menu" class="%2$s nav navbar-nav menu-menu">
			  									<li class="hidden"><a href="#page-top"></a></li>
												<li><a href="#top_nav" class="page-scroll">Home</a></li>%3$s
											  </ul>';
			 }		
			  wp_nav_menu( $delve_nav_menu ); ?>
		</div>
	</div><!-- /.container -->
</div><!-- /#sticky header -->