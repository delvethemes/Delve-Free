<?php
/**
 * The template for displaying search form
 *
 * @package WordPress
 * @subpackage Delve_Theme
 * @since Delve Theme 1.0
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
    <div class="input-group">
  		<input id="search" type="search" name="s" value="" class="form-control" placeholder="Search" title="Search for:"  />
        <span class="input-group-addon"><i class="fa fa-search fa-fw"></i></span>
	</div>
	<input type="submit" style="display:none;" class="search-submit" value="Search" />
</form>