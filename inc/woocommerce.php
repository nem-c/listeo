<?php 
/**
 * Change the Shop archive page title.
 * @param  string $title
 * @return string
 */

add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

add_filter('loop_shop_columns', 'loop_columns',999);
if (!function_exists('loop_columns')) {
	function loop_columns() {
	
		$layout = get_option( 'pp_shop_layout','full-width' ); 
	
		if( $layout == 'full-width' ){ 
			return 3;
		} else {
			
			return 2;

		}
	}
}

//add_filter('woocommerce_short_description', 'listeo_woocommerce_short_description', 10, 1);
function listeo_woocommerce_short_description($post_excerpt){
	global $product;
	if($product->get_type() == "property_package") {
       		
				$output = '<ul>';
					
					$jobslimit = $product->get_limit();
					if(!$jobslimit){
						$output .= "<li>";
						$output .= esc_html__('Unlimited number of listings','listeo'); 
						$output .=  "</li>";
					} else { 
						$output .= '<li>';
						$output .= esc_html__('This plan includes ','listeo'); $output .= sprintf( _n( '%d listing', '%s listings', $jobslimit, 'listeo' ) . ' ', $jobslimit ); 
						$output .= '</li>';

						$jobduration =  $product->get_duration();
						if(!empty($jobduration)){ 
						$output .= '<li>';
						$output .= esc_html__('Listings are published ','listeo'); $output .= sprintf( _n( 'for %s day', 'for %s days', $product->get_duration(), 'listeo' ), $product->get_duration() ); 
						$output .= '</li>';
					 } 
				$output .= "</ul>";
				} 

        $post_excerpt = $output . $post_excerpt;
    }
    return $post_excerpt;
}


remove_action( 'woocommerce_after_shop_loop_item_title','woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_after_shop_loop_item','woocommerce_template_loop_add_to_cart', 10 );
add_action( 'woocommerce_before_shop_loop_item_title','woocommerce_template_loop_add_to_cart', 10 );

add_filter( 'woocommerce_show_page_title', 'listeo_hide_shop_title' );
function listeo_hide_shop_title() { return false; }



remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_upsells', 15 );

if ( ! function_exists( 'woocommerce_output_upsells' ) ) {
	function woocommerce_output_upsells() {
	    woocommerce_upsell_display( 3,3 ); // Display 3 products in rows of 3
	}
}

add_filter( 'woocommerce_output_related_products_args', 'listeo_related_woo_per_page' );

function listeo_related_woo_per_page( $args ) { 
    $args = wp_parse_args( array( 'posts_per_page' => 3 ), $args );
    return $args;
}


function listeo_woocommerce_remove_item( $listeo_html, $cart_item_key ) {
	$cart_item_key = $cart_item_key;
	$listeo_html = sprintf( '<a href="%s" class="remove" title="%s"><i class="fa fa-times" aria-hidden="true"></i></a>', esc_url( wc_get_cart_remove_url( $cart_item_key ) ), esc_html__( 'Remove this item', 'listeo' ));
	return $listeo_html;
}

add_filter ( 'woocommerce_cart_item_remove_link', 'listeo_woocommerce_remove_item', 10, 2 );



?>