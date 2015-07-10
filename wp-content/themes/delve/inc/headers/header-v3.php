<div class="container_header">

    <div class="container container_header_main">

        <div class="navbar-header">

             <?php delve_set_navbar_header(); ?>

        </div>

    </div>



    <!-- Collect the nav links, forms, and other content for toggling -->

    <div class="container collapse navbar-collapse navbar-ex1-collapse">

    	<div class="nav-container">

			 <?php 
                    if( has_nav_menu($theme_loc) )
                        wp_nav_menu( $delve_nav_menu );
                    else 
                        echo "<div class='no-menu-selected'>Please set menu from WordPress backend.</div>";
              ?>

        </div>

    </div><!-- /.navbar-collapse -->

</div>