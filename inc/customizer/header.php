<?php
global $wpdb;

$rev_sliders = array();
// Table name
$table_name = $wpdb->prefix . "revslider_sliders";

// Get sliders
if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
	$sliders = $wpdb->get_results( "SELECT alias, title FROM $table_name" );
} else {
	$sliders = '';
}
$rev_sliders[] = esc_html__("--Select slider--","listeo");
// Iterate over the sliders
if($sliders) {
	foreach($sliders as $key => $item) {
	  $rev_sliders[$item->alias] = $item->title;
	}
} else {
	$rev_sliders = array();
}


	listeo_Kirki::add_section( 'general_header', array(
		    'title'          => esc_html__( 'Header','listeo'  ),
		    'description'    => esc_html__( 'Header settings','listeo' ),
		    'priority'       => 10,
		    'capability'     => 'edit_theme_options',
		    'theme_supports' => '', // Rarely needed.
		) );

      

    listeo_Kirki::add_field( 'listeo', array(
        'settings'    => 'listeo_sticky_header',
        'label'		  => 'Sticky Header',
        'description' => esc_html__( 'Switching it to ON will globally enable sticky header for all pages', 'listeo' ),
        'section'     => 'general_header',
        'type'        => 'radio',
		'default'     => 0,
		'priority'    => 10,
		'choices'     => array(
			true  => esc_attr__( 'Enable', 'listeo' ),
			false => esc_attr__( 'Disable', 'listeo' ),
		),
    ) );    

    listeo_Kirki::add_field( 'listeo', array(
        'type'        => 'radio',
        'settings'    => 'listeo_my_account_display',
        'label'       => esc_html__( 'Display "My account" button in header', 'listeo' ),
        'section'     => 'general_header',
        'default'     => 0,
		'priority'    => 10,
		'choices'     => array(
			true  => esc_attr__( 'Enable', 'listeo' ),
			false => esc_attr__( 'Disable', 'listeo' ),
		),
    ) );    
    listeo_Kirki::add_field( 'listeo', array(
        'type'        => 'radio',
        'settings'    => 'listeo_submit_display',
        'label'       => esc_html__( 'Display "Add Listing" button in header', 'listeo' ),
        'section'     => 'general_header',
        'default'     => false,
		'priority'    => 10,
		'choices'     => array(
			true  => esc_attr__( 'Enable', 'listeo' ),
			false => esc_attr__( 'Disable', 'listeo' ),
		),
    ) );
  	listeo_Kirki::add_field( 'listeo', array(
        'type'        => 'radio',
        'settings'    => 'listeo_fw_header',
        'label'       => esc_html__( 'Full width header', 'listeo' ),
        'section'     => 'general_header',
        'default'     => false,
		'priority'    => 10,
		'choices'     => array(
			true  => esc_attr__( 'Enable', 'listeo' ),
			false => esc_attr__( 'Disable', 'listeo' ),
		),
    ) );


?>