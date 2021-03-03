<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package listeo
 */

	$sidebar = false;

	if( is_singular() ) {
		$sidebar = get_post_meta( get_the_ID(), 'listeo_sidebar_select', true );
		
	}
	if( ! $sidebar ) {
		$sidebar = 'sidebar-listing';			
	}
		
	if( is_active_sidebar( $sidebar ) ) {
		dynamic_sidebar( $sidebar );
	}

?>