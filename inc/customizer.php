<?php
/**
 * listeo Theme Customizer
 *
 * @package listeo
 */

/**
 * Add the theme configuration
 */
listeo_Kirki::add_config( 'listeo', array(
    'option_type' => 'option',
    'capability'  => 'edit_theme_options',
) );
    
    
require get_template_directory() . '/inc/customizer/var.php';
require get_template_directory() . '/inc/customizer/header.php';
require get_template_directory() . '/inc/customizer/home.php';
require get_template_directory() . '/inc/customizer/listings.php';
require get_template_directory() . '/inc/customizer/general.php';
require get_template_directory() . '/inc/customizer/shop.php';
require get_template_directory() . '/inc/customizer/typography.php';
require get_template_directory() . '/inc/customizer/blog.php';
require get_template_directory() . '/inc/customizer/footer.php';




/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function listeo_customize_register( $wp_customize ) {
    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
    $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'listeo_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function listeo_customize_preview_js() {
    wp_enqueue_script( 'listeo_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'listeo_customize_preview_js' );


/**
 * Add color styling from theme
 */
function listeo_custom_styles() {
    $maincolor = get_option('pp_main_color','#f30c0c' ); 
    $maincolor_rgb = implode(",",sscanf($maincolor, "#%02x%02x%02x"));
    
    $video_color = get_option('listeo_video_search_color','rgba(22,22,22,0.4)');
    $custom_css = "
input[type='checkbox'].switch_1:checked,
.time-slot input:checked ~ label:hover,
div.datedropper:before,
div.datedropper .pick-submit,
div.datedropper .pick-lg-b .pick-sl:before,
div.datedropper .pick-m,
body.no-map-marker-icon .face.front,
body.no-map-marker-icon .face.front:after,
div.datedropper .pick-lg-h {
  background-color: {$maincolor} !important;
}
#booking-date-range-enabler:after,
.nav-links div a:hover, #posts-nav li a:hover,
.hosted-by-title a:hover,

.sort-by-select .select2-container--default .select2-selection--single .select2-selection__arrow b:after,
.claim-badge a i,
.search-input-icon:hover i,
.listing-features.checkboxes a:hover,
div.datedropper .pick-y.pick-jump,
div.datedropper .pick li span,
div.datedropper .pick-lg-b .pick-wke,
div.datedropper .pick-btn,
#listeo-coupon-link,
.total-discounted_costs span,
.widget_meta ul li a:hover, .widget_categories ul li a:hover, .widget_archive ul li a:hover, .widget_recent_comments ul li a:hover, .widget_recent_entries ul li a:hover,
.booking-estimated-discount-cost span {
  color: {$maincolor} !important;
}

.comment-by-listing a:hover,
.browse-all-user-listings a i,
.hosted-by-title h4 a:hover,
.style-2 .trigger.active a,
.style-2 .ui-accordion .ui-accordion-header-active:hover,
.style-2 .ui-accordion .ui-accordion-header-active,
#posts-nav li a:hover,
.plan.featured .listing-badge,
.post-content h3 a:hover,
.add-review-photos i,
.show-more-button i,
.listing-details-sidebar li a,
.star-rating .rating-counter a:hover,
.more-search-options-trigger:after,
.header-widget .sign-in:hover,
#footer a,
#footer .footer-links li a:hover,
#navigation.style-1 .current,
#navigation.style-1 ul li:hover a,
.user-menu.active .user-name:after,
.user-menu:hover .user-name:after,
.user-menu.active .user-name,
.user-menu:hover .user-name,
.main-search-input-item.location a:hover,
.chosen-container .chosen-results li.highlighted,
.input-with-icon.location a i:hover,
.sort-by .chosen-container-single .chosen-single div:after,
.sort-by .chosen-container-single .chosen-default,
.panel-dropdown a:after,
.post-content a.read-more,
.post-meta li a:hover,
.widget-text h5 a:hover,
.about-author a,
button.button.border.white:hover,
a.button.border.white:hover,
.icon-box-2 i,
button.button.border,
a.button.border,
.style-2 .ui-accordion .ui-accordion-header:hover,
.style-2 .trigger a:hover ,
.plan.featured .listing-badges .featured,
.list-4 li:before,
.list-3 li:before,
.list-2 li:before,
.list-1 li:before,
.info-box h4,
.testimonial-carousel .slick-slide.slick-active .testimonial:before,
.sign-in-form .tabs-nav li a:hover,
.sign-in-form .tabs-nav li.active a,
.lost_password:hover a,
#top-bar .social-icons li a:hover i,
.listing-share .social-icons li a:hover i,
.agent .social-icons li a:hover i,
#footer .social-icons li a:hover i,
.headline span i,
vc_tta.vc_tta-style-tabs-style-1 .vc_tta-tab.vc_active a,.vc_tta.vc_tta-style-tabs-style-2 .vc_tta-tab.vc_active a,.tabs-nav li.active a,.wc-tabs li.active a.custom-caption,#backtotop a,.trigger.active a,.post-categories li a,.vc_tta.vc_tta-style-tabs-style-3.vc_general .vc_tta-tab a:hover,.vc_tta.vc_tta-style-tabs-style-3.vc_general .vc_tta-tab.vc_active a,.wc-tabs li a:hover,.tabs-nav li a:hover,.tabs-nav li.active a,.wc-tabs li a:hover,.wc-tabs li.active a,.testimonial-author h4,.widget-button:hover,.widget-text h5 a:hover,a,a.button.border,a.button.border.white:hover,button.button.border,button.button.border.white:hover,.wpb-js-composer .vc_tta.vc_general.vc_tta-style-tabs-style-1 .vc_tta-tab.vc_active>a,.wpb-js-composer .vc_tta.vc_general.vc_tta-style-tabs-style-2 .vc_tta-tab.vc_active>a,
#add_payment_method .cart-collaterals .cart_totals tr th,
.woocommerce-cart .cart-collaterals .cart_totals tr th, 
.woocommerce-checkout .cart-collaterals .cart_totals tr th,
#add_payment_method table.cart th, 
.woocommerce-cart table.cart th, 
.woocommerce-checkout table.cart th,
.woocommerce-checkout table.shop_table th,
.uploadButton .uploadButton-button:before,
.time-slot input ~ label:hover,
.time-slot label:hover span,
.booking-loading-icon {
    color: {$maincolor};
}

body .icon-box-2 svg g,
body .icon-box-2 svg circle,
body .icon-box-2 svg rect,
body .icon-box-2 svg path,
body .listeo-svg-icon-box-grid svg g,
body .listeo-svg-icon-box-grid svg circle,
body .listeo-svg-icon-box-grid svg rect,
body .listeo-svg-icon-box-grid svg path,
.listing-type:hover .listing-type-icon svg g,
.listing-type:hover .listing-type-icon svg circle,
.listing-type:hover .listing-type-icon svg rect,
.listing-type:hover .listing-type-icon svg path,
.marker-container .front.face svg g,
.marker-container .front.face svg circle,
.marker-container .front.face svg rect,
.marker-container .front.face svg path { fill: {$maincolor}; }

.qtyTotal,
.mm-menu em.mm-counter,
.mm-counter,
.category-small-box:hover,
.option-set li a.selected,
.pricing-list-container h4:after,
#backtotop a,
.chosen-container-multi .chosen-choices li.search-choice,
.select-options li:hover,
button.panel-apply,
.layout-switcher a:hover,
.listing-features.checkboxes li:before,
.comment-by a.comment-reply-link:hover,
.add-review-photos:hover,
.office-address h3:after,
.post-img:before,
button.button,
.booking-confirmation-page a.button.color,
input[type=\"button\"],
input[type=\"submit\"],
a.button,
a.button.border:hover,
button.button.border:hover,
table.basic-table th,
.plan.featured .plan-price,
mark.color,
.style-4 .tabs-nav li.active a,
.style-5 .tabs-nav li.active a,
.dashboard-list-box .button.gray:hover,
.change-photo-btn:hover,
.dashboard-list-box  a.rate-review:hover,
input:checked + .slider,
.add-pricing-submenu.button:hover,
.add-pricing-list-item.button:hover,
.custom-zoom-in:hover,
.custom-zoom-out:hover,
#geoLocation:hover,
#streetView:hover,
#scrollEnabling:hover,
.code-button:hover,
.category-small-box-alt:hover .category-box-counter-alt,
#scrollEnabling.enabled,
#mapnav-buttons a:hover,
#sign-in-dialog .mfp-close:hover,
.button.listeo-booking-widget-apply_new_coupon:before,
#small-dialog .mfp-close:hover,
.daterangepicker td.end-date.in-range.available,
.radio input[type='radio'] + label .radio-label:after,
.radio input[type='radio']:checked + label .radio-label,
.daterangepicker .ranges li.active, .day-slot-headline, .add-slot-btn button:hover, .daterangepicker td.available:hover, .daterangepicker th.available:hover, .time-slot input:checked ~ label, .daterangepicker td.active, .daterangepicker td.active:hover, .daterangepicker .drp-buttons button.applyBtn,.uploadButton .uploadButton-button:hover {
    background-color: {$maincolor};
}


.rangeslider__fill,
span.blog-item-tag ,
.testimonial-carousel .slick-slide.slick-active .testimonial-box,
.listing-item-container.list-layout span.tag,
.tip,
.search .panel-dropdown.active a,
#getDirection:hover,
.loader-ajax-container,
.mfp-arrow:hover {
    background: {$maincolor};
}

.radio input[type='radio']:checked + label .radio-label,
.rangeslider__handle { border-color: {$maincolor}; }

.layout-switcher a.active {
    color: {$maincolor};
    border-color: {$maincolor};
}

#titlebar.listing-titlebar span.listing-tag a,
#titlebar.listing-titlebar span.listing-tag {
    border-color: {$maincolor};
    color: {$maincolor};
}
.single-service .qtyInc:hover, .single-service .qtyDec:hover,
.services-counter,
.listing-slider .slick-next:hover,
.listing-slider .slick-prev:hover {
    background-color: {$maincolor};
}
.single-service .qtyInc:hover, .single-service .qtyDec:hover{
    -webkit-text-stroke: 1px {$maincolor};
}


.listing-nav-container.cloned .listing-nav li:first-child a.active,
.listing-nav-container.cloned .listing-nav li:first-child a:hover,
.listing-nav li:first-child a,
.listing-nav li a.active,
.listing-nav li a:hover {
    border-color: {$maincolor};
    color: {$maincolor};
}

.pricing-list-container h4 {
    color: {$maincolor};
    border-color: {$maincolor};
}

.sidebar-textbox ul.contact-details li a { color: {$maincolor}; }

button.button.border,
a.button.border {
    color: {$maincolor};
    border-color: {$maincolor};
}

.trigger.active a,
.ui-accordion .ui-accordion-header-active:hover,
.ui-accordion .ui-accordion-header-active {
    background-color: {$maincolor};
    border-color: {$maincolor};
}

.numbered.color ol > li::before {
    border-color: {$maincolor};;
    color: {$maincolor};
}

.numbered.color.filled ol > li::before {
    border-color: {$maincolor};
    background-color: {$maincolor};
}

.info-box {
    border-top: 2px solid {$maincolor};
    background: linear-gradient(to bottom, rgba(255,255,255,0.98), rgba(255,255,255,0.95));
    background-color: {$maincolor};
    color: {$maincolor};
}

.info-box.no-border {
    background: linear-gradient(to bottom, rgba(255,255,255,0.96), rgba(255,255,255,0.93));
    background-color: {$maincolor};
}

.tabs-nav li a:hover { border-color: {$maincolor}; }
.tabs-nav li a:hover,
.tabs-nav li.active a {
    border-color: {$maincolor};
    color: {$maincolor};
}

.style-3 .tabs-nav li a:hover,
.style-3 .tabs-nav li.active a {
    border-color: {$maincolor};
    background-color: {$maincolor};
}
.woocommerce-cart .woocommerce table.shop_table th,
.vc_tta.vc_general.vc_tta-style-style-1 .vc_active .vc_tta-panel-heading,
.wpb-js-composer .vc_tta.vc_general.vc_tta-style-tabs-style-2 .vc_tta-tab.vc_active>a,
.wpb-js-composer .vc_tta.vc_general.vc_tta-style-tabs-style-2 .vc_tta-tab:hover>a,
.wpb-js-composer .vc_tta.vc_general.vc_tta-style-tabs-style-1 .vc_tta-tab.vc_active>a,
.wpb-js-composer .vc_tta.vc_general.vc_tta-style-tabs-style-1 .vc_tta-tab:hover>a{    
    border-bottom-color: {$maincolor}
}

.checkboxes input[type=checkbox]:checked + label:before {
    background-color: {$maincolor};
    border-color: {$maincolor};
}

.listing-item-container.compact .listing-item-content span.tag { background-color: {$maincolor}; }

.dashboard-nav ul li.active,
.dashboard-nav ul li:hover { border-color: {$maincolor}; }

.dashboard-list-box .comment-by-listing a:hover { color: {$maincolor}; }

.opening-day:hover h5 { color: {$maincolor} !important; }

.map-box h4 a:hover { color: {$maincolor}; }
.infoBox-close:hover {
    background-color: {$maincolor};
    -webkit-text-stroke: 1px {$maincolor};
}
.select2-container--default .select2-selection--multiple .select2-selection__choice,
body .select2-container--default .select2-results__option--highlighted[aria-selected], 
body .select2-container--default .select2-results__option--highlighted[data-selected],
body .woocommerce .cart .button, 
body .woocommerce .cart input.button,
body .woocommerce #respond input#submit, 
body .woocommerce a.button, 
body .woocommerce button.button, 
body .woocommerce input.button,
body .woocommerce #respond input#submit.alt:hover, 
body .woocommerce a.button.alt:hover, 
body .woocommerce button.button.alt:hover, 
body .woocommerce input.button.alt:hover,
.marker-cluster-small div, .marker-cluster-medium div, .marker-cluster-large div,
.cluster-visible {
    background-color: {$maincolor} !important;
}

.marker-cluster div:before {
    border: 7px solid {$maincolor};
    opacity: 0.2;
    box-shadow: inset 0 0 0 4px {$maincolor};
}

.cluster-visible:before {
    border: 7px solid {$maincolor};
    box-shadow: inset 0 0 0 4px {$maincolor};
}

.marker-arrow {
    border-color: {$maincolor} transparent transparent;
}

.face.front {
    border-color: {$maincolor};
    color: {$maincolor};
}

.face.back {
    background: {$maincolor};
    border-color: {$maincolor};
}

.custom-zoom-in:hover:before,
.custom-zoom-out:hover:before  { -webkit-text-stroke: 1px {$maincolor};  }

.category-box-btn:hover {
    background-color: {$maincolor};
    border-color: {$maincolor};
}

.message-bubble.me .message-text {
    color: {$maincolor};
    background-color: rgba({$maincolor_rgb},0.05);
}


.time-slot input ~ label:hover {
    background-color: rgba({$maincolor_rgb},0.08);   
}

.message-bubble.me .message-text:before {
    color: rgba({$maincolor_rgb},0.05);
}
.booking-widget i, .opening-hours i, .message-vendor i {
    color: {$maincolor};
}
.opening-hours.summary li:hover,
.opening-hours.summary li.total-costs span { color: {$maincolor}; }
.payment-tab-trigger > input:checked ~ label::before { border-color: {$maincolor}; }
.payment-tab-trigger > input:checked ~ label::after { background-color: {$maincolor}; }
#navigation.style-1 > ul > li.current-menu-ancestor > a,
#navigation.style-1 > ul > li.current-menu-item > a,
#navigation.style-1 > ul > li:hover > a { 
    background: rgba({$maincolor_rgb}, 0.06);
    color: {$maincolor};
}

.img-box:hover span {  background-color: {$maincolor}; }

body #navigation.style-1 ul ul li:hover a:after,
body #navigation.style-1 ul li:hover ul li:hover a,
body #navigation.style-1 ul li:hover ul li:hover li:hover a,
body #navigation.style-1 ul li:hover ul li:hover li:hover li:hover a,
body #navigation.style-1 ul ul li:hover ul li a:hover { color: {$maincolor}; }

.headline.headline-box span:before {
    background: {$maincolor};
}

.main-search-inner .highlighted-category {
    background-color:{$maincolor};
    box-shadow: 0 2px 8px rgba({$maincolor_rgb}, 0.2);
}

.category-box:hover .category-box-content span {
    background-color: {$maincolor};
}

.user-menu ul li a:hover {
    color: {$maincolor};
}

.icon-box-2 i {
    background-color: {$maincolor};
}

@keyframes iconBoxAnim {
    0%,100% {
        box-shadow: 0 0 0 9px rgba({$maincolor_rgb}, 0.08);
    }
    50% {
        box-shadow: 0 0 0 15px rgba({$maincolor_rgb}, 0.08);
    }
}
.listing-type:hover {
box-shadow: 0 3px 12px rgba(0,0,0,0.1);
background-color: {$maincolor};
}
.listing-type:hover .listing-type-icon {
color: {$maincolor};
}

.listing-type-icon {
background-color: {$maincolor};
box-shadow: 0 0 0 8px rgb({$maincolor_rgb}, 0.1);
}

#footer ul.menu li a:hover {
    color: {$maincolor};
}

#booking-date-range span::after, .time-slot label:hover span, .daterangepicker td.in-range, .time-slot input ~ label:hover, .booking-estimated-cost span, .time-slot label:hover span {
    color: {$maincolor};
}

.daterangepicker td.in-range {
    background-color: rgba({$maincolor_rgb}, 0.05);
    color: {$maincolor};
}

.transparent-header #header:not(.cloned) #navigation.style-1 > ul > li.current-menu-ancestor > a, 
.transparent-header #header:not(.cloned) #navigation.style-1 > ul > li.current-menu-item > a, 
.transparent-header #header:not(.cloned) #navigation.style-1 > ul > li:hover > a {
    background: {$maincolor};
}

.transparent-header #header:not(.cloned) .header-widget .button:hover,
.transparent-header #header:not(.cloned) .header-widget .button.border:hover {
    background: {$maincolor};
}

.transparent-header.user_not_logged_in #header:not(.cloned) .header-widget .sign-in:hover {
    background: {$maincolor};
}

.category-small-box-alt i,
.category-small-box i {
    color: {$maincolor};
}

.account-type input.account-type-radio:checked ~ label {
    background-color: {$maincolor};
}

.category-small-box:hover {
    box-shadow: 0 3px 12px rgba({$maincolor_rgb}, 0.22);
}


.transparent-header.user_not_logged_in #header.cloned .header-widget .sign-in:hover,
.user_not_logged_in .header-widget .sign-in:hover {
    background: {$maincolor};
}
.nav-links div.nav-next a:hover:before,
.nav-links div.nav-previous a:hover:before,
#posts-nav li.next-post a:hover:before,
#posts-nav li.prev-post a:hover:before { background: {$maincolor}; }

.slick-current .testimonial-author h4 span {
   background: rgba({$maincolor_rgb}, 0.06);
   color: {$maincolor};
}

body .icon-box-2 i {
   background-color: rgba({$maincolor_rgb}, 0.07);
   color: {$maincolor};
}

.headline.headline-box:after,
.headline.headline-box span:after {
background: {$maincolor};
}
.listing-item-content span.tag {
   background: {$maincolor};
}

.message-vendor div.wpcf7 .ajax-loader,
body .message-vendor input[type='submit'],
body .message-vendor input[type='submit']:focus,
body .message-vendor input[type='submit']:active {
  background-color: {$maincolor};
}   

.message-vendor .wpcf7-form .wpcf7-radio input[type=radio]:checked + span:before {
   border-color: {$maincolor};
}

.message-vendor .wpcf7-form .wpcf7-radio input[type=radio]:checked + span:after {
   background: {$maincolor};
}
#show-map-button,
.slider-selection {
background-color:{$maincolor};
}

.slider-handle {
border-color:{$maincolor};
}
.bookable-services .single-service:hover h5,
.bookable-services .single-service:hover .single-service-price {
    color: {$maincolor};
}
 
.bookable-services .single-service:hover .single-service-price {
    background-color: rgba({$maincolor_rgb}, 0.08);
    color: {$maincolor};
}
 
 
.bookable-services input[type='checkbox'] + label:hover {
    background-color: rgba({$maincolor_rgb}, 0.08);
    color: {$maincolor};
}
.services-counter,
.bookable-services input[type='checkbox']:checked + label {
    background-color: {$maincolor};
}
.bookable-services input[type='checkbox']:checked + label .single-service-price {
    color: {$maincolor};
}
";

if(get_option('listeo_home_banner_text_align')=='center'){
    $custom_css .= '.main-search-inner {
                    text-align: center;
                    }';
}
$opacity = get_option('listeo_search_bg_opacity',0.8);
$correct_opactity = str_replace(',', '.', $opacity);
$homecolor = get_option('listeo_search_color','#333333');
$homecolor_rgb = implode(",",sscanf($homecolor, "#%02x%02x%02x"));

$custom_css .= "

.main-search-container:before {
    background: linear-gradient(to right, rgba({$homecolor_rgb},0.99) 20%, rgba({$homecolor_rgb},0.7) 70%, rgba({$homecolor_rgb},0) 95%)
}

.solid-bg-home-banner .main-search-container:before,
body.transparent-header .main-search-container:before {
background: rgba({$homecolor_rgb},{$correct_opactity}) ;
}


.loader-ajax-container {
   box-shadow: 0 0 20px rgba( {$maincolor_rgb}, 0.4);
}


";

$custom_dark_css = '';
if(get_option('listeo_dark_mode')){

    $custom_dark_css.="
    body#dark-mode #navigation.style-1 > ul > li.current-menu-ancestor > a,
    body#dark-mode .category-small-box:hover,
    body#dark-mode #navigation.style-1 > ul > li.current-menu-ancestor > a, 
    body#dark-mode #navigation.style-1 > ul > li.current-menu-item > a,
    body#dark-mode #navigation.style-1 > ul > li:hover > a,
    body#dark-mode .slick-current .testimonial-author h4 span,
    body#dark-mode .layout-switcher a.active,
    body#dark-mode .time-slot input:checked ~ label,
    body#dark-mode .search-results .blog-post a.read-more, body#dark-mode .archive .blog-post a.read-more, body#dark-mode .blog-post a.read-more
    {
        background: {$maincolor};
    }

    body#dark-mode button.button.border, body#dark-mode a.button.border,
    body#dark-mode .category-small-box-alt:hover .category-box-counter-alt,
    body#dark-mode .icon-box-2 i,
    body#dark-mode .checkboxes input[type=checkbox]:checked + label:before,
    body#dark-mode #sign-in-dialog .mfp-close:hover,
    body#dark-mode .book-now-notloggedin,
    body#dark-mode .woocommerce-pagination ul li span.current, body#dark-mode .pagination ul li span.current, body#dark-mode .pagination .current, .pagination ul li a.current-page, body#dark-mode .pagination .current a, .pagination ul li a:hover, body#dark-mode .pagination-next-prev ul li a:hover,
    #titlebar.listing-titlebar span.listing-tag a, #titlebar.listing-titlebar span.listing-tag,
    body#dark-mode .listing-nav-container.cloned .listing-nav li:first-child a.active, body#dark-mode .listing-nav-container.cloned .listing-nav li:first-child a:hover, body#dark-mode .listing-nav li:first-child a, body#dark-mode .listing-nav li a.active, body#dark-mode .listing-nav li a:hover,
    body#dark-mode .show-more-button i,
    body#dark-mode .pricing-list-container h4,
    body#dark-mode .show-more-button,
    body#dark-mode #respond input[type='submit'],
    body#dark-mode #add-review input[type='submit'],
    body#dark-mode .time-slot label:hover,
    body#dark-mode #small-dialog .mfp-close:hover,
    body#dark-mode input[type='submit'],
    body#dark-mode .info-box,
    body#dark-mode .comment-by a.comment-reply-link:hover,
    body#dark-mode .account-type input.account-type-radio:checked ~ label,
    body#dark-mode .nav-links div.nav-next a:before, body#dark-mode .nav-links div.nav-previous a:before, body#dark-mode #posts-nav li.prev-post a:before, body#dark-mode #posts-nav li.next-post a:before,
    body#dark-mode.transparent-header.user_not_logged_in #header.cloned .header-widget .sign-in, 
    body#dark-mode.user_not_logged_in .header-widget .sign-in,
    body#dark-mode .header-widget .sign-in,
    body#dark-mode .messages-headline h4 span, .message-by-headline span,
    body#dark-mode .messages-inbox .message-by-headline span,
    body#dark-mode a.rate-review:hover,
    body#dark-mode a.rate-review,
    body#dark-mode .listing-type:hover,
    body#dark-mode input:checked + .slider,
    body#dark-mode .add-pricing-submenu.button, .add-pricing-list-item.button
    {
        background-color: {$maincolor};
    }

    body#dark-mode .bookable-services input[type='checkbox'] + label:hover,
    body#dark-mode .services-counter, .bookable-services input[type='checkbox']:checked + label,
    body#dark-mode .waiting-booking .inner-booking-list ul li.highlighted, body#dark-mode  .pending-booking .inner-booking-list ul li.highlighted {
        background-color:  {$maincolor} !important;
    } 

    body#dark-mode .checkboxes input[type=checkbox]:checked + label:before,
    #titlebar.listing-titlebar span.listing-tag a, #titlebar.listing-titlebar span.listing-tag,
    body#dark-mode .listing-nav-container.cloned .listing-nav li:first-child a.active, body#dark-mode .listing-nav-container.cloned .listing-nav li:first-child a:hover, body#dark-mode .listing-nav li:first-child a, body#dark-mode .listing-nav li a.active, .listing-nav li a:hover
    {
        border-color: {$maincolor};
    }
    body#dark-mode .listing-nav-container.cloned .listing-nav li:first-child a.active, body#dark-mode .listing-nav-container.cloned .listing-nav li:first-child a:hover, body#dark-mode .listing-nav li:first-child a, body#dark-mode .listing-nav li a.active, .listing-nav li a:hover,
    body#dark-mode .bookable-services input[type='checkbox']:checked + label .single-service-price {
        color: {$maincolor};
    }

    ";

}

$header_menu_margin_top = get_option('header_menu_margin_top',0);
$header_menu_margin_bottom = get_option('header_menu_margin_bottom',0);
$custom_css.="
@media (min-width: 1240px) { #header:not(.sticky) ul.menu, #header:not(.sticky) .header-widget { margin-top: {$header_menu_margin_top}px; margin-bottom: {$header_menu_margin_bottom}px; } }
";

if(get_option('listeo_disable_reviews')){ 
    $custom_css .= ' .infoBox .listing-title { display: none; }';
}

$radius_scale = get_option('listeo_radius_unit');
$custom_css.="
.range-output:after {
    content: '$radius_scale';
}";

$ordering = get_option( 'pp_shop_ordering' ); 
if($ordering == 'hide') {
     $custom_css .= '.woocommerce-ordering { display: none; }
    .woocommerce-result-count { display: none; }';
}


if(get_option('listeo_home_slider_background') == 'solid_color'){
    $background_color = get_option('listeo_home_slider_background_color','#fff1e3');
     $custom_css .= '.main-search-container.plain-color { background-color: '. $background_color .' } ';
}

if(get_option('listeo_home_slider_background') == 'svg'){
    $svg = get_option('listeo_home_slider_background_svg');
    if(empty($svg)){
        $svg = "background-color: #ffffff;
    background-image: url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100%25' height='100%25' viewBox='0 0 1600 800'%3E%3Cg %3E%3Cpath fill='%23fffaf5' d='M486 705.8c-109.3-21.8-223.4-32.2-335.3-19.4C99.5 692.1 49 703 0 719.8V800h843.8c-115.9-33.2-230.8-68.1-347.6-92.2C492.8 707.1 489.4 706.5 486 705.8z'/%3E%3Cpath fill='%23fff5ec' d='M1600 0H0v719.8c49-16.8 99.5-27.8 150.7-33.5c111.9-12.7 226-2.4 335.3 19.4c3.4 0.7 6.8 1.4 10.2 2c116.8 24 231.7 59 347.6 92.2H1600V0z'/%3E%3Cpath fill='%23ffefe2' d='M478.4 581c3.2 0.8 6.4 1.7 9.5 2.5c196.2 52.5 388.7 133.5 593.5 176.6c174.2 36.6 349.5 29.2 518.6-10.2V0H0v574.9c52.3-17.6 106.5-27.7 161.1-30.9C268.4 537.4 375.7 554.2 478.4 581z'/%3E%3Cpath fill='%23ffead9' d='M0 0v429.4c55.6-18.4 113.5-27.3 171.4-27.7c102.8-0.8 203.2 22.7 299.3 54.5c3 1 5.9 2 8.9 3c183.6 62 365.7 146.1 562.4 192.1c186.7 43.7 376.3 34.4 557.9-12.6V0H0z'/%3E%3Cpath fill='%23ffe5cf' d='M181.8 259.4c98.2 6 191.9 35.2 281.3 72.1c2.8 1.1 5.5 2.3 8.3 3.4c171 71.6 342.7 158.5 531.3 207.7c198.8 51.8 403.4 40.8 597.3-14.8V0H0v283.2C59 263.6 120.6 255.7 181.8 259.4z'/%3E%3Cpath fill='%23ffead9' d='M1600 0H0v136.3c62.3-20.9 127.7-27.5 192.2-19.2c93.6 12.1 180.5 47.7 263.3 89.6c2.6 1.3 5.1 2.6 7.7 3.9c158.4 81.1 319.7 170.9 500.3 223.2c210.5 61 430.8 49 636.6-16.6V0z'/%3E%3Cpath fill='%23ffefe2' d='M454.9 86.3C600.7 177 751.6 269.3 924.1 325c208.6 67.4 431.3 60.8 637.9-5.3c12.8-4.1 25.4-8.4 38.1-12.9V0H288.1c56 21.3 108.7 50.6 159.7 82C450.2 83.4 452.5 84.9 454.9 86.3z'/%3E%3Cpath fill='%23fff5ec' d='M1600 0H498c118.1 85.8 243.5 164.5 386.8 216.2c191.8 69.2 400 74.7 595 21.1c40.8-11.2 81.1-25.2 120.3-41.7V0z'/%3E%3Cpath fill='%23fffaf5' d='M1397.5 154.8c47.2-10.6 93.6-25.3 138.6-43.8c21.7-8.9 43-18.8 63.9-29.5V0H643.4c62.9 41.7 129.7 78.2 202.1 107.4C1020.4 178.1 1214.2 196.1 1397.5 154.8z'/%3E%3Cpath fill='%23ffffff' d='M1315.3 72.4c75.3-12.6 148.9-37.1 216.8-72.4h-723C966.8 71 1144.7 101 1315.3 72.4z'/%3E%3C/g%3E%3C/svg%3E\");
    background-attachment: fixed;
    background-size: cover;";
     
    }
    $custom_css .= '.main-search-container.plain-color { '.$svg.' } ';
}

wp_add_inline_style( 'listeo-style', $custom_css );

wp_add_inline_style( 'listeo-dark', $custom_dark_css );
}
add_action( 'wp_enqueue_scripts', 'listeo_custom_styles' );

function listeo_hex2RGB($hex) 
{
        preg_match("/^#{0,1}([0-9a-f]{1,6})$/i",$hex,$match);
        if(!isset($match[1]))
        {
            return false;
        }

        if(strlen($match[1]) == 6)
        {
            list($r, $g, $b) = array($hex[0].$hex[1],$hex[2].$hex[3],$hex[4].$hex[5]);
        }
        elseif(strlen($match[1]) == 3)
        {
            list($r, $g, $b) = array($hex[0].$hex[0],$hex[1].$hex[1],$hex[2].$hex[2]);
        }
        else if(strlen($match[1]) == 2)
        {
            list($r, $g, $b) = array($hex[0].$hex[1],$hex[0].$hex[1],$hex[0].$hex[1]);
        }
        else if(strlen($match[1]) == 1)
        {
            list($r, $g, $b) = array($hex.$hex,$hex.$hex,$hex.$hex);
        }
        else
        {
            return false;
        }

        $color = array();
        $color['r'] = hexdec($r);
        $color['g'] = hexdec($g);
        $color['b'] = hexdec($b);

        return $color;
}