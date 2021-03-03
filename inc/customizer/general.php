<?php

listeo_Kirki::add_section( 'general', array(
    'title'          => esc_html__( 'General Options', 'listeo'  ),
    'description'    => esc_html__( 'General options', 'listeo'  ),
    'panel'          => '', // Not typically needed.
    'priority'       => 13,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );

 	
	listeo_Kirki::add_field( 'listeo', array(
		  'type'        => 'repeater',
		  'label'       => esc_attr__( 'Sidebar generator', 'listeo' ),
		  'section'     => 'general',
		  'priority'    => 10,
		  'settings'    => 'pp_listeo_sidebar',

		  'fields' => array(
		      'sidebar_name' => array(
		          'type'        => 'text',
		          'label'       => esc_attr__( 'Sidebar name', 'listeo' ),
		          'description' => esc_attr__( 'This will be name of sidebar', 'listeo' ),
		          'default'     => 'Sidebar name',
		      ),
		      'sidebar_id' => array(
		          'type'        => 'text',
		          'label'       => esc_attr__( 'Sidebar ID', 'listeo' ),
		          'description' => esc_attr__( 'Replace x with a number', 'listeo' ),
		          'default'     => 'sidebar_id_x',
		
		      ),
		  )
		) );
 ?>