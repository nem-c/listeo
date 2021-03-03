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

listeo_Kirki::add_panel( 'blog_panel', array(
    'priority'    => 15,
    'title'       => esc_html__( 'Blog', 'listeo' ),
    'description' => esc_html__( 'Blog related settings', 'listeo' ),
) );

listeo_Kirki::add_section( 'blog', array(
	    'title'          => esc_html__( 'Blog Options', 'listeo'  ),
	    'description'    => esc_html__( 'Blog related options', 'listeo'  ),
	    'panel'          => 'blog_panel', // Not typically needed.
	    'priority'       => 30,
	    'capability'     => 'edit_theme_options',
	    'theme_supports' => '', // Rarely needed.
	) );



	listeo_Kirki::add_field( 'listeo', array(
	    'type'        => 'radio-image',
	    'settings'     => 'pp_blog_layout',
	    'label'       => esc_html__( 'Blog layout', 'listeo' ),
	    'description' => esc_html__( 'Choose the sidebar side for blog', 'listeo' ),
	    'section'     => 'blog',
	    'default'     => 'right-sidebar',
	    'priority'    => 10,
	    'choices'     => array(
	       // 'full-width' => trailingslashit( trailingslashit( get_template_directory_uri() )) . '/images/full-width.png',
	        'left-sidebar' => trailingslashit( trailingslashit( get_template_directory_uri() )) . '/images/left-sidebar.png',
	        'right-sidebar' => trailingslashit( trailingslashit( get_template_directory_uri() )) . '/images/right-sidebar.png',
	    ),	

	));
	
	listeo_Kirki::add_field( 'listeo', array(
	    'type'        => 'multicheck',
	    'settings'    => 'pp_meta_single',
	    'label'       => esc_html__( 'Post meta informations on single post', 'listeo' ),
	    'description' => esc_html__( 'Set which elements of posts meta data you want to display', 'listeo' ),
	    'section'     => 'blog',
	    'default'     => array('author'),
	    'priority'    => 10,
	    'choices'     => array(
	        'author' 	=> esc_html__( 'Author', 'listeo' ),
	        'date' 		=> esc_html__( 'Date', 'listeo' ),
	        'tags' 		=> esc_html__( 'Tags', 'listeo' ),
	        'cat' 		=> esc_html__( 'Categories', 'listeo' ),
	    ),
	) );
	
	listeo_Kirki::add_field( 'listeo', array(
	    'type'        => 'multicheck',
	    'settings'     => 'pp_post_share',
	    'label'       => esc_html__( 'Share buttons on single post', 'listeo' ),
	    'description' => esc_html__( 'Set which share buttons you want to display on single blog post', 'listeo' ),
	    'section'     => 'blog',
	    'default'     => array('author'),
	    'priority'    => 10,
	    'choices'     => array(
	        'facebook' 	=> esc_html__( 'Facebook', 'listeo' ),
	        'twitter' 		=> esc_html__( 'Twitter', 'listeo' ),
	        'google-plus' 		=> esc_html__( 'Google Plus', 'listeo' ),
	        'pinterest' 		=> esc_html__( 'Pinterest', 'listeo' ),
	    ),
	) );

	listeo_Kirki::add_field( 'listeo', array(
        'type'        => 'radio',
        'settings'    => 'listeo_author_widget',
        'label'       => esc_html__( 'Display "About Author" box below post.', 'listeo' ),
        'description'       => esc_html__( 'Author needs to have Bio field filled.', 'listeo' ),
        'section'     => 'blog',
        'default'     => 'enable',
		'priority'    => 10,
		'choices'     => array(
			'enable'  => esc_attr__( 'Enable', 'listeo' ),
			'disable' => esc_attr__( 'Disable', 'listeo' ),
		),
    ) );  
    listeo_Kirki::add_field( 'listeo', array(
        'type'        => 'radio',
        'settings'    => 'listeo_related_posts',
        'label'       => esc_html__( 'Display "Related posts" box below post', 'listeo' ),
        'section'     => 'blog',
        'default'     => 'enable',
		'priority'    => 10,
		'choices'     => array(
			'enable'  => esc_attr__( 'Enable', 'listeo' ),
			'disable' => esc_attr__( 'Disable', 'listeo' ),
		),
    ) );  

	listeo_Kirki::add_field( 'listeo', array(
	    'type'        => 'multicheck',
	    'settings'     => 'pp_blog_meta',
	    'label'       => esc_html__( 'Post meta informations on blog post', 'listeo' ),
	    'description' => esc_html__( 'Set which elements of posts meta data you want to display on blog and archive pages', 'listeo' ),
	    'section'     => 'blog',
	    'default'     => array('author'),
	    'priority'    => 10,
	    'choices'     => array(
	        'author' 	=> esc_html__( 'Author', 'listeo' ),
	        'date' 		=> esc_html__( 'Date', 'listeo' ),
	        'tags' 		=> esc_html__( 'Tags', 'listeo' ),
	        'cat' 		=> esc_html__( 'Categories', 'listeo' ),
	        'com' 		=> esc_html__( 'Comments', 'listeo' ),
	    ),
	) );


/*blog header*/


listeo_Kirki::add_section( 'blog_header', array(
	    'title'          => esc_html__( 'Blog Header', 'listeo' ),
	    'description'    => esc_html__( 'Header settings', 'listeo' ),
	    'panel'          => 'blog_panel', 
	    'priority'       => 160,
	    'capability'     => 'edit_theme_options',
	    'theme_supports' => '', // Rarely needed.
	) );
	listeo_Kirki::add_field( 'listeo', array(
        'type'        => 'radio',
        'settings'    => 'listeo_blog_titlebar_status',
        'label'       => esc_html__( 'Enable/Disable titlebar.', 'listeo' ),
        'section'     => 'blog_header',
        'default'     => 'show',
		'choices'     => array(
			'show'  => esc_attr__( 'Show titlebar', 'listeo' ),
			'hide' => esc_attr__( 'Hide titlebar', 'listeo' ),
		),
    ) );  
	listeo_Kirki::add_field( 'listeo', array(
	    'type'        => 'text',
	    'settings'    => 'listeo_blog_title',
	    'label'       => esc_html__( 'Blog page title', 'listeo' ),
	    'default'     => 'Blog',
	    'section'     => 'blog_header',
	    'priority'    => 10,
	) );

	listeo_Kirki::add_field( 'listeo', array(
	    'type'        => 'text',
	    'settings'    => 'listeo_blog_subtitle',
	    'label'       => esc_html__( 'Blog page subtitle', 'listeo' ),
	    'default'     => 'Latest News',
	    'section'     => 'blog_header',
	    'priority'    => 10,
	) );
listeo_Kirki::add_field( 'listeo', array(
        'type'        => 'radio',
        'settings'    => 'listeo_blog_titlebar_style',
        'label'       => esc_html__( 'Choose gradient or solid color.', 'listeo' ),
        'section'     => 'blog_header',
        'default'     => 'gradient',
		'priority'    => 10,
		'choices'     => array(
			'gradient'  => esc_attr__( 'Gradient', 'listeo' ),
			'solid' => esc_attr__( 'Solid', 'listeo' ),
		),
    ) );  



?>