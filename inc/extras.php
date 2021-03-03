<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package listeo
 */



function workscout_license_admin_notice(){
            
            $licenseKey   = get_option("Listeo_lic_Key","");
            
            $liceEmail    = get_option( "Listeo_lic_email","");
            
            $templateDir  = get_template_directory(); //or dirname(__FILE__);
    
            if(!ListeoBase::CheckWPPlugin( $licenseKey, $liceEmail, $licenseMessage, $responseObj, $templateDir."/style.css")){            
            ob_start();

            ?>
                <div class="license-validation-popup">
                    <p>Oops, seems that you have not activated your Listeo license yet!</p>
                    <a href="<?php echo add_query_arg( array( 'tab' => 'license' ) , menu_page_url('listeo_license',false) ) ?>" class="nav-tab">Activate License</a>
                </div>
            
            <?php $html = ob_get_clean();
            echo $html;
        }
}
add_action('admin_notices', 'workscout_license_admin_notice');


/**
 * Check if WooCommerce is activated
 */
if ( ! function_exists( 'is_woocommerce_activated' ) ) {
  function is_woocommerce_activated() {
    if ( class_exists( 'woocommerce' ) ) { return true; } else { return false; }
  }
}


function listeo_check_abandoned_cart(){

  $unpaid_listing_in_cart = false;
  
  if(is_woocommerce_activated()){
      
    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
        if(WC_Product_Factory::get_product_type($cart_item['product_id']) == "listing_package"){
          $unpaid_listing_in_cart = true;
        };
       
         
    }
  }

  return $unpaid_listing_in_cart;
}


// add_filter( 'woocommerce_return_to_shop_redirect', 'listeo_woocommerce_shop_url' );
// /**
//  * Redirect WooCommerce Shop URL
//  */

// function listeo_woocommerce_shop_url(){
  

//   $submit_page = get_option('listeo_submit_page');
//   if($submit_page){
//     return get_permalink($submit_page);
//   }


// }

function listeo_render_svg_icon( $value ) {
    if ( ! isset( $value) ) {
      return '';
    }

    return listeo_get_inline_svg( $value );
  }

function listeo_get_inline_svg( $attachment_id ) {
    $svg = get_post_meta( $attachment_id, '_elementor_inline_svg', true );

    if ( ! empty( $svg ) ) {
      return $svg;
    }

    $attachment_file = get_attached_file( $attachment_id );

    if ( ! $attachment_file ) {
      return '';
    }

    $svg = file_get_contents( $attachment_file );

    if ( ! empty( $svg ) ) {
      update_post_meta( $attachment_id, '_elementor_inline_svg', $svg );
    }

    return $svg;
  }


/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function listeo_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

  $submit_page = get_option('listeo_submit_page');
  if(is_page($submit_page)){
      $classes[] = 'add-listing-dashboard-template';   
  }

  if(!is_user_logged_in()){
      $classes[] = 'user_not_logged_in';
  }
  if( ( is_page_template('template-home-search.php') || is_page_template('template-home-search-splash.php') )  && (get_option('listeo_home_transparent_header') == 'enable')){
      $classes[] = 'transparent-header';   
  } else {
      $classes[] = 'solid-header';   
  }
  if(is_page_template('template-home-search.php')  && (get_option('listeo_home_solid_background') == 'enable')){
      $classes[] = 'solid-bg-home-banner';   
  }

  
  if(is_post_type_archive('listing') && get_option('pp_listings_top_layout') == 'half'){
        $classes[] = 'page-template-template-split-map';   
  }
  if(get_option('listeo_fw_header') || is_page_template('template-home-search-splash.php')){
    $classes[] = 'full-width-header';
  }
  if(get_option('listeo_marker_no_icon') == 'no_icon'){
    $classes[] = 'no-map-marker-icon ';
  }
	return $classes;
}
add_filter( 'body_class', 'listeo_body_classes' );


add_action('pre_user_query', 'my_custom_users_search');
function my_custom_users_search( $args ) {
    if( isset( $args->query_vars['and2or'] ) )
        $args->query_where = str_replace(') AND (', ') OR (', $args->query_where);
}
/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function listeo_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'listeo_pingback_header' );



function workscout_get_rating_class($average) {
     if(!$average) {
               $class="no-stars";
     } else {
          switch ($average) {
               
               case $average >= 1 && $average < 1.5:
                    $class="one-stars";
                    break;
               case $average >= 1.5 && $average < 2:
                    $class="one-and-half-stars";
                    break;
               case $average >= 2 && $average < 2.5:
                    $class="two-stars";
                    break;
               case $average >= 2.5 && $average < 3:
                    $class="two-and-half-stars";
                    break;
               case $average >= 3 && $average < 3.5:
                    $class="three-stars";
                    break;
               case $average >= 3.5 && $average < 4:
                    $class="three-and-half-stars";
                    break;
               case $average >= 4 && $average < 4.5:
                    $class="four-stars";
                    break;
               case $average >= 4.5 && $average < 5:
                    $class="four-and-half-stars";
                    break;
               case $average >= 5:
                    $class="five-stars";
                    break;

               default:
                    $class="no-stars";
                    break;
          }
     }
     return $class;
     }


function wsl_findeo_use_fontawesome_icons( $provider_id, $provider_name, $authenticate_url )
{
   ?>
   <a 
      rel           = "nofollow"
      href          = "<?php echo $authenticate_url; ?>"
      data-provider = "<?php echo $provider_id ?>"
      class         = "wp-social-login-provider wp-social-login-provider-<?php echo strtolower( $provider_id ); ?>" 
    >
      <span>
         <i class="fa fa-<?php echo strtolower( $provider_id ); ?>"></i><?php echo $provider_name; ?>
      </span>
   </a>
<?php
}
 
add_filter( 'wsl_render_auth_widget_alter_provider_icon_markup', 'wsl_findeo_use_fontawesome_icons', 10, 3 );
/**
 * Customize the PageNavi HTML before it is output
 */
add_filter( 'wp_pagenavi', 'listeo_pagination', 10, 2 );
function listeo_pagination($html) {
    $out = '';
    //wrap a's and span's in li's
    
    $out = str_replace("<a","<li><a",$html);
    $out = str_replace("</a>","</a></li>",$out);
    $out = str_replace("<span","<li><span",$out);
    $out = str_replace("</span>","</span></li>",$out);
    $out = str_replace("<div class='wp-pagenavi' role='navigation'>","",$out);
    $out = str_replace("</div>","",$out);
    return '<div class="pagination"><ul>'.$out.'</ul></div>';
}

function listeo_disable_sticky_footer($sticky){
	if(is_404()){
		$sticky = false;
	}
	return $sticky;
}
add_action('listeo_sticky_footer_filter','listeo_disable_sticky_footer');


function get_listeo_icons_dropdown($sel=''){
   // $icons = vc_iconpicker_type_iconsmind(array());
    $output = '<option value="">'.esc_html__('no icon','listeo').'</option>';

    $sl_icons = purethemes_get_simple_line_icons();

    foreach ($sl_icons as $icon) {
       $output .= '<option value="' . esc_attr( $icon ) . '" ' . ( strcmp( $icon, $sel ) === 0 ? 'selected' : '' ) . '>' . esc_html( $icon  ) . '(Simple Line)</option>' . "\n";
    }
  

    return $output;
}


/**
 * FontAwesome icons array
 */
function listeo_fa_icons_list(){
    $icon = array(
'fab fa-500px' => __( '500px', 'buildr' ),
        'fab fa-accessible-icon' => __( 'accessible-icon', 'buildr' ),
        'fab fa-accusoft' => __( 'accusoft', 'buildr' ),
        'fas fa-address-book' => __( 'address-book', 'buildr' ),
        'far fa-address-book' => __( 'address-book', 'buildr' ),
        'fas fa-address-card' => __( 'address-card', 'buildr' ),
        'far fa-address-card' => __( 'address-card', 'buildr' ),
        'fas fa-adjust' => __( 'adjust', 'buildr' ),
        'fab fa-adn' => __( 'adn', 'buildr' ),
        'fab fa-adversal' => __( 'adversal', 'buildr' ),
        'fab fa-affiliatetheme' => __( 'affiliatetheme', 'buildr' ),
        'fab fa-algolia' => __( 'algolia', 'buildr' ),
        'fas fa-align-center' => __( 'align-center', 'buildr' ),
        'fas fa-align-justify' => __( 'align-justify', 'buildr' ),
        'fas fa-align-left' => __( 'align-left', 'buildr' ),
        'fas fa-align-right' => __( 'align-right', 'buildr' ),
        'fas fa-allergies' => __( 'allergies', 'buildr' ),
        'fab fa-amazon' => __( 'amazon', 'buildr' ),
        'fab fa-amazon-pay' => __( 'amazon-pay', 'buildr' ),
        'fas fa-ambulance' => __( 'ambulance', 'buildr' ),
        'fas fa-american-sign-language-interpreting' => __( 'american-sign-language-interpreting', 'buildr' ),
        'fab fa-amilia' => __( 'amilia', 'buildr' ),
        'fas fa-anchor' => __( 'anchor', 'buildr' ),
        'fab fa-android' => __( 'android', 'buildr' ),
        'fab fa-angellist' => __( 'angellist', 'buildr' ),
        'fas fa-angle-double-down' => __( 'angle-double-down', 'buildr' ),
        'fas fa-angle-double-left' => __( 'angle-double-left', 'buildr' ),
        'fas fa-angle-double-right' => __( 'angle-double-right', 'buildr' ),
        'fas fa-angle-double-up' => __( 'angle-double-up', 'buildr' ),
        'fas fa-angle-down' => __( 'angle-down', 'buildr' ),
        'fas fa-angle-left' => __( 'angle-left', 'buildr' ),
        'fas fa-angle-right' => __( 'angle-right', 'buildr' ),
        'fas fa-angle-up' => __( 'angle-up', 'buildr' ),
        'fab fa-angrycreative' => __( 'angrycreative', 'buildr' ),
        'fab fa-angular' => __( 'angular', 'buildr' ),
        'fab fa-app-store' => __( 'app-store', 'buildr' ),
        'fab fa-app-store-ios' => __( 'app-store-ios', 'buildr' ),
        'fab fa-apper' => __( 'apper', 'buildr' ),
        'fab fa-apple' => __( 'apple', 'buildr' ),
        'fab fa-apple-pay' => __( 'apple-pay', 'buildr' ),
        'fas fa-archive' => __( 'archive', 'buildr' ),
        'fas fa-arrow-alt-circle-down' => __( 'arrow-alt-circle-down', 'buildr' ),
        'far fa-arrow-alt-circle-down' => __( 'arrow-alt-circle-down', 'buildr' ),
        'fas fa-arrow-alt-circle-left' => __( 'arrow-alt-circle-left', 'buildr' ),
        'far fa-arrow-alt-circle-left' => __( 'arrow-alt-circle-left', 'buildr' ),
        'fas fa-arrow-alt-circle-right' => __( 'arrow-alt-circle-right', 'buildr' ),
        'far fa-arrow-alt-circle-right' => __( 'arrow-alt-circle-right', 'buildr' ),
        'fas fa-arrow-alt-circle-up' => __( 'arrow-alt-circle-up', 'buildr' ),
        'far fa-arrow-alt-circle-up' => __( 'arrow-alt-circle-up', 'buildr' ),
        'fas fa-arrow-circle-down' => __( 'arrow-circle-down', 'buildr' ),
        'fas fa-arrow-circle-left' => __( 'arrow-circle-left', 'buildr' ),
        'fas fa-arrow-circle-right' => __( 'arrow-circle-right', 'buildr' ),
        'fas fa-arrow-circle-up' => __( 'arrow-circle-up', 'buildr' ),
        'fas fa-arrow-down' => __( 'arrow-down', 'buildr' ),
        'fas fa-arrow-left' => __( 'arrow-left', 'buildr' ),
        'fas fa-arrow-right' => __( 'arrow-right', 'buildr' ),
        'fas fa-arrow-up' => __( 'arrow-up', 'buildr' ),
        'fas fa-arrows-alt' => __( 'arrows-alt', 'buildr' ),
        'fas fa-arrows-alt-h' => __( 'arrows-alt-h', 'buildr' ),
        'fas fa-arrows-alt-v' => __( 'arrows-alt-v', 'buildr' ),
        'fas fa-assistive-listening-systems' => __( 'assistive-listening-systems', 'buildr' ),
        'fas fa-asterisk' => __( 'asterisk', 'buildr' ),
        'fab fa-asymmetrik' => __( 'asymmetrik', 'buildr' ),
        'fas fa-at' => __( 'at', 'buildr' ),
        'fab fa-audible' => __( 'audible', 'buildr' ),
        'fas fa-audio-description' => __( 'audio-description', 'buildr' ),
        'fab fa-autoprefixer' => __( 'autoprefixer', 'buildr' ),
        'fab fa-avianex' => __( 'avianex', 'buildr' ),
        'fab fa-aviato' => __( 'aviato', 'buildr' ),
        'fab fa-aws' => __( 'aws', 'buildr' ),
        'fas fa-backward' => __( 'backward', 'buildr' ),
        'fas fa-balance-scale' => __( 'balance-scale', 'buildr' ),
        'fas fa-ban' => __( 'ban', 'buildr' ),
        'fas fa-band-aid' => __( 'band-aid', 'buildr' ),
        'fab fa-bandcamp' => __( 'bandcamp', 'buildr' ),
        'fas fa-barcode' => __( 'barcode', 'buildr' ),
        'fas fa-bars' => __( 'bars', 'buildr' ),
        'fas fa-baseball-ball' => __( 'baseball-ball', 'buildr' ),
        'fas fa-basketball-ball' => __( 'basketball-ball', 'buildr' ),
        'fas fa-bath' => __( 'bath', 'buildr' ),
        'fas fa-battery-empty' => __( 'battery-empty', 'buildr' ),
        'fas fa-battery-full' => __( 'battery-full', 'buildr' ),
        'fas fa-battery-half' => __( 'battery-half', 'buildr' ),
        'fas fa-battery-quarter' => __( 'battery-quarter', 'buildr' ),
        'fas fa-battery-three-quarters' => __( 'battery-three-quarters', 'buildr' ),
        'fas fa-bed' => __( 'bed', 'buildr' ),
        'fas fa-beer' => __( 'beer', 'buildr' ),
        'fab fa-behance' => __( 'behance', 'buildr' ),
        'fab fa-behance-square' => __( 'behance-square', 'buildr' ),
        'fas fa-bell' => __( 'bell', 'buildr' ),
        'far fa-bell' => __( 'bell', 'buildr' ),
        'fas fa-bell-slash' => __( 'bell-slash', 'buildr' ),
        'far fa-bell-slash' => __( 'bell-slash', 'buildr' ),
        'fas fa-bicycle' => __( 'bicycle', 'buildr' ),
        'fab fa-bimobject' => __( 'bimobject', 'buildr' ),
        'fas fa-binoculars' => __( 'binoculars', 'buildr' ),
        'fas fa-birthday-cake' => __( 'birthday-cake', 'buildr' ),
        'fab fa-bitbucket' => __( 'bitbucket', 'buildr' ),
        'fab fa-bitcoin' => __( 'bitcoin', 'buildr' ),
        'fab fa-bity' => __( 'bity', 'buildr' ),
        'fab fa-black-tie' => __( 'black-tie', 'buildr' ),
        'fab fa-blackberry' => __( 'blackberry', 'buildr' ),
        'fas fa-blind' => __( 'blind', 'buildr' ),
        'fab fa-blogger' => __( 'blogger', 'buildr' ),
        'fab fa-blogger-b' => __( 'blogger-b', 'buildr' ),
        'fab fa-bluetooth' => __( 'bluetooth', 'buildr' ),
        'fab fa-bluetooth-b' => __( 'bluetooth-b', 'buildr' ),
        'fas fa-bold' => __( 'bold', 'buildr' ),
        'fas fa-bolt' => __( 'bolt', 'buildr' ),
        'fas fa-bomb' => __( 'bomb', 'buildr' ),
        'fas fa-book' => __( 'book', 'buildr' ),
        'fas fa-bookmark' => __( 'bookmark', 'buildr' ),
        'far fa-bookmark' => __( 'bookmark', 'buildr' ),
        'fas fa-bowling-ball' => __( 'bowling-ball', 'buildr' ),
        'fas fa-box' => __( 'box', 'buildr' ),
        'fas fa-box-open' => __( 'box-open', 'buildr' ),
        'fas fa-boxes' => __( 'boxes', 'buildr' ),
        'fas fa-braille' => __( 'braille', 'buildr' ),
        'fas fa-briefcase' => __( 'briefcase', 'buildr' ),
        'fas fa-briefcase-medical' => __( 'briefcase-medical', 'buildr' ),
        'fab fa-btc' => __( 'btc', 'buildr' ),
        'fas fa-bug' => __( 'bug', 'buildr' ),
        'fas fa-building' => __( 'building', 'buildr' ),
        'far fa-building' => __( 'building', 'buildr' ),
        'fas fa-bullhorn' => __( 'bullhorn', 'buildr' ),
        'fas fa-bullseye' => __( 'bullseye', 'buildr' ),
        'fas fa-burn' => __( 'burn', 'buildr' ),
        'fab fa-buromobelexperte' => __( 'buromobelexperte', 'buildr' ),
        'fas fa-bus' => __( 'bus', 'buildr' ),
        'fab fa-buysellads' => __( 'buysellads', 'buildr' ),
        'fas fa-calculator' => __( 'calculator', 'buildr' ),
        'fas fa-calendar' => __( 'calendar', 'buildr' ),
        'far fa-calendar' => __( 'calendar', 'buildr' ),
        'fas fa-calendar-alt' => __( 'calendar-alt', 'buildr' ),
        'far fa-calendar-alt' => __( 'calendar-alt', 'buildr' ),
        'fas fa-calendar-check' => __( 'calendar-check', 'buildr' ),
        'far fa-calendar-check' => __( 'calendar-check', 'buildr' ),
        'fas fa-calendar-minus' => __( 'calendar-minus', 'buildr' ),
        'far fa-calendar-minus' => __( 'calendar-minus', 'buildr' ),
        'fas fa-calendar-plus' => __( 'calendar-plus', 'buildr' ),
        'far fa-calendar-plus' => __( 'calendar-plus', 'buildr' ),
        'fas fa-calendar-times' => __( 'calendar-times', 'buildr' ),
        'far fa-calendar-times' => __( 'calendar-times', 'buildr' ),
        'fas fa-camera' => __( 'camera', 'buildr' ),
        'fas fa-camera-retro' => __( 'camera-retro', 'buildr' ),
        'fas fa-capsules' => __( 'capsules', 'buildr' ),
        'fas fa-car' => __( 'car', 'buildr' ),
        'fas fa-caret-down' => __( 'caret-down', 'buildr' ),
        'fas fa-caret-left' => __( 'caret-left', 'buildr' ),
        'fas fa-caret-right' => __( 'caret-right', 'buildr' ),
        'fas fa-caret-square-down' => __( 'caret-square-down', 'buildr' ),
        'far fa-caret-square-down' => __( 'caret-square-down', 'buildr' ),
        'fas fa-caret-square-left' => __( 'caret-square-left', 'buildr' ),
        'far fa-caret-square-left' => __( 'caret-square-left', 'buildr' ),
        'fas fa-caret-square-right' => __( 'caret-square-right', 'buildr' ),
        'far fa-caret-square-right' => __( 'caret-square-right', 'buildr' ),
        'fas fa-caret-square-up' => __( 'caret-square-up', 'buildr' ),
        'far fa-caret-square-up' => __( 'caret-square-up', 'buildr' ),
        'fas fa-caret-up' => __( 'caret-up', 'buildr' ),
        'fas fa-cart-arrow-down' => __( 'cart-arrow-down', 'buildr' ),
        'fas fa-cart-plus' => __( 'cart-plus', 'buildr' ),
        'fab fa-cc-amazon-pay' => __( 'cc-amazon-pay', 'buildr' ),
        'fab fa-cc-amex' => __( 'cc-amex', 'buildr' ),
        'fab fa-cc-apple-pay' => __( 'cc-apple-pay', 'buildr' ),
        'fab fa-cc-diners-club' => __( 'cc-diners-club', 'buildr' ),
        'fab fa-cc-discover' => __( 'cc-discover', 'buildr' ),
        'fab fa-cc-jcb' => __( 'cc-jcb', 'buildr' ),
        'fab fa-cc-mastercard' => __( 'cc-mastercard', 'buildr' ),
        'fab fa-cc-paypal' => __( 'cc-paypal', 'buildr' ),
        'fab fa-cc-stripe' => __( 'cc-stripe', 'buildr' ),
        'fab fa-cc-visa' => __( 'cc-visa', 'buildr' ),
        'fab fa-centercode' => __( 'centercode', 'buildr' ),
        'fas fa-certificate' => __( 'certificate', 'buildr' ),
        'fas fa-chart-area' => __( 'chart-area', 'buildr' ),
        'fas fa-chart-bar' => __( 'chart-bar', 'buildr' ),
        'far fa-chart-bar' => __( 'chart-bar', 'buildr' ),
        'fas fa-chart-line' => __( 'chart-line', 'buildr' ),
        'fas fa-chart-pie' => __( 'chart-pie', 'buildr' ),
        'fas fa-check' => __( 'check', 'buildr' ),
        'fas fa-check-circle' => __( 'check-circle', 'buildr' ),
        'far fa-check-circle' => __( 'check-circle', 'buildr' ),
        'fas fa-check-square' => __( 'check-square', 'buildr' ),
        'far fa-check-square' => __( 'check-square', 'buildr' ),
        'fas fa-chess' => __( 'chess', 'buildr' ),
        'fas fa-chess-bishop' => __( 'chess-bishop', 'buildr' ),
        'fas fa-chess-board' => __( 'chess-board', 'buildr' ),
        'fas fa-chess-king' => __( 'chess-king', 'buildr' ),
        'fas fa-chess-knight' => __( 'chess-knight', 'buildr' ),
        'fas fa-chess-pawn' => __( 'chess-pawn', 'buildr' ),
        'fas fa-chess-queen' => __( 'chess-queen', 'buildr' ),
        'fas fa-chess-rook' => __( 'chess-rook', 'buildr' ),
        'fas fa-chevron-circle-down' => __( 'chevron-circle-down', 'buildr' ),
        'fas fa-chevron-circle-left' => __( 'chevron-circle-left', 'buildr' ),
        'fas fa-chevron-circle-right' => __( 'chevron-circle-right', 'buildr' ),
        'fas fa-chevron-circle-up' => __( 'chevron-circle-up', 'buildr' ),
        'fas fa-chevron-down' => __( 'chevron-down', 'buildr' ),
        'fas fa-chevron-left' => __( 'chevron-left', 'buildr' ),
        'fas fa-chevron-right' => __( 'chevron-right', 'buildr' ),
        'fas fa-chevron-up' => __( 'chevron-up', 'buildr' ),
        'fas fa-child' => __( 'child', 'buildr' ),
        'fab fa-chrome' => __( 'chrome', 'buildr' ),
        'fas fa-circle' => __( 'circle', 'buildr' ),
        'far fa-circle' => __( 'circle', 'buildr' ),
        'fas fa-circle-notch' => __( 'circle-notch', 'buildr' ),
        'fas fa-clipboard' => __( 'clipboard', 'buildr' ),
        'far fa-clipboard' => __( 'clipboard', 'buildr' ),
        'fas fa-clipboard-check' => __( 'clipboard-check', 'buildr' ),
        'fas fa-clipboard-list' => __( 'clipboard-list', 'buildr' ),
        'fas fa-clock' => __( 'clock', 'buildr' ),
        'far fa-clock' => __( 'clock', 'buildr' ),
        'fas fa-clone' => __( 'clone', 'buildr' ),
        'far fa-clone' => __( 'clone', 'buildr' ),
        'fas fa-closed-captioning' => __( 'closed-captioning', 'buildr' ),
        'far fa-closed-captioning' => __( 'closed-captioning', 'buildr' ),
        'fas fa-cloud' => __( 'cloud', 'buildr' ),
        'fas fa-cloud-download-alt' => __( 'cloud-download-alt', 'buildr' ),
        'fas fa-cloud-upload-alt' => __( 'cloud-upload-alt', 'buildr' ),
        'fab fa-cloudscale' => __( 'cloudscale', 'buildr' ),
        'fab fa-cloudsmith' => __( 'cloudsmith', 'buildr' ),
        'fab fa-cloudversify' => __( 'cloudversify', 'buildr' ),
        'fas fa-code' => __( 'code', 'buildr' ),
        'fas fa-code-branch' => __( 'code-branch', 'buildr' ),
        'fab fa-codepen' => __( 'codepen', 'buildr' ),
        'fab fa-codiepie' => __( 'codiepie', 'buildr' ),
        'fas fa-coffee' => __( 'coffee', 'buildr' ),
        'fas fa-cog' => __( 'cog', 'buildr' ),
        'fas fa-cogs' => __( 'cogs', 'buildr' ),
        'fas fa-columns' => __( 'columns', 'buildr' ),
        'fas fa-comment' => __( 'comment', 'buildr' ),
        'far fa-comment' => __( 'comment', 'buildr' ),
        'fas fa-comment-alt' => __( 'comment-alt', 'buildr' ),
        'far fa-comment-alt' => __( 'comment-alt', 'buildr' ),
        'fas fa-comment-dots' => __( 'comment-dots', 'buildr' ),
        'fas fa-comment-slash' => __( 'comment-slash', 'buildr' ),
        'fas fa-comments' => __( 'comments', 'buildr' ),
        'far fa-comments' => __( 'comments', 'buildr' ),
        'fas fa-compass' => __( 'compass', 'buildr' ),
        'far fa-compass' => __( 'compass', 'buildr' ),
        'fas fa-compress' => __( 'compress', 'buildr' ),
        'fab fa-connectdevelop' => __( 'connectdevelop', 'buildr' ),
        'fab fa-contao' => __( 'contao', 'buildr' ),
        'fas fa-copy' => __( 'copy', 'buildr' ),
        'far fa-copy' => __( 'copy', 'buildr' ),
        'fas fa-copyright' => __( 'copyright', 'buildr' ),
        'far fa-copyright' => __( 'copyright', 'buildr' ),
        'fas fa-couch' => __( 'couch', 'buildr' ),
        'fab fa-cpanel' => __( 'cpanel', 'buildr' ),
        'fab fa-creative-commons' => __( 'creative-commons', 'buildr' ),
        'fas fa-credit-card' => __( 'credit-card', 'buildr' ),
        'far fa-credit-card' => __( 'credit-card', 'buildr' ),
        'fas fa-crop' => __( 'crop', 'buildr' ),
        'fas fa-crosshairs' => __( 'crosshairs', 'buildr' ),
        'fab fa-css3' => __( 'css3', 'buildr' ),
        'fab fa-css3-alt' => __( 'css3-alt', 'buildr' ),
        'fas fa-cube' => __( 'cube', 'buildr' ),
        'fas fa-cubes' => __( 'cubes', 'buildr' ),
        'fas fa-cut' => __( 'cut', 'buildr' ),
        'fab fa-cuttlefish' => __( 'cuttlefish', 'buildr' ),
        'fab fa-d-and-d' => __( 'd-and-d', 'buildr' ),
        'fab fa-dashcube' => __( 'dashcube', 'buildr' ),
        'fas fa-database' => __( 'database', 'buildr' ),
        'fas fa-deaf' => __( 'deaf', 'buildr' ),
        'fab fa-delicious' => __( 'delicious', 'buildr' ),
        'fab fa-deploydog' => __( 'deploydog', 'buildr' ),
        'fab fa-deskpro' => __( 'deskpro', 'buildr' ),
        'fas fa-desktop' => __( 'desktop', 'buildr' ),
        'fab fa-deviantart' => __( 'deviantart', 'buildr' ),
        'fas fa-diagnoses' => __( 'diagnoses', 'buildr' ),
        'fab fa-digg' => __( 'digg', 'buildr' ),
        'fab fa-digital-ocean' => __( 'digital-ocean', 'buildr' ),
        'fab fa-discord' => __( 'discord', 'buildr' ),
        'fab fa-discourse' => __( 'discourse', 'buildr' ),
        'fas fa-dna' => __( 'dna', 'buildr' ),
        'fab fa-dochub' => __( 'dochub', 'buildr' ),
        'fab fa-docker' => __( 'docker', 'buildr' ),
        'fas fa-dollar-sign' => __( 'dollar-sign', 'buildr' ),
        'fas fa-dolly' => __( 'dolly', 'buildr' ),
        'fas fa-dolly-flatbed' => __( 'dolly-flatbed', 'buildr' ),
        'fas fa-donate' => __( 'donate', 'buildr' ),
        'fas fa-dot-circle' => __( 'dot-circle', 'buildr' ),
        'far fa-dot-circle' => __( 'dot-circle', 'buildr' ),
        'fas fa-dove' => __( 'dove', 'buildr' ),
        'fas fa-download' => __( 'download', 'buildr' ),
        'fab fa-draft2digital' => __( 'draft2digital', 'buildr' ),
        'fab fa-dribbble' => __( 'dribbble', 'buildr' ),
        'fab fa-dribbble-square' => __( 'dribbble-square', 'buildr' ),
        'fab fa-dropbox' => __( 'dropbox', 'buildr' ),
        'fab fa-drupal' => __( 'drupal', 'buildr' ),
        'fab fa-dyalog' => __( 'dyalog', 'buildr' ),
        'fab fa-earlybirds' => __( 'earlybirds', 'buildr' ),
        'fab fa-edge' => __( 'edge', 'buildr' ),
        'fas fa-edit' => __( 'edit', 'buildr' ),
        'far fa-edit' => __( 'edit', 'buildr' ),
        'fas fa-eject' => __( 'eject', 'buildr' ),
        'fab fa-elementor' => __( 'elementor', 'buildr' ),
        'fas fa-ellipsis-h' => __( 'ellipsis-h', 'buildr' ),
        'fas fa-ellipsis-v' => __( 'ellipsis-v', 'buildr' ),
        'fab fa-ember' => __( 'ember', 'buildr' ),
        'fab fa-empire' => __( 'empire', 'buildr' ),
        'fas fa-envelope' => __( 'envelope', 'buildr' ),
        'far fa-envelope' => __( 'envelope', 'buildr' ),
        'fas fa-envelope-open' => __( 'envelope-open', 'buildr' ),
        'far fa-envelope-open' => __( 'envelope-open', 'buildr' ),
        'fas fa-envelope-square' => __( 'envelope-square', 'buildr' ),
        'fab fa-envira' => __( 'envira', 'buildr' ),
        'fas fa-eraser' => __( 'eraser', 'buildr' ),
        'fab fa-erlang' => __( 'erlang', 'buildr' ),
        'fab fa-ethereum' => __( 'ethereum', 'buildr' ),
        'fab fa-etsy' => __( 'etsy', 'buildr' ),
        'fas fa-euro-sign' => __( 'euro-sign', 'buildr' ),
        'fas fa-exchange-alt' => __( 'exchange-alt', 'buildr' ),
        'fas fa-exclamation' => __( 'exclamation', 'buildr' ),
        'fas fa-exclamation-circle' => __( 'exclamation-circle', 'buildr' ),
        'fas fa-exclamation-triangle' => __( 'exclamation-triangle', 'buildr' ),
        'fas fa-expand' => __( 'expand', 'buildr' ),
        'fas fa-expand-arrows-alt' => __( 'expand-arrows-alt', 'buildr' ),
        'fab fa-expeditedssl' => __( 'expeditedssl', 'buildr' ),
        'fas fa-external-link-alt' => __( 'external-link-alt', 'buildr' ),
        'fas fa-external-link-square-alt' => __( 'external-link-square-alt', 'buildr' ),
        'fas fa-eye' => __( 'eye', 'buildr' ),
        'fas fa-eye-dropper' => __( 'eye-dropper', 'buildr' ),
        'fas fa-eye-slash' => __( 'eye-slash', 'buildr' ),
        'far fa-eye-slash' => __( 'eye-slash', 'buildr' ),
        'fab fa-facebook' => __( 'facebook', 'buildr' ),
        'fab fa-facebook-f' => __( 'facebook-f', 'buildr' ),
        'fab fa-facebook-messenger' => __( 'facebook-messenger', 'buildr' ),
        'fab fa-facebook-square' => __( 'facebook-square', 'buildr' ),
        'fas fa-fast-backward' => __( 'fast-backward', 'buildr' ),
        'fas fa-fast-forward' => __( 'fast-forward', 'buildr' ),
        'fas fa-fax' => __( 'fax', 'buildr' ),
        'fas fa-female' => __( 'female', 'buildr' ),
        'fas fa-fighter-jet' => __( 'fighter-jet', 'buildr' ),
        'fas fa-file' => __( 'file', 'buildr' ),
        'far fa-file' => __( 'file', 'buildr' ),
        'fas fa-file-alt' => __( 'file-alt', 'buildr' ),
        'far fa-file-alt' => __( 'file-alt', 'buildr' ),
        'fas fa-file-archive' => __( 'file-archive', 'buildr' ),
        'far fa-file-archive' => __( 'file-archive', 'buildr' ),
        'fas fa-file-audio' => __( 'file-audio', 'buildr' ),
        'far fa-file-audio' => __( 'file-audio', 'buildr' ),
        'fas fa-file-code' => __( 'file-code', 'buildr' ),
        'far fa-file-code' => __( 'file-code', 'buildr' ),
        'fas fa-file-excel' => __( 'file-excel', 'buildr' ),
        'far fa-file-excel' => __( 'file-excel', 'buildr' ),
        'fas fa-file-image' => __( 'file-image', 'buildr' ),
        'far fa-file-image' => __( 'file-image', 'buildr' ),
        'fas fa-file-medical' => __( 'file-medical', 'buildr' ),
        'fas fa-file-medical-alt' => __( 'file-medical-alt', 'buildr' ),
        'fas fa-file-pdf' => __( 'file-pdf', 'buildr' ),
        'far fa-file-pdf' => __( 'file-pdf', 'buildr' ),
        'fas fa-file-powerpoint' => __( 'file-powerpoint', 'buildr' ),
        'far fa-file-powerpoint' => __( 'file-powerpoint', 'buildr' ),
        'fas fa-file-video' => __( 'file-video', 'buildr' ),
        'far fa-file-video' => __( 'file-video', 'buildr' ),
        'fas fa-file-word' => __( 'file-word', 'buildr' ),
        'far fa-file-word' => __( 'file-word', 'buildr' ),
        'fas fa-film' => __( 'film', 'buildr' ),
        'fas fa-filter' => __( 'filter', 'buildr' ),
        'fas fa-fire' => __( 'fire', 'buildr' ),
        'fas fa-fire-extinguisher' => __( 'fire-extinguisher', 'buildr' ),
        'fab fa-firefox' => __( 'firefox', 'buildr' ),
        'fas fa-first-aid' => __( 'first-aid', 'buildr' ),
        'fab fa-first-order' => __( 'first-order', 'buildr' ),
        'fab fa-firstdraft' => __( 'firstdraft', 'buildr' ),
        'fas fa-flag' => __( 'flag', 'buildr' ),
        'far fa-flag' => __( 'flag', 'buildr' ),
        'fas fa-flag-checkered' => __( 'flag-checkered', 'buildr' ),
        'fas fa-flask' => __( 'flask', 'buildr' ),
        'fab fa-flickr' => __( 'flickr', 'buildr' ),
        'fab fa-flipboard' => __( 'flipboard', 'buildr' ),
        'fab fa-fly' => __( 'fly', 'buildr' ),
        'fas fa-folder' => __( 'folder', 'buildr' ),
        'far fa-folder' => __( 'folder', 'buildr' ),
        'fas fa-folder-open' => __( 'folder-open', 'buildr' ),
        'far fa-folder-open' => __( 'folder-open', 'buildr' ),
        'fas fa-font' => __( 'font', 'buildr' ),
        'fab fa-font-awesome' => __( 'font-awesome', 'buildr' ),
        'fab fa-font-awesome-alt' => __( 'font-awesome-alt', 'buildr' ),
        'fab fa-font-awesome-flag' => __( 'font-awesome-flag', 'buildr' ),
        'fab fa-fonticons' => __( 'fonticons', 'buildr' ),
        'fab fa-fonticons-fi' => __( 'fonticons-fi', 'buildr' ),
        'fas fa-football-ball' => __( 'football-ball', 'buildr' ),
        'fab fa-fort-awesome' => __( 'fort-awesome', 'buildr' ),
        'fab fa-fort-awesome-alt' => __( 'fort-awesome-alt', 'buildr' ),
        'fab fa-forumbee' => __( 'forumbee', 'buildr' ),
        'fas fa-forward' => __( 'forward', 'buildr' ),
        'fab fa-foursquare' => __( 'foursquare', 'buildr' ),
        'fab fa-free-code-camp' => __( 'free-code-camp', 'buildr' ),
        'fab fa-freebsd' => __( 'freebsd', 'buildr' ),
        'fas fa-frown' => __( 'frown', 'buildr' ),
        'far fa-frown' => __( 'frown', 'buildr' ),
        'fas fa-futbol' => __( 'futbol', 'buildr' ),
        'far fa-futbol' => __( 'futbol', 'buildr' ),
        'fas fa-gamepad' => __( 'gamepad', 'buildr' ),
        'fas fa-gavel' => __( 'gavel', 'buildr' ),
        'fas fa-gem' => __( 'gem', 'buildr' ),
        'far fa-gem' => __( 'gem', 'buildr' ),
        'fas fa-genderless' => __( 'genderless', 'buildr' ),
        'fab fa-get-pocket' => __( 'get-pocket', 'buildr' ),
        'fab fa-gg' => __( 'gg', 'buildr' ),
        'fab fa-gg-circle' => __( 'gg-circle', 'buildr' ),
        'fas fa-gift' => __( 'gift', 'buildr' ),
        'fab fa-git' => __( 'git', 'buildr' ),
        'fab fa-git-square' => __( 'git-square', 'buildr' ),
        'fab fa-github' => __( 'github', 'buildr' ),
        'fab fa-github-alt' => __( 'github-alt', 'buildr' ),
        'fab fa-github-square' => __( 'github-square', 'buildr' ),
        'fab fa-gitkraken' => __( 'gitkraken', 'buildr' ),
        'fab fa-gitlab' => __( 'gitlab', 'buildr' ),
        'fab fa-gitter' => __( 'gitter', 'buildr' ),
        'fas fa-glass-martini' => __( 'glass-martini', 'buildr' ),
        'fab fa-glide' => __( 'glide', 'buildr' ),
        'fab fa-glide-g' => __( 'glide-g', 'buildr' ),
        'fas fa-globe' => __( 'globe', 'buildr' ),
        'fab fa-gofore' => __( 'gofore', 'buildr' ),
        'fas fa-golf-ball' => __( 'golf-ball', 'buildr' ),
        'fab fa-goodreads' => __( 'goodreads', 'buildr' ),
        'fab fa-goodreads-g' => __( 'goodreads-g', 'buildr' ),
        'fab fa-google' => __( 'google', 'buildr' ),
        'fab fa-google-drive' => __( 'google-drive', 'buildr' ),
        'fab fa-google-play' => __( 'google-play', 'buildr' ),
        'fab fa-google-plus' => __( 'google-plus', 'buildr' ),
        'fab fa-google-plus-g' => __( 'google-plus-g', 'buildr' ),
        'fab fa-google-plus-square' => __( 'google-plus-square', 'buildr' ),
        'fab fa-google-wallet' => __( 'google-wallet', 'buildr' ),
        'fas fa-graduation-cap' => __( 'graduation-cap', 'buildr' ),
        'fab fa-gratipay' => __( 'gratipay', 'buildr' ),
        'fab fa-grav' => __( 'grav', 'buildr' ),
        'fab fa-gripfire' => __( 'gripfire', 'buildr' ),
        'fab fa-grunt' => __( 'grunt', 'buildr' ),
        'fab fa-gulp' => __( 'gulp', 'buildr' ),
        'fas fa-h-square' => __( 'h-square', 'buildr' ),
        'fab fa-hacker-news' => __( 'hacker-news', 'buildr' ),
        'fab fa-hacker-news-square' => __( 'hacker-news-square', 'buildr' ),
        'fas fa-hand-holding' => __( 'hand-holding', 'buildr' ),
        'fas fa-hand-holding-heart' => __( 'hand-holding-heart', 'buildr' ),
        'fas fa-hand-holding-usd' => __( 'hand-holding-usd', 'buildr' ),
        'fas fa-hand-lizard' => __( 'hand-lizard', 'buildr' ),
        'far fa-hand-lizard' => __( 'hand-lizard', 'buildr' ),
        'fas fa-hand-paper' => __( 'hand-paper', 'buildr' ),
        'far fa-hand-paper' => __( 'hand-paper', 'buildr' ),
        'fas fa-hand-peace' => __( 'hand-peace', 'buildr' ),
        'far fa-hand-peace' => __( 'hand-peace', 'buildr' ),
        'fas fa-hand-point-down' => __( 'hand-point-down', 'buildr' ),
        'far fa-hand-point-down' => __( 'hand-point-down', 'buildr' ),
        'fas fa-hand-point-left' => __( 'hand-point-left', 'buildr' ),
        'far fa-hand-point-left' => __( 'hand-point-left', 'buildr' ),
        'fas fa-hand-point-right' => __( 'hand-point-right', 'buildr' ),
        'far fa-hand-point-right' => __( 'hand-point-right', 'buildr' ),
        'fas fa-hand-point-up' => __( 'hand-point-up', 'buildr' ),
        'far fa-hand-point-up' => __( 'hand-point-up', 'buildr' ),
        'fas fa-hand-pointer' => __( 'hand-pointer', 'buildr' ),
        'far fa-hand-pointer' => __( 'hand-pointer', 'buildr' ),
        'fas fa-hand-rock' => __( 'hand-rock', 'buildr' ),
        'far fa-hand-rock' => __( 'hand-rock', 'buildr' ),
        'fas fa-hand-scissors' => __( 'hand-scissors', 'buildr' ),
        'far fa-hand-scissors' => __( 'hand-scissors', 'buildr' ),
        'fas fa-hand-spock' => __( 'hand-spock', 'buildr' ),
        'far fa-hand-spock' => __( 'hand-spock', 'buildr' ),
        'fas fa-hands' => __( 'hands', 'buildr' ),
        'fas fa-hands-helping' => __( 'hands-helping', 'buildr' ),
        'fas fa-handshake' => __( 'handshake', 'buildr' ),
        'far fa-handshake' => __( 'handshake', 'buildr' ),
        'fas fa-hashtag' => __( 'hashtag', 'buildr' ),
        'fas fa-hdd' => __( 'hdd', 'buildr' ),
        'far fa-hdd' => __( 'hdd', 'buildr' ),
        'fas fa-heading' => __( 'heading', 'buildr' ),
        'fas fa-headphones' => __( 'headphones', 'buildr' ),
        'fas fa-heart' => __( 'heart', 'buildr' ),
        'far fa-heart' => __( 'heart', 'buildr' ),
        'fas fa-heartbeat' => __( 'heartbeat', 'buildr' ),
        'fab fa-hips' => __( 'hips', 'buildr' ),
        'fab fa-hire-a-helper' => __( 'hire-a-helper', 'buildr' ),
        'fas fa-history' => __( 'history', 'buildr' ),
        'fas fa-hockey-puck' => __( 'hockey-puck', 'buildr' ),
        'fas fa-home' => __( 'home', 'buildr' ),
        'fab fa-hooli' => __( 'hooli', 'buildr' ),
        'fas fa-hospital' => __( 'hospital', 'buildr' ),
        'far fa-hospital' => __( 'hospital', 'buildr' ),
        'fas fa-hospital-alt' => __( 'hospital-alt', 'buildr' ),
        'fas fa-hospital-symbol' => __( 'hospital-symbol', 'buildr' ),
        'fab fa-hotjar' => __( 'hotjar', 'buildr' ),
        'fas fa-hourglass' => __( 'hourglass', 'buildr' ),
        'far fa-hourglass' => __( 'hourglass', 'buildr' ),
        'fas fa-hourglass-end' => __( 'hourglass-end', 'buildr' ),
        'fas fa-hourglass-half' => __( 'hourglass-half', 'buildr' ),
        'fas fa-hourglass-start' => __( 'hourglass-start', 'buildr' ),
        'fab fa-houzz' => __( 'houzz', 'buildr' ),
        'fab fa-html5' => __( 'html5', 'buildr' ),
        'fab fa-hubspot' => __( 'hubspot', 'buildr' ),
        'fas fa-i-cursor' => __( 'i-cursor', 'buildr' ),
        'fas fa-id-badge' => __( 'id-badge', 'buildr' ),
        'far fa-id-badge' => __( 'id-badge', 'buildr' ),
        'fas fa-id-card' => __( 'id-card', 'buildr' ),
        'far fa-id-card' => __( 'id-card', 'buildr' ),
        'fas fa-id-card-alt' => __( 'id-card-alt', 'buildr' ),
        'fas fa-image' => __( 'image', 'buildr' ),
        'far fa-image' => __( 'image', 'buildr' ),
        'fas fa-images' => __( 'images', 'buildr' ),
        'far fa-images' => __( 'images', 'buildr' ),
        'fab fa-imdb' => __( 'imdb', 'buildr' ),
        'fas fa-inbox' => __( 'inbox', 'buildr' ),
        'fas fa-indent' => __( 'indent', 'buildr' ),
        'fas fa-industry' => __( 'industry', 'buildr' ),
        'fas fa-info' => __( 'info', 'buildr' ),
        'fas fa-info-circle' => __( 'info-circle', 'buildr' ),
        'fab fa-instagram' => __( 'instagram', 'buildr' ),
        'fab fa-internet-explorer' => __( 'internet-explorer', 'buildr' ),
        'fab fa-ioxhost' => __( 'ioxhost', 'buildr' ),
        'fas fa-italic' => __( 'italic', 'buildr' ),
        'fab fa-itunes' => __( 'itunes', 'buildr' ),
        'fab fa-itunes-note' => __( 'itunes-note', 'buildr' ),
        'fab fa-java' => __( 'java', 'buildr' ),
        'fab fa-jenkins' => __( 'jenkins', 'buildr' ),
        'fab fa-joget' => __( 'joget', 'buildr' ),
        'fab fa-joomla' => __( 'joomla', 'buildr' ),
        'fab fa-js' => __( 'js', 'buildr' ),
        'fab fa-js-square' => __( 'js-square', 'buildr' ),
        'fab fa-jsfiddle' => __( 'jsfiddle', 'buildr' ),
        'fas fa-key' => __( 'key', 'buildr' ),
        'fas fa-keyboard' => __( 'keyboard', 'buildr' ),
        'far fa-keyboard' => __( 'keyboard', 'buildr' ),
        'fab fa-keycdn' => __( 'keycdn', 'buildr' ),
        'fab fa-kickstarter' => __( 'kickstarter', 'buildr' ),
        'fab fa-kickstarter-k' => __( 'kickstarter-k', 'buildr' ),
        'fab fa-korvue' => __( 'korvue', 'buildr' ),
        'fas fa-language' => __( 'language', 'buildr' ),
        'fas fa-laptop' => __( 'laptop', 'buildr' ),
        'fab fa-laravel' => __( 'laravel', 'buildr' ),
        'fab fa-lastfm' => __( 'lastfm', 'buildr' ),
        'fab fa-lastfm-square' => __( 'lastfm-square', 'buildr' ),
        'fas fa-leaf' => __( 'leaf', 'buildr' ),
        'fab fa-leanpub' => __( 'leanpub', 'buildr' ),
        'fas fa-lemon' => __( 'lemon', 'buildr' ),
        'far fa-lemon' => __( 'lemon', 'buildr' ),
        'fab fa-less' => __( 'less', 'buildr' ),
        'fas fa-level-down-alt' => __( 'level-down-alt', 'buildr' ),
        'fas fa-level-up-alt' => __( 'level-up-alt', 'buildr' ),
        'fas fa-life-ring' => __( 'life-ring', 'buildr' ),
        'far fa-life-ring' => __( 'life-ring', 'buildr' ),
        'fas fa-lightbulb' => __( 'lightbulb', 'buildr' ),
        'far fa-lightbulb' => __( 'lightbulb', 'buildr' ),
        'fab fa-line' => __( 'line', 'buildr' ),
        'fas fa-link' => __( 'link', 'buildr' ),
        'fab fa-linkedin' => __( 'linkedin', 'buildr' ),
        'fab fa-linkedin-in' => __( 'linkedin-in', 'buildr' ),
        'fab fa-linode' => __( 'linode', 'buildr' ),
        'fab fa-linux' => __( 'linux', 'buildr' ),
        'fas fa-lira-sign' => __( 'lira-sign', 'buildr' ),
        'fas fa-list' => __( 'list', 'buildr' ),
        'fas fa-list-alt' => __( 'list-alt', 'buildr' ),
        'far fa-list-alt' => __( 'list-alt', 'buildr' ),
        'fas fa-list-ol' => __( 'list-ol', 'buildr' ),
        'fas fa-list-ul' => __( 'list-ul', 'buildr' ),
        'fas fa-location-arrow' => __( 'location-arrow', 'buildr' ),
        'fas fa-lock' => __( 'lock', 'buildr' ),
        'fas fa-lock-open' => __( 'lock-open', 'buildr' ),
        'fas fa-long-arrow-alt-down' => __( 'long-arrow-alt-down', 'buildr' ),
        'fas fa-long-arrow-alt-left' => __( 'long-arrow-alt-left', 'buildr' ),
        'fas fa-long-arrow-alt-right' => __( 'long-arrow-alt-right', 'buildr' ),
        'fas fa-long-arrow-alt-up' => __( 'long-arrow-alt-up', 'buildr' ),
        'fas fa-low-vision' => __( 'low-vision', 'buildr' ),
        'fab fa-lyft' => __( 'lyft', 'buildr' ),
        'fab fa-magento' => __( 'magento', 'buildr' ),
        'fas fa-magic' => __( 'magic', 'buildr' ),
        'fas fa-magnet' => __( 'magnet', 'buildr' ),
        'fas fa-male' => __( 'male', 'buildr' ),
        'fas fa-map' => __( 'map', 'buildr' ),
        'far fa-map' => __( 'map', 'buildr' ),
        'fas fa-map-marker' => __( 'map-marker', 'buildr' ),
        'fas fa-map-marker-alt' => __( 'map-marker-alt', 'buildr' ),
        'fas fa-map-pin' => __( 'map-pin', 'buildr' ),
        'fas fa-map-signs' => __( 'map-signs', 'buildr' ),
        'fas fa-mars' => __( 'mars', 'buildr' ),
        'fas fa-mars-double' => __( 'mars-double', 'buildr' ),
        'fas fa-mars-stroke' => __( 'mars-stroke', 'buildr' ),
        'fas fa-mars-stroke-h' => __( 'mars-stroke-h', 'buildr' ),
        'fas fa-mars-stroke-v' => __( 'mars-stroke-v', 'buildr' ),
        'fab fa-maxcdn' => __( 'maxcdn', 'buildr' ),
        'fab fa-medapps' => __( 'medapps', 'buildr' ),
        'fab fa-medium' => __( 'medium', 'buildr' ),
        'fab fa-medium-m' => __( 'medium-m', 'buildr' ),
        'fas fa-medkit' => __( 'medkit', 'buildr' ),
        'fab fa-medrt' => __( 'medrt', 'buildr' ),
        'fab fa-meetup' => __( 'meetup', 'buildr' ),
        'fas fa-meh' => __( 'meh', 'buildr' ),
        'far fa-meh' => __( 'meh', 'buildr' ),
        'fas fa-mercury' => __( 'mercury', 'buildr' ),
        'fas fa-microchip' => __( 'microchip', 'buildr' ),
        'fas fa-microphone' => __( 'microphone', 'buildr' ),
        'fas fa-microphone-slash' => __( 'microphone-slash', 'buildr' ),
        'fab fa-microsoft' => __( 'microsoft', 'buildr' ),
        'fas fa-minus' => __( 'minus', 'buildr' ),
        'fas fa-minus-circle' => __( 'minus-circle', 'buildr' ),
        'fas fa-minus-square' => __( 'minus-square', 'buildr' ),
        'far fa-minus-square' => __( 'minus-square', 'buildr' ),
        'fab fa-mix' => __( 'mix', 'buildr' ),
        'fab fa-mixcloud' => __( 'mixcloud', 'buildr' ),
        'fab fa-mizuni' => __( 'mizuni', 'buildr' ),
        'fas fa-mobile' => __( 'mobile', 'buildr' ),
        'fas fa-mobile-alt' => __( 'mobile-alt', 'buildr' ),
        'fab fa-modx' => __( 'modx', 'buildr' ),
        'fab fa-monero' => __( 'monero', 'buildr' ),
        'fas fa-money-bill-alt' => __( 'money-bill-alt', 'buildr' ),
        'far fa-money-bill-alt' => __( 'money-bill-alt', 'buildr' ),
        'fas fa-moon' => __( 'moon', 'buildr' ),
        'far fa-moon' => __( 'moon', 'buildr' ),
        'fas fa-motorcycle' => __( 'motorcycle', 'buildr' ),
        'fas fa-mouse-pointer' => __( 'mouse-pointer', 'buildr' ),
        'fas fa-music' => __( 'music', 'buildr' ),
        'fab fa-napster' => __( 'napster', 'buildr' ),
        'fas fa-neuter' => __( 'neuter', 'buildr' ),
        'fas fa-newspaper' => __( 'newspaper', 'buildr' ),
        'far fa-newspaper' => __( 'newspaper', 'buildr' ),
        'fab fa-nintendo-switch' => __( 'nintendo-switch', 'buildr' ),
        'fab fa-node' => __( 'node', 'buildr' ),
        'fab fa-node-js' => __( 'node-js', 'buildr' ),
        'fas fa-notes-medical' => __( 'notes-medical', 'buildr' ),
        'fab fa-npm' => __( 'npm', 'buildr' ),
        'fab fa-ns8' => __( 'ns8', 'buildr' ),
        'fab fa-nutritionix' => __( 'nutritionix', 'buildr' ),
        'fas fa-object-group' => __( 'object-group', 'buildr' ),
        'far fa-object-group' => __( 'object-group', 'buildr' ),
        'fas fa-object-ungroup' => __( 'object-ungroup', 'buildr' ),
        'far fa-object-ungroup' => __( 'object-ungroup', 'buildr' ),
        'fab fa-odnoklassniki' => __( 'odnoklassniki', 'buildr' ),
        'fab fa-odnoklassniki-square' => __( 'odnoklassniki-square', 'buildr' ),
        'fab fa-opencart' => __( 'opencart', 'buildr' ),
        'fab fa-openid' => __( 'openid', 'buildr' ),
        'fab fa-opera' => __( 'opera', 'buildr' ),
        'fab fa-optin-monster' => __( 'optin-monster', 'buildr' ),
        'fab fa-osi' => __( 'osi', 'buildr' ),
        'fas fa-outdent' => __( 'outdent', 'buildr' ),
        'fab fa-page4' => __( 'page4', 'buildr' ),
        'fab fa-pagelines' => __( 'pagelines', 'buildr' ),
        'fas fa-paint-brush' => __( 'paint-brush', 'buildr' ),
        'fab fa-palfed' => __( 'palfed', 'buildr' ),
        'fas fa-pallet' => __( 'pallet', 'buildr' ),
        'fas fa-paper-plane' => __( 'paper-plane', 'buildr' ),
        'far fa-paper-plane' => __( 'paper-plane', 'buildr' ),
        'fas fa-paperclip' => __( 'paperclip', 'buildr' ),
        'fas fa-parachute-box' => __( 'parachute-box', 'buildr' ),
        'fas fa-paragraph' => __( 'paragraph', 'buildr' ),
        'fas fa-paste' => __( 'paste', 'buildr' ),
        'fab fa-patreon' => __( 'patreon', 'buildr' ),
        'fas fa-pause' => __( 'pause', 'buildr' ),
        'fas fa-pause-circle' => __( 'pause-circle', 'buildr' ),
        'far fa-pause-circle' => __( 'pause-circle', 'buildr' ),
        'fas fa-paw' => __( 'paw', 'buildr' ),
        'fab fa-paypal' => __( 'paypal', 'buildr' ),
        'fas fa-pen-square' => __( 'pen-square', 'buildr' ),
        'fas fa-pencil-alt' => __( 'pencil-alt', 'buildr' ),
        'fas fa-people-carry' => __( 'people-carry', 'buildr' ),
        'fas fa-percent' => __( 'percent', 'buildr' ),
        'fab fa-periscope' => __( 'periscope', 'buildr' ),
        'fab fa-phabricator' => __( 'phabricator', 'buildr' ),
        'fab fa-phoenix-framework' => __( 'phoenix-framework', 'buildr' ),
        'fas fa-phone' => __( 'phone', 'buildr' ),
        'fas fa-phone-slash' => __( 'phone-slash', 'buildr' ),
        'fas fa-phone-square' => __( 'phone-square', 'buildr' ),
        'fas fa-phone-volume' => __( 'phone-volume', 'buildr' ),
        'fab fa-php' => __( 'php', 'buildr' ),
        'fab fa-pied-piper' => __( 'pied-piper', 'buildr' ),
        'fab fa-pied-piper-alt' => __( 'pied-piper-alt', 'buildr' ),
        'fab fa-pied-piper-hat' => __( 'pied-piper-hat', 'buildr' ),
        'fab fa-pied-piper-pp' => __( 'pied-piper-pp', 'buildr' ),
        'fas fa-piggy-bank' => __( 'piggy-bank', 'buildr' ),
        'fas fa-pills' => __( 'pills', 'buildr' ),
        'fab fa-pinterest' => __( 'pinterest', 'buildr' ),
        'fab fa-pinterest-p' => __( 'pinterest-p', 'buildr' ),
        'fab fa-pinterest-square' => __( 'pinterest-square', 'buildr' ),
        'fas fa-plane' => __( 'plane', 'buildr' ),
        'fas fa-play' => __( 'play', 'buildr' ),
        'fas fa-play-circle' => __( 'play-circle', 'buildr' ),
        'far fa-play-circle' => __( 'play-circle', 'buildr' ),
        'fab fa-playstation' => __( 'playstation', 'buildr' ),
        'fas fa-plug' => __( 'plug', 'buildr' ),
        'fas fa-plus' => __( 'plus', 'buildr' ),
        'fas fa-plus-circle' => __( 'plus-circle', 'buildr' ),
        'fas fa-plus-square' => __( 'plus-square', 'buildr' ),
        'far fa-plus-square' => __( 'plus-square', 'buildr' ),
        'fas fa-podcast' => __( 'podcast', 'buildr' ),
        'fas fa-poo' => __( 'poo', 'buildr' ),
        'fas fa-pound-sign' => __( 'pound-sign', 'buildr' ),
        'fas fa-power-off' => __( 'power-off', 'buildr' ),
        'fas fa-prescription-bottle' => __( 'prescription-bottle', 'buildr' ),
        'fas fa-prescription-bottle-alt' => __( 'prescription-bottle-alt', 'buildr' ),
        'fas fa-print' => __( 'print', 'buildr' ),
        'fas fa-procedures' => __( 'procedures', 'buildr' ),
        'fab fa-product-hunt' => __( 'product-hunt', 'buildr' ),
        'fab fa-pushed' => __( 'pushed', 'buildr' ),
        'fas fa-puzzle-piece' => __( 'puzzle-piece', 'buildr' ),
        'fab fa-python' => __( 'python', 'buildr' ),
        'fab fa-qq' => __( 'qq', 'buildr' ),
        'fas fa-qrcode' => __( 'qrcode', 'buildr' ),
        'fas fa-question' => __( 'question', 'buildr' ),
        'fas fa-question-circle' => __( 'question-circle', 'buildr' ),
        'far fa-question-circle' => __( 'question-circle', 'buildr' ),
        'fas fa-quidditch' => __( 'quidditch', 'buildr' ),
        'fab fa-quinscape' => __( 'quinscape', 'buildr' ),
        'fab fa-quora' => __( 'quora', 'buildr' ),
        'fas fa-quote-left' => __( 'quote-left', 'buildr' ),
        'fas fa-quote-right' => __( 'quote-right', 'buildr' ),
        'fas fa-random' => __( 'random', 'buildr' ),
        'fab fa-ravelry' => __( 'ravelry', 'buildr' ),
        'fab fa-react' => __( 'react', 'buildr' ),
        'fab fa-readme' => __( 'readme', 'buildr' ),
        'fab fa-rebel' => __( 'rebel', 'buildr' ),
        'fas fa-recycle' => __( 'recycle', 'buildr' ),
        'fab fa-red-river' => __( 'red-river', 'buildr' ),
        'fab fa-reddit' => __( 'reddit', 'buildr' ),
        'fab fa-reddit-alien' => __( 'reddit-alien', 'buildr' ),
        'fab fa-reddit-square' => __( 'reddit-square', 'buildr' ),
        'fas fa-redo' => __( 'redo', 'buildr' ),
        'fas fa-redo-alt' => __( 'redo-alt', 'buildr' ),
        'fas fa-registered' => __( 'registered', 'buildr' ),
        'far fa-registered' => __( 'registered', 'buildr' ),
        'fab fa-rendact' => __( 'rendact', 'buildr' ),
        'fab fa-renren' => __( 'renren', 'buildr' ),
        'fas fa-reply' => __( 'reply', 'buildr' ),
        'fas fa-reply-all' => __( 'reply-all', 'buildr' ),
        'fab fa-replyd' => __( 'replyd', 'buildr' ),
        'fab fa-resolving' => __( 'resolving', 'buildr' ),
        'fas fa-retweet' => __( 'retweet', 'buildr' ),
        'fas fa-ribbon' => __( 'ribbon', 'buildr' ),
        'fas fa-road' => __( 'road', 'buildr' ),
        'fas fa-rocket' => __( 'rocket', 'buildr' ),
        'fab fa-rocketchat' => __( 'rocketchat', 'buildr' ),
        'fab fa-rockrms' => __( 'rockrms', 'buildr' ),
        'fas fa-rss' => __( 'rss', 'buildr' ),
        'fas fa-rss-square' => __( 'rss-square', 'buildr' ),
        'fas fa-ruble-sign' => __( 'ruble-sign', 'buildr' ),
        'fas fa-rupee-sign' => __( 'rupee-sign', 'buildr' ),
        'fab fa-safari' => __( 'safari', 'buildr' ),
        'fab fa-sass' => __( 'sass', 'buildr' ),
        'fas fa-save' => __( 'save', 'buildr' ),
        'far fa-save' => __( 'save', 'buildr' ),
        'fab fa-schlix' => __( 'schlix', 'buildr' ),
        'fab fa-scribd' => __( 'scribd', 'buildr' ),
        'fas fa-search' => __( 'search', 'buildr' ),
        'fas fa-search-minus' => __( 'search-minus', 'buildr' ),
        'fas fa-search-plus' => __( 'search-plus', 'buildr' ),
        'fab fa-searchengin' => __( 'searchengin', 'buildr' ),
        'fas fa-seedling' => __( 'seedling', 'buildr' ),
        'fab fa-sellcast' => __( 'sellcast', 'buildr' ),
        'fab fa-sellsy' => __( 'sellsy', 'buildr' ),
        'fas fa-server' => __( 'server', 'buildr' ),
        'fab fa-servicestack' => __( 'servicestack', 'buildr' ),
        'fas fa-share' => __( 'share', 'buildr' ),
        'fas fa-share-alt' => __( 'share-alt', 'buildr' ),
        'fas fa-share-alt-square' => __( 'share-alt-square', 'buildr' ),
        'fas fa-share-square' => __( 'share-square', 'buildr' ),
        'far fa-share-square' => __( 'share-square', 'buildr' ),
        'fas fa-shekel-sign' => __( 'shekel-sign', 'buildr' ),
        'fas fa-shield-alt' => __( 'shield-alt', 'buildr' ),
        'fas fa-ship' => __( 'ship', 'buildr' ),
        'fas fa-shipping-fast' => __( 'shipping-fast', 'buildr' ),
        'fab fa-shirtsinbulk' => __( 'shirtsinbulk', 'buildr' ),
        'fas fa-shopping-bag' => __( 'shopping-bag', 'buildr' ),
        'fas fa-shopping-basket' => __( 'shopping-basket', 'buildr' ),
        'fas fa-shopping-cart' => __( 'shopping-cart', 'buildr' ),
        'fas fa-shower' => __( 'shower', 'buildr' ),
        'fas fa-sign' => __( 'sign', 'buildr' ),
        'fas fa-sign-in-alt' => __( 'sign-in-alt', 'buildr' ),
        'fas fa-sign-language' => __( 'sign-language', 'buildr' ),
        'fas fa-sign-out-alt' => __( 'sign-out-alt', 'buildr' ),
        'fas fa-signal' => __( 'signal', 'buildr' ),
        'fab fa-simplybuilt' => __( 'simplybuilt', 'buildr' ),
        'fab fa-sistrix' => __( 'sistrix', 'buildr' ),
        'fas fa-sitemap' => __( 'sitemap', 'buildr' ),
        'fab fa-skyatlas' => __( 'skyatlas', 'buildr' ),
        'fab fa-skype' => __( 'skype', 'buildr' ),
        'fab fa-slack' => __( 'slack', 'buildr' ),
        'fab fa-slack-hash' => __( 'slack-hash', 'buildr' ),
        'fas fa-sliders-h' => __( 'sliders-h', 'buildr' ),
        'fab fa-slideshare' => __( 'slideshare', 'buildr' ),
        'fas fa-smile' => __( 'smile', 'buildr' ),
        'far fa-smile' => __( 'smile', 'buildr' ),
        'fas fa-smoking' => __( 'smoking', 'buildr' ),
        'fab fa-snapchat' => __( 'snapchat', 'buildr' ),
        'fab fa-snapchat-ghost' => __( 'snapchat-ghost', 'buildr' ),
        'fab fa-snapchat-square' => __( 'snapchat-square', 'buildr' ),
        'fas fa-snowflake' => __( 'snowflake', 'buildr' ),
        'far fa-snowflake' => __( 'snowflake', 'buildr' ),
        'fas fa-sort' => __( 'sort', 'buildr' ),
        'fas fa-sort-alpha-down' => __( 'sort-alpha-down', 'buildr' ),
        'fas fa-sort-alpha-up' => __( 'sort-alpha-up', 'buildr' ),
        'fas fa-sort-amount-down' => __( 'sort-amount-down', 'buildr' ),
        'fas fa-sort-amount-up' => __( 'sort-amount-up', 'buildr' ),
        'fas fa-sort-down' => __( 'sort-down', 'buildr' ),
        'fas fa-sort-numeric-down' => __( 'sort-numeric-down', 'buildr' ),
        'fas fa-sort-numeric-up' => __( 'sort-numeric-up', 'buildr' ),
        'fas fa-sort-up' => __( 'sort-up', 'buildr' ),
        'fab fa-soundcloud' => __( 'soundcloud', 'buildr' ),
        'fas fa-space-shuttle' => __( 'space-shuttle', 'buildr' ),
        'fab fa-speakap' => __( 'speakap', 'buildr' ),
        'fas fa-spinner' => __( 'spinner', 'buildr' ),
        'fab fa-spotify' => __( 'spotify', 'buildr' ),
        'fas fa-square' => __( 'square', 'buildr' ),
        'far fa-square' => __( 'square', 'buildr' ),
        'fas fa-square-full' => __( 'square-full', 'buildr' ),
        'fab fa-stack-exchange' => __( 'stack-exchange', 'buildr' ),
        'fab fa-stack-overflow' => __( 'stack-overflow', 'buildr' ),
        'fas fa-star' => __( 'star', 'buildr' ),
        'far fa-star' => __( 'star', 'buildr' ),
        'fas fa-star-half' => __( 'star-half', 'buildr' ),
        'far fa-star-half' => __( 'star-half', 'buildr' ),
        'fab fa-staylinked' => __( 'staylinked', 'buildr' ),
        'fab fa-steam' => __( 'steam', 'buildr' ),
        'fab fa-steam-square' => __( 'steam-square', 'buildr' ),
        'fab fa-steam-symbol' => __( 'steam-symbol', 'buildr' ),
        'fas fa-step-backward' => __( 'step-backward', 'buildr' ),
        'fas fa-step-forward' => __( 'step-forward', 'buildr' ),
        'fas fa-stethoscope' => __( 'stethoscope', 'buildr' ),
        'fab fa-sticker-mule' => __( 'sticker-mule', 'buildr' ),
        'fas fa-sticky-note' => __( 'sticky-note', 'buildr' ),
        'far fa-sticky-note' => __( 'sticky-note', 'buildr' ),
        'fas fa-stop' => __( 'stop', 'buildr' ),
        'fas fa-stop-circle' => __( 'stop-circle', 'buildr' ),
        'far fa-stop-circle' => __( 'stop-circle', 'buildr' ),
        'fas fa-stopwatch' => __( 'stopwatch', 'buildr' ),
        'fab fa-strava' => __( 'strava', 'buildr' ),
        'fas fa-street-view' => __( 'street-view', 'buildr' ),
        'fas fa-strikethrough' => __( 'strikethrough', 'buildr' ),
        'fab fa-stripe' => __( 'stripe', 'buildr' ),
        'fab fa-stripe-s' => __( 'stripe-s', 'buildr' ),
        'fab fa-studiovinari' => __( 'studiovinari', 'buildr' ),
        'fab fa-stumbleupon' => __( 'stumbleupon', 'buildr' ),
        'fab fa-stumbleupon-circle' => __( 'stumbleupon-circle', 'buildr' ),
        'fas fa-subscript' => __( 'subscript', 'buildr' ),
        'fas fa-subway' => __( 'subway', 'buildr' ),
        'fas fa-suitcase' => __( 'suitcase', 'buildr' ),
        'fas fa-sun' => __( 'sun', 'buildr' ),
        'far fa-sun' => __( 'sun', 'buildr' ),
        'fab fa-superpowers' => __( 'superpowers', 'buildr' ),
        'fas fa-superscript' => __( 'superscript', 'buildr' ),
        'fab fa-supple' => __( 'supple', 'buildr' ),
        'fas fa-sync' => __( 'sync', 'buildr' ),
        'fas fa-sync-alt' => __( 'sync-alt', 'buildr' ),
        'fas fa-syringe' => __( 'syringe', 'buildr' ),
        'fas fa-table' => __( 'table', 'buildr' ),
        'fas fa-table-tennis' => __( 'table-tennis', 'buildr' ),
        'fas fa-tablet' => __( 'tablet', 'buildr' ),
        'fas fa-tablet-alt' => __( 'tablet-alt', 'buildr' ),
        'fas fa-tablets' => __( 'tablets', 'buildr' ),
        'fas fa-tachometer-alt' => __( 'tachometer-alt', 'buildr' ),
        'fas fa-tag' => __( 'tag', 'buildr' ),
        'fas fa-tags' => __( 'tags', 'buildr' ),
        'fas fa-tape' => __( 'tape', 'buildr' ),
        'fas fa-tasks' => __( 'tasks', 'buildr' ),
        'fas fa-taxi' => __( 'taxi', 'buildr' ),
        'fab fa-telegram' => __( 'telegram', 'buildr' ),
        'fab fa-telegram-plane' => __( 'telegram-plane', 'buildr' ),
        'fab fa-tencent-weibo' => __( 'tencent-weibo', 'buildr' ),
        'fas fa-terminal' => __( 'terminal', 'buildr' ),
        'fas fa-text-height' => __( 'text-height', 'buildr' ),
        'fas fa-text-width' => __( 'text-width', 'buildr' ),
        'fas fa-th' => __( 'th', 'buildr' ),
        'fas fa-th-large' => __( 'th-large', 'buildr' ),
        'fas fa-th-list' => __( 'th-list', 'buildr' ),
        'fab fa-themeisle' => __( 'themeisle', 'buildr' ),
        'fas fa-thermometer' => __( 'thermometer', 'buildr' ),
        'fas fa-thermometer-empty' => __( 'thermometer-empty', 'buildr' ),
        'fas fa-thermometer-full' => __( 'thermometer-full', 'buildr' ),
        'fas fa-thermometer-half' => __( 'thermometer-half', 'buildr' ),
        'fas fa-thermometer-quarter' => __( 'thermometer-quarter', 'buildr' ),
        'fas fa-thermometer-three-quarters' => __( 'thermometer-three-quarters', 'buildr' ),
        'fas fa-thumbs-down' => __( 'thumbs-down', 'buildr' ),
        'far fa-thumbs-down' => __( 'thumbs-down', 'buildr' ),
        'fas fa-thumbs-up' => __( 'thumbs-up', 'buildr' ),
        'far fa-thumbs-up' => __( 'thumbs-up', 'buildr' ),
        'fas fa-thumbtack' => __( 'thumbtack', 'buildr' ),
        'fas fa-ticket-alt' => __( 'ticket-alt', 'buildr' ),
        'fas fa-times' => __( 'times', 'buildr' ),
        'fas fa-times-circle' => __( 'times-circle', 'buildr' ),
        'far fa-times-circle' => __( 'times-circle', 'buildr' ),
        'fas fa-tint' => __( 'tint', 'buildr' ),
        'fas fa-toggle-off' => __( 'toggle-off', 'buildr' ),
        'fas fa-toggle-on' => __( 'toggle-on', 'buildr' ),
        'fas fa-trademark' => __( 'trademark', 'buildr' ),
        'fas fa-train' => __( 'train', 'buildr' ),
        'fas fa-transgender' => __( 'transgender', 'buildr' ),
        'fas fa-transgender-alt' => __( 'transgender-alt', 'buildr' ),
        'fas fa-trash' => __( 'trash', 'buildr' ),
        'fas fa-trash-alt' => __( 'trash-alt', 'buildr' ),
        'far fa-trash-alt' => __( 'trash-alt', 'buildr' ),
        'fas fa-tree' => __( 'tree', 'buildr' ),
        'fab fa-trello' => __( 'trello', 'buildr' ),
        'fab fa-tripadvisor' => __( 'tripadvisor', 'buildr' ),
        'fas fa-trophy' => __( 'trophy', 'buildr' ),
        'fas fa-truck' => __( 'truck', 'buildr' ),
        'fas fa-truck-loading' => __( 'truck-loading', 'buildr' ),
        'fas fa-truck-moving' => __( 'truck-moving', 'buildr' ),
        'fas fa-tty' => __( 'tty', 'buildr' ),
        'fab fa-tumblr' => __( 'tumblr', 'buildr' ),
        'fab fa-tumblr-square' => __( 'tumblr-square', 'buildr' ),
        'fas fa-tv' => __( 'tv', 'buildr' ),
        'fab fa-twitch' => __( 'twitch', 'buildr' ),
        'fab fa-twitter' => __( 'twitter', 'buildr' ),
        'fab fa-twitter-square' => __( 'twitter-square', 'buildr' ),
        'fab fa-typo3' => __( 'typo3', 'buildr' ),
        'fab fa-uber' => __( 'uber', 'buildr' ),
        'fab fa-uikit' => __( 'uikit', 'buildr' ),
        'fas fa-umbrella' => __( 'umbrella', 'buildr' ),
        'fas fa-underline' => __( 'underline', 'buildr' ),
        'fas fa-undo' => __( 'undo', 'buildr' ),
        'fas fa-undo-alt' => __( 'undo-alt', 'buildr' ),
        'fab fa-uniregistry' => __( 'uniregistry', 'buildr' ),
        'fas fa-universal-access' => __( 'universal-access', 'buildr' ),
        'fas fa-university' => __( 'university', 'buildr' ),
        'fas fa-unlink' => __( 'unlink', 'buildr' ),
        'fas fa-unlock' => __( 'unlock', 'buildr' ),
        'fas fa-unlock-alt' => __( 'unlock-alt', 'buildr' ),
        'fab fa-untappd' => __( 'untappd', 'buildr' ),
        'fas fa-upload' => __( 'upload', 'buildr' ),
        'fab fa-usb' => __( 'usb', 'buildr' ),
        'fas fa-user' => __( 'user', 'buildr' ),
        'far fa-user' => __( 'user', 'buildr' ),
        'fas fa-user-circle' => __( 'user-circle', 'buildr' ),
        'far fa-user-circle' => __( 'user-circle', 'buildr' ),
        'fas fa-user-md' => __( 'user-md', 'buildr' ),
        'fas fa-user-plus' => __( 'user-plus', 'buildr' ),
        'fas fa-user-secret' => __( 'user-secret', 'buildr' ),
        'fas fa-user-times' => __( 'user-times', 'buildr' ),
        'fas fa-users' => __( 'users', 'buildr' ),
        'fab fa-ussunnah' => __( 'ussunnah', 'buildr' ),
        'fas fa-utensil-spoon' => __( 'utensil-spoon', 'buildr' ),
        'fas fa-utensils' => __( 'utensils', 'buildr' ),
        'fab fa-vaadin' => __( 'vaadin', 'buildr' ),
        'fas fa-venus' => __( 'venus', 'buildr' ),
        'fas fa-venus-double' => __( 'venus-double', 'buildr' ),
        'fas fa-venus-mars' => __( 'venus-mars', 'buildr' ),
        'fab fa-viacoin' => __( 'viacoin', 'buildr' ),
        'fab fa-viadeo' => __( 'viadeo', 'buildr' ),
        'fab fa-viadeo-square' => __( 'viadeo-square', 'buildr' ),
        'fas fa-vial' => __( 'vial', 'buildr' ),
        'fas fa-vials' => __( 'vials', 'buildr' ),
        'fab fa-viber' => __( 'viber', 'buildr' ),
        'fas fa-video' => __( 'video', 'buildr' ),
        'fas fa-video-slash' => __( 'video-slash', 'buildr' ),
        'fab fa-vimeo' => __( 'vimeo', 'buildr' ),
        'fab fa-vimeo-square' => __( 'vimeo-square', 'buildr' ),
        'fab fa-vimeo-v' => __( 'vimeo-v', 'buildr' ),
        'fab fa-vine' => __( 'vine', 'buildr' ),
        'fab fa-vk' => __( 'vk', 'buildr' ),
        'fab fa-vnv' => __( 'vnv', 'buildr' ),
        'fas fa-volleyball-ball' => __( 'volleyball-ball', 'buildr' ),
        'fas fa-volume-down' => __( 'volume-down', 'buildr' ),
        'fas fa-volume-off' => __( 'volume-off', 'buildr' ),
        'fas fa-volume-up' => __( 'volume-up', 'buildr' ),
        'fab fa-vuejs' => __( 'vuejs', 'buildr' ),
        'fas fa-warehouse' => __( 'warehouse', 'buildr' ),
        'fab fa-weibo' => __( 'weibo', 'buildr' ),
        'fas fa-weight' => __( 'weight', 'buildr' ),
        'fab fa-weixin' => __( 'weixin', 'buildr' ),
        'fab fa-whatsapp' => __( 'whatsapp', 'buildr' ),
        'fab fa-whatsapp-square' => __( 'whatsapp-square', 'buildr' ),
        'fas fa-wheelchair' => __( 'wheelchair', 'buildr' ),
        'fab fa-whmcs' => __( 'whmcs', 'buildr' ),
        'fas fa-wifi' => __( 'wifi', 'buildr' ),
        'fab fa-wikipedia-w' => __( 'wikipedia-w', 'buildr' ),
        'fas fa-window-close' => __( 'window-close', 'buildr' ),
        'far fa-window-close' => __( 'window-close', 'buildr' ),
        'fas fa-window-maximize' => __( 'window-maximize', 'buildr' ),
        'far fa-window-maximize' => __( 'window-maximize', 'buildr' ),
        'fas fa-window-minimize' => __( 'window-minimize', 'buildr' ),
        'far fa-window-minimize' => __( 'window-minimize', 'buildr' ),
        'fas fa-window-restore' => __( 'window-restore', 'buildr' ),
        'far fa-window-restore' => __( 'window-restore', 'buildr' ),
        'fab fa-windows' => __( 'windows', 'buildr' ),
        'fas fa-wine-glass' => __( 'wine-glass', 'buildr' ),
        'fas fa-won-sign' => __( 'won-sign', 'buildr' ),
        'fab fa-wordpress' => __( 'wordpress', 'buildr' ),
        'fab fa-wordpress-simple' => __( 'wordpress-simple', 'buildr' ),
        'fab fa-wpbeginner' => __( 'wpbeginner', 'buildr' ),
        'fab fa-wpexplorer' => __( 'wpexplorer', 'buildr' ),
        'fab fa-wpforms' => __( 'wpforms', 'buildr' ),
        'fas fa-wrench' => __( 'wrench', 'buildr' ),
        'fas fa-x-ray' => __( 'x-ray', 'buildr' ),
        'fab fa-xbox' => __( 'xbox', 'buildr' ),
        'fab fa-xing' => __( 'xing', 'buildr' ),
        'fab fa-xing-square' => __( 'xing-square', 'buildr' ),
        'fab fa-y-combinator' => __( 'y-combinator', 'buildr' ),
        'fab fa-yahoo' => __( 'yahoo', 'buildr' ),
        'fab fa-yandex' => __( 'yandex', 'buildr' ),
        'fab fa-yandex-international' => __( 'yandex-international', 'buildr' ),
        'fab fa-yelp' => __( 'yelp', 'buildr' ),
        'fas fa-yen-sign' => __( 'yen-sign', 'buildr' ),
        'fab fa-yoast' => __( 'yoast', 'buildr' ),
        'fab fa-youtube' => __( 'youtube', 'buildr' ),
        'fab fa-youtube-square' => __( 'youtube-square', 'buildr' ),
    );
    return $icon;
}

function purethemes_get_simple_line_icons(){
    return array(
          'user',
          'people',
          'user-female',
          'user-follow',
          'user-following',
          'user-unfollow',
          'login',
          'logout',
          'emotsmile',
          'phone',
          'call-end',
          'call-in',
          'call-out',
          'map',
          'location',
          'direction',
          'directions',
          'compass',
          'layers',
          'menu',
          'list',
          'options-vertical',
          'options',
          'arrow-down',
          'arrow-left',
          'arrow-right',
          'arrow-up',
          'arrow-up-circle',
          'arrow-left-circle',
          'arrow-right-circle',
          'arrow-down-circle',
          'check',
          'clock',
          'plus',
          'minus',
          'close',
          'exclamation',
          'organization',
          'trophy',
          'screen-smartphone',
          'screen-desktop',
          'plane',
          'notebook',
          'mustache',
          'mouse',
          'magnet',
          'energy',
          'disc',
          'cursor',
          'cursor-move',
          'crop',
          'chemistry',
          'speedometer',
          'shield',
          'screen-tablet',
          'magic-wand',
          'hourglass',
          'graduation',
          'ghost',
          'game-controller',
          'fire',
          'eyeglass',
          'envelope-open',
          'envelope-letter',
          'bell',
          'badge',
          'anchor',
          'wallet',
          'vector',
          'speech',
          'puzzle',
          'printer',
          'present',
          'playlist',
          'pin',
          'picture',
          'handbag',
          'globe-alt',
          'globe',
          'folder-alt',
          'folder',
          'film',
          'feed',
          'drop',
          'drawer',
          'docs',
          'doc',
          'diamond',
          'cup',
          'calculator',
          'bubbles',
          'briefcase',
          'book-open',
          'basket-loaded',
          'basket',
          'bag',
          'action-undo',
          'action-redo',
          'wrench',
          'umbrella',
          'trash',
          'tag',
          'support',
          'frame',
          'size-fullscreen',
          'size-actual',
          'shuffle',
          'share-alt',
          'share',
          'rocket',
          'question',
          'pie-chart',
          'pencil',
          'note',
          'loop',
          'home',
          'grid',
          'graph',
          'microphone',
          'music-tone-alt',
          'music-tone',
          'earphones-alt',
          'earphones',
          'equalizer',
          'like',
          'dislike',
          'control-start',
          'control-rewind',
          'control-play',
          'control-pause',
          'control-forward',
          'control-end',
          'volume-1',
          'volume-2',
          'volume-off',
          'calendar',
          'bulb',
          'chart',
          'ban',
          'bubble',
          'camrecorder',
          'camera',
          'cloud-download',
          'cloud-upload',
          'envelope',
          'eye',
          'flag',
          'heart',
          'info',
          'key',
          'link',
          'lock',
          'lock-open',
          'magnifier',
          'magnifier-add',
          'magnifier-remove',
          'paper-clip',
          'paper-plane',
          'power',
          'refresh',
          'reload',
          'settings',
          'star',
          'symbol-female',
          'symbol-male',
          'target',
          'credit-card',
          'paypal',
          'social-tumblr',
          'social-twitter',
          'social-facebook',
          'social-instagram',
          'social-linkedin',
          'social-pinterest',
          'social-github',
          'social-google',
          'social-reddit',
          'social-skype',
          'social-dribbble',
          'social-behance',
          'social-foursqare',
          'social-soundcloud',
          'social-spotify',
          'social-stumbleupon',
          'social-youtube',
          'social-dropbox',
  );
}


function vc_iconpicker_type_iconsmind( $icons ){
$iconsmind_icons = array(
array( '' => 'empty' ), array( 'im im-icon-A-Z' => 'A-Z' ),array( 'im im-icon-Aa' => 'Aa' ),array( 'im im-icon-Add-Bag' => 'Add-Bag' ),array( 'im im-icon-Add-Basket' => 'Add-Basket' ),array( 'im im-icon-Add-Cart' => 'Add-Cart' ),array( 'im im-icon-Add-File' => 'Add-File' ),array( 'im im-icon-Add-SpaceAfterParagraph' => 'Add-SpaceAfterParagraph' ),array( 'im im-icon-Add-SpaceBeforeParagraph' => 'Add-SpaceBeforeParagraph' ),array( 'im im-icon-Add-User' => 'Add-User' ),array( 'im im-icon-Add-UserStar' => 'Add-UserStar' ),array( 'im im-icon-Add-Window' => 'Add-Window' ),array( 'im im-icon-Add' => 'Add' ),array( 'im im-icon-Address-Book' => 'Address-Book' ),array( 'im im-icon-Address-Book2' => 'Address-Book2' ),array( 'im im-icon-Administrator' => 'Administrator' ),array( 'im im-icon-Aerobics-2' => 'Aerobics-2' ),array( 'im im-icon-Aerobics-3' => 'Aerobics-3' ),array( 'im im-icon-Aerobics' => 'Aerobics' ),array( 'im im-icon-Affiliate' => 'Affiliate' ),array( 'im im-icon-Aim' => 'Aim' ),array( 'im im-icon-Air-Balloon' => 'Air-Balloon' ),array( 'im im-icon-Airbrush' => 'Airbrush' ),array( 'im im-icon-Airship' => 'Airship' ),array( 'im im-icon-Alarm-Clock' => 'Alarm-Clock' ),array( 'im im-icon-Alarm-Clock2' => 'Alarm-Clock2' ),array( 'im im-icon-Alarm' => 'Alarm' ),array( 'im im-icon-Alien-2' => 'Alien-2' ),array( 'im im-icon-Alien' => 'Alien' ),array( 'im im-icon-Aligator' => 'Aligator' ),array( 'im im-icon-Align-Center' => 'Align-Center' ),array( 'im im-icon-Align-JustifyAll' => 'Align-JustifyAll' ),array( 'im im-icon-Align-JustifyCenter' => 'Align-JustifyCenter' ),array( 'im im-icon-Align-JustifyLeft' => 'Align-JustifyLeft' ),array( 'im im-icon-Align-JustifyRight' => 'Align-JustifyRight' ),array( 'im im-icon-Align-Left' => 'Align-Left' ),array( 'im im-icon-Align-Right' => 'Align-Right' ),array( 'im im-icon-Alpha' => 'Alpha' ),array( 'im im-icon-Ambulance' => 'Ambulance' ),array( 'im im-icon-AMX' => 'AMX' ),array( 'im im-icon-Anchor-2' => 'Anchor-2' ),array( 'im im-icon-Anchor' => 'Anchor' ),array( 'im im-icon-Android-Store' => 'Android-Store' ),array( 'im im-icon-Android' => 'Android' ),array( 'im im-icon-Angel-Smiley' => 'Angel-Smiley' ),array( 'im im-icon-Angel' => 'Angel' ),array( 'im im-icon-Angry' => 'Angry' ),array( 'im im-icon-Apple-Bite' => 'Apple-Bite' ),array( 'im im-icon-Apple-Store' => 'Apple-Store' ),array( 'im im-icon-Apple' => 'Apple' ),array( 'im im-icon-Approved-Window' => 'Approved-Window' ),array( 'im im-icon-Aquarius-2' => 'Aquarius-2' ),array( 'im im-icon-Aquarius' => 'Aquarius' ),array( 'im im-icon-Archery-2' => 'Archery-2' ),array( 'im im-icon-Archery' => 'Archery' ),array( 'im im-icon-Argentina' => 'Argentina' ),array( 'im im-icon-Aries-2' => 'Aries-2' ),array( 'im im-icon-Aries' => 'Aries' ),array( 'im im-icon-Army-Key' => 'Army-Key' ),array( 'im im-icon-Arrow-Around' => 'Arrow-Around' ),array( 'im im-icon-Arrow-Back3' => 'Arrow-Back3' ),array( 'im im-icon-Arrow-Back' => 'Arrow-Back' ),array( 'im im-icon-Arrow-Back2' => 'Arrow-Back2' ),array( 'im im-icon-Arrow-Barrier' => 'Arrow-Barrier' ),array( 'im im-icon-Arrow-Circle' => 'Arrow-Circle' ),array( 'im im-icon-Arrow-Cross' => 'Arrow-Cross' ),array( 'im im-icon-Arrow-Down' => 'Arrow-Down' ),array( 'im im-icon-Arrow-Down2' => 'Arrow-Down2' ),array( 'im im-icon-Arrow-Down3' => 'Arrow-Down3' ),array( 'im im-icon-Arrow-DowninCircle' => 'Arrow-DowninCircle' ),array( 'im im-icon-Arrow-Fork' => 'Arrow-Fork' ),array( 'im im-icon-Arrow-Forward' => 'Arrow-Forward' ),array( 'im im-icon-Arrow-Forward2' => 'Arrow-Forward2' ),array( 'im im-icon-Arrow-From' => 'Arrow-From' ),array( 'im im-icon-Arrow-Inside' => 'Arrow-Inside' ),array( 'im im-icon-Arrow-Inside45' => 'Arrow-Inside45' ),array( 'im im-icon-Arrow-InsideGap' => 'Arrow-InsideGap' ),array( 'im im-icon-Arrow-InsideGap45' => 'Arrow-InsideGap45' ),array( 'im im-icon-Arrow-Into' => 'Arrow-Into' ),array( 'im im-icon-Arrow-Join' => 'Arrow-Join' ),array( 'im im-icon-Arrow-Junction' => 'Arrow-Junction' ),array( 'im im-icon-Arrow-Left' => 'Arrow-Left' ),array( 'im im-icon-Arrow-Left2' => 'Arrow-Left2' ),array( 'im im-icon-Arrow-LeftinCircle' => 'Arrow-LeftinCircle' ),array( 'im im-icon-Arrow-Loop' => 'Arrow-Loop' ),array( 'im im-icon-Arrow-Merge' => 'Arrow-Merge' ),array( 'im im-icon-Arrow-Mix' => 'Arrow-Mix' ),array( 'im im-icon-Arrow-Next' => 'Arrow-Next' ),array( 'im im-icon-Arrow-OutLeft' => 'Arrow-OutLeft' ),array( 'im im-icon-Arrow-OutRight' => 'Arrow-OutRight' ),array( 'im im-icon-Arrow-Outside' => 'Arrow-Outside' ),array( 'im im-icon-Arrow-Outside45' => 'Arrow-Outside45' ),array( 'im im-icon-Arrow-OutsideGap' => 'Arrow-OutsideGap' ),array( 'im im-icon-Arrow-OutsideGap45' => 'Arrow-OutsideGap45' ),array( 'im im-icon-Arrow-Over' => 'Arrow-Over' ),array( 'im im-icon-Arrow-Refresh' => 'Arrow-Refresh' ),array( 'im im-icon-Arrow-Refresh2' => 'Arrow-Refresh2' ),array( 'im im-icon-Arrow-Right' => 'Arrow-Right' ),array( 'im im-icon-Arrow-Right2' => 'Arrow-Right2' ),array( 'im im-icon-Arrow-RightinCircle' => 'Arrow-RightinCircle' ),array( 'im im-icon-Arrow-Shuffle' => 'Arrow-Shuffle' ),array( 'im im-icon-Arrow-Squiggly' => 'Arrow-Squiggly' ),array( 'im im-icon-Arrow-Through' => 'Arrow-Through' ),array( 'im im-icon-Arrow-To' => 'Arrow-To' ),array( 'im im-icon-Arrow-TurnLeft' => 'Arrow-TurnLeft' ),array( 'im im-icon-Arrow-TurnRight' => 'Arrow-TurnRight' ),array( 'im im-icon-Arrow-Up' => 'Arrow-Up' ),array( 'im im-icon-Arrow-Up2' => 'Arrow-Up2' ),array( 'im im-icon-Arrow-Up3' => 'Arrow-Up3' ),array( 'im im-icon-Arrow-UpinCircle' => 'Arrow-UpinCircle' ),array( 'im im-icon-Arrow-XLeft' => 'Arrow-XLeft' ),array( 'im im-icon-Arrow-XRight' => 'Arrow-XRight' ),array( 'im im-icon-Ask' => 'Ask' ),array( 'im im-icon-Assistant' => 'Assistant' ),array( 'im im-icon-Astronaut' => 'Astronaut' ),array( 'im im-icon-At-Sign' => 'At-Sign' ),array( 'im im-icon-ATM' => 'ATM' ),array( 'im im-icon-Atom' => 'Atom' ),array( 'im im-icon-Audio' => 'Audio' ),array( 'im im-icon-Auto-Flash' => 'Auto-Flash' ),array( 'im im-icon-Autumn' => 'Autumn' ),array( 'im im-icon-Baby-Clothes' => 'Baby-Clothes' ),array( 'im im-icon-Baby-Clothes2' => 'Baby-Clothes2' ),array( 'im im-icon-Baby-Cry' => 'Baby-Cry' ),array( 'im im-icon-Baby' => 'Baby' ),array( 'im im-icon-Back2' => 'Back2' ),array( 'im im-icon-Back-Media' => 'Back-Media' ),array( 'im im-icon-Back-Music' => 'Back-Music' ),array( 'im im-icon-Back' => 'Back' ),array( 'im im-icon-Background' => 'Background' ),array( 'im im-icon-Bacteria' => 'Bacteria' ),array( 'im im-icon-Bag-Coins' => 'Bag-Coins' ),array( 'im im-icon-Bag-Items' => 'Bag-Items' ),array( 'im im-icon-Bag-Quantity' => 'Bag-Quantity' ),array( 'im im-icon-Bag' => 'Bag' ),array( 'im im-icon-Bakelite' => 'Bakelite' ),array( 'im im-icon-Ballet-Shoes' => 'Ballet-Shoes' ),array( 'im im-icon-Balloon' => 'Balloon' ),array( 'im im-icon-Banana' => 'Banana' ),array( 'im im-icon-Band-Aid' => 'Band-Aid' ),array( 'im im-icon-Bank' => 'Bank' ),array( 'im im-icon-Bar-Chart' => 'Bar-Chart' ),array( 'im im-icon-Bar-Chart2' => 'Bar-Chart2' ),array( 'im im-icon-Bar-Chart3' => 'Bar-Chart3' ),array( 'im im-icon-Bar-Chart4' => 'Bar-Chart4' ),array( 'im im-icon-Bar-Chart5' => 'Bar-Chart5' ),array( 'im im-icon-Bar-Code' => 'Bar-Code' ),array( 'im im-icon-Barricade-2' => 'Barricade-2' ),array( 'im im-icon-Barricade' => 'Barricade' ),array( 'im im-icon-Baseball' => 'Baseball' ),array( 'im im-icon-Basket-Ball' => 'Basket-Ball' ),array( 'im im-icon-Basket-Coins' => 'Basket-Coins' ),array( 'im im-icon-Basket-Items' => 'Basket-Items' ),array( 'im im-icon-Basket-Quantity' => 'Basket-Quantity' ),array( 'im im-icon-Bat-2' => 'Bat-2' ),array( 'im im-icon-Bat' => 'Bat' ),array( 'im im-icon-Bathrobe' => 'Bathrobe' ),array( 'im im-icon-Batman-Mask' => 'Batman-Mask' ),array( 'im im-icon-Battery-0' => 'Battery-0' ),array( 'im im-icon-Battery-25' => 'Battery-25' ),array( 'im im-icon-Battery-50' => 'Battery-50' ),array( 'im im-icon-Battery-75' => 'Battery-75' ),array( 'im im-icon-Battery-100' => 'Battery-100' ),array( 'im im-icon-Battery-Charge' => 'Battery-Charge' ),array( 'im im-icon-Bear' => 'Bear' ),array( 'im im-icon-Beard-2' => 'Beard-2' ),array( 'im im-icon-Beard-3' => 'Beard-3' ),array( 'im im-icon-Beard' => 'Beard' ),array( 'im im-icon-Bebo' => 'Bebo' ),array( 'im im-icon-Bee' => 'Bee' ),array( 'im im-icon-Beer-Glass' => 'Beer-Glass' ),array( 'im im-icon-Beer' => 'Beer' ),array( 'im im-icon-Bell-2' => 'Bell-2' ),array( 'im im-icon-Bell' => 'Bell' ),array( 'im im-icon-Belt-2' => 'Belt-2' ),array( 'im im-icon-Belt-3' => 'Belt-3' ),array( 'im im-icon-Belt' => 'Belt' ),array( 'im im-icon-Berlin-Tower' => 'Berlin-Tower' ),array( 'im im-icon-Beta' => 'Beta' ),array( 'im im-icon-Betvibes' => 'Betvibes' ),array( 'im im-icon-Bicycle-2' => 'Bicycle-2' ),array( 'im im-icon-Bicycle-3' => 'Bicycle-3' ),array( 'im im-icon-Bicycle' => 'Bicycle' ),array( 'im im-icon-Big-Bang' => 'Big-Bang' ),array( 'im im-icon-Big-Data' => 'Big-Data' ),array( 'im im-icon-Bike-Helmet' => 'Bike-Helmet' ),array( 'im im-icon-Bikini' => 'Bikini' ),array( 'im im-icon-Bilk-Bottle2' => 'Bilk-Bottle2' ),array( 'im im-icon-Billing' => 'Billing' ),array( 'im im-icon-Bing' => 'Bing' ),array( 'im im-icon-Binocular' => 'Binocular' ),array( 'im im-icon-Bio-Hazard' => 'Bio-Hazard' ),array( 'im im-icon-Biotech' => 'Biotech' ),array( 'im im-icon-Bird-DeliveringLetter' => 'Bird-DeliveringLetter' ),array( 'im im-icon-Bird' => 'Bird' ),array( 'im im-icon-Birthday-Cake' => 'Birthday-Cake' ),array( 'im im-icon-Bisexual' => 'Bisexual' ),array( 'im im-icon-Bishop' => 'Bishop' ),array( 'im im-icon-Bitcoin' => 'Bitcoin' ),array( 'im im-icon-Black-Cat' => 'Black-Cat' ),array( 'im im-icon-Blackboard' => 'Blackboard' ),array( 'im im-icon-Blinklist' => 'Blinklist' ),array( 'im im-icon-Block-Cloud' => 'Block-Cloud' ),array( 'im im-icon-Block-Window' => 'Block-Window' ),array( 'im im-icon-Blogger' => 'Blogger' ),array( 'im im-icon-Blood' => 'Blood' ),array( 'im im-icon-Blouse' => 'Blouse' ),array( 'im im-icon-Blueprint' => 'Blueprint' ),array( 'im im-icon-Board' => 'Board' ),array( 'im im-icon-Bodybuilding' => 'Bodybuilding' ),array( 'im im-icon-Bold-Text' => 'Bold-Text' ),array( 'im im-icon-Bone' => 'Bone' ),array( 'im im-icon-Bones' => 'Bones' ),array( 'im im-icon-Book' => 'Book' ),array( 'im im-icon-Bookmark' => 'Bookmark' ),array( 'im im-icon-Books-2' => 'Books-2' ),array( 'im im-icon-Books' => 'Books' ),array( 'im im-icon-Boom' => 'Boom' ),array( 'im im-icon-Boot-2' => 'Boot-2' ),array( 'im im-icon-Boot' => 'Boot' ),array( 'im im-icon-Bottom-ToTop' => 'Bottom-ToTop' ),array( 'im im-icon-Bow-2' => 'Bow-2' ),array( 'im im-icon-Bow-3' => 'Bow-3' ),array( 'im im-icon-Bow-4' => 'Bow-4' ),array( 'im im-icon-Bow-5' => 'Bow-5' ),array( 'im im-icon-Bow-6' => 'Bow-6' ),array( 'im im-icon-Bow' => 'Bow' ),array( 'im im-icon-Bowling-2' => 'Bowling-2' ),array( 'im im-icon-Bowling' => 'Bowling' ),array( 'im im-icon-Box2' => 'Box2' ),array( 'im im-icon-Box-Close' => 'Box-Close' ),array( 'im im-icon-Box-Full' => 'Box-Full' ),array( 'im im-icon-Box-Open' => 'Box-Open' ),array( 'im im-icon-Box-withFolders' => 'Box-withFolders' ),array( 'im im-icon-Box' => 'Box' ),array( 'im im-icon-Boy' => 'Boy' ),array( 'im im-icon-Bra' => 'Bra' ),array( 'im im-icon-Brain-2' => 'Brain-2' ),array( 'im im-icon-Brain-3' => 'Brain-3' ),array( 'im im-icon-Brain' => 'Brain' ),array( 'im im-icon-Brazil' => 'Brazil' ),array( 'im im-icon-Bread-2' => 'Bread-2' ),array( 'im im-icon-Bread' => 'Bread' ),array( 'im im-icon-Bridge' => 'Bridge' ),array( 'im im-icon-Brightkite' => 'Brightkite' ),array( 'im im-icon-Broke-Link2' => 'Broke-Link2' ),array( 'im im-icon-Broken-Link' => 'Broken-Link' ),array( 'im im-icon-Broom' => 'Broom' ),array( 'im im-icon-Brush' => 'Brush' ),array( 'im im-icon-Bucket' => 'Bucket' ),array( 'im im-icon-Bug' => 'Bug' ),array( 'im im-icon-Building' => 'Building' ),array( 'im im-icon-Bulleted-List' => 'Bulleted-List' ),array( 'im im-icon-Bus-2' => 'Bus-2' ),array( 'im im-icon-Bus' => 'Bus' ),array( 'im im-icon-Business-Man' => 'Business-Man' ),array( 'im im-icon-Business-ManWoman' => 'Business-ManWoman' ),array( 'im im-icon-Business-Mens' => 'Business-Mens' ),array( 'im im-icon-Business-Woman' => 'Business-Woman' ),array( 'im im-icon-Butterfly' => 'Butterfly' ),array( 'im im-icon-Button' => 'Button' ),array( 'im im-icon-Cable-Car' => 'Cable-Car' ),array( 'im im-icon-Cake' => 'Cake' ),array( 'im im-icon-Calculator-2' => 'Calculator-2' ),array( 'im im-icon-Calculator-3' => 'Calculator-3' ),array( 'im im-icon-Calculator' => 'Calculator' ),array( 'im im-icon-Calendar-2' => 'Calendar-2' ),array( 'im im-icon-Calendar-3' => 'Calendar-3' ),array( 'im im-icon-Calendar-4' => 'Calendar-4' ),array( 'im im-icon-Calendar-Clock' => 'Calendar-Clock' ),array( 'im im-icon-Calendar' => 'Calendar' ),array( 'im im-icon-Camel' => 'Camel' ),array( 'im im-icon-Camera-2' => 'Camera-2' ),array( 'im im-icon-Camera-3' => 'Camera-3' ),array( 'im im-icon-Camera-4' => 'Camera-4' ),array( 'im im-icon-Camera-5' => 'Camera-5' ),array( 'im im-icon-Camera-Back' => 'Camera-Back' ),array( 'im im-icon-Camera' => 'Camera' ),array( 'im im-icon-Can-2' => 'Can-2' ),array( 'im im-icon-Can' => 'Can' ),array( 'im im-icon-Canada' => 'Canada' ),array( 'im im-icon-Cancer-2' => 'Cancer-2' ),array( 'im im-icon-Cancer-3' => 'Cancer-3' ),array( 'im im-icon-Cancer' => 'Cancer' ),array( 'im im-icon-Candle' => 'Candle' ),array( 'im im-icon-Candy-Cane' => 'Candy-Cane' ),array( 'im im-icon-Candy' => 'Candy' ),array( 'im im-icon-Cannon' => 'Cannon' ),array( 'im im-icon-Cap-2' => 'Cap-2' ),array( 'im im-icon-Cap-3' => 'Cap-3' ),array( 'im im-icon-Cap-Smiley' => 'Cap-Smiley' ),array( 'im im-icon-Cap' => 'Cap' ),array( 'im im-icon-Capricorn-2' => 'Capricorn-2' ),array( 'im im-icon-Capricorn' => 'Capricorn' ),array( 'im im-icon-Car-2' => 'Car-2' ),array( 'im im-icon-Car-3' => 'Car-3' ),array( 'im im-icon-Car-Coins' => 'Car-Coins' ),array( 'im im-icon-Car-Items' => 'Car-Items' ),array( 'im im-icon-Car-Wheel' => 'Car-Wheel' ),array( 'im im-icon-Car' => 'Car' ),array( 'im im-icon-Cardigan' => 'Cardigan' ),array( 'im im-icon-Cardiovascular' => 'Cardiovascular' ),array( 'im im-icon-Cart-Quantity' => 'Cart-Quantity' ),array( 'im im-icon-Casette-Tape' => 'Casette-Tape' ),array( 'im im-icon-Cash-Register' => 'Cash-Register' ),array( 'im im-icon-Cash-register2' => 'Cash-register2' ),array( 'im im-icon-Castle' => 'Castle' ),array( 'im im-icon-Cat' => 'Cat' ),array( 'im im-icon-Cathedral' => 'Cathedral' ),array( 'im im-icon-Cauldron' => 'Cauldron' ),array( 'im im-icon-CD-2' => 'CD-2' ),array( 'im im-icon-CD-Cover' => 'CD-Cover' ),array( 'im im-icon-CD' => 'CD' ),array( 'im im-icon-Cello' => 'Cello' ),array( 'im im-icon-Celsius' => 'Celsius' ),array( 'im im-icon-Chacked-Flag' => 'Chacked-Flag' ),array( 'im im-icon-Chair' => 'Chair' ),array( 'im im-icon-Charger' => 'Charger' ),array( 'im im-icon-Check-2' => 'Check-2' ),array( 'im im-icon-Check' => 'Check' ),array( 'im im-icon-Checked-User' => 'Checked-User' ),array( 'im im-icon-Checkmate' => 'Checkmate' ),array( 'im im-icon-Checkout-Bag' => 'Checkout-Bag' ),array( 'im im-icon-Checkout-Basket' => 'Checkout-Basket' ),array( 'im im-icon-Checkout' => 'Checkout' ),array( 'im im-icon-Cheese' => 'Cheese' ),array( 'im im-icon-Cheetah' => 'Cheetah' ),array( 'im im-icon-Chef-Hat' => 'Chef-Hat' ),array( 'im im-icon-Chef-Hat2' => 'Chef-Hat2' ),array( 'im im-icon-Chef' => 'Chef' ),array( 'im im-icon-Chemical-2' => 'Chemical-2' ),array( 'im im-icon-Chemical-3' => 'Chemical-3' ),array( 'im im-icon-Chemical-4' => 'Chemical-4' ),array( 'im im-icon-Chemical-5' => 'Chemical-5' ),array( 'im im-icon-Chemical' => 'Chemical' ),array( 'im im-icon-Chess-Board' => 'Chess-Board' ),array( 'im im-icon-Chess' => 'Chess' ),array( 'im im-icon-Chicken' => 'Chicken' ),array( 'im im-icon-Chile' => 'Chile' ),array( 'im im-icon-Chimney' => 'Chimney' ),array( 'im im-icon-China' => 'China' ),array( 'im im-icon-Chinese-Temple' => 'Chinese-Temple' ),array( 'im im-icon-Chip' => 'Chip' ),array( 'im im-icon-Chopsticks-2' => 'Chopsticks-2' ),array( 'im im-icon-Chopsticks' => 'Chopsticks' ),array( 'im im-icon-Christmas-Ball' => 'Christmas-Ball' ),array( 'im im-icon-Christmas-Bell' => 'Christmas-Bell' ),array( 'im im-icon-Christmas-Candle' => 'Christmas-Candle' ),array( 'im im-icon-Christmas-Hat' => 'Christmas-Hat' ),array( 'im im-icon-Christmas-Sleigh' => 'Christmas-Sleigh' ),array( 'im im-icon-Christmas-Snowman' => 'Christmas-Snowman' ),array( 'im im-icon-Christmas-Sock' => 'Christmas-Sock' ),array( 'im im-icon-Christmas-Tree' => 'Christmas-Tree' ),array( 'im im-icon-Christmas' => 'Christmas' ),array( 'im im-icon-Chrome' => 'Chrome' ),array( 'im im-icon-Chrysler-Building' => 'Chrysler-Building' ),array( 'im im-icon-Cinema' => 'Cinema' ),array( 'im im-icon-Circular-Point' => 'Circular-Point' ),array( 'im im-icon-City-Hall' => 'City-Hall' ),array( 'im im-icon-Clamp' => 'Clamp' ),array( 'im im-icon-Clapperboard-Close' => 'Clapperboard-Close' ),array( 'im im-icon-Clapperboard-Open' => 'Clapperboard-Open' ),array( 'im im-icon-Claps' => 'Claps' ),array( 'im im-icon-Clef' => 'Clef' ),array( 'im im-icon-Clinic' => 'Clinic' ),array( 'im im-icon-Clock-2' => 'Clock-2' ),array( 'im im-icon-Clock-3' => 'Clock-3' ),array( 'im im-icon-Clock-4' => 'Clock-4' ),array( 'im im-icon-Clock-Back' => 'Clock-Back' ),array( 'im im-icon-Clock-Forward' => 'Clock-Forward' ),array( 'im im-icon-Clock' => 'Clock' ),array( 'im im-icon-Close-Window' => 'Close-Window' ),array( 'im im-icon-Close' => 'Close' ),array( 'im im-icon-Clothing-Store' => 'Clothing-Store' ),array( 'im im-icon-Cloud--' => 'Cloud--' ),array( 'im im-icon-Cloud-' => 'Cloud-' ),array( 'im im-icon-Cloud-Camera' => 'Cloud-Camera' ),array( 'im im-icon-Cloud-Computer' => 'Cloud-Computer' ),array( 'im im-icon-Cloud-Email' => 'Cloud-Email' ),array( 'im im-icon-Cloud-Hail' => 'Cloud-Hail' ),array( 'im im-icon-Cloud-Laptop' => 'Cloud-Laptop' ),array( 'im im-icon-Cloud-Lock' => 'Cloud-Lock' ),array( 'im im-icon-Cloud-Moon' => 'Cloud-Moon' ),array( 'im im-icon-Cloud-Music' => 'Cloud-Music' ),array( 'im im-icon-Cloud-Picture' => 'Cloud-Picture' ),array( 'im im-icon-Cloud-Rain' => 'Cloud-Rain' ),array( 'im im-icon-Cloud-Remove' => 'Cloud-Remove' ),array( 'im im-icon-Cloud-Secure' => 'Cloud-Secure' ),array( 'im im-icon-Cloud-Settings' => 'Cloud-Settings' ),array( 'im im-icon-Cloud-Smartphone' => 'Cloud-Smartphone' ),array( 'im im-icon-Cloud-Snow' => 'Cloud-Snow' ),array( 'im im-icon-Cloud-Sun' => 'Cloud-Sun' ),array( 'im im-icon-Cloud-Tablet' => 'Cloud-Tablet' ),array( 'im im-icon-Cloud-Video' => 'Cloud-Video' ),array( 'im im-icon-Cloud-Weather' => 'Cloud-Weather' ),array( 'im im-icon-Cloud' => 'Cloud' ),array( 'im im-icon-Clouds-Weather' => 'Clouds-Weather' ),array( 'im im-icon-Clouds' => 'Clouds' ),array( 'im im-icon-Clown' => 'Clown' ),array( 'im im-icon-CMYK' => 'CMYK' ),array( 'im im-icon-Coat' => 'Coat' ),array( 'im im-icon-Cocktail' => 'Cocktail' ),array( 'im im-icon-Coconut' => 'Coconut' ),array( 'im im-icon-Code-Window' => 'Code-Window' ),array( 'im im-icon-Coding' => 'Coding' ),array( 'im im-icon-Coffee-2' => 'Coffee-2' ),array( 'im im-icon-Coffee-Bean' => 'Coffee-Bean' ),array( 'im im-icon-Coffee-Machine' => 'Coffee-Machine' ),array( 'im im-icon-Coffee-toGo' => 'Coffee-toGo' ),array( 'im im-icon-Coffee' => 'Coffee' ),array( 'im im-icon-Coffin' => 'Coffin' ),array( 'im im-icon-Coin' => 'Coin' ),array( 'im im-icon-Coins-2' => 'Coins-2' ),array( 'im im-icon-Coins-3' => 'Coins-3' ),array( 'im im-icon-Coins' => 'Coins' ),array( 'im im-icon-Colombia' => 'Colombia' ),array( 'im im-icon-Colosseum' => 'Colosseum' ),array( 'im im-icon-Column-2' => 'Column-2' ),array( 'im im-icon-Column-3' => 'Column-3' ),array( 'im im-icon-Column' => 'Column' ),array( 'im im-icon-Comb-2' => 'Comb-2' ),array( 'im im-icon-Comb' => 'Comb' ),array( 'im im-icon-Communication-Tower' => 'Communication-Tower' ),array( 'im im-icon-Communication-Tower2' => 'Communication-Tower2' ),array( 'im im-icon-Compass-2' => 'Compass-2' ),array( 'im im-icon-Compass-3' => 'Compass-3' ),array( 'im im-icon-Compass-4' => 'Compass-4' ),array( 'im im-icon-Compass-Rose' => 'Compass-Rose' ),array( 'im im-icon-Compass' => 'Compass' ),array( 'im im-icon-Computer-2' => 'Computer-2' ),array( 'im im-icon-Computer-3' => 'Computer-3' ),array( 'im im-icon-Computer-Secure' => 'Computer-Secure' ),array( 'im im-icon-Computer' => 'Computer' ),array( 'im im-icon-Conference' => 'Conference' ),array( 'im im-icon-Confused' => 'Confused' ),array( 'im im-icon-Conservation' => 'Conservation' ),array( 'im im-icon-Consulting' => 'Consulting' ),array( 'im im-icon-Contrast' => 'Contrast' ),array( 'im im-icon-Control-2' => 'Control-2' ),array( 'im im-icon-Control' => 'Control' ),array( 'im im-icon-Cookie-Man' => 'Cookie-Man' ),array( 'im im-icon-Cookies' => 'Cookies' ),array( 'im im-icon-Cool-Guy' => 'Cool-Guy' ),array( 'im im-icon-Cool' => 'Cool' ),array( 'im im-icon-Copyright' => 'Copyright' ),array( 'im im-icon-Costume' => 'Costume' ),array( 'im im-icon-Couple-Sign' => 'Couple-Sign' ),array( 'im im-icon-Cow' => 'Cow' ),array( 'im im-icon-CPU' => 'CPU' ),array( 'im im-icon-Crane' => 'Crane' ),array( 'im im-icon-Cranium' => 'Cranium' ),array( 'im im-icon-Credit-Card' => 'Credit-Card' ),array( 'im im-icon-Credit-Card2' => 'Credit-Card2' ),array( 'im im-icon-Credit-Card3' => 'Credit-Card3' ),array( 'im im-icon-Cricket' => 'Cricket' ),array( 'im im-icon-Criminal' => 'Criminal' ),array( 'im im-icon-Croissant' => 'Croissant' ),array( 'im im-icon-Crop-2' => 'Crop-2' ),array( 'im im-icon-Crop-3' => 'Crop-3' ),array( 'im im-icon-Crown-2' => 'Crown-2' ),array( 'im im-icon-Crown' => 'Crown' ),array( 'im im-icon-Crying' => 'Crying' ),array( 'im im-icon-Cube-Molecule' => 'Cube-Molecule' ),array( 'im im-icon-Cube-Molecule2' => 'Cube-Molecule2' ),array( 'im im-icon-Cupcake' => 'Cupcake' ),array( 'im im-icon-Cursor-Click' => 'Cursor-Click' ),array( 'im im-icon-Cursor-Click2' => 'Cursor-Click2' ),array( 'im im-icon-Cursor-Move' => 'Cursor-Move' ),array( 'im im-icon-Cursor-Move2' => 'Cursor-Move2' ),array( 'im im-icon-Cursor-Select' => 'Cursor-Select' ),array( 'im im-icon-Cursor' => 'Cursor' ),array( 'im im-icon-D-Eyeglasses' => 'D-Eyeglasses' ),array( 'im im-icon-D-Eyeglasses2' => 'D-Eyeglasses2' ),array( 'im im-icon-Dam' => 'Dam' ),array( 'im im-icon-Danemark' => 'Danemark' ),array( 'im im-icon-Danger-2' => 'Danger-2' ),array( 'im im-icon-Danger' => 'Danger' ),array( 'im im-icon-Dashboard' => 'Dashboard' ),array( 'im im-icon-Data-Backup' => 'Data-Backup' ),array( 'im im-icon-Data-Block' => 'Data-Block' ),array( 'im im-icon-Data-Center' => 'Data-Center' ),array( 'im im-icon-Data-Clock' => 'Data-Clock' ),array( 'im im-icon-Data-Cloud' => 'Data-Cloud' ),array( 'im im-icon-Data-Compress' => 'Data-Compress' ),array( 'im im-icon-Data-Copy' => 'Data-Copy' ),array( 'im im-icon-Data-Download' => 'Data-Download' ),array( 'im im-icon-Data-Financial' => 'Data-Financial' ),array( 'im im-icon-Data-Key' => 'Data-Key' ),array( 'im im-icon-Data-Lock' => 'Data-Lock' ),array( 'im im-icon-Data-Network' => 'Data-Network' ),array( 'im im-icon-Data-Password' => 'Data-Password' ),array( 'im im-icon-Data-Power' => 'Data-Power' ),array( 'im im-icon-Data-Refresh' => 'Data-Refresh' ),array( 'im im-icon-Data-Save' => 'Data-Save' ),array( 'im im-icon-Data-Search' => 'Data-Search' ),array( 'im im-icon-Data-Security' => 'Data-Security' ),array( 'im im-icon-Data-Settings' => 'Data-Settings' ),array( 'im im-icon-Data-Sharing' => 'Data-Sharing' ),array( 'im im-icon-Data-Shield' => 'Data-Shield' ),array( 'im im-icon-Data-Signal' => 'Data-Signal' ),array( 'im im-icon-Data-Storage' => 'Data-Storage' ),array( 'im im-icon-Data-Stream' => 'Data-Stream' ),array( 'im im-icon-Data-Transfer' => 'Data-Transfer' ),array( 'im im-icon-Data-Unlock' => 'Data-Unlock' ),array( 'im im-icon-Data-Upload' => 'Data-Upload' ),array( 'im im-icon-Data-Yes' => 'Data-Yes' ),array( 'im im-icon-Data' => 'Data' ),array( 'im im-icon-David-Star' => 'David-Star' ),array( 'im im-icon-Daylight' => 'Daylight' ),array( 'im im-icon-Death' => 'Death' ),array( 'im im-icon-Debian' => 'Debian' ),array( 'im im-icon-Dec' => 'Dec' ),array( 'im im-icon-Decrase-Inedit' => 'Decrase-Inedit' ),array( 'im im-icon-Deer-2' => 'Deer-2' ),array( 'im im-icon-Deer' => 'Deer' ),array( 'im im-icon-Delete-File' => 'Delete-File' ),array( 'im im-icon-Delete-Window' => 'Delete-Window' ),array( 'im im-icon-Delicious' => 'Delicious' ),array( 'im im-icon-Depression' => 'Depression' ),array( 'im im-icon-Deviantart' => 'Deviantart' ),array( 'im im-icon-Device-SyncwithCloud' => 'Device-SyncwithCloud' ),array( 'im im-icon-Diamond' => 'Diamond' ),array( 'im im-icon-Dice-2' => 'Dice-2' ),array( 'im im-icon-Dice' => 'Dice' ),array( 'im im-icon-Digg' => 'Digg' ),array( 'im im-icon-Digital-Drawing' => 'Digital-Drawing' ),array( 'im im-icon-Diigo' => 'Diigo' ),array( 'im im-icon-Dinosaur' => 'Dinosaur' ),array( 'im im-icon-Diploma-2' => 'Diploma-2' ),array( 'im im-icon-Diploma' => 'Diploma' ),array( 'im im-icon-Direction-East' => 'Direction-East' ),array( 'im im-icon-Direction-North' => 'Direction-North' ),array( 'im im-icon-Direction-South' => 'Direction-South' ),array( 'im im-icon-Direction-West' => 'Direction-West' ),array( 'im im-icon-Director' => 'Director' ),array( 'im im-icon-Disk' => 'Disk' ),array( 'im im-icon-Dj' => 'Dj' ),array( 'im im-icon-DNA-2' => 'DNA-2' ),array( 'im im-icon-DNA-Helix' => 'DNA-Helix' ),array( 'im im-icon-DNA' => 'DNA' ),array( 'im im-icon-Doctor' => 'Doctor' ),array( 'im im-icon-Dog' => 'Dog' ),array( 'im im-icon-Dollar-Sign' => 'Dollar-Sign' ),array( 'im im-icon-Dollar-Sign2' => 'Dollar-Sign2' ),array( 'im im-icon-Dollar' => 'Dollar' ),array( 'im im-icon-Dolphin' => 'Dolphin' ),array( 'im im-icon-Domino' => 'Domino' ),array( 'im im-icon-Door-Hanger' => 'Door-Hanger' ),array( 'im im-icon-Door' => 'Door' ),array( 'im im-icon-Doplr' => 'Doplr' ),array( 'im im-icon-Double-Circle' => 'Double-Circle' ),array( 'im im-icon-Double-Tap' => 'Double-Tap' ),array( 'im im-icon-Doughnut' => 'Doughnut' ),array( 'im im-icon-Dove' => 'Dove' ),array( 'im im-icon-Down-2' => 'Down-2' ),array( 'im im-icon-Down-3' => 'Down-3' ),array( 'im im-icon-Down-4' => 'Down-4' ),array( 'im im-icon-Down' => 'Down' ),array( 'im im-icon-Download-2' => 'Download-2' ),array( 'im im-icon-Download-fromCloud' => 'Download-fromCloud' ),array( 'im im-icon-Download-Window' => 'Download-Window' ),array( 'im im-icon-Download' => 'Download' ),array( 'im im-icon-Downward' => 'Downward' ),array( 'im im-icon-Drag-Down' => 'Drag-Down' ),array( 'im im-icon-Drag-Left' => 'Drag-Left' ),array( 'im im-icon-Drag-Right' => 'Drag-Right' ),array( 'im im-icon-Drag-Up' => 'Drag-Up' ),array( 'im im-icon-Drag' => 'Drag' ),array( 'im im-icon-Dress' => 'Dress' ),array( 'im im-icon-Drill-2' => 'Drill-2' ),array( 'im im-icon-Drill' => 'Drill' ),array( 'im im-icon-Drop' => 'Drop' ),array( 'im im-icon-Dropbox' => 'Dropbox' ),array( 'im im-icon-Drum' => 'Drum' ),array( 'im im-icon-Dry' => 'Dry' ),array( 'im im-icon-Duck' => 'Duck' ),array( 'im im-icon-Dumbbell' => 'Dumbbell' ),array( 'im im-icon-Duplicate-Layer' => 'Duplicate-Layer' ),array( 'im im-icon-Duplicate-Window' => 'Duplicate-Window' ),array( 'im im-icon-DVD' => 'DVD' ),array( 'im im-icon-Eagle' => 'Eagle' ),array( 'im im-icon-Ear' => 'Ear' ),array( 'im im-icon-Earphones-2' => 'Earphones-2' ),array( 'im im-icon-Earphones' => 'Earphones' ),array( 'im im-icon-Eci-Icon' => 'Eci-Icon' ),array( 'im im-icon-Edit-Map' => 'Edit-Map' ),array( 'im im-icon-Edit' => 'Edit' ),array( 'im im-icon-Eggs' => 'Eggs' ),array( 'im im-icon-Egypt' => 'Egypt' ),array( 'im im-icon-Eifel-Tower' => 'Eifel-Tower' ),array( 'im im-icon-eject-2' => 'eject-2' ),array( 'im im-icon-Eject' => 'Eject' ),array( 'im im-icon-El-Castillo' => 'El-Castillo' ),array( 'im im-icon-Elbow' => 'Elbow' ),array( 'im im-icon-Electric-Guitar' => 'Electric-Guitar' ),array( 'im im-icon-Electricity' => 'Electricity' ),array( 'im im-icon-Elephant' => 'Elephant' ),array( 'im im-icon-Email' => 'Email' ),array( 'im im-icon-Embassy' => 'Embassy' ),array( 'im im-icon-Empire-StateBuilding' => 'Empire-StateBuilding' ),array( 'im im-icon-Empty-Box' => 'Empty-Box' ),array( 'im im-icon-End2' => 'End2' ),array( 'im im-icon-End-2' => 'End-2' ),array( 'im im-icon-End' => 'End' ),array( 'im im-icon-Endways' => 'Endways' ),array( 'im im-icon-Engineering' => 'Engineering' ),array( 'im im-icon-Envelope-2' => 'Envelope-2' ),array( 'im im-icon-Envelope' => 'Envelope' ),array( 'im im-icon-Environmental-2' => 'Environmental-2' ),array( 'im im-icon-Environmental-3' => 'Environmental-3' ),array( 'im im-icon-Environmental' => 'Environmental' ),array( 'im im-icon-Equalizer' => 'Equalizer' ),array( 'im im-icon-Eraser-2' => 'Eraser-2' ),array( 'im im-icon-Eraser-3' => 'Eraser-3' ),array( 'im im-icon-Eraser' => 'Eraser' ),array( 'im im-icon-Error-404Window' => 'Error-404Window' ),array( 'im im-icon-Euro-Sign' => 'Euro-Sign' ),array( 'im im-icon-Euro-Sign2' => 'Euro-Sign2' ),array( 'im im-icon-Euro' => 'Euro' ),array( 'im im-icon-Evernote' => 'Evernote' ),array( 'im im-icon-Evil' => 'Evil' ),array( 'im im-icon-Explode' => 'Explode' ),array( 'im im-icon-Eye-2' => 'Eye-2' ),array( 'im im-icon-Eye-Blind' => 'Eye-Blind' ),array( 'im im-icon-Eye-Invisible' => 'Eye-Invisible' ),array( 'im im-icon-Eye-Scan' => 'Eye-Scan' ),array( 'im im-icon-Eye-Visible' => 'Eye-Visible' ),array( 'im im-icon-Eye' => 'Eye' ),array( 'im im-icon-Eyebrow-2' => 'Eyebrow-2' ),array( 'im im-icon-Eyebrow-3' => 'Eyebrow-3' ),array( 'im im-icon-Eyebrow' => 'Eyebrow' ),array( 'im im-icon-Eyeglasses-Smiley' => 'Eyeglasses-Smiley' ),array( 'im im-icon-Eyeglasses-Smiley2' => 'Eyeglasses-Smiley2' ),array( 'im im-icon-Face-Style' => 'Face-Style' ),array( 'im im-icon-Face-Style2' => 'Face-Style2' ),array( 'im im-icon-Face-Style3' => 'Face-Style3' ),array( 'im im-icon-Face-Style4' => 'Face-Style4' ),array( 'im im-icon-Face-Style5' => 'Face-Style5' ),array( 'im im-icon-Face-Style6' => 'Face-Style6' ),array( 'im im-icon-Facebook-2' => 'Facebook-2' ),array( 'im im-icon-Facebook' => 'Facebook' ),array( 'im im-icon-Factory-2' => 'Factory-2' ),array( 'im im-icon-Factory' => 'Factory' ),array( 'im im-icon-Fahrenheit' => 'Fahrenheit' ),array( 'im im-icon-Family-Sign' => 'Family-Sign' ),array( 'im im-icon-Fan' => 'Fan' ),array( 'im im-icon-Farmer' => 'Farmer' ),array( 'im im-icon-Fashion' => 'Fashion' ),array( 'im im-icon-Favorite-Window' => 'Favorite-Window' ),array( 'im im-icon-Fax' => 'Fax' ),array( 'im im-icon-Feather' => 'Feather' ),array( 'im im-icon-Feedburner' => 'Feedburner' ),array( 'im im-icon-Female-2' => 'Female-2' ),array( 'im im-icon-Female-Sign' => 'Female-Sign' ),array( 'im im-icon-Female' => 'Female' ),array( 'im im-icon-File-Block' => 'File-Block' ),array( 'im im-icon-File-Bookmark' => 'File-Bookmark' ),array( 'im im-icon-File-Chart' => 'File-Chart' ),array( 'im im-icon-File-Clipboard' => 'File-Clipboard' ),array( 'im im-icon-File-ClipboardFileText' => 'File-ClipboardFileText' ),array( 'im im-icon-File-ClipboardTextImage' => 'File-ClipboardTextImage' ),array( 'im im-icon-File-Cloud' => 'File-Cloud' ),array( 'im im-icon-File-Copy' => 'File-Copy' ),array( 'im im-icon-File-Copy2' => 'File-Copy2' ),array( 'im im-icon-File-CSV' => 'File-CSV' ),array( 'im im-icon-File-Download' => 'File-Download' ),array( 'im im-icon-File-Edit' => 'File-Edit' ),array( 'im im-icon-File-Excel' => 'File-Excel' ),array( 'im im-icon-File-Favorite' => 'File-Favorite' ),array( 'im im-icon-File-Fire' => 'File-Fire' ),array( 'im im-icon-File-Graph' => 'File-Graph' ),array( 'im im-icon-File-Hide' => 'File-Hide' ),array( 'im im-icon-File-Horizontal' => 'File-Horizontal' ),array( 'im im-icon-File-HorizontalText' => 'File-HorizontalText' ),array( 'im im-icon-File-HTML' => 'File-HTML' ),array( 'im im-icon-File-JPG' => 'File-JPG' ),array( 'im im-icon-File-Link' => 'File-Link' ),array( 'im im-icon-File-Loading' => 'File-Loading' ),array( 'im im-icon-File-Lock' => 'File-Lock' ),array( 'im im-icon-File-Love' => 'File-Love' ),array( 'im im-icon-File-Music' => 'File-Music' ),array( 'im im-icon-File-Network' => 'File-Network' ),array( 'im im-icon-File-Pictures' => 'File-Pictures' ),array( 'im im-icon-File-Pie' => 'File-Pie' ),array( 'im im-icon-File-Presentation' => 'File-Presentation' ),array( 'im im-icon-File-Refresh' => 'File-Refresh' ),array( 'im im-icon-File-Search' => 'File-Search' ),array( 'im im-icon-File-Settings' => 'File-Settings' ),array( 'im im-icon-File-Share' => 'File-Share' ),array( 'im im-icon-File-TextImage' => 'File-TextImage' ),array( 'im im-icon-File-Trash' => 'File-Trash' ),array( 'im im-icon-File-TXT' => 'File-TXT' ),array( 'im im-icon-File-Upload' => 'File-Upload' ),array( 'im im-icon-File-Video' => 'File-Video' ),array( 'im im-icon-File-Word' => 'File-Word' ),array( 'im im-icon-File-Zip' => 'File-Zip' ),array( 'im im-icon-File' => 'File' ),array( 'im im-icon-Files' => 'Files' ),array( 'im im-icon-Film-Board' => 'Film-Board' ),array( 'im im-icon-Film-Cartridge' => 'Film-Cartridge' ),array( 'im im-icon-Film-Strip' => 'Film-Strip' ),array( 'im im-icon-Film-Video' => 'Film-Video' ),array( 'im im-icon-Film' => 'Film' ),array( 'im im-icon-Filter-2' => 'Filter-2' ),array( 'im im-icon-Filter' => 'Filter' ),array( 'im im-icon-Financial' => 'Financial' ),array( 'im im-icon-Find-User' => 'Find-User' ),array( 'im im-icon-Finger-DragFourSides' => 'Finger-DragFourSides' ),array( 'im im-icon-Finger-DragTwoSides' => 'Finger-DragTwoSides' ),array( 'im im-icon-Finger-Print' => 'Finger-Print' ),array( 'im im-icon-Finger' => 'Finger' ),array( 'im im-icon-Fingerprint-2' => 'Fingerprint-2' ),array( 'im im-icon-Fingerprint' => 'Fingerprint' ),array( 'im im-icon-Fire-Flame' => 'Fire-Flame' ),array( 'im im-icon-Fire-Flame2' => 'Fire-Flame2' ),array( 'im im-icon-Fire-Hydrant' => 'Fire-Hydrant' ),array( 'im im-icon-Fire-Staion' => 'Fire-Staion' ),array( 'im im-icon-Firefox' => 'Firefox' ),array( 'im im-icon-Firewall' => 'Firewall' ),array( 'im im-icon-First-Aid' => 'First-Aid' ),array( 'im im-icon-First' => 'First' ),array( 'im im-icon-Fish-Food' => 'Fish-Food' ),array( 'im im-icon-Fish' => 'Fish' ),array( 'im im-icon-Fit-To' => 'Fit-To' ),array( 'im im-icon-Fit-To2' => 'Fit-To2' ),array( 'im im-icon-Five-Fingers' => 'Five-Fingers' ),array( 'im im-icon-Five-FingersDrag' => 'Five-FingersDrag' ),array( 'im im-icon-Five-FingersDrag2' => 'Five-FingersDrag2' ),array( 'im im-icon-Five-FingersTouch' => 'Five-FingersTouch' ),array( 'im im-icon-Flag-2' => 'Flag-2' ),array( 'im im-icon-Flag-3' => 'Flag-3' ),array( 'im im-icon-Flag-4' => 'Flag-4' ),array( 'im im-icon-Flag-5' => 'Flag-5' ),array( 'im im-icon-Flag-6' => 'Flag-6' ),array( 'im im-icon-Flag' => 'Flag' ),array( 'im im-icon-Flamingo' => 'Flamingo' ),array( 'im im-icon-Flash-2' => 'Flash-2' ),array( 'im im-icon-Flash-Video' => 'Flash-Video' ),array( 'im im-icon-Flash' => 'Flash' ),array( 'im im-icon-Flashlight' => 'Flashlight' ),array( 'im im-icon-Flask-2' => 'Flask-2' ),array( 'im im-icon-Flask' => 'Flask' ),array( 'im im-icon-Flick' => 'Flick' ),array( 'im im-icon-Flickr' => 'Flickr' ),array( 'im im-icon-Flowerpot' => 'Flowerpot' ),array( 'im im-icon-Fluorescent' => 'Fluorescent' ),array( 'im im-icon-Fog-Day' => 'Fog-Day' ),array( 'im im-icon-Fog-Night' => 'Fog-Night' ),array( 'im im-icon-Folder-Add' => 'Folder-Add' ),array( 'im im-icon-Folder-Archive' => 'Folder-Archive' ),array( 'im im-icon-Folder-Binder' => 'Folder-Binder' ),array( 'im im-icon-Folder-Binder2' => 'Folder-Binder2' ),array( 'im im-icon-Folder-Block' => 'Folder-Block' ),array( 'im im-icon-Folder-Bookmark' => 'Folder-Bookmark' ),array( 'im im-icon-Folder-Close' => 'Folder-Close' ),array( 'im im-icon-Folder-Cloud' => 'Folder-Cloud' ),array( 'im im-icon-Folder-Delete' => 'Folder-Delete' ),array( 'im im-icon-Folder-Download' => 'Folder-Download' ),array( 'im im-icon-Folder-Edit' => 'Folder-Edit' ),array( 'im im-icon-Folder-Favorite' => 'Folder-Favorite' ),array( 'im im-icon-Folder-Fire' => 'Folder-Fire' ),array( 'im im-icon-Folder-Hide' => 'Folder-Hide' ),array( 'im im-icon-Folder-Link' => 'Folder-Link' ),array( 'im im-icon-Folder-Loading' => 'Folder-Loading' ),array( 'im im-icon-Folder-Lock' => 'Folder-Lock' ),array( 'im im-icon-Folder-Love' => 'Folder-Love' ),array( 'im im-icon-Folder-Music' => 'Folder-Music' ),array( 'im im-icon-Folder-Network' => 'Folder-Network' ),array( 'im im-icon-Folder-Open' => 'Folder-Open' ),array( 'im im-icon-Folder-Open2' => 'Folder-Open2' ),array( 'im im-icon-Folder-Organizing' => 'Folder-Organizing' ),array( 'im im-icon-Folder-Pictures' => 'Folder-Pictures' ),array( 'im im-icon-Folder-Refresh' => 'Folder-Refresh' ),array( 'im im-icon-Folder-Remove-' => 'Folder-Remove-' ),array( 'im im-icon-Folder-Search' => 'Folder-Search' ),array( 'im im-icon-Folder-Settings' => 'Folder-Settings' ),array( 'im im-icon-Folder-Share' => 'Folder-Share' ),array( 'im im-icon-Folder-Trash' => 'Folder-Trash' ),array( 'im im-icon-Folder-Upload' => 'Folder-Upload' ),array( 'im im-icon-Folder-Video' => 'Folder-Video' ),array( 'im im-icon-Folder-WithDocument' => 'Folder-WithDocument' ),array( 'im im-icon-Folder-Zip' => 'Folder-Zip' ),array( 'im im-icon-Folder' => 'Folder' ),array( 'im im-icon-Folders' => 'Folders' ),array( 'im im-icon-Font-Color' => 'Font-Color' ),array( 'im im-icon-Font-Name' => 'Font-Name' ),array( 'im im-icon-Font-Size' => 'Font-Size' ),array( 'im im-icon-Font-Style' => 'Font-Style' ),array( 'im im-icon-Font-StyleSubscript' => 'Font-StyleSubscript' ),array( 'im im-icon-Font-StyleSuperscript' => 'Font-StyleSuperscript' ),array( 'im im-icon-Font-Window' => 'Font-Window' ),array( 'im im-icon-Foot-2' => 'Foot-2' ),array( 'im im-icon-Foot' => 'Foot' ),array( 'im im-icon-Football-2' => 'Football-2' ),array( 'im im-icon-Football' => 'Football' ),array( 'im im-icon-Footprint-2' => 'Footprint-2' ),array( 'im im-icon-Footprint-3' => 'Footprint-3' ),array( 'im im-icon-Footprint' => 'Footprint' ),array( 'im im-icon-Forest' => 'Forest' ),array( 'im im-icon-Fork' => 'Fork' ),array( 'im im-icon-Formspring' => 'Formspring' ),array( 'im im-icon-Formula' => 'Formula' ),array( 'im im-icon-Forsquare' => 'Forsquare' ),array( 'im im-icon-Forward' => 'Forward' ),array( 'im im-icon-Fountain-Pen' => 'Fountain-Pen' ),array( 'im im-icon-Four-Fingers' => 'Four-Fingers' ),array( 'im im-icon-Four-FingersDrag' => 'Four-FingersDrag' ),array( 'im im-icon-Four-FingersDrag2' => 'Four-FingersDrag2' ),array( 'im im-icon-Four-FingersTouch' => 'Four-FingersTouch' ),array( 'im im-icon-Fox' => 'Fox' ),array( 'im im-icon-Frankenstein' => 'Frankenstein' ),array( 'im im-icon-French-Fries' => 'French-Fries' ),array( 'im im-icon-Friendfeed' => 'Friendfeed' ),array( 'im im-icon-Friendster' => 'Friendster' ),array( 'im im-icon-Frog' => 'Frog' ),array( 'im im-icon-Fruits' => 'Fruits' ),array( 'im im-icon-Fuel' => 'Fuel' ),array( 'im im-icon-Full-Bag' => 'Full-Bag' ),array( 'im im-icon-Full-Basket' => 'Full-Basket' ),array( 'im im-icon-Full-Cart' => 'Full-Cart' ),array( 'im im-icon-Full-Moon' => 'Full-Moon' ),array( 'im im-icon-Full-Screen' => 'Full-Screen' ),array( 'im im-icon-Full-Screen2' => 'Full-Screen2' ),array( 'im im-icon-Full-View' => 'Full-View' ),array( 'im im-icon-Full-View2' => 'Full-View2' ),array( 'im im-icon-Full-ViewWindow' => 'Full-ViewWindow' ),array( 'im im-icon-Function' => 'Function' ),array( 'im im-icon-Funky' => 'Funky' ),array( 'im im-icon-Funny-Bicycle' => 'Funny-Bicycle' ),array( 'im im-icon-Furl' => 'Furl' ),array( 'im im-icon-Gamepad-2' => 'Gamepad-2' ),array( 'im im-icon-Gamepad' => 'Gamepad' ),array( 'im im-icon-Gas-Pump' => 'Gas-Pump' ),array( 'im im-icon-Gaugage-2' => 'Gaugage-2' ),array( 'im im-icon-Gaugage' => 'Gaugage' ),array( 'im im-icon-Gay' => 'Gay' ),array( 'im im-icon-Gear-2' => 'Gear-2' ),array( 'im im-icon-Gear' => 'Gear' ),array( 'im im-icon-Gears-2' => 'Gears-2' ),array( 'im im-icon-Gears' => 'Gears' ),array( 'im im-icon-Geek-2' => 'Geek-2' ),array( 'im im-icon-Geek' => 'Geek' ),array( 'im im-icon-Gemini-2' => 'Gemini-2' ),array( 'im im-icon-Gemini' => 'Gemini' ),array( 'im im-icon-Genius' => 'Genius' ),array( 'im im-icon-Gentleman' => 'Gentleman' ),array( 'im im-icon-Geo--' => 'Geo--' ),array( 'im im-icon-Geo-' => 'Geo-' ),array( 'im im-icon-Geo-Close' => 'Geo-Close' ),array( 'im im-icon-Geo-Love' => 'Geo-Love' ),array( 'im im-icon-Geo-Number' => 'Geo-Number' ),array( 'im im-icon-Geo-Star' => 'Geo-Star' ),array( 'im im-icon-Geo' => 'Geo' ),array( 'im im-icon-Geo2--' => 'Geo2--' ),array( 'im im-icon-Geo2-' => 'Geo2-' ),array( 'im im-icon-Geo2-Close' => 'Geo2-Close' ),array( 'im im-icon-Geo2-Love' => 'Geo2-Love' ),array( 'im im-icon-Geo2-Number' => 'Geo2-Number' ),array( 'im im-icon-Geo2-Star' => 'Geo2-Star' ),array( 'im im-icon-Geo2' => 'Geo2' ),array( 'im im-icon-Geo3--' => 'Geo3--' ),array( 'im im-icon-Geo3-' => 'Geo3-' ),array( 'im im-icon-Geo3-Close' => 'Geo3-Close' ),array( 'im im-icon-Geo3-Love' => 'Geo3-Love' ),array( 'im im-icon-Geo3-Number' => 'Geo3-Number' ),array( 'im im-icon-Geo3-Star' => 'Geo3-Star' ),array( 'im im-icon-Geo3' => 'Geo3' ),array( 'im im-icon-Gey' => 'Gey' ),array( 'im im-icon-Gift-Box' => 'Gift-Box' ),array( 'im im-icon-Giraffe' => 'Giraffe' ),array( 'im im-icon-Girl' => 'Girl' ),array( 'im im-icon-Glass-Water' => 'Glass-Water' ),array( 'im im-icon-Glasses-2' => 'Glasses-2' ),array( 'im im-icon-Glasses-3' => 'Glasses-3' ),array( 'im im-icon-Glasses' => 'Glasses' ),array( 'im im-icon-Global-Position' => 'Global-Position' ),array( 'im im-icon-Globe-2' => 'Globe-2' ),array( 'im im-icon-Globe' => 'Globe' ),array( 'im im-icon-Gloves' => 'Gloves' ),array( 'im im-icon-Go-Bottom' => 'Go-Bottom' ),array( 'im im-icon-Go-Top' => 'Go-Top' ),array( 'im im-icon-Goggles' => 'Goggles' ),array( 'im im-icon-Golf-2' => 'Golf-2' ),array( 'im im-icon-Golf' => 'Golf' ),array( 'im im-icon-Google-Buzz' => 'Google-Buzz' ),array( 'im im-icon-Google-Drive' => 'Google-Drive' ),array( 'im im-icon-Google-Play' => 'Google-Play' ),array( 'im im-icon-Google-Plus' => 'Google-Plus' ),array( 'im im-icon-Google' => 'Google' ),array( 'im im-icon-Gopro' => 'Gopro' ),array( 'im im-icon-Gorilla' => 'Gorilla' ),array( 'im im-icon-Gowalla' => 'Gowalla' ),array( 'im im-icon-Grave' => 'Grave' ),array( 'im im-icon-Graveyard' => 'Graveyard' ),array( 'im im-icon-Greece' => 'Greece' ),array( 'im im-icon-Green-Energy' => 'Green-Energy' ),array( 'im im-icon-Green-House' => 'Green-House' ),array( 'im im-icon-Guitar' => 'Guitar' ),array( 'im im-icon-Gun-2' => 'Gun-2' ),array( 'im im-icon-Gun-3' => 'Gun-3' ),array( 'im im-icon-Gun' => 'Gun' ),array( 'im im-icon-Gymnastics' => 'Gymnastics' ),array( 'im im-icon-Hair-2' => 'Hair-2' ),array( 'im im-icon-Hair-3' => 'Hair-3' ),array( 'im im-icon-Hair-4' => 'Hair-4' ),array( 'im im-icon-Hair' => 'Hair' ),array( 'im im-icon-Half-Moon' => 'Half-Moon' ),array( 'im im-icon-Halloween-HalfMoon' => 'Halloween-HalfMoon' ),array( 'im im-icon-Halloween-Moon' => 'Halloween-Moon' ),array( 'im im-icon-Hamburger' => 'Hamburger' ),array( 'im im-icon-Hammer' => 'Hammer' ),array( 'im im-icon-Hand-Touch' => 'Hand-Touch' ),array( 'im im-icon-Hand-Touch2' => 'Hand-Touch2' ),array( 'im im-icon-Hand-TouchSmartphone' => 'Hand-TouchSmartphone' ),array( 'im im-icon-Hand' => 'Hand' ),array( 'im im-icon-Hands' => 'Hands' ),array( 'im im-icon-Handshake' => 'Handshake' ),array( 'im im-icon-Hanger' => 'Hanger' ),array( 'im im-icon-Happy' => 'Happy' ),array( 'im im-icon-Hat-2' => 'Hat-2' ),array( 'im im-icon-Hat' => 'Hat' ),array( 'im im-icon-Haunted-House' => 'Haunted-House' ),array( 'im im-icon-HD-Video' => 'HD-Video' ),array( 'im im-icon-HD' => 'HD' ),array( 'im im-icon-HDD' => 'HDD' ),array( 'im im-icon-Headphone' => 'Headphone' ),array( 'im im-icon-Headphones' => 'Headphones' ),array( 'im im-icon-Headset' => 'Headset' ),array( 'im im-icon-Heart-2' => 'Heart-2' ),array( 'im im-icon-Heart' => 'Heart' ),array( 'im im-icon-Heels-2' => 'Heels-2' ),array( 'im im-icon-Heels' => 'Heels' ),array( 'im im-icon-Height-Window' => 'Height-Window' ),array( 'im im-icon-Helicopter-2' => 'Helicopter-2' ),array( 'im im-icon-Helicopter' => 'Helicopter' ),array( 'im im-icon-Helix-2' => 'Helix-2' ),array( 'im im-icon-Hello' => 'Hello' ),array( 'im im-icon-Helmet-2' => 'Helmet-2' ),array( 'im im-icon-Helmet-3' => 'Helmet-3' ),array( 'im im-icon-Helmet' => 'Helmet' ),array( 'im im-icon-Hipo' => 'Hipo' ),array( 'im im-icon-Hipster-Glasses' => 'Hipster-Glasses' ),array( 'im im-icon-Hipster-Glasses2' => 'Hipster-Glasses2' ),array( 'im im-icon-Hipster-Glasses3' => 'Hipster-Glasses3' ),array( 'im im-icon-Hipster-Headphones' => 'Hipster-Headphones' ),array( 'im im-icon-Hipster-Men' => 'Hipster-Men' ),array( 'im im-icon-Hipster-Men2' => 'Hipster-Men2' ),array( 'im im-icon-Hipster-Men3' => 'Hipster-Men3' ),array( 'im im-icon-Hipster-Sunglasses' => 'Hipster-Sunglasses' ),array( 'im im-icon-Hipster-Sunglasses2' => 'Hipster-Sunglasses2' ),array( 'im im-icon-Hipster-Sunglasses3' => 'Hipster-Sunglasses3' ),array( 'im im-icon-Hokey' => 'Hokey' ),array( 'im im-icon-Holly' => 'Holly' ),array( 'im im-icon-Home-2' => 'Home-2' ),array( 'im im-icon-Home-3' => 'Home-3' ),array( 'im im-icon-Home-4' => 'Home-4' ),array( 'im im-icon-Home-5' => 'Home-5' ),array( 'im im-icon-Home-Window' => 'Home-Window' ),array( 'im im-icon-Home' => 'Home' ),array( 'im im-icon-Homosexual' => 'Homosexual' ),array( 'im im-icon-Honey' => 'Honey' ),array( 'im im-icon-Hong-Kong' => 'Hong-Kong' ),array( 'im im-icon-Hoodie' => 'Hoodie' ),array( 'im im-icon-Horror' => 'Horror' ),array( 'im im-icon-Horse' => 'Horse' ),array( 'im im-icon-Hospital-2' => 'Hospital-2' ),array( 'im im-icon-Hospital' => 'Hospital' ),array( 'im im-icon-Host' => 'Host' ),array( 'im im-icon-Hot-Dog' => 'Hot-Dog' ),array( 'im im-icon-Hotel' => 'Hotel' ),array( 'im im-icon-Hour' => 'Hour' ),array( 'im im-icon-Hub' => 'Hub' ),array( 'im im-icon-Humor' => 'Humor' ),array( 'im im-icon-Hurt' => 'Hurt' ),array( 'im im-icon-Ice-Cream' => 'Ice-Cream' ),array( 'im im-icon-ICQ' => 'ICQ' ),array( 'im im-icon-ID-2' => 'ID-2' ),array( 'im im-icon-ID-3' => 'ID-3' ),array( 'im im-icon-ID-Card' => 'ID-Card' ),array( 'im im-icon-Idea-2' => 'Idea-2' ),array( 'im im-icon-Idea-3' => 'Idea-3' ),array( 'im im-icon-Idea-4' => 'Idea-4' ),array( 'im im-icon-Idea-5' => 'Idea-5' ),array( 'im im-icon-Idea' => 'Idea' ),array( 'im im-icon-Identification-Badge' => 'Identification-Badge' ),array( 'im im-icon-ImDB' => 'ImDB' ),array( 'im im-icon-Inbox-Empty' => 'Inbox-Empty' ),array( 'im im-icon-Inbox-Forward' => 'Inbox-Forward' ),array( 'im im-icon-Inbox-Full' => 'Inbox-Full' ),array( 'im im-icon-Inbox-Into' => 'Inbox-Into' ),array( 'im im-icon-Inbox-Out' => 'Inbox-Out' ),array( 'im im-icon-Inbox-Reply' => 'Inbox-Reply' ),array( 'im im-icon-Inbox' => 'Inbox' ),array( 'im im-icon-Increase-Inedit' => 'Increase-Inedit' ),array( 'im im-icon-Indent-FirstLine' => 'Indent-FirstLine' ),array( 'im im-icon-Indent-LeftMargin' => 'Indent-LeftMargin' ),array( 'im im-icon-Indent-RightMargin' => 'Indent-RightMargin' ),array( 'im im-icon-India' => 'India' ),array( 'im im-icon-Info-Window' => 'Info-Window' ),array( 'im im-icon-Information' => 'Information' ),array( 'im im-icon-Inifity' => 'Inifity' ),array( 'im im-icon-Instagram' => 'Instagram' ),array( 'im im-icon-Internet-2' => 'Internet-2' ),array( 'im im-icon-Internet-Explorer' => 'Internet-Explorer' ),array( 'im im-icon-Internet-Smiley' => 'Internet-Smiley' ),array( 'im im-icon-Internet' => 'Internet' ),array( 'im im-icon-iOS-Apple' => 'iOS-Apple' ),array( 'im im-icon-Israel' => 'Israel' ),array( 'im im-icon-Italic-Text' => 'Italic-Text' ),array( 'im im-icon-Jacket-2' => 'Jacket-2' ),array( 'im im-icon-Jacket' => 'Jacket' ),array( 'im im-icon-Jamaica' => 'Jamaica' ),array( 'im im-icon-Japan' => 'Japan' ),array( 'im im-icon-Japanese-Gate' => 'Japanese-Gate' ),array( 'im im-icon-Jeans' => 'Jeans' ),array( 'im im-icon-Jeep-2' => 'Jeep-2' ),array( 'im im-icon-Jeep' => 'Jeep' ),array( 'im im-icon-Jet' => 'Jet' ),array( 'im im-icon-Joystick' => 'Joystick' ),array( 'im im-icon-Juice' => 'Juice' ),array( 'im im-icon-Jump-Rope' => 'Jump-Rope' ),array( 'im im-icon-Kangoroo' => 'Kangoroo' ),array( 'im im-icon-Kenya' => 'Kenya' ),array( 'im im-icon-Key-2' => 'Key-2' ),array( 'im im-icon-Key-3' => 'Key-3' ),array( 'im im-icon-Key-Lock' => 'Key-Lock' ),array( 'im im-icon-Key' => 'Key' ),array( 'im im-icon-Keyboard' => 'Keyboard' ),array( 'im im-icon-Keyboard3' => 'Keyboard3' ),array( 'im im-icon-Keypad' => 'Keypad' ),array( 'im im-icon-King-2' => 'King-2' ),array( 'im im-icon-King' => 'King' ),array( 'im im-icon-Kiss' => 'Kiss' ),array( 'im im-icon-Knee' => 'Knee' ),array( 'im im-icon-Knife-2' => 'Knife-2' ),array( 'im im-icon-Knife' => 'Knife' ),array( 'im im-icon-Knight' => 'Knight' ),array( 'im im-icon-Koala' => 'Koala' ),array( 'im im-icon-Korea' => 'Korea' ),array( 'im im-icon-Lamp' => 'Lamp' ),array( 'im im-icon-Landscape-2' => 'Landscape-2' ),array( 'im im-icon-Landscape' => 'Landscape' ),array( 'im im-icon-Lantern' => 'Lantern' ),array( 'im im-icon-Laptop-2' => 'Laptop-2' ),array( 'im im-icon-Laptop-3' => 'Laptop-3' ),array( 'im im-icon-Laptop-Phone' => 'Laptop-Phone' ),array( 'im im-icon-Laptop-Secure' => 'Laptop-Secure' ),array( 'im im-icon-Laptop-Tablet' => 'Laptop-Tablet' ),array( 'im im-icon-Laptop' => 'Laptop' ),array( 'im im-icon-Laser' => 'Laser' ),array( 'im im-icon-Last-FM' => 'Last-FM' ),array( 'im im-icon-Last' => 'Last' ),array( 'im im-icon-Laughing' => 'Laughing' ),array( 'im im-icon-Layer-1635' => 'Layer-1635' ),array( 'im im-icon-Layer-1646' => 'Layer-1646' ),array( 'im im-icon-Layer-Backward' => 'Layer-Backward' ),array( 'im im-icon-Layer-Forward' => 'Layer-Forward' ),array( 'im im-icon-Leafs-2' => 'Leafs-2' ),array( 'im im-icon-Leafs' => 'Leafs' ),array( 'im im-icon-Leaning-Tower' => 'Leaning-Tower' ),array( 'im im-icon-Left--Right' => 'Left--Right' ),array( 'im im-icon-Left--Right3' => 'Left--Right3' ),array( 'im im-icon-Left-2' => 'Left-2' ),array( 'im im-icon-Left-3' => 'Left-3' ),array( 'im im-icon-Left-4' => 'Left-4' ),array( 'im im-icon-Left-ToRight' => 'Left-ToRight' ),array( 'im im-icon-Left' => 'Left' ),array( 'im im-icon-Leg-2' => 'Leg-2' ),array( 'im im-icon-Leg' => 'Leg' ),array( 'im im-icon-Lego' => 'Lego' ),array( 'im im-icon-Lemon' => 'Lemon' ),array( 'im im-icon-Len-2' => 'Len-2' ),array( 'im im-icon-Len-3' => 'Len-3' ),array( 'im im-icon-Len' => 'Len' ),array( 'im im-icon-Leo-2' => 'Leo-2' ),array( 'im im-icon-Leo' => 'Leo' ),array( 'im im-icon-Leopard' => 'Leopard' ),array( 'im im-icon-Lesbian' => 'Lesbian' ),array( 'im im-icon-Lesbians' => 'Lesbians' ),array( 'im im-icon-Letter-Close' => 'Letter-Close' ),array( 'im im-icon-Letter-Open' => 'Letter-Open' ),array( 'im im-icon-Letter-Sent' => 'Letter-Sent' ),array( 'im im-icon-Libra-2' => 'Libra-2' ),array( 'im im-icon-Libra' => 'Libra' ),array( 'im im-icon-Library-2' => 'Library-2' ),array( 'im im-icon-Library' => 'Library' ),array( 'im im-icon-Life-Jacket' => 'Life-Jacket' ),array( 'im im-icon-Life-Safer' => 'Life-Safer' ),array( 'im im-icon-Light-Bulb' => 'Light-Bulb' ),array( 'im im-icon-Light-Bulb2' => 'Light-Bulb2' ),array( 'im im-icon-Light-BulbLeaf' => 'Light-BulbLeaf' ),array( 'im im-icon-Lighthouse' => 'Lighthouse' ),array( 'im im-icon-Like-2' => 'Like-2' ),array( 'im im-icon-Like' => 'Like' ),array( 'im im-icon-Line-Chart' => 'Line-Chart' ),array( 'im im-icon-Line-Chart2' => 'Line-Chart2' ),array( 'im im-icon-Line-Chart3' => 'Line-Chart3' ),array( 'im im-icon-Line-Chart4' => 'Line-Chart4' ),array( 'im im-icon-Line-Spacing' => 'Line-Spacing' ),array( 'im im-icon-Line-SpacingText' => 'Line-SpacingText' ),array( 'im im-icon-Link-2' => 'Link-2' ),array( 'im im-icon-Link' => 'Link' ),array( 'im im-icon-Linkedin-2' => 'Linkedin-2' ),array( 'im im-icon-Linkedin' => 'Linkedin' ),array( 'im im-icon-Linux' => 'Linux' ),array( 'im im-icon-Lion' => 'Lion' ),array( 'im im-icon-Livejournal' => 'Livejournal' ),array( 'im im-icon-Loading-2' => 'Loading-2' ),array( 'im im-icon-Loading-3' => 'Loading-3' ),array( 'im im-icon-Loading-Window' => 'Loading-Window' ),array( 'im im-icon-Loading' => 'Loading' ),array( 'im im-icon-Location-2' => 'Location-2' ),array( 'im im-icon-Location' => 'Location' ),array( 'im im-icon-Lock-2' => 'Lock-2' ),array( 'im im-icon-Lock-3' => 'Lock-3' ),array( 'im im-icon-Lock-User' => 'Lock-User' ),array( 'im im-icon-Lock-Window' => 'Lock-Window' ),array( 'im im-icon-Lock' => 'Lock' ),array( 'im im-icon-Lollipop-2' => 'Lollipop-2' ),array( 'im im-icon-Lollipop-3' => 'Lollipop-3' ),array( 'im im-icon-Lollipop' => 'Lollipop' ),array( 'im im-icon-Loop' => 'Loop' ),array( 'im im-icon-Loud' => 'Loud' ),array( 'im im-icon-Loudspeaker' => 'Loudspeaker' ),array( 'im im-icon-Love-2' => 'Love-2' ),array( 'im im-icon-Love-User' => 'Love-User' ),array( 'im im-icon-Love-Window' => 'Love-Window' ),array( 'im im-icon-Love' => 'Love' ),array( 'im im-icon-Lowercase-Text' => 'Lowercase-Text' ),array( 'im im-icon-Luggafe-Front' => 'Luggafe-Front' ),array( 'im im-icon-Luggage-2' => 'Luggage-2' ),array( 'im im-icon-Macro' => 'Macro' ),array( 'im im-icon-Magic-Wand' => 'Magic-Wand' ),array( 'im im-icon-Magnet' => 'Magnet' ),array( 'im im-icon-Magnifi-Glass-' => 'Magnifi-Glass-' ),array( 'im im-icon-Magnifi-Glass' => 'Magnifi-Glass' ),array( 'im im-icon-Magnifi-Glass2' => 'Magnifi-Glass2' ),array( 'im im-icon-Mail-2' => 'Mail-2' ),array( 'im im-icon-Mail-3' => 'Mail-3' ),array( 'im im-icon-Mail-Add' => 'Mail-Add' ),array( 'im im-icon-Mail-Attachement' => 'Mail-Attachement' ),array( 'im im-icon-Mail-Block' => 'Mail-Block' ),array( 'im im-icon-Mail-Delete' => 'Mail-Delete' ),array( 'im im-icon-Mail-Favorite' => 'Mail-Favorite' ),array( 'im im-icon-Mail-Forward' => 'Mail-Forward' ),array( 'im im-icon-Mail-Gallery' => 'Mail-Gallery' ),array( 'im im-icon-Mail-Inbox' => 'Mail-Inbox' ),array( 'im im-icon-Mail-Link' => 'Mail-Link' ),array( 'im im-icon-Mail-Lock' => 'Mail-Lock' ),array( 'im im-icon-Mail-Love' => 'Mail-Love' ),array( 'im im-icon-Mail-Money' => 'Mail-Money' ),array( 'im im-icon-Mail-Open' => 'Mail-Open' ),array( 'im im-icon-Mail-Outbox' => 'Mail-Outbox' ),array( 'im im-icon-Mail-Password' => 'Mail-Password' ),array( 'im im-icon-Mail-Photo' => 'Mail-Photo' ),array( 'im im-icon-Mail-Read' => 'Mail-Read' ),array( 'im im-icon-Mail-Removex' => 'Mail-Removex' ),array( 'im im-icon-Mail-Reply' => 'Mail-Reply' ),array( 'im im-icon-Mail-ReplyAll' => 'Mail-ReplyAll' ),array( 'im im-icon-Mail-Search' => 'Mail-Search' ),array( 'im im-icon-Mail-Send' => 'Mail-Send' ),array( 'im im-icon-Mail-Settings' => 'Mail-Settings' ),array( 'im im-icon-Mail-Unread' => 'Mail-Unread' ),array( 'im im-icon-Mail-Video' => 'Mail-Video' ),array( 'im im-icon-Mail-withAtSign' => 'Mail-withAtSign' ),array( 'im im-icon-Mail-WithCursors' => 'Mail-WithCursors' ),array( 'im im-icon-Mail' => 'Mail' ),array( 'im im-icon-Mailbox-Empty' => 'Mailbox-Empty' ),array( 'im im-icon-Mailbox-Full' => 'Mailbox-Full' ),array( 'im im-icon-Male-2' => 'Male-2' ),array( 'im im-icon-Male-Sign' => 'Male-Sign' ),array( 'im im-icon-Male' => 'Male' ),array( 'im im-icon-MaleFemale' => 'MaleFemale' ),array( 'im im-icon-Man-Sign' => 'Man-Sign' ),array( 'im im-icon-Management' => 'Management' ),array( 'im im-icon-Mans-Underwear' => 'Mans-Underwear' ),array( 'im im-icon-Mans-Underwear2' => 'Mans-Underwear2' ),array( 'im im-icon-Map-Marker' => 'Map-Marker' ),array( 'im im-icon-Map-Marker2' => 'Map-Marker2' ),array( 'im im-icon-Map-Marker3' => 'Map-Marker3' ),array( 'im im-icon-Map' => 'Map' ),array( 'im im-icon-Map2' => 'Map2' ),array( 'im im-icon-Marker-2' => 'Marker-2' ),array( 'im im-icon-Marker-3' => 'Marker-3' ),array( 'im im-icon-Marker' => 'Marker' ),array( 'im im-icon-Martini-Glass' => 'Martini-Glass' ),array( 'im im-icon-Mask' => 'Mask' ),array( 'im im-icon-Master-Card' => 'Master-Card' ),array( 'im im-icon-Maximize-Window' => 'Maximize-Window' ),array( 'im im-icon-Maximize' => 'Maximize' ),array( 'im im-icon-Medal-2' => 'Medal-2' ),array( 'im im-icon-Medal-3' => 'Medal-3' ),array( 'im im-icon-Medal' => 'Medal' ),array( 'im im-icon-Medical-Sign' => 'Medical-Sign' ),array( 'im im-icon-Medicine-2' => 'Medicine-2' ),array( 'im im-icon-Medicine-3' => 'Medicine-3' ),array( 'im im-icon-Medicine' => 'Medicine' ),array( 'im im-icon-Megaphone' => 'Megaphone' ),array( 'im im-icon-Memory-Card' => 'Memory-Card' ),array( 'im im-icon-Memory-Card2' => 'Memory-Card2' ),array( 'im im-icon-Memory-Card3' => 'Memory-Card3' ),array( 'im im-icon-Men' => 'Men' ),array( 'im im-icon-Menorah' => 'Menorah' ),array( 'im im-icon-Mens' => 'Mens' ),array( 'im im-icon-Metacafe' => 'Metacafe' ),array( 'im im-icon-Mexico' => 'Mexico' ),array( 'im im-icon-Mic' => 'Mic' ),array( 'im im-icon-Microphone-2' => 'Microphone-2' ),array( 'im im-icon-Microphone-3' => 'Microphone-3' ),array( 'im im-icon-Microphone-4' => 'Microphone-4' ),array( 'im im-icon-Microphone-5' => 'Microphone-5' ),array( 'im im-icon-Microphone-6' => 'Microphone-6' ),array( 'im im-icon-Microphone-7' => 'Microphone-7' ),array( 'im im-icon-Microphone' => 'Microphone' ),array( 'im im-icon-Microscope' => 'Microscope' ),array( 'im im-icon-Milk-Bottle' => 'Milk-Bottle' ),array( 'im im-icon-Mine' => 'Mine' ),array( 'im im-icon-Minimize-Maximize-Close-Window' => 'Minimize-Maximize-Close-Window' ),array( 'im im-icon-Minimize-Window' => 'Minimize-Window' ),array( 'im im-icon-Minimize' => 'Minimize' ),array( 'im im-icon-Mirror' => 'Mirror' ),array( 'im im-icon-Mixer' => 'Mixer' ),array( 'im im-icon-Mixx' => 'Mixx' ),array( 'im im-icon-Money-2' => 'Money-2' ),array( 'im im-icon-Money-Bag' => 'Money-Bag' ),array( 'im im-icon-Money-Smiley' => 'Money-Smiley' ),array( 'im im-icon-Money' => 'Money' ),array( 'im im-icon-Monitor-2' => 'Monitor-2' ),array( 'im im-icon-Monitor-3' => 'Monitor-3' ),array( 'im im-icon-Monitor-4' => 'Monitor-4' ),array( 'im im-icon-Monitor-5' => 'Monitor-5' ),array( 'im im-icon-Monitor-Analytics' => 'Monitor-Analytics' ),array( 'im im-icon-Monitor-Laptop' => 'Monitor-Laptop' ),array( 'im im-icon-Monitor-phone' => 'Monitor-phone' ),array( 'im im-icon-Monitor-Tablet' => 'Monitor-Tablet' ),array( 'im im-icon-Monitor-Vertical' => 'Monitor-Vertical' ),array( 'im im-icon-Monitor' => 'Monitor' ),array( 'im im-icon-Monitoring' => 'Monitoring' ),array( 'im im-icon-Monkey' => 'Monkey' ),array( 'im im-icon-Monster' => 'Monster' ),array( 'im im-icon-Morocco' => 'Morocco' ),array( 'im im-icon-Motorcycle' => 'Motorcycle' ),array( 'im im-icon-Mouse-2' => 'Mouse-2' ),array( 'im im-icon-Mouse-3' => 'Mouse-3' ),array( 'im im-icon-Mouse-4' => 'Mouse-4' ),array( 'im im-icon-Mouse-Pointer' => 'Mouse-Pointer' ),array( 'im im-icon-Mouse' => 'Mouse' ),array( 'im im-icon-Moustache-Smiley' => 'Moustache-Smiley' ),array( 'im im-icon-Movie-Ticket' => 'Movie-Ticket' ),array( 'im im-icon-Movie' => 'Movie' ),array( 'im im-icon-Mp3-File' => 'Mp3-File' ),array( 'im im-icon-Museum' => 'Museum' ),array( 'im im-icon-Mushroom' => 'Mushroom' ),array( 'im im-icon-Music-Note' => 'Music-Note' ),array( 'im im-icon-Music-Note2' => 'Music-Note2' ),array( 'im im-icon-Music-Note3' => 'Music-Note3' ),array( 'im im-icon-Music-Note4' => 'Music-Note4' ),array( 'im im-icon-Music-Player' => 'Music-Player' ),array( 'im im-icon-Mustache-2' => 'Mustache-2' ),array( 'im im-icon-Mustache-3' => 'Mustache-3' ),array( 'im im-icon-Mustache-4' => 'Mustache-4' ),array( 'im im-icon-Mustache-5' => 'Mustache-5' ),array( 'im im-icon-Mustache-6' => 'Mustache-6' ),array( 'im im-icon-Mustache-7' => 'Mustache-7' ),array( 'im im-icon-Mustache-8' => 'Mustache-8' ),array( 'im im-icon-Mustache' => 'Mustache' ),array( 'im im-icon-Mute' => 'Mute' ),array( 'im im-icon-Myspace' => 'Myspace' ),array( 'im im-icon-Navigat-Start' => 'Navigat-Start' ),array( 'im im-icon-Navigate-End' => 'Navigate-End' ),array( 'im im-icon-Navigation-LeftWindow' => 'Navigation-LeftWindow' ),array( 'im im-icon-Navigation-RightWindow' => 'Navigation-RightWindow' ),array( 'im im-icon-Nepal' => 'Nepal' ),array( 'im im-icon-Netscape' => 'Netscape' ),array( 'im im-icon-Network-Window' => 'Network-Window' ),array( 'im im-icon-Network' => 'Network' ),array( 'im im-icon-Neutron' => 'Neutron' ),array( 'im im-icon-New-Mail' => 'New-Mail' ),array( 'im im-icon-New-Tab' => 'New-Tab' ),array( 'im im-icon-Newspaper-2' => 'Newspaper-2' ),array( 'im im-icon-Newspaper' => 'Newspaper' ),array( 'im im-icon-Newsvine' => 'Newsvine' ),array( 'im im-icon-Next2' => 'Next2' ),array( 'im im-icon-Next-3' => 'Next-3' ),array( 'im im-icon-Next-Music' => 'Next-Music' ),array( 'im im-icon-Next' => 'Next' ),array( 'im im-icon-No-Battery' => 'No-Battery' ),array( 'im im-icon-No-Drop' => 'No-Drop' ),array( 'im im-icon-No-Flash' => 'No-Flash' ),array( 'im im-icon-No-Smoking' => 'No-Smoking' ),array( 'im im-icon-Noose' => 'Noose' ),array( 'im im-icon-Normal-Text' => 'Normal-Text' ),array( 'im im-icon-Note' => 'Note' ),array( 'im im-icon-Notepad-2' => 'Notepad-2' ),array( 'im im-icon-Notepad' => 'Notepad' ),array( 'im im-icon-Nuclear' => 'Nuclear' ),array( 'im im-icon-Numbering-List' => 'Numbering-List' ),array( 'im im-icon-Nurse' => 'Nurse' ),array( 'im im-icon-Office-Lamp' => 'Office-Lamp' ),array( 'im im-icon-Office' => 'Office' ),array( 'im im-icon-Oil' => 'Oil' ),array( 'im im-icon-Old-Camera' => 'Old-Camera' ),array( 'im im-icon-Old-Cassette' => 'Old-Cassette' ),array( 'im im-icon-Old-Clock' => 'Old-Clock' ),array( 'im im-icon-Old-Radio' => 'Old-Radio' ),array( 'im im-icon-Old-Sticky' => 'Old-Sticky' ),array( 'im im-icon-Old-Sticky2' => 'Old-Sticky2' ),array( 'im im-icon-Old-Telephone' => 'Old-Telephone' ),array( 'im im-icon-Old-TV' => 'Old-TV' ),array( 'im im-icon-On-Air' => 'On-Air' ),array( 'im im-icon-On-Off-2' => 'On-Off-2' ),array( 'im im-icon-On-Off-3' => 'On-Off-3' ),array( 'im im-icon-On-off' => 'On-off' ),array( 'im im-icon-One-Finger' => 'One-Finger' ),array( 'im im-icon-One-FingerTouch' => 'One-FingerTouch' ),array( 'im im-icon-One-Window' => 'One-Window' ),array( 'im im-icon-Open-Banana' => 'Open-Banana' ),array( 'im im-icon-Open-Book' => 'Open-Book' ),array( 'im im-icon-Opera-House' => 'Opera-House' ),array( 'im im-icon-Opera' => 'Opera' ),array( 'im im-icon-Optimization' => 'Optimization' ),array( 'im im-icon-Orientation-2' => 'Orientation-2' ),array( 'im im-icon-Orientation-3' => 'Orientation-3' ),array( 'im im-icon-Orientation' => 'Orientation' ),array( 'im im-icon-Orkut' => 'Orkut' ),array( 'im im-icon-Ornament' => 'Ornament' ),array( 'im im-icon-Over-Time' => 'Over-Time' ),array( 'im im-icon-Over-Time2' => 'Over-Time2' ),array( 'im im-icon-Owl' => 'Owl' ),array( 'im im-icon-Pac-Man' => 'Pac-Man' ),array( 'im im-icon-Paint-Brush' => 'Paint-Brush' ),array( 'im im-icon-Paint-Bucket' => 'Paint-Bucket' ),array( 'im im-icon-Paintbrush' => 'Paintbrush' ),array( 'im im-icon-Palette' => 'Palette' ),array( 'im im-icon-Palm-Tree' => 'Palm-Tree' ),array( 'im im-icon-Panda' => 'Panda' ),array( 'im im-icon-Panorama' => 'Panorama' ),array( 'im im-icon-Pantheon' => 'Pantheon' ),array( 'im im-icon-Pantone' => 'Pantone' ),array( 'im im-icon-Pants' => 'Pants' ),array( 'im im-icon-Paper-Plane' => 'Paper-Plane' ),array( 'im im-icon-Paper' => 'Paper' ),array( 'im im-icon-Parasailing' => 'Parasailing' ),array( 'im im-icon-Parrot' => 'Parrot' ),array( 'im im-icon-Password-2shopping' => 'Password-2shopping' ),array( 'im im-icon-Password-Field' => 'Password-Field' ),array( 'im im-icon-Password-shopping' => 'Password-shopping' ),array( 'im im-icon-Password' => 'Password' ),array( 'im im-icon-pause-2' => 'pause-2' ),array( 'im im-icon-Pause' => 'Pause' ),array( 'im im-icon-Paw' => 'Paw' ),array( 'im im-icon-Pawn' => 'Pawn' ),array( 'im im-icon-Paypal' => 'Paypal' ),array( 'im im-icon-Pen-2' => 'Pen-2' ),array( 'im im-icon-Pen-3' => 'Pen-3' ),array( 'im im-icon-Pen-4' => 'Pen-4' ),array( 'im im-icon-Pen-5' => 'Pen-5' ),array( 'im im-icon-Pen-6' => 'Pen-6' ),array( 'im im-icon-Pen' => 'Pen' ),array( 'im im-icon-Pencil-Ruler' => 'Pencil-Ruler' ),array( 'im im-icon-Pencil' => 'Pencil' ),array( 'im im-icon-Penguin' => 'Penguin' ),array( 'im im-icon-Pentagon' => 'Pentagon' ),array( 'im im-icon-People-onCloud' => 'People-onCloud' ),array( 'im im-icon-Pepper-withFire' => 'Pepper-withFire' ),array( 'im im-icon-Pepper' => 'Pepper' ),array( 'im im-icon-Petrol' => 'Petrol' ),array( 'im im-icon-Petronas-Tower' => 'Petronas-Tower' ),array( 'im im-icon-Philipines' => 'Philipines' ),array( 'im im-icon-Phone-2' => 'Phone-2' ),array( 'im im-icon-Phone-3' => 'Phone-3' ),array( 'im im-icon-Phone-3G' => 'Phone-3G' ),array( 'im im-icon-Phone-4G' => 'Phone-4G' ),array( 'im im-icon-Phone-Simcard' => 'Phone-Simcard' ),array( 'im im-icon-Phone-SMS' => 'Phone-SMS' ),array( 'im im-icon-Phone-Wifi' => 'Phone-Wifi' ),array( 'im im-icon-Phone' => 'Phone' ),array( 'im im-icon-Photo-2' => 'Photo-2' ),array( 'im im-icon-Photo-3' => 'Photo-3' ),array( 'im im-icon-Photo-Album' => 'Photo-Album' ),array( 'im im-icon-Photo-Album2' => 'Photo-Album2' ),array( 'im im-icon-Photo-Album3' => 'Photo-Album3' ),array( 'im im-icon-Photo' => 'Photo' ),array( 'im im-icon-Photos' => 'Photos' ),array( 'im im-icon-Physics' => 'Physics' ),array( 'im im-icon-Pi' => 'Pi' ),array( 'im im-icon-Piano' => 'Piano' ),array( 'im im-icon-Picasa' => 'Picasa' ),array( 'im im-icon-Pie-Chart' => 'Pie-Chart' ),array( 'im im-icon-Pie-Chart2' => 'Pie-Chart2' ),array( 'im im-icon-Pie-Chart3' => 'Pie-Chart3' ),array( 'im im-icon-Pilates-2' => 'Pilates-2' ),array( 'im im-icon-Pilates-3' => 'Pilates-3' ),array( 'im im-icon-Pilates' => 'Pilates' ),array( 'im im-icon-Pilot' => 'Pilot' ),array( 'im im-icon-Pinch' => 'Pinch' ),array( 'im im-icon-Ping-Pong' => 'Ping-Pong' ),array( 'im im-icon-Pinterest' => 'Pinterest' ),array( 'im im-icon-Pipe' => 'Pipe' ),array( 'im im-icon-Pipette' => 'Pipette' ),array( 'im im-icon-Piramids' => 'Piramids' ),array( 'im im-icon-Pisces-2' => 'Pisces-2' ),array( 'im im-icon-Pisces' => 'Pisces' ),array( 'im im-icon-Pizza-Slice' => 'Pizza-Slice' ),array( 'im im-icon-Pizza' => 'Pizza' ),array( 'im im-icon-Plane-2' => 'Plane-2' ),array( 'im im-icon-Plane' => 'Plane' ),array( 'im im-icon-Plant' => 'Plant' ),array( 'im im-icon-Plasmid' => 'Plasmid' ),array( 'im im-icon-Plaster' => 'Plaster' ),array( 'im im-icon-Plastic-CupPhone' => 'Plastic-CupPhone' ),array( 'im im-icon-Plastic-CupPhone2' => 'Plastic-CupPhone2' ),array( 'im im-icon-Plate' => 'Plate' ),array( 'im im-icon-Plates' => 'Plates' ),array( 'im im-icon-Plaxo' => 'Plaxo' ),array( 'im im-icon-Play-Music' => 'Play-Music' ),array( 'im im-icon-Plug-In' => 'Plug-In' ),array( 'im im-icon-Plug-In2' => 'Plug-In2' ),array( 'im im-icon-Plurk' => 'Plurk' ),array( 'im im-icon-Pointer' => 'Pointer' ),array( 'im im-icon-Poland' => 'Poland' ),array( 'im im-icon-Police-Man' => 'Police-Man' ),array( 'im im-icon-Police-Station' => 'Police-Station' ),array( 'im im-icon-Police-Woman' => 'Police-Woman' ),array( 'im im-icon-Police' => 'Police' ),array( 'im im-icon-Polo-Shirt' => 'Polo-Shirt' ),array( 'im im-icon-Portrait' => 'Portrait' ),array( 'im im-icon-Portugal' => 'Portugal' ),array( 'im im-icon-Post-Mail' => 'Post-Mail' ),array( 'im im-icon-Post-Mail2' => 'Post-Mail2' ),array( 'im im-icon-Post-Office' => 'Post-Office' ),array( 'im im-icon-Post-Sign' => 'Post-Sign' ),array( 'im im-icon-Post-Sign2ways' => 'Post-Sign2ways' ),array( 'im im-icon-Posterous' => 'Posterous' ),array( 'im im-icon-Pound-Sign' => 'Pound-Sign' ),array( 'im im-icon-Pound-Sign2' => 'Pound-Sign2' ),array( 'im im-icon-Pound' => 'Pound' ),array( 'im im-icon-Power-2' => 'Power-2' ),array( 'im im-icon-Power-3' => 'Power-3' ),array( 'im im-icon-Power-Cable' => 'Power-Cable' ),array( 'im im-icon-Power-Station' => 'Power-Station' ),array( 'im im-icon-Power' => 'Power' ),array( 'im im-icon-Prater' => 'Prater' ),array( 'im im-icon-Present' => 'Present' ),array( 'im im-icon-Presents' => 'Presents' ),array( 'im im-icon-Press' => 'Press' ),array( 'im im-icon-Preview' => 'Preview' ),array( 'im im-icon-Previous' => 'Previous' ),array( 'im im-icon-Pricing' => 'Pricing' ),array( 'im im-icon-Printer' => 'Printer' ),array( 'im im-icon-Professor' => 'Professor' ),array( 'im im-icon-Profile' => 'Profile' ),array( 'im im-icon-Project' => 'Project' ),array( 'im im-icon-Projector-2' => 'Projector-2' ),array( 'im im-icon-Projector' => 'Projector' ),array( 'im im-icon-Pulse' => 'Pulse' ),array( 'im im-icon-Pumpkin' => 'Pumpkin' ),array( 'im im-icon-Punk' => 'Punk' ),array( 'im im-icon-Punker' => 'Punker' ),array( 'im im-icon-Puzzle' => 'Puzzle' ),array( 'im im-icon-QIK' => 'QIK' ),array( 'im im-icon-QR-Code' => 'QR-Code' ),array( 'im im-icon-Queen-2' => 'Queen-2' ),array( 'im im-icon-Queen' => 'Queen' ),array( 'im im-icon-Quill-2' => 'Quill-2' ),array( 'im im-icon-Quill-3' => 'Quill-3' ),array( 'im im-icon-Quill' => 'Quill' ),array( 'im im-icon-Quotes-2' => 'Quotes-2' ),array( 'im im-icon-Quotes' => 'Quotes' ),array( 'im im-icon-Radio' => 'Radio' ),array( 'im im-icon-Radioactive' => 'Radioactive' ),array( 'im im-icon-Rafting' => 'Rafting' ),array( 'im im-icon-Rain-Drop' => 'Rain-Drop' ),array( 'im im-icon-Rainbow-2' => 'Rainbow-2' ),array( 'im im-icon-Rainbow' => 'Rainbow' ),array( 'im im-icon-Ram' => 'Ram' ),array( 'im im-icon-Razzor-Blade' => 'Razzor-Blade' ),array( 'im im-icon-Receipt-2' => 'Receipt-2' ),array( 'im im-icon-Receipt-3' => 'Receipt-3' ),array( 'im im-icon-Receipt-4' => 'Receipt-4' ),array( 'im im-icon-Receipt' => 'Receipt' ),array( 'im im-icon-Record2' => 'Record2' ),array( 'im im-icon-Record-3' => 'Record-3' ),array( 'im im-icon-Record-Music' => 'Record-Music' ),array( 'im im-icon-Record' => 'Record' ),array( 'im im-icon-Recycling-2' => 'Recycling-2' ),array( 'im im-icon-Recycling' => 'Recycling' ),array( 'im im-icon-Reddit' => 'Reddit' ),array( 'im im-icon-Redhat' => 'Redhat' ),array( 'im im-icon-Redirect' => 'Redirect' ),array( 'im im-icon-Redo' => 'Redo' ),array( 'im im-icon-Reel' => 'Reel' ),array( 'im im-icon-Refinery' => 'Refinery' ),array( 'im im-icon-Refresh-Window' => 'Refresh-Window' ),array( 'im im-icon-Refresh' => 'Refresh' ),array( 'im im-icon-Reload-2' => 'Reload-2' ),array( 'im im-icon-Reload-3' => 'Reload-3' ),array( 'im im-icon-Reload' => 'Reload' ),array( 'im im-icon-Remote-Controll' => 'Remote-Controll' ),array( 'im im-icon-Remote-Controll2' => 'Remote-Controll2' ),array( 'im im-icon-Remove-Bag' => 'Remove-Bag' ),array( 'im im-icon-Remove-Basket' => 'Remove-Basket' ),array( 'im im-icon-Remove-Cart' => 'Remove-Cart' ),array( 'im im-icon-Remove-File' => 'Remove-File' ),array( 'im im-icon-Remove-User' => 'Remove-User' ),array( 'im im-icon-Remove-Window' => 'Remove-Window' ),array( 'im im-icon-Remove' => 'Remove' ),array( 'im im-icon-Rename' => 'Rename' ),array( 'im im-icon-Repair' => 'Repair' ),array( 'im im-icon-Repeat-2' => 'Repeat-2' ),array( 'im im-icon-Repeat-3' => 'Repeat-3' ),array( 'im im-icon-Repeat-4' => 'Repeat-4' ),array( 'im im-icon-Repeat-5' => 'Repeat-5' ),array( 'im im-icon-Repeat-6' => 'Repeat-6' ),array( 'im im-icon-Repeat-7' => 'Repeat-7' ),array( 'im im-icon-Repeat' => 'Repeat' ),array( 'im im-icon-Reset' => 'Reset' ),array( 'im im-icon-Resize' => 'Resize' ),array( 'im im-icon-Restore-Window' => 'Restore-Window' ),array( 'im im-icon-Retouching' => 'Retouching' ),array( 'im im-icon-Retro-Camera' => 'Retro-Camera' ),array( 'im im-icon-Retro' => 'Retro' ),array( 'im im-icon-Retweet' => 'Retweet' ),array( 'im im-icon-Reverbnation' => 'Reverbnation' ),array( 'im im-icon-Rewind' => 'Rewind' ),array( 'im im-icon-RGB' => 'RGB' ),array( 'im im-icon-Ribbon-2' => 'Ribbon-2' ),array( 'im im-icon-Ribbon-3' => 'Ribbon-3' ),array( 'im im-icon-Ribbon' => 'Ribbon' ),array( 'im im-icon-Right-2' => 'Right-2' ),array( 'im im-icon-Right-3' => 'Right-3' ),array( 'im im-icon-Right-4' => 'Right-4' ),array( 'im im-icon-Right-ToLeft' => 'Right-ToLeft' ),array( 'im im-icon-Right' => 'Right' ),array( 'im im-icon-Road-2' => 'Road-2' ),array( 'im im-icon-Road-3' => 'Road-3' ),array( 'im im-icon-Road' => 'Road' ),array( 'im im-icon-Robot-2' => 'Robot-2' ),array( 'im im-icon-Robot' => 'Robot' ),array( 'im im-icon-Rock-andRoll' => 'Rock-andRoll' ),array( 'im im-icon-Rocket' => 'Rocket' ),array( 'im im-icon-Roller' => 'Roller' ),array( 'im im-icon-Roof' => 'Roof' ),array( 'im im-icon-Rook' => 'Rook' ),array( 'im im-icon-Rotate-Gesture' => 'Rotate-Gesture' ),array( 'im im-icon-Rotate-Gesture2' => 'Rotate-Gesture2' ),array( 'im im-icon-Rotate-Gesture3' => 'Rotate-Gesture3' ),array( 'im im-icon-Rotation-390' => 'Rotation-390' ),array( 'im im-icon-Rotation' => 'Rotation' ),array( 'im im-icon-Router-2' => 'Router-2' ),array( 'im im-icon-Router' => 'Router' ),array( 'im im-icon-RSS' => 'RSS' ),array( 'im im-icon-Ruler-2' => 'Ruler-2' ),array( 'im im-icon-Ruler' => 'Ruler' ),array( 'im im-icon-Running-Shoes' => 'Running-Shoes' ),array( 'im im-icon-Running' => 'Running' ),array( 'im im-icon-Safari' => 'Safari' ),array( 'im im-icon-Safe-Box' => 'Safe-Box' ),array( 'im im-icon-Safe-Box2' => 'Safe-Box2' ),array( 'im im-icon-Safety-PinClose' => 'Safety-PinClose' ),array( 'im im-icon-Safety-PinOpen' => 'Safety-PinOpen' ),array( 'im im-icon-Sagittarus-2' => 'Sagittarus-2' ),array( 'im im-icon-Sagittarus' => 'Sagittarus' ),array( 'im im-icon-Sailing-Ship' => 'Sailing-Ship' ),array( 'im im-icon-Sand-watch' => 'Sand-watch' ),array( 'im im-icon-Sand-watch2' => 'Sand-watch2' ),array( 'im im-icon-Santa-Claus' => 'Santa-Claus' ),array( 'im im-icon-Santa-Claus2' => 'Santa-Claus2' ),array( 'im im-icon-Santa-onSled' => 'Santa-onSled' ),array( 'im im-icon-Satelite-2' => 'Satelite-2' ),array( 'im im-icon-Satelite' => 'Satelite' ),array( 'im im-icon-Save-Window' => 'Save-Window' ),array( 'im im-icon-Save' => 'Save' ),array( 'im im-icon-Saw' => 'Saw' ),array( 'im im-icon-Saxophone' => 'Saxophone' ),array( 'im im-icon-Scale' => 'Scale' ),array( 'im im-icon-Scarf' => 'Scarf' ),array( 'im im-icon-Scissor' => 'Scissor' ),array( 'im im-icon-Scooter-Front' => 'Scooter-Front' ),array( 'im im-icon-Scooter' => 'Scooter' ),array( 'im im-icon-Scorpio-2' => 'Scorpio-2' ),array( 'im im-icon-Scorpio' => 'Scorpio' ),array( 'im im-icon-Scotland' => 'Scotland' ),array( 'im im-icon-Screwdriver' => 'Screwdriver' ),array( 'im im-icon-Scroll-Fast' => 'Scroll-Fast' ),array( 'im im-icon-Scroll' => 'Scroll' ),array( 'im im-icon-Scroller-2' => 'Scroller-2' ),array( 'im im-icon-Scroller' => 'Scroller' ),array( 'im im-icon-Sea-Dog' => 'Sea-Dog' ),array( 'im im-icon-Search-onCloud' => 'Search-onCloud' ),array( 'im im-icon-Search-People' => 'Search-People' ),array( 'im im-icon-secound' => 'secound' ),array( 'im im-icon-secound2' => 'secound2' ),array( 'im im-icon-Security-Block' => 'Security-Block' ),array( 'im im-icon-Security-Bug' => 'Security-Bug' ),array( 'im im-icon-Security-Camera' => 'Security-Camera' ),array( 'im im-icon-Security-Check' => 'Security-Check' ),array( 'im im-icon-Security-Settings' => 'Security-Settings' ),array( 'im im-icon-Security-Smiley' => 'Security-Smiley' ),array( 'im im-icon-Securiy-Remove' => 'Securiy-Remove' ),array( 'im im-icon-Seed' => 'Seed' ),array( 'im im-icon-Selfie' => 'Selfie' ),array( 'im im-icon-Serbia' => 'Serbia' ),array( 'im im-icon-Server-2' => 'Server-2' ),array( 'im im-icon-Server' => 'Server' ),array( 'im im-icon-Servers' => 'Servers' ),array( 'im im-icon-Settings-Window' => 'Settings-Window' ),array( 'im im-icon-Sewing-Machine' => 'Sewing-Machine' ),array( 'im im-icon-Sexual' => 'Sexual' ),array( 'im im-icon-Share-onCloud' => 'Share-onCloud' ),array( 'im im-icon-Share-Window' => 'Share-Window' ),array( 'im im-icon-Share' => 'Share' ),array( 'im im-icon-Sharethis' => 'Sharethis' ),array( 'im im-icon-Shark' => 'Shark' ),array( 'im im-icon-Sheep' => 'Sheep' ),array( 'im im-icon-Sheriff-Badge' => 'Sheriff-Badge' ),array( 'im im-icon-Shield' => 'Shield' ),array( 'im im-icon-Ship-2' => 'Ship-2' ),array( 'im im-icon-Ship' => 'Ship' ),array( 'im im-icon-Shirt' => 'Shirt' ),array( 'im im-icon-Shoes-2' => 'Shoes-2' ),array( 'im im-icon-Shoes-3' => 'Shoes-3' ),array( 'im im-icon-Shoes' => 'Shoes' ),array( 'im im-icon-Shop-2' => 'Shop-2' ),array( 'im im-icon-Shop-3' => 'Shop-3' ),array( 'im im-icon-Shop-4' => 'Shop-4' ),array( 'im im-icon-Shop' => 'Shop' ),array( 'im im-icon-Shopping-Bag' => 'Shopping-Bag' ),array( 'im im-icon-Shopping-Basket' => 'Shopping-Basket' ),array( 'im im-icon-Shopping-Cart' => 'Shopping-Cart' ),array( 'im im-icon-Short-Pants' => 'Short-Pants' ),array( 'im im-icon-Shoutwire' => 'Shoutwire' ),array( 'im im-icon-Shovel' => 'Shovel' ),array( 'im im-icon-Shuffle-2' => 'Shuffle-2' ),array( 'im im-icon-Shuffle-3' => 'Shuffle-3' ),array( 'im im-icon-Shuffle-4' => 'Shuffle-4' ),array( 'im im-icon-Shuffle' => 'Shuffle' ),array( 'im im-icon-Shutter' => 'Shutter' ),array( 'im im-icon-Sidebar-Window' => 'Sidebar-Window' ),array( 'im im-icon-Signal' => 'Signal' ),array( 'im im-icon-Singapore' => 'Singapore' ),array( 'im im-icon-Skate-Shoes' => 'Skate-Shoes' ),array( 'im im-icon-Skateboard-2' => 'Skateboard-2' ),array( 'im im-icon-Skateboard' => 'Skateboard' ),array( 'im im-icon-Skeleton' => 'Skeleton' ),array( 'im im-icon-Ski' => 'Ski' ),array( 'im im-icon-Skirt' => 'Skirt' ),array( 'im im-icon-Skrill' => 'Skrill' ),array( 'im im-icon-Skull' => 'Skull' ),array( 'im im-icon-Skydiving' => 'Skydiving' ),array( 'im im-icon-Skype' => 'Skype' ),array( 'im im-icon-Sled-withGifts' => 'Sled-withGifts' ),array( 'im im-icon-Sled' => 'Sled' ),array( 'im im-icon-Sleeping' => 'Sleeping' ),array( 'im im-icon-Sleet' => 'Sleet' ),array( 'im im-icon-Slippers' => 'Slippers' ),array( 'im im-icon-Smart' => 'Smart' ),array( 'im im-icon-Smartphone-2' => 'Smartphone-2' ),array( 'im im-icon-Smartphone-3' => 'Smartphone-3' ),array( 'im im-icon-Smartphone-4' => 'Smartphone-4' ),array( 'im im-icon-Smartphone-Secure' => 'Smartphone-Secure' ),array( 'im im-icon-Smartphone' => 'Smartphone' ),array( 'im im-icon-Smile' => 'Smile' ),array( 'im im-icon-Smoking-Area' => 'Smoking-Area' ),array( 'im im-icon-Smoking-Pipe' => 'Smoking-Pipe' ),array( 'im im-icon-Snake' => 'Snake' ),array( 'im im-icon-Snorkel' => 'Snorkel' ),array( 'im im-icon-Snow-2' => 'Snow-2' ),array( 'im im-icon-Snow-Dome' => 'Snow-Dome' ),array( 'im im-icon-Snow-Storm' => 'Snow-Storm' ),array( 'im im-icon-Snow' => 'Snow' ),array( 'im im-icon-Snowflake-2' => 'Snowflake-2' ),array( 'im im-icon-Snowflake-3' => 'Snowflake-3' ),array( 'im im-icon-Snowflake-4' => 'Snowflake-4' ),array( 'im im-icon-Snowflake' => 'Snowflake' ),array( 'im im-icon-Snowman' => 'Snowman' ),array( 'im im-icon-Soccer-Ball' => 'Soccer-Ball' ),array( 'im im-icon-Soccer-Shoes' => 'Soccer-Shoes' ),array( 'im im-icon-Socks' => 'Socks' ),array( 'im im-icon-Solar' => 'Solar' ),array( 'im im-icon-Sound-Wave' => 'Sound-Wave' ),array( 'im im-icon-Sound' => 'Sound' ),array( 'im im-icon-Soundcloud' => 'Soundcloud' ),array( 'im im-icon-Soup' => 'Soup' ),array( 'im im-icon-South-Africa' => 'South-Africa' ),array( 'im im-icon-Space-Needle' => 'Space-Needle' ),array( 'im im-icon-Spain' => 'Spain' ),array( 'im im-icon-Spam-Mail' => 'Spam-Mail' ),array( 'im im-icon-Speach-Bubble' => 'Speach-Bubble' ),array( 'im im-icon-Speach-Bubble2' => 'Speach-Bubble2' ),array( 'im im-icon-Speach-Bubble3' => 'Speach-Bubble3' ),array( 'im im-icon-Speach-Bubble4' => 'Speach-Bubble4' ),array( 'im im-icon-Speach-Bubble5' => 'Speach-Bubble5' ),array( 'im im-icon-Speach-Bubble6' => 'Speach-Bubble6' ),array( 'im im-icon-Speach-Bubble7' => 'Speach-Bubble7' ),array( 'im im-icon-Speach-Bubble8' => 'Speach-Bubble8' ),array( 'im im-icon-Speach-Bubble9' => 'Speach-Bubble9' ),array( 'im im-icon-Speach-Bubble10' => 'Speach-Bubble10' ),array( 'im im-icon-Speach-Bubble11' => 'Speach-Bubble11' ),array( 'im im-icon-Speach-Bubble12' => 'Speach-Bubble12' ),array( 'im im-icon-Speach-Bubble13' => 'Speach-Bubble13' ),array( 'im im-icon-Speach-BubbleAsking' => 'Speach-BubbleAsking' ),array( 'im im-icon-Speach-BubbleComic' => 'Speach-BubbleComic' ),array( 'im im-icon-Speach-BubbleComic2' => 'Speach-BubbleComic2' ),array( 'im im-icon-Speach-BubbleComic3' => 'Speach-BubbleComic3' ),array( 'im im-icon-Speach-BubbleComic4' => 'Speach-BubbleComic4' ),array( 'im im-icon-Speach-BubbleDialog' => 'Speach-BubbleDialog' ),array( 'im im-icon-Speach-Bubbles' => 'Speach-Bubbles' ),array( 'im im-icon-Speak-2' => 'Speak-2' ),array( 'im im-icon-Speak' => 'Speak' ),array( 'im im-icon-Speaker-2' => 'Speaker-2' ),array( 'im im-icon-Speaker' => 'Speaker' ),array( 'im im-icon-Spell-Check' => 'Spell-Check' ),array( 'im im-icon-Spell-CheckABC' => 'Spell-CheckABC' ),array( 'im im-icon-Spermium' => 'Spermium' ),array( 'im im-icon-Spider' => 'Spider' ),array( 'im im-icon-Spiderweb' => 'Spiderweb' ),array( 'im im-icon-Split-FourSquareWindow' => 'Split-FourSquareWindow' ),array( 'im im-icon-Split-Horizontal' => 'Split-Horizontal' ),array( 'im im-icon-Split-Horizontal2Window' => 'Split-Horizontal2Window' ),array( 'im im-icon-Split-Vertical' => 'Split-Vertical' ),array( 'im im-icon-Split-Vertical2' => 'Split-Vertical2' ),array( 'im im-icon-Split-Window' => 'Split-Window' ),array( 'im im-icon-Spoder' => 'Spoder' ),array( 'im im-icon-Spoon' => 'Spoon' ),array( 'im im-icon-Sport-Mode' => 'Sport-Mode' ),array( 'im im-icon-Sports-Clothings1' => 'Sports-Clothings1' ),array( 'im im-icon-Sports-Clothings2' => 'Sports-Clothings2' ),array( 'im im-icon-Sports-Shirt' => 'Sports-Shirt' ),array( 'im im-icon-Spot' => 'Spot' ),array( 'im im-icon-Spray' => 'Spray' ),array( 'im im-icon-Spread' => 'Spread' ),array( 'im im-icon-Spring' => 'Spring' ),array( 'im im-icon-Spurl' => 'Spurl' ),array( 'im im-icon-Spy' => 'Spy' ),array( 'im im-icon-Squirrel' => 'Squirrel' ),array( 'im im-icon-SSL' => 'SSL' ),array( 'im im-icon-St-BasilsCathedral' => 'St-BasilsCathedral' ),array( 'im im-icon-St-PaulsCathedral' => 'St-PaulsCathedral' ),array( 'im im-icon-Stamp-2' => 'Stamp-2' ),array( 'im im-icon-Stamp' => 'Stamp' ),array( 'im im-icon-Stapler' => 'Stapler' ),array( 'im im-icon-Star-Track' => 'Star-Track' ),array( 'im im-icon-Star' => 'Star' ),array( 'im im-icon-Starfish' => 'Starfish' ),array( 'im im-icon-Start2' => 'Start2' ),array( 'im im-icon-Start-3' => 'Start-3' ),array( 'im im-icon-Start-ways' => 'Start-ways' ),array( 'im im-icon-Start' => 'Start' ),array( 'im im-icon-Statistic' => 'Statistic' ),array( 'im im-icon-Stethoscope' => 'Stethoscope' ),array( 'im im-icon-stop--2' => 'stop--2' ),array( 'im im-icon-Stop-Music' => 'Stop-Music' ),array( 'im im-icon-Stop' => 'Stop' ),array( 'im im-icon-Stopwatch-2' => 'Stopwatch-2' ),array( 'im im-icon-Stopwatch' => 'Stopwatch' ),array( 'im im-icon-Storm' => 'Storm' ),array( 'im im-icon-Street-View' => 'Street-View' ),array( 'im im-icon-Street-View2' => 'Street-View2' ),array( 'im im-icon-Strikethrough-Text' => 'Strikethrough-Text' ),array( 'im im-icon-Stroller' => 'Stroller' ),array( 'im im-icon-Structure' => 'Structure' ),array( 'im im-icon-Student-Female' => 'Student-Female' ),array( 'im im-icon-Student-Hat' => 'Student-Hat' ),array( 'im im-icon-Student-Hat2' => 'Student-Hat2' ),array( 'im im-icon-Student-Male' => 'Student-Male' ),array( 'im im-icon-Student-MaleFemale' => 'Student-MaleFemale' ),array( 'im im-icon-Students' => 'Students' ),array( 'im im-icon-Studio-Flash' => 'Studio-Flash' ),array( 'im im-icon-Studio-Lightbox' => 'Studio-Lightbox' ),array( 'im im-icon-Stumbleupon' => 'Stumbleupon' ),array( 'im im-icon-Suit' => 'Suit' ),array( 'im im-icon-Suitcase' => 'Suitcase' ),array( 'im im-icon-Sum-2' => 'Sum-2' ),array( 'im im-icon-Sum' => 'Sum' ),array( 'im im-icon-Summer' => 'Summer' ),array( 'im im-icon-Sun-CloudyRain' => 'Sun-CloudyRain' ),array( 'im im-icon-Sun' => 'Sun' ),array( 'im im-icon-Sunglasses-2' => 'Sunglasses-2' ),array( 'im im-icon-Sunglasses-3' => 'Sunglasses-3' ),array( 'im im-icon-Sunglasses-Smiley' => 'Sunglasses-Smiley' ),array( 'im im-icon-Sunglasses-Smiley2' => 'Sunglasses-Smiley2' ),array( 'im im-icon-Sunglasses-W' => 'Sunglasses-W' ),array( 'im im-icon-Sunglasses-W2' => 'Sunglasses-W2' ),array( 'im im-icon-Sunglasses-W3' => 'Sunglasses-W3' ),array( 'im im-icon-Sunglasses' => 'Sunglasses' ),array( 'im im-icon-Sunrise' => 'Sunrise' ),array( 'im im-icon-Sunset' => 'Sunset' ),array( 'im im-icon-Superman' => 'Superman' ),array( 'im im-icon-Support' => 'Support' ),array( 'im im-icon-Surprise' => 'Surprise' ),array( 'im im-icon-Sushi' => 'Sushi' ),array( 'im im-icon-Sweden' => 'Sweden' ),array( 'im im-icon-Swimming-Short' => 'Swimming-Short' ),array( 'im im-icon-Swimming' => 'Swimming' ),array( 'im im-icon-Swimmwear' => 'Swimmwear' ),array( 'im im-icon-Switch' => 'Switch' ),array( 'im im-icon-Switzerland' => 'Switzerland' ),array( 'im im-icon-Sync-Cloud' => 'Sync-Cloud' ),array( 'im im-icon-Sync' => 'Sync' ),array( 'im im-icon-Synchronize-2' => 'Synchronize-2' ),array( 'im im-icon-Synchronize' => 'Synchronize' ),array( 'im im-icon-T-Shirt' => 'T-Shirt' ),array( 'im im-icon-Tablet-2' => 'Tablet-2' ),array( 'im im-icon-Tablet-3' => 'Tablet-3' ),array( 'im im-icon-Tablet-Orientation' => 'Tablet-Orientation' ),array( 'im im-icon-Tablet-Phone' => 'Tablet-Phone' ),array( 'im im-icon-Tablet-Secure' => 'Tablet-Secure' ),array( 'im im-icon-Tablet-Vertical' => 'Tablet-Vertical' ),array( 'im im-icon-Tablet' => 'Tablet' ),array( 'im im-icon-Tactic' => 'Tactic' ),array( 'im im-icon-Tag-2' => 'Tag-2' ),array( 'im im-icon-Tag-3' => 'Tag-3' ),array( 'im im-icon-Tag-4' => 'Tag-4' ),array( 'im im-icon-Tag-5' => 'Tag-5' ),array( 'im im-icon-Tag' => 'Tag' ),array( 'im im-icon-Taj-Mahal' => 'Taj-Mahal' ),array( 'im im-icon-Talk-Man' => 'Talk-Man' ),array( 'im im-icon-Tap' => 'Tap' ),array( 'im im-icon-Target-Market' => 'Target-Market' ),array( 'im im-icon-Target' => 'Target' ),array( 'im im-icon-Taurus-2' => 'Taurus-2' ),array( 'im im-icon-Taurus' => 'Taurus' ),array( 'im im-icon-Taxi-2' => 'Taxi-2' ),array( 'im im-icon-Taxi-Sign' => 'Taxi-Sign' ),array( 'im im-icon-Taxi' => 'Taxi' ),array( 'im im-icon-Teacher' => 'Teacher' ),array( 'im im-icon-Teapot' => 'Teapot' ),array( 'im im-icon-Technorati' => 'Technorati' ),array( 'im im-icon-Teddy-Bear' => 'Teddy-Bear' ),array( 'im im-icon-Tee-Mug' => 'Tee-Mug' ),array( 'im im-icon-Telephone-2' => 'Telephone-2' ),array( 'im im-icon-Telephone' => 'Telephone' ),array( 'im im-icon-Telescope' => 'Telescope' ),array( 'im im-icon-Temperature-2' => 'Temperature-2' ),array( 'im im-icon-Temperature-3' => 'Temperature-3' ),array( 'im im-icon-Temperature' => 'Temperature' ),array( 'im im-icon-Temple' => 'Temple' ),array( 'im im-icon-Tennis-Ball' => 'Tennis-Ball' ),array( 'im im-icon-Tennis' => 'Tennis' ),array( 'im im-icon-Tent' => 'Tent' ),array( 'im im-icon-Test-Tube' => 'Test-Tube' ),array( 'im im-icon-Test-Tube2' => 'Test-Tube2' ),array( 'im im-icon-Testimonal' => 'Testimonal' ),array( 'im im-icon-Text-Box' => 'Text-Box' ),array( 'im im-icon-Text-Effect' => 'Text-Effect' ),array( 'im im-icon-Text-HighlightColor' => 'Text-HighlightColor' ),array( 'im im-icon-Text-Paragraph' => 'Text-Paragraph' ),array( 'im im-icon-Thailand' => 'Thailand' ),array( 'im im-icon-The-WhiteHouse' => 'The-WhiteHouse' ),array( 'im im-icon-This-SideUp' => 'This-SideUp' ),array( 'im im-icon-Thread' => 'Thread' ),array( 'im im-icon-Three-ArrowFork' => 'Three-ArrowFork' ),array( 'im im-icon-Three-Fingers' => 'Three-Fingers' ),array( 'im im-icon-Three-FingersDrag' => 'Three-FingersDrag' ),array( 'im im-icon-Three-FingersDrag2' => 'Three-FingersDrag2' ),array( 'im im-icon-Three-FingersTouch' => 'Three-FingersTouch' ),array( 'im im-icon-Thumb' => 'Thumb' ),array( 'im im-icon-Thumbs-DownSmiley' => 'Thumbs-DownSmiley' ),array( 'im im-icon-Thumbs-UpSmiley' => 'Thumbs-UpSmiley' ),array( 'im im-icon-Thunder' => 'Thunder' ),array( 'im im-icon-Thunderstorm' => 'Thunderstorm' ),array( 'im im-icon-Ticket' => 'Ticket' ),array( 'im im-icon-Tie-2' => 'Tie-2' ),array( 'im im-icon-Tie-3' => 'Tie-3' ),array( 'im im-icon-Tie-4' => 'Tie-4' ),array( 'im im-icon-Tie' => 'Tie' ),array( 'im im-icon-Tiger' => 'Tiger' ),array( 'im im-icon-Time-Backup' => 'Time-Backup' ),array( 'im im-icon-Time-Bomb' => 'Time-Bomb' ),array( 'im im-icon-Time-Clock' => 'Time-Clock' ),array( 'im im-icon-Time-Fire' => 'Time-Fire' ),array( 'im im-icon-Time-Machine' => 'Time-Machine' ),array( 'im im-icon-Time-Window' => 'Time-Window' ),array( 'im im-icon-Timer-2' => 'Timer-2' ),array( 'im im-icon-Timer' => 'Timer' ),array( 'im im-icon-To-Bottom' => 'To-Bottom' ),array( 'im im-icon-To-Bottom2' => 'To-Bottom2' ),array( 'im im-icon-To-Left' => 'To-Left' ),array( 'im im-icon-To-Right' => 'To-Right' ),array( 'im im-icon-To-Top' => 'To-Top' ),array( 'im im-icon-To-Top2' => 'To-Top2' ),array( 'im im-icon-Token-' => 'Token-' ),array( 'im im-icon-Tomato' => 'Tomato' ),array( 'im im-icon-Tongue' => 'Tongue' ),array( 'im im-icon-Tooth-2' => 'Tooth-2' ),array( 'im im-icon-Tooth' => 'Tooth' ),array( 'im im-icon-Top-ToBottom' => 'Top-ToBottom' ),array( 'im im-icon-Touch-Window' => 'Touch-Window' ),array( 'im im-icon-Tourch' => 'Tourch' ),array( 'im im-icon-Tower-2' => 'Tower-2' ),array( 'im im-icon-Tower-Bridge' => 'Tower-Bridge' ),array( 'im im-icon-Tower' => 'Tower' ),array( 'im im-icon-Trace' => 'Trace' ),array( 'im im-icon-Tractor' => 'Tractor' ),array( 'im im-icon-traffic-Light' => 'traffic-Light' ),array( 'im im-icon-Traffic-Light2' => 'Traffic-Light2' ),array( 'im im-icon-Train-2' => 'Train-2' ),array( 'im im-icon-Train' => 'Train' ),array( 'im im-icon-Tram' => 'Tram' ),array( 'im im-icon-Transform-2' => 'Transform-2' ),array( 'im im-icon-Transform-3' => 'Transform-3' ),array( 'im im-icon-Transform-4' => 'Transform-4' ),array( 'im im-icon-Transform' => 'Transform' ),array( 'im im-icon-Trash-withMen' => 'Trash-withMen' ),array( 'im im-icon-Tree-2' => 'Tree-2' ),array( 'im im-icon-Tree-3' => 'Tree-3' ),array( 'im im-icon-Tree-4' => 'Tree-4' ),array( 'im im-icon-Tree-5' => 'Tree-5' ),array( 'im im-icon-Tree' => 'Tree' ),array( 'im im-icon-Trekking' => 'Trekking' ),array( 'im im-icon-Triangle-ArrowDown' => 'Triangle-ArrowDown' ),array( 'im im-icon-Triangle-ArrowLeft' => 'Triangle-ArrowLeft' ),array( 'im im-icon-Triangle-ArrowRight' => 'Triangle-ArrowRight' ),array( 'im im-icon-Triangle-ArrowUp' => 'Triangle-ArrowUp' ),array( 'im im-icon-Tripod-2' => 'Tripod-2' ),array( 'im im-icon-Tripod-andVideo' => 'Tripod-andVideo' ),array( 'im im-icon-Tripod-withCamera' => 'Tripod-withCamera' ),array( 'im im-icon-Tripod-withGopro' => 'Tripod-withGopro' ),array( 'im im-icon-Trophy-2' => 'Trophy-2' ),array( 'im im-icon-Trophy' => 'Trophy' ),array( 'im im-icon-Truck' => 'Truck' ),array( 'im im-icon-Trumpet' => 'Trumpet' ),array( 'im im-icon-Tumblr' => 'Tumblr' ),array( 'im im-icon-Turkey' => 'Turkey' ),array( 'im im-icon-Turn-Down' => 'Turn-Down' ),array( 'im im-icon-Turn-Down2' => 'Turn-Down2' ),array( 'im im-icon-Turn-DownFromLeft' => 'Turn-DownFromLeft' ),array( 'im im-icon-Turn-DownFromRight' => 'Turn-DownFromRight' ),array( 'im im-icon-Turn-Left' => 'Turn-Left' ),array( 'im im-icon-Turn-Left3' => 'Turn-Left3' ),array( 'im im-icon-Turn-Right' => 'Turn-Right' ),array( 'im im-icon-Turn-Right3' => 'Turn-Right3' ),array( 'im im-icon-Turn-Up' => 'Turn-Up' ),array( 'im im-icon-Turn-Up2' => 'Turn-Up2' ),array( 'im im-icon-Turtle' => 'Turtle' ),array( 'im im-icon-Tuxedo' => 'Tuxedo' ),array( 'im im-icon-TV' => 'TV' ),array( 'im im-icon-Twister' => 'Twister' ),array( 'im im-icon-Twitter-2' => 'Twitter-2' ),array( 'im im-icon-Twitter' => 'Twitter' ),array( 'im im-icon-Two-Fingers' => 'Two-Fingers' ),array( 'im im-icon-Two-FingersDrag' => 'Two-FingersDrag' ),array( 'im im-icon-Two-FingersDrag2' => 'Two-FingersDrag2' ),array( 'im im-icon-Two-FingersScroll' => 'Two-FingersScroll' ),array( 'im im-icon-Two-FingersTouch' => 'Two-FingersTouch' ),array( 'im im-icon-Two-Windows' => 'Two-Windows' ),array( 'im im-icon-Type-Pass' => 'Type-Pass' ),array( 'im im-icon-Ukraine' => 'Ukraine' ),array( 'im im-icon-Umbrela' => 'Umbrela' ),array( 'im im-icon-Umbrella-2' => 'Umbrella-2' ),array( 'im im-icon-Umbrella-3' => 'Umbrella-3' ),array( 'im im-icon-Under-LineText' => 'Under-LineText' ),array( 'im im-icon-Undo' => 'Undo' ),array( 'im im-icon-United-Kingdom' => 'United-Kingdom' ),array( 'im im-icon-United-States' => 'United-States' ),array( 'im im-icon-University-2' => 'University-2' ),array( 'im im-icon-University' => 'University' ),array( 'im im-icon-Unlike-2' => 'Unlike-2' ),array( 'im im-icon-Unlike' => 'Unlike' ),array( 'im im-icon-Unlock-2' => 'Unlock-2' ),array( 'im im-icon-Unlock-3' => 'Unlock-3' ),array( 'im im-icon-Unlock' => 'Unlock' ),array( 'im im-icon-Up--Down' => 'Up--Down' ),array( 'im im-icon-Up--Down3' => 'Up--Down3' ),array( 'im im-icon-Up-2' => 'Up-2' ),array( 'im im-icon-Up-3' => 'Up-3' ),array( 'im im-icon-Up-4' => 'Up-4' ),array( 'im im-icon-Up' => 'Up' ),array( 'im im-icon-Upgrade' => 'Upgrade' ),array( 'im im-icon-Upload-2' => 'Upload-2' ),array( 'im im-icon-Upload-toCloud' => 'Upload-toCloud' ),array( 'im im-icon-Upload-Window' => 'Upload-Window' ),array( 'im im-icon-Upload' => 'Upload' ),array( 'im im-icon-Uppercase-Text' => 'Uppercase-Text' ),array( 'im im-icon-Upward' => 'Upward' ),array( 'im im-icon-URL-Window' => 'URL-Window' ),array( 'im im-icon-Usb-2' => 'Usb-2' ),array( 'im im-icon-Usb-Cable' => 'Usb-Cable' ),array( 'im im-icon-Usb' => 'Usb' ),array( 'im im-icon-User' => 'User' ),array( 'im im-icon-Ustream' => 'Ustream' ),array( 'im im-icon-Vase' => 'Vase' ),array( 'im im-icon-Vector-2' => 'Vector-2' ),array( 'im im-icon-Vector-3' => 'Vector-3' ),array( 'im im-icon-Vector-4' => 'Vector-4' ),array( 'im im-icon-Vector-5' => 'Vector-5' ),array( 'im im-icon-Vector' => 'Vector' ),array( 'im im-icon-Venn-Diagram' => 'Venn-Diagram' ),array( 'im im-icon-Vest-2' => 'Vest-2' ),array( 'im im-icon-Vest' => 'Vest' ),array( 'im im-icon-Viddler' => 'Viddler' ),array( 'im im-icon-Video-2' => 'Video-2' ),array( 'im im-icon-Video-3' => 'Video-3' ),array( 'im im-icon-Video-4' => 'Video-4' ),array( 'im im-icon-Video-5' => 'Video-5' ),array( 'im im-icon-Video-6' => 'Video-6' ),array( 'im im-icon-Video-GameController' => 'Video-GameController' ),array( 'im im-icon-Video-Len' => 'Video-Len' ),array( 'im im-icon-Video-Len2' => 'Video-Len2' ),array( 'im im-icon-Video-Photographer' => 'Video-Photographer' ),array( 'im im-icon-Video-Tripod' => 'Video-Tripod' ),array( 'im im-icon-Video' => 'Video' ),array( 'im im-icon-Vietnam' => 'Vietnam' ),array( 'im im-icon-View-Height' => 'View-Height' ),array( 'im im-icon-View-Width' => 'View-Width' ),array( 'im im-icon-Vimeo' => 'Vimeo' ),array( 'im im-icon-Virgo-2' => 'Virgo-2' ),array( 'im im-icon-Virgo' => 'Virgo' ),array( 'im im-icon-Virus-2' => 'Virus-2' ),array( 'im im-icon-Virus-3' => 'Virus-3' ),array( 'im im-icon-Virus' => 'Virus' ),array( 'im im-icon-Visa' => 'Visa' ),array( 'im im-icon-Voice' => 'Voice' ),array( 'im im-icon-Voicemail' => 'Voicemail' ),array( 'im im-icon-Volleyball' => 'Volleyball' ),array( 'im im-icon-Volume-Down' => 'Volume-Down' ),array( 'im im-icon-Volume-Up' => 'Volume-Up' ),array( 'im im-icon-VPN' => 'VPN' ),array( 'im im-icon-Wacom-Tablet' => 'Wacom-Tablet' ),array( 'im im-icon-Waiter' => 'Waiter' ),array( 'im im-icon-Walkie-Talkie' => 'Walkie-Talkie' ),array( 'im im-icon-Wallet-2' => 'Wallet-2' ),array( 'im im-icon-Wallet-3' => 'Wallet-3' ),array( 'im im-icon-Wallet' => 'Wallet' ),array( 'im im-icon-Warehouse' => 'Warehouse' ),array( 'im im-icon-Warning-Window' => 'Warning-Window' ),array( 'im im-icon-Watch-2' => 'Watch-2' ),array( 'im im-icon-Watch-3' => 'Watch-3' ),array( 'im im-icon-Watch' => 'Watch' ),array( 'im im-icon-Wave-2' => 'Wave-2' ),array( 'im im-icon-Wave' => 'Wave' ),array( 'im im-icon-Webcam' => 'Webcam' ),array( 'im im-icon-weight-Lift' => 'weight-Lift' ),array( 'im im-icon-Wheelbarrow' => 'Wheelbarrow' ),array( 'im im-icon-Wheelchair' => 'Wheelchair' ),array( 'im im-icon-Width-Window' => 'Width-Window' ),array( 'im im-icon-Wifi-2' => 'Wifi-2' ),array( 'im im-icon-Wifi-Keyboard' => 'Wifi-Keyboard' ),array( 'im im-icon-Wifi' => 'Wifi' ),array( 'im im-icon-Wind-Turbine' => 'Wind-Turbine' ),array( 'im im-icon-Windmill' => 'Windmill' ),array( 'im im-icon-Window-2' => 'Window-2' ),array( 'im im-icon-Window' => 'Window' ),array( 'im im-icon-Windows-2' => 'Windows-2' ),array( 'im im-icon-Windows-Microsoft' => 'Windows-Microsoft' ),array( 'im im-icon-Windows' => 'Windows' ),array( 'im im-icon-Windsock' => 'Windsock' ),array( 'im im-icon-Windy' => 'Windy' ),array( 'im im-icon-Wine-Bottle' => 'Wine-Bottle' ),array( 'im im-icon-Wine-Glass' => 'Wine-Glass' ),array( 'im im-icon-Wink' => 'Wink' ),array( 'im im-icon-Winter-2' => 'Winter-2' ),array( 'im im-icon-Winter' => 'Winter' ),array( 'im im-icon-Wireless' => 'Wireless' ),array( 'im im-icon-Witch-Hat' => 'Witch-Hat' ),array( 'im im-icon-Witch' => 'Witch' ),array( 'im im-icon-Wizard' => 'Wizard' ),array( 'im im-icon-Wolf' => 'Wolf' ),array( 'im im-icon-Woman-Sign' => 'Woman-Sign' ),array( 'im im-icon-WomanMan' => 'WomanMan' ),array( 'im im-icon-Womans-Underwear' => 'Womans-Underwear' ),array( 'im im-icon-Womans-Underwear2' => 'Womans-Underwear2' ),array( 'im im-icon-Women' => 'Women' ),array( 'im im-icon-Wonder-Woman' => 'Wonder-Woman' ),array( 'im im-icon-Wordpress' => 'Wordpress' ),array( 'im im-icon-Worker-Clothes' => 'Worker-Clothes' ),array( 'im im-icon-Worker' => 'Worker' ),array( 'im im-icon-Wrap-Text' => 'Wrap-Text' ),array( 'im im-icon-Wreath' => 'Wreath' ),array( 'im im-icon-Wrench' => 'Wrench' ),array( 'im im-icon-X-Box' => 'X-Box' ),array( 'im im-icon-X-ray' => 'X-ray' ),array( 'im im-icon-Xanga' => 'Xanga' ),array( 'im im-icon-Xing' => 'Xing' ),array( 'im im-im im-icon-Yacht' => 'Yacht' ),array( 'im im-icon-Yahoo-Buzz' => 'Yahoo-Buzz' ),array( 'im im-icon-Yahoo' => 'Yahoo' ),array( 'im im-icon-Yelp' => 'Yelp' ),array( 'im im-icon-Yes' => 'Yes' ),array( 'im im-icon-Ying-Yang' => 'Ying-Yang' ),array( 'im im-icon-Youtube' => 'Youtube' ),array( 'im im-icon-Z-A' => 'Z-A' ),array( 'im im-icon-Zebra' => 'Zebra' ),array( 'im im-icon-Zombie' => 'Zombie' ),array( 'im im-icon-Zoom-Gesture' => 'Zoom-Gesture' ),array( 'im im-icon-Zootool' => 'Zootool' ),
  );

  return array_merge( $icons, $iconsmind_icons );
}



// This filter allow a wp_dropdown_categories select to return multiple items
add_filter( 'wp_dropdown_cats', 'willy_wp_dropdown_cats_multiple', 10, 2 );
function willy_wp_dropdown_cats_multiple( $output, $r ) {
  if ( ! empty( $r['multiple'] ) ) {
    $output = preg_replace( '/<select(.*?)>/i', '<select$1 multiple="multiple">', $output );
    $output = preg_replace( '/name=([\'"]{1})(.*?)\1/i', 'name=$2[]', $output );
  }
  return $output;
}

// This Walker is needed to match more than one selected value
class Willy_Walker_CategoryDropdown extends Walker_CategoryDropdown {
  public function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
    $pad = str_repeat('&nbsp;', $depth * 3);

    /** This filter is documented in wp-includes/category-template.php */
    $cat_name = apply_filters( 'list_cats', $category->name, $category );

    if ( isset( $args['value_field'] ) && isset( $category->{$args['value_field']} ) ) {
      $value_field = $args['value_field'];
    } else {
      $value_field = 'term_id';
    }

    $output .= "\t<option class=\"level-$depth\" value=\"" . esc_attr( $category->{$value_field} ) . "\"";

    // Type-juggling causes false matches, so we force everything to a string.
    if ( in_array( $category->{$value_field}, (array)$args['selected'], true ) )
      $output .= ' selected="selected"';
    $output .= '>';
    $output .= $pad.$cat_name;
    if ( $args['show_count'] )
      $output .= '&nbsp;&nbsp;('. number_format_i18n( $category->count ) .')';
    $output .= "</option>\n";
  }
}