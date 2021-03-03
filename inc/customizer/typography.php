<?php

/*section typography*/ 
listeo_Kirki::add_section( 'typography', array(
    'title'          => esc_html__( 'Typography', 'listeo'  ),
    'description'    => esc_html__( 'Fonts options', 'listeo'  ),
    'panel'          => '', // Not typically needed.
    'priority'       => 14,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );

	listeo_Kirki::add_field( 'listeo', array(
		'type'        => 'typography',
		'settings'    => 'pp_body_font',
		'label'       => esc_attr__( 'Body font', 'listeo' ),
		'section'     => 'typography',
		'default'     => array(
			'font-family'    => 'Raleway',
			'variant'        => 'regular',
			'font-size'      => '15px',
			'line-height'    => '27px',
			'letter-spacing' => '0',
			'subsets'        => array( 'latin-ext' ),
			'color'          => '#707070',
			'text-transform' => 'none',
			'text-align'     => 'left'
		),
		'priority'    => 10,
		'output'      => array(
			array(
				'element' => 'body',
			),
		),
	) );	

	listeo_Kirki::add_field( 'listeo', array(
		'type'        => 'typography',
		'settings'    => 'pp_logo_font',
		'label'       => esc_attr__( 'Text logo font', 'listeo' ),
		'section'     => 'typography',
		'default'     => array(
			'font-family'    => 'Raleway',
			'variant'        => 'regular',
			'color'          => '#666',
			'text-transform' => 'none',
			'font-size'      => '24px',
			'line-height'    => '27px',
			'text-align'     => 'left',
			'subsets'        => array( 'latin-ext' ),
			
		),
		'priority'    => 10,
		'output'      => array(
			array(
				'element' => '#logo h1 a,#logo h2 a',
			),
		),
	) );

	listeo_Kirki::add_field( 'listeo', array(
		'type'        => 'typography',
		'settings'    => 'pp_headers_font',
		'label'       => esc_attr__( 'h1..h6 font', 'listeo' ),
		'section'     => 'typography',
		'default'     => array(
			'font-family'    => 'Raleway',
			'variant'        => 'regular',
			'subsets'        => array( 'latin-ext' ),
			
		),
		'priority'    => 10,
		'output'      => array(
			array(
				'element' => 'h1,h2,h3,h4,h5,h6',
			),
		),
	) );

	listeo_Kirki::add_field( 'listeo', array(
		'type'        => 'typography',
		'settings'    => 'pp_menu_font',
		'label'       => esc_attr__( 'Menu font', 'listeo' ),
		'section'     => 'typography',
		'default'     => array(
			'font-family'    => 'Raleway',
			'variant'        => '400',
			'font-size'      => '16px',
			'line-height'    => '32px',
			'subsets'        => array( 'latin-ext' ),
			'color'          => '#444',
			'text-transform' => 'none',
			'text-align'     => 'left'
			
		),
		'priority'    => 10,
		'output'      => array(
			array(
				'element' => '#navigation ul > li > a',
			),
		),
	) );

	?>