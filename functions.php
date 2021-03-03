<?php
/**
 * listeo functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package listeo
 */

 

if ( ! function_exists( 'listeo_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
// $date_format = get_option('date_format');
// echo strtotime( date( $date_format, strtotime('+5 days') ) );
global $wpdb;
		
//temp fix for listing author 
// $ownerusers = get_users( 'role=owner' );
// foreach ( $ownerusers as $user ) {
//    $user->add_cap('level_1');
// }

function cc_mime_types($mimes) {
 $mimes['svg'] = 'image/svg+xml';
 return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

function listeo_setup() {


	load_theme_textdomain( 'listeo', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'title-tag' );


	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size(900, 500, true); //size of thumbs
	add_image_size( 'listeo-avatar', 590, 590 );
	add_image_size( 'listeo-blog-post', 1200, 670 );
	add_image_size( 'listeo-blog-related-post', 577, 866 );
	add_image_size( 'listeo-post-thumb', 150, 150, true );


	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Main Menu', 'listeo' ),
	) );

	do_action( 'purethemes-testimonials' );
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'listeo_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	add_theme_support( 'woocommerce' );
}
endif;
add_action( 'after_setup_theme', 'listeo_setup' );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function listeo_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'listeo_content_width', 760 );
}
add_action( 'after_setup_theme', 'listeo_content_width', 0 );

/**
 * Register widget area.
 */
function listeo_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'listeo' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'listeo' ),
		'before_widget' => '<section id="%1$s" class="widget  margin-top-40 %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );	
	register_sidebar( array(
		'name'          => esc_html__( 'Shop page sidebar', 'workscout', 'listeo' ),
		'id'            => 'sidebar-shop',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget  margin-top-40 %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar(array(
		'id' => 'footer1',
		'name' => esc_html__('Footer 1st Column', 'listeo' ),
		'description' => esc_html__('1st column for widgets in Footer', 'listeo' ),
		'before_widget' => '<aside id="%1$s" class="footer-widget widget %2$s">',
		'after_widget' => '</aside>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>',
		));
	register_sidebar(array(
		'id' => 'footer2',
		'name' => esc_html__('Footer 2nd Column', 'listeo' ),
		'description' => esc_html__('2nd column for widgets in Footer', 'listeo' ),
		'before_widget' => '<aside id="%1$s" class="footer-widget widget %2$s">',
		'after_widget' => '</aside>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>',
		));
	register_sidebar(array(
		'id' => 'footer3',
		'name' => esc_html__('Footer 3rd Column', 'listeo' ),
		'description' => esc_html__('3rd column for widgets in Footer', 'listeo' ),
		'before_widget' => '<aside id="%1$s" class="footer-widget widget %2$s">',
		'after_widget' => '</aside>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>',
		));
	register_sidebar(array(
		'id' => 'footer4',
		'name' => esc_html__('Footer 4th Column', 'listeo' ),
		'description' => esc_html__('4th column for widgets in Footer', 'listeo' ),
		'before_widget' => '<aside id="%1$s" class="footer-widget widget %2$s">',
		'after_widget' => '</aside>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>',
		));
	
	if (get_option('pp_listeo_sidebar')):
		
		$pp_sidebars = get_option('pp_listeo_sidebar');
		if(!empty($pp_sidebars)):
			foreach ($pp_sidebars as $pp_sidebar) {
		
				register_sidebar(array(
					'name' => esc_html($pp_sidebar["sidebar_name"]),
					'id' => esc_attr($pp_sidebar["sidebar_id"]),
					'before_widget' => '<section id="%1$s" class="widget %2$s">',
					'after_widget'  => '</section>',
					'before_title'  => '<h3 class="widget-title">',
					'after_title'   => '</h3>',
					));
			}
		endif;
	endif;
}
add_action( 'widgets_init', 'listeo_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function listeo_scripts() {
	
	$my_theme = wp_get_theme();
	//$ver_num = $my_theme->get( 'Version' );
	$ver_num = 1.7;

	wp_register_style( 'bootstrap', get_template_directory_uri(). '/css/bootstrap-grid.css' );
	wp_register_style( 'listeo-woocommerce', get_template_directory_uri(). '/css/woocommerce.min.css' );
    wp_register_style( 'listeo-iconsmind', get_template_directory_uri(). '/css/icons.css' );
    wp_register_style( 'simple-line-icons', get_template_directory_uri(). '/css/simple-line-icons.css' );
    wp_register_style( 'font-awesome-5', get_template_directory_uri(). '/css/all.css' );
    wp_register_style( 'font-awesome-5-shims', get_template_directory_uri(). '/css/v4-shims.min.css' );
	wp_enqueue_style( 'listeo-style', get_stylesheet_uri(), array('bootstrap','font-awesome-5','font-awesome-5-shims','simple-line-icons','listeo-woocommerce'), $ver_num );
	if(get_option('listeo_iconsmind')!='hide'){
		wp_enqueue_style( 'listeo-iconsmind');
	}
	wp_register_style( 'listeo-dark', get_template_directory_uri(). '/css/dark-mode.css' );
	if(get_option('listeo_dark_mode')){
		wp_enqueue_style( 'listeo-dark', get_template_directory_uri(). '/css/dark-mode.css' ,array('listeo-style'));
	}
	//wp_register_script( 'chosen-min', get_template_directory_uri() . '/js/chosen.min.js', array( 'jquery' ), $ver_num );
	wp_register_script( 'select2-min', get_template_directory_uri() . '/js/select2.min.js', array( 'jquery' ), $ver_num );
	wp_register_script( 'counterup-min', get_template_directory_uri() . '/js/counterup.min.js', array( 'jquery' ), $ver_num );
	wp_register_script( 'jquery-scrollto', get_template_directory_uri() . '/js/jquery.scrollto.js', array( 'jquery' ), $ver_num );
	wp_register_script( 'datedropper', get_template_directory_uri() . '/js/datedropper.js', array( 'jquery' ), $ver_num );
	wp_register_script( 'dropzone', get_template_directory_uri() . '/js/dropzone.js', array( 'jquery' ), $ver_num );
	
	wp_register_script( 'isotope-min', get_template_directory_uri() . '/js/isotope.min.js', array( 'jquery' ), $ver_num );
	wp_register_script( 'jquery-counterdown-min', get_template_directory_uri() . '/js/jquery.countdown.min.js', array( 'jquery' ), $ver_num );
	wp_register_script( 'magnific-popup-min', get_template_directory_uri() . '/js/magnific-popup.min.js', array( 'jquery' ), $ver_num );

	
	wp_register_script( 'quantityButtons', get_template_directory_uri() . '/js/quantityButtons.js', array( 'jquery' ), $ver_num );
	wp_register_script( 'rangeslider-min', get_template_directory_uri() . '/js/rangeslider.min.js', array( 'jquery' ), $ver_num );
	wp_register_script( 'timedropper', get_template_directory_uri() . '/js/timedropper.js', array( 'jquery' ), $ver_num );
	wp_register_script( 'tooltips-min', get_template_directory_uri() . '/js/tooltips.min.js', array( 'jquery' ), $ver_num );
	wp_register_script( 'waypoints-min', get_template_directory_uri() . '/js/waypoints.min.js', array( 'jquery' ), $ver_num );
	wp_register_script( 'slick-min', get_template_directory_uri() . '/js/slick.min.js', array( 'jquery' ), $ver_num );
	wp_register_script( 'mmenu-min', get_template_directory_uri() . '/js/mmenu.min.js', array( 'jquery' ), $ver_num );
	
	wp_register_script( 'moment', get_template_directory_uri() . '/js/moment.min.js', array( 'jquery' ), $ver_num );
	wp_register_script( 'daterangerpicker', get_template_directory_uri() . '/js/daterangepicker.js', array( 'jquery','moment' ), $ver_num );
 	wp_register_script( 'flatpickr', get_template_directory_uri() . '/js/flatpickr.js', array( 'jquery' ), $ver_num );
 	wp_register_script( 'bootstrap-slider-min', get_template_directory_uri() . '/js/bootstrap-slider.min.js', array( 'jquery' ), $ver_num );

	//wp_enqueue_script( 'chosen-min' );
	wp_enqueue_script( 'select2-min' );
	wp_enqueue_script( 'counterup-min' );
	wp_enqueue_script( 'datedropper' );
	wp_enqueue_script( 'dropzone' );
	
	
	if ( is_page_template( 'template-comming-soon.php' ) ) {
		wp_enqueue_script( 'jquery-counterdown-min' );
	}
	wp_enqueue_script( 'magnific-popup-min' );

	
	
	wp_enqueue_script( 'mmenu-min' );
	wp_enqueue_script( 'slick-min' );
	wp_enqueue_script( 'quantityButtons' );
	wp_enqueue_script( 'rangeslider-min' );
	wp_enqueue_script( 'timedropper' );
	wp_enqueue_script( 'jquery-scrollto' );
	wp_enqueue_script( 'tooltips-min' );
	wp_enqueue_script( 'waypoints-min' );
	wp_enqueue_script( 'moment' );
	wp_enqueue_script( 'daterangerpicker' );
	wp_enqueue_script( 'bootstrap-slider-min' );
	wp_enqueue_script( 'flatpickr' );
	wp_enqueue_script( 'listeo-custom', get_template_directory_uri() . '/js/custom.js', array('jquery'), '20170821', true );


	$open_sans_args = array(
		'family' => 'Open+Sans:500,600,700' // Change this font to whatever font you'd like
	);
	wp_register_style( 'google-fonts-open-sans', add_query_arg( $open_sans_args, "//fonts.googleapis.com/css" ), array(), null );

	$raleway_args = array(
		'family' => 'Raleway:300,400,500,600,700' // Change this font to whatever font you'd like
	);
	wp_register_style( 'google-fonts-raleway', add_query_arg( $raleway_args, "//fonts.googleapis.com/css" ), array(), null );
	
	wp_enqueue_style( 'google-fonts-raleway' );
	wp_enqueue_style( 'google-fonts-open-sans' );
	
	$convertedData = listeo_date_time_wp_format();

	// add converented format date to javascript
	wp_localize_script( 'listeo-custom', 'wordpress_date_format', $convertedData );


	$ajax_url = admin_url( 'admin-ajax.php', 'relative' );
	wp_localize_script( 'listeo-custom', 'listeo',
    array(
        'ajaxurl' 				=> $ajax_url,
        'theme_url'				=> get_template_directory_uri(),
        )
    );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'listeo_scripts' );


add_action(  'admin_enqueue_scripts', 'listeo_admin_scripts' );
function listeo_admin_scripts($hook){

	if($hook=='edit-tags.php' || $hook == 'term.php'|| $hook == 'post.php' || $hook == 'toplevel_page_listeo_settings' || $hook = 'listeo-core_page_listeo_license'){
		wp_enqueue_style( 'listeo-admin', get_template_directory_uri(). '/css/admin.css' );
		wp_enqueue_style( 'listeo-icons', get_template_directory_uri(). '/css/all.css' );
		wp_enqueue_style( 'listeo-icons-fav4', get_template_directory_uri(). '/css/fav4-shims.min.css' );
		wp_enqueue_style( 'listeo-iconsmind', get_template_directory_uri(). '/css/icons.css' );
		wp_enqueue_script( 'listeo-icon-selector', get_template_directory_uri() . '/js/iconselector.min.js', array('jquery'), '20180323', true );
		
	}
}


function listeo_add_editor_styles() {
    add_editor_style( 'custom-editor-style.css' );
}
add_action( 'admin_init', 'listeo_add_editor_styles' );

/**
 * Load aq_resizer.
 */
require get_template_directory() . '/inc/aq_resize.php';


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Custom meta-boxes
 */
require get_template_directory() . '/inc/meta-boxes.php';

/*
 * Load the Kirki Fallback class
 */
require get_template_directory() . '/inc/kirki-fallback.php';


/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


/**
 * Load TGMPA file.
 */
require get_template_directory() . '/inc/tgmpa.php';



/**
 * Load big map.
 */
require get_template_directory() . '/inc/properties-maps.php';

/**
 * Load woocommerce 
 */
require get_template_directory() . '/inc/woocommerce.php';
/**
 * Load megamenu 
 */
require get_template_directory() . '/inc/megamenu.php';


if (!class_exists("ListeoBase")) {
require_once get_template_directory() . '/inc/ListeoBase.php';
}
require get_template_directory() . '/inc/licenser.php';


/**
 * Setup Wizard
 */
require get_template_directory() . '/envato_setup/envato_setup.php';

// Enable shortcodes in text widgets
add_filter('widget_text','do_shortcode');

function listeo_disable_admin_bar() {
   if (current_user_can('administrator')  ) {
     // user can view admin bar
     show_admin_bar(true); // this line isn't essentially needed by default...
   } else {
     // hide admin bar
     show_admin_bar(false);
   }
}
add_action('after_setup_theme', 'listeo_disable_admin_bar');


function listeo_new_customer_data($new_customer_data){
 $new_customer_data['role'] = 'owner';
 return $new_customer_data;
}
add_filter( 'woocommerce_new_customer_data', 'listeo_new_customer_data');


function listeo_noindex_for_products()
{
    if ( is_singular( 'product' ) ) {
    	global $post;
    	if( function_exists('wc_get_product') ){
    		$product = wc_get_product( $post->ID );
    		//listing_booking, listing_package_subscription, listing_package
            if( $product->is_type( 'listing_booking' ) || $product->is_type( 'listing_package_subscription' ) || $product->is_type( 'listing_package' )  ){
            	echo '<meta name="robots" content="noindex, follow">';
            }
    	}
        
    }
}

add_action('wp_head', 'listeo_noindex_for_products');
