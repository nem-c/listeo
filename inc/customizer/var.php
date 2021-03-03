<?php 

	listeo_Kirki::add_field( 'listeo', array(
	    'type'        => 'upload',
	    'settings'     => 'pp_logo_upload',
	    'label'       => esc_html__( 'Logo image', 'listeo' ),
	    'description' => esc_html__( 'Upload logo for your website', 'listeo' ),
	    'section'     => 'title_tagline',
	    'default'     => '',
	    'priority'    => 10,
	 /* 'transport'   => 'postMessage',
	    'js_vars'   => array(
			array(
				'element'  => '#logo img',
				'function' => 'html',
			
			),
		)*/
	) );		

	listeo_Kirki::add_field( 'listeo', array(
	    'type'        => 'upload',
	    'settings'     => 'pp_dashboard_logo_upload',
	    'label'       => esc_html__( 'Transparent Header / Dashboard logo image', 'listeo' ),
	    'description' => esc_html__( 'Upload logo for user dashboard', 'listeo' ),
	    'section'     => 'title_tagline',
	    'default'     => '',
	    'priority'    => 10,
	 /* 'transport'   => 'postMessage',
	    'js_vars'   => array(
			array(
				'element'  => '#logo img',
				'function' => 'html',
			
			),
		)*/
	) );		


	listeo_Kirki::add_field( 'listeo', array(
        'type'        => 'slider',
        'settings'    => 'large_logo_max_height',
        'label'       => esc_attr__( 'Logo Max Height (px)', 'listeo' ),
        'section'     => 'title_tagline',
        'priority'     => 11,
        'default'     => 43,
        'choices'     => array(
            'min'  => '30',
            'max'  => '500',
            'step' => '1',
        ),
        'output' => array(
            array(
                'element'  => '#logo img',
                'property' => 'max-height',
                'units'    => 'px',
            ),
        ),
    ) ); 
	listeo_Kirki::add_field( 'listeo', array(
        'type'        => 'slider',
        'settings'    => 'sticky_logo_width',
        'label'       => esc_attr__( 'Sticky Header Logo Width (px)', 'listeo' ),
        'section'     => 'title_tagline',
        'priority'     => 11,
        'default'     => 120,
        'choices'     => array(
            'min'  => '30',
            'max'  => '500',
            'step' => '1',
        ),
        'output' => array(
            array(
                'element'  => '#header.cloned #logo img',
                'property' => 'max-width',
                'units'    => 'px',
            ),
        ),
    ) ); 

	listeo_Kirki::add_field( 'listeo', array(
        'type'        => 'slider',
        'settings'    => 'header_menu_margin_top',
        'label'       => esc_attr__( 'Menu top margin (px)', 'listeo' ),
        'section'     => 'title_tagline',
        'priority'     => 11,
        'default'     => 0,
        'choices'     => array(
            'min'  => '0',
            'max'  => '200',
            'step' => '1',
        ),
    ) ); 
    listeo_Kirki::add_field( 'listeo', array(
        'type'        => 'slider',
        'settings'    => 'header_menu_margin_bottom',
        'label'       => esc_attr__( 'Menu bottom margin (px)', 'listeo' ),
        'section'     => 'title_tagline',
        'priority'     => 11,
        'default'     => 0,
        'choices'     => array(
            'min'  => '0',
            'max'  => '200',
            'step' => '1',
        ),
    ) );   

	listeo_Kirki::add_field( 'listeo', array(
	    'type'        => 'upload',
	    'settings'     => 'pp_sticky_logo_upload',
	    'label'       => esc_html__( 'Alternative header Sticky Logo image', 'listeo' ),
	    'description' => esc_html__( 'Upload logo used in sticky header', 'listeo' ),
	    'section'     => 'title_tagline',
	    'default'     => '',
	    'priority'    => 10,
	    
       
  
	) );	

	listeo_Kirki::add_field( 'listeo', array(
	    'type'        => 'color',
	    'settings'    => 'pp_main_color',
	    'label'       => esc_html__( 'Select main theme color', 'listeo' ),
	    'section'     => 'colors',
	    'default'     => '#f91942',
	    'priority'    => 10,
	) );

    listeo_Kirki::add_field( 'listeo', array(
        'type'        => 'radio',
        'settings'    => 'listeo_dark_mode',
        'label'       => esc_html__( 'Enable dark mode color', 'listeo' ),
        'section'     => 'colors',
        'choices'     => array(
            true  => esc_attr__( 'Enable', 'listeo' ),
            false => esc_attr__( 'Disable', 'listeo' ),
        ),
        'priority'    => 10,
         'default'     => 0,
    ) );
    listeo_Kirki::add_field( 'theme_config_id', [
        'type'        => 'custom',
        'settings'    => 'listeo_dark_mode_desc',
        // 'label'       => esc_html__( 'This is the label', 'kirki' ), // optional
        'section'     => 'colors',
        'default'         => 'You will need to change manually background color  of some sections on homepage in Elementor: <a href="https://www.docs.purethemes.net/listeo/knowledge-base/how-to-enable-dark-mode/">Read more &rarr;</a>',
        'priority'    => 10,
    ] );

?>