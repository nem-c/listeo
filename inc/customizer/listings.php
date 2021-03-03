<?php 


listeo_Kirki::add_section( 'listings_list', array(
	    'title'          => esc_html__( 'Listings List Options', 'listeo'  ),
	    'description'    => esc_html__( 'Archive page related options', 'listeo'  ),
	   // 'panel'          => 'listings_panel', // Not typically needed.
	    'priority'       => 12,
	    'capability'     => 'edit_theme_options',
	    'theme_supports' => '', // Rarely needed.
	) );

	listeo_Kirki::add_field( 'listeo', array(
	    'type'        => 'number',
	    'settings'    => 'listeo_listings_per_page',
	    'label'       => esc_html__( 'Listings per page', 'listeo' ),
	    'default'     => '10',
	    'section'     => 'listings_list',
	    'priority'    => 10,
	    'default'     => 10,
		'choices'     => array(
			'min'  => 0,
			'max'  => 150,
			'step' => 1,
		),
	) );

	listeo_Kirki::add_field( 'listeo', array(
	    'type'        => 'number',
	    'settings'    => 'listeo_author_listings_per_page',
	    'label'       => esc_html__( 'Author archive listings per page', 'listeo' ),
	    'default'     => '3',
	    'section'     => 'listings_list',
	    'priority'    => 10,
	    'default'     => 3,
		'choices'     => array(
			'min'  => 0,
			'max'  => 50,
			'step' => 1,
		),
	) );
	listeo_Kirki::add_field( 'listeo', array(
	    'type'        => 'text',
	    'settings'    => 'listeo_listings_archive_title',
	    'label'       => esc_html__( 'Listings archive title', 'listeo' ),
	    'default'     => 'Listings',
	    'section'     => 'listings_list',
	    'priority'    => 10,
	) );

	listeo_Kirki::add_field( 'listeo', array(
	    'type'        => 'text',
	    'settings'    => 'listeo_listings_archive_subtitle',
	    'label'       => esc_html__( 'Listings archive subtitle', 'listeo' ),
	    'default'     => 'Latest Listings',
	    'section'     => 'listings_list',
	    'priority'    => 10,
	) );

  	listeo_Kirki::add_field( 'listeo', array(
	    'type'        => 'radio',
	    'settings'    => 'listeo_rating_type',
	    'label'       => esc_html__( 'Choose rating display style on listings', 'listeo' ),
	    'description' => esc_html__( 'Stars or colored numbers', 'listeo' ),
	    'section'     => 'listings_list',
	    'default'     => 'stars',
	    'priority'    => 10,
	    'choices'     => array(
	       'stars' 		=> esc_attr__( 'Stars', 'listeo' ),
	       'numerical' 		=> esc_attr__( 'Numerical', 'listeo' ),
	      
 		),	
	));
	
	listeo_Kirki::add_field( 'listeo', array(
	    'type'        => 'select',
	    'settings'    => 'listeo_price_filter_icon',
	    'label'       => esc_html__( 'Choose Price filter tag icon', 'listeo' ),
	    'description' => esc_html__( 'Choose the icon for your currency', 'listeo' ),
	    'section'     => 'listings_list',
	    'default'     => 'tag',
	    'priority'    => 10,
	    'choices'     => array(
	       'tag' 		=> esc_attr__( 'Tag', 'listeo' ),
	       'dollar' 	=> esc_attr__( 'Dollar', 'listeo' ),
	       'euro' 		=> esc_attr__( 'Euro', 'listeo' ),
	       'gbp' 		=> esc_attr__( 'GBP', 'listeo' ),
	       'ruble' 		=> esc_attr__( 'Ruble', 'listeo' ),
	       'turkish-lira' 		=> esc_attr__( 'Turkish lira', 'listeo' ),
	       'rupee' 		=> esc_attr__( 'Rupee', 'listeo' ),
	       'won' 		=> esc_attr__( 'Won', 'listeo' ),
	       'shekel' 		=> esc_attr__( 'Shekel', 'listeo' ),
	       'krw' 		=> esc_attr__( 'KRW', 'listeo' ),


 		),	
	));

	listeo_Kirki::add_field( 'listeo', array(
	    'type'        => 'select',
	    'settings'    => 'listeo_marker_no_icon',
	    'label'       => esc_html__( 'Map listing marker style', 'listeo' ),
	    'description' => esc_html__( 'Choose the general marker style for all maps', 'listeo' ),
	    'section'     => 'listings_list',
	    'default'     => 'icon',
	    'priority'    => 10,
	    'choices'     => array(
	       'icon' 		=> esc_attr__( 'With Icons', 'listeo' ),
	       'no_icon' 		=> esc_attr__( 'No Icon', 'listeo' ),
	       
 		),	
	));
	listeo_Kirki::add_field( 'listeo', array(
	    'type'        => 'select',
	    'settings'    => 'pp_listings_top_layout',
	    'label'       => esc_html__( 'Listings archive general layout', 'listeo' ),
	    'description' => esc_html__( 'Choose the general archive  layout', 'listeo' ),
	    'section'     => 'listings_list',
	    'default'     => 'list_with_sidebar',
	    'priority'    => 10,
	    'choices'     => array(
	       'titlebar' 		=> esc_attr__( 'Standard titlebar', 'listeo' ),
	       'search' 		=> esc_attr__( 'Full width search form', 'listeo' ),
	       'map_searchform' => esc_attr__( 'Map with search form', 'listeo' ),
	       'map' 			=> esc_attr__( 'Map on top', 'listeo' ),
	       'half' 			=> esc_attr__( 'Split Map/Content', 'listeo' ),
	       'disable' 		=> esc_attr__( 'Disable titlebar', 'listeo' ),
 		),	
	));

	listeo_Kirki::add_field( 'listeo', array(
	    'type'        => 'select',
	    'settings'     => 'pp_listings_layout',
	    'label'       => esc_html__( 'Listings content layout', 'listeo' ),
	    'description' => esc_html__( 'Choose the general archive content  layout', 'listeo' ),
	    'section'     => 'listings_list',
	    'default'     => 'list',
	    'priority'    => 10,
	    'choices'     => array(
	       'list' 		=> esc_attr__( 'List', 'listeo' ),
	       'grid' 		=> esc_attr__( 'Grid', 'listeo' ),
	       'compact' 	=> esc_attr__( 'Grid alt layout', 'listeo' ),
 		),	
	));


	listeo_Kirki::add_field( 'listeo', array(
	    'type'        => 'radio-image',
	    'settings'    => 'pp_listings_sidebar_layout',
	    'label'       => esc_html__( 'Sidebar side', 'listeo' ),
	    'description' => esc_html__( 'Applies if the choosen layout has sidebar', 'listeo' ),
	    'section'     => 'listings_list',
	    'default'     => 'right-sidebar',
	    'priority'    => 10,
	    'choices'     => array(
	        'full-width' 	=> trailingslashit( trailingslashit( get_template_directory_uri() )) . '/images/full-width.png',
	        'left-sidebar' 	=> trailingslashit( trailingslashit( get_template_directory_uri() )) . '/images/left-sidebar.png',
	        'right-sidebar' => trailingslashit( trailingslashit( get_template_directory_uri() )) . '/images/right-sidebar.png',
	    ),	

	));	

	listeo_Kirki::add_field( 'listeo', array(
	    'type'        => 'radio-image',
	    'settings'    => 'listeo_listings_mobile_layout',
	    'label'       => esc_html__( 'Mobile Layout sidebar side', 'listeo' ),
	    'description' => esc_html__( 'Applies if the choosen layout has sidebar', 'listeo' ),
	    'section'     => 'listings_list',
	    'default'     => 'right-sidebar',
	    'priority'    => 10,
	    'choices'     => array(
	        'left-sidebar' 	=> trailingslashit( trailingslashit( get_template_directory_uri() )) . '/images/left-sidebar.png',
	        'right-sidebar' => trailingslashit( trailingslashit( get_template_directory_uri() )) . '/images/right-sidebar.png',
	    ),	
	    'active_callback'  => array(
            array(
                'setting'  => 'pp_listings_sidebar_layout',
                'operator' => '==',
                'value'    => 'right-sidebar',
            ),

        )

	));


	listeo_Kirki::add_field( 'listeo', array(
        'settings'    => 'listeo_listings_top_buttons',
        'label'		  => 'Top Buttons ',
        'description' => esc_html__( 'Show additional buttons before listings', 'listeo' ),
        'section'     => 'listings_list',
        'type'        => 'radio',
		'default'     => 'disable',
		'priority'    => 10,
		'choices'     => array(
			'enable'  => esc_attr__( 'Enable', 'listeo' ),
			'disable' => esc_attr__( 'Disable', 'listeo' ),
		),
		
    ) );  
    listeo_Kirki::add_field( 'listeo', array(
        'settings'    => 'listeo_listings_top_buttons_conf',
        'label'		  => 'Top Buttons  configuration',
        'description' => esc_html__( 'Function buttons configuration', 'listeo' ),
        'section'     => 'listings_list',
        'type'        => 'multicheck',
		'default'     => '',
		'priority'    => 10,
		'choices'     => array(
			'layout'  	=> esc_attr__( 'List/Grid (works only with Ajax)', 'listeo' ),
			'filters' 	=> esc_attr__( 'Features panel filter', 'listeo' ),
			'radius' 	=> esc_attr__( 'Radius slider', 'listeo' ),
			'order' 	=> esc_attr__( 'Orderby dropdown', 'listeo' ),
		),
		'active_callback'  => array(
            array(
                'setting'  => 'listeo_listings_top_buttons',
                'operator' => '==',
                'value'    => 'enable',
            ),
           
        
        )
	
    ) );  


	listeo_Kirki::add_section( 'listing_single', array(
	    'title'          => esc_html__( 'Single Listing Options', 'listeo'  ),
	    'description'    => esc_html__( 'Options for single listing layout', 'listeo'  ),
	   // 'panel'          => 'listings_panel', // Not typically needed.
	    'priority'       => 12,
	    'capability'     => 'edit_theme_options',
	    'theme_supports' => '', // Rarely needed.
	) );
	listeo_Kirki::add_field( 'listeo', array(
	   'type'        => 'radio-image',
	    //'type'        => 'radio',
	    'settings'    => 'listeo_single_layout',
	    'label'       => esc_html__( 'Sidebar side', 'listeo' ),
	    'description' => esc_html__( 'Applies if the choosen layout has sidebar', 'listeo' ),
	    'section'     => 'listing_single',
	    'default'     => 'right-sidebar',
	    'priority'    => 10,
	    'choices'     => array(
	        'left-sidebar' 	=> trailingslashit( trailingslashit( get_template_directory_uri() )) . '/images/left-sidebar.png',
	        'right-sidebar' => trailingslashit( trailingslashit( get_template_directory_uri() )) . '/images/right-sidebar.png',
	    ),	
	));	
	

	listeo_Kirki::add_field( 'listeo', array(
	    'type'        => 'radio-image',
	    'settings'    => 'listeo_single_mobile_layout',
	    'label'       => esc_html__( 'Mobile layout sidebar side', 'listeo' ),
	    'description' => esc_html__( 'Applies if the choosen layout has sidebar', 'listeo' ),
	    'section'     => 'listing_single',
	    'default'     => 'right-sidebar',
	    'priority'    => 10,
	    'choices'     => array(
	        'left-sidebar' 	=> trailingslashit( trailingslashit( get_template_directory_uri() )) . '/images/left-sidebar.png',
	        'right-sidebar' => trailingslashit( trailingslashit( get_template_directory_uri() )) . '/images/right-sidebar.png',
	    ),	
	    'active_callback'  => array(
            array(
                'setting'  => 'listeo_single_layout',
                'operator' => '==',
                'value'    => 'right-sidebar',
            ),

        )
	
	));
 ?>