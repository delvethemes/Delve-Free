<div class="container container_header">

    <div class="navbar-header">

        <?php delve_set_navbar_header(); ?>

    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->

    <div class="collapse navbar-collapse navbar-ex1-collapse">
 	<?php 
		if( has_nav_menu($theme_loc) )
			wp_nav_menu( $delve_nav_menu );
		else 
			echo "<div class='no-menu-selected'>Please set menu from WordPress backend.</div>";
		?>
    </div><!-- /.navbar-collapse -->

</div><!-- /.container -->