<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package listeo
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area" role="complementary">
		<?php 
	$sidebar = false;
	if( is_singular() ) {
		$sidebar = get_post_meta( get_the_ID(), 'listeo_sidebar_select', true );
		
	}
	
	$sidebar = apply_filters( 'listeo_sidebar_select', $sidebar );
	
	if( ! $sidebar ) {
		$sidebar = 'sidebar-1';			
	}
		
	if( is_active_sidebar( $sidebar ) ) {
		dynamic_sidebar( $sidebar );
	}
	 ?>
	 <div class="margin-top-40"></div>
</aside><!-- #secondary -->
