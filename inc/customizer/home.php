<?php 


listeo_Kirki::add_panel( 'homes_panel', array(
    'priority'    => 21,
    'title'       => __( 'Home Search Options', 'listeo' ),
    'description' => __( 'Options for Home Page templates', 'listeo' ),
) );



listeo_Kirki::add_section( 'homepage', array(
    'title'          => esc_html__( 'General Home Search Template Options', 'listeo'  ),
    'description'    => esc_html__( 'Options for Page with Search form', 'listeo'  ),
    'priority'       => 11,
    'capability'     => 'edit_theme_options',
    'panel'     => 'homes_panel',
    'theme_supports' => '', // Rarely needed.
) );

listeo_Kirki::add_section( 'homepage_slider', array(
    'title'          => esc_html__( 'Home Search with Slider Template Options', 'listeo'  ),
    'description'    => esc_html__( 'Options for Page with Search form & Slider', 'listeo'  ),
    'priority'       => 11,
    'capability'     => 'edit_theme_options',
    'panel'     => 'homes_panel',
    'theme_supports' => '', // Rarely needed.
) );


		
		listeo_Kirki::add_field( 'listeo', array(
		    'type'        => 'radio',
		    'settings'     => 'listeo_home_transparent_header',
		    'label'       => esc_html__( 'Enable Transparent Header on Homepage', 'listeo' ),
		    'section'     => 'homepage',
		    'default'     => 'disable',
			'priority'    => 1,
			'choices'     => array(
				'enable'  => esc_attr__( 'Enable', 'listeo' ),
				'disable' => esc_attr__( 'Disable', 'listeo' ),
			),
		) );

		listeo_Kirki::add_field( 'listeo', array(
		    'type'        => 'radio',
		    'settings'     => 'listeo_home_form_type',
		    'label'       => esc_html__( 'Choose Search Form Style:', 'listeo' ),
		    'section'     => 'homepage',
		    'default'     => 'wide',
			'priority'    => 1,
			'choices'     => array(
				'wide'  => esc_attr__( 'Wide', 'listeo' ),
				'boxed' => esc_attr__( 'Boxed', 'listeo' ),
			),
		) );	

		listeo_Kirki::add_field( 'listeo', array(
		    'type'        => 'text',
		    'settings'     => 'listeo_home_title',
		    'label'       => esc_html__( 'Search Banner Title', 'listeo' ),
		    'description' => esc_html__( 'Title above search form ', 'listeo' ),
		    'section'     => 'homepage',
		    'default'     => esc_html__('Find Nearby Attractions','listeo') ,
		    'priority'    => 1,
		) );

		listeo_Kirki::add_field( 'listeo', array(
		    'type'        => 'radio',
		    'settings'     => 'listeo_home_full_screen',
		    'label'       => esc_html__( 'Full Screen Search Container', 'listeo' ),
		    'description'       => esc_html__( 'Works above 1360px viewport', 'listeo' ),
		    'section'     => 'homepage',
		    'default'     => 'disable',
			'priority'    => 1,
			'choices'     => array(
				'enable'  => esc_attr__( 'Enable', 'listeo' ),
				'disable' => esc_attr__( 'Disable', 'listeo' ),
			),
		) );

		listeo_Kirki::add_field( 'listeo', array(
		    'type'        => 'radio',
		    'settings'     => 'listeo_home_typed_status',
		    'label'       => esc_html__( 'Enable Typed words effect', 'listeo' ),
		    'section'     => 'homepage',
		    'default'     => 'disable',
			'priority'    => 1,
			'choices'     => array(
				'enable'  => esc_attr__( 'Enable', 'listeo' ),
				'disable' => esc_attr__( 'Disable', 'listeo' ),
			),
			'active_callback'  => array(
	            array(
	                'setting'  => 'listeo_home_form_type',
	                'operator' => '==',
	                'value'    => 'wide',
	            ),
	        )
		) );			

		listeo_Kirki::add_field( 'listeo', array(
		    'type'        => 'text',
		    'settings'     => 'listeo_home_typed_text',
		    'label'       => esc_html__( 'Text to display in "typed" Banner Subtitle', 'listeo' ),
		    'description' => esc_html__( 'Separate with coma', 'listeo' ),
		    'section'     => 'homepage',
		    'default'     => esc_html__('Attractions, Restaurants, Hotels','listeo') ,
		    'priority'    => 1,
		    'active_callback'  => array(
	            array(
	                'setting'  => 'listeo_home_typed_status',
	                'operator' => '==',
	                'value'    => 'enable',
	            ),
	            array(
	                'setting'  => 'listeo_home_form_type',
	                'operator' => '==',
	                'value'    => 'wide',
	            ),
	        )

		) );	

		
		listeo_Kirki::add_field( 'listeo', array(
		    'type'        => 'text',
		    'settings'     => 'listeo_home_subtitle',
		    'label'       => esc_html__( 'Search Banner Subtitle', 'listeo' ),
		    'description' => esc_html__( 'Subtitle above search form ', 'listeo' ),
		    'section'     => 'homepage',
		    'default'     => esc_html__('Expolore top-rated attractions, activities and more','listeo') ,
		    'priority'    => 1,
		) );	

		listeo_Kirki::add_field( 'listeo', array(
		    'type'        => 'radio',
		    'settings'     => 'listeo_home_banner_text_align',
		    'label'       => esc_html__( 'Text alignment on Search form', 'listeo' ),
		    'section'     => 'homepage',
		    'default'     => 'left',
			'priority'    => 1,
			'choices'     => array(
				'center'  => esc_attr__( 'Center', 'listeo' ),
				'left' => esc_attr__( 'Left', 'listeo' ),
			),
			'active_callback'  => array(
	            array(
	                'setting'  => 'listeo_home_form_type',
	                'operator' => '==',
	                'value'    => 'wide',
	            ),
	        )
		) );	
		listeo_Kirki::add_field( 'listeo', array(
		    'type'        => 'radio',
		    'settings'     => 'listeo_home_featured_categories_status',
		    'label'       => esc_html__( 'Enable "or browse by category" section', 'listeo' ),
		    'section'     => 'homepage',
		    'default'     => 'disable',
			'priority'    => 99,
			'choices'     => array(
				'enable'  => esc_attr__( 'Enable', 'listeo' ),
				'disable' => esc_attr__( 'Disable', 'listeo' ),
			),
			'active_callback'  => array(
	            array(
	                'setting'  => 'listeo_home_form_type',
	                'operator' => '==',
	                'value'    => 'wide',
	            ),
	        )
		) );


			
		listeo_Kirki::add_field( 'listeo', array(
		    'type'        => 'radio',
		    'settings'     => 'listeo_home_background_type',
		    'label'       => esc_html__( 'Choose Background Type for Form:', 'listeo' ),
		    'section'     => 'homepage',
		    'default'     => 'image',
			'priority'    => 1,
			'choices'     => array(
				'image'  => esc_attr__( 'Image', 'listeo' ),
				'video' => esc_attr__( 'Video', 'listeo' ),
			),
		) );	

		listeo_Kirki::add_field( 'listeo', array(
		    'type'        => 'image',
		    'settings'     => 'listeo_search_bg',
		    'label'       => esc_html__( 'Background for search banner on homepage', 'listeo' ),
		    'description' => esc_html__( 'Set image for search banner, should be 1920px wide', 'listeo' ),
		    'section'     => 'homepage',
		    'default'     => '',
		    'priority'    => 2,
		    'active_callback'  => array(
	            array(
	                'setting'  => 'listeo_home_background_type',
	                'operator' => '==',
	                'value'    => 'image',
	            ),
	        )
		) );

		listeo_Kirki::add_field( 'listeo', array(
		    'type'        => 'radio',
		    'settings'     => 'listeo_home_solid_background',
		    'label'       => esc_html__( 'Enable Solid Background', 'listeo' ),
		    'section'     => 'homepage',
		    'default'     => 'disable',
			'priority'    => 1,
			'choices'     => array(
				'enable'  => esc_attr__( 'Enable', 'listeo' ),
				'disable' => esc_attr__( 'Disable', 'listeo' ),
			),
			'active_callback'  => array(
	            array(
	                'setting'  => 'listeo_home_transparent_header',
	                'operator' => '==',
	                'value'    => 'disable',
	            ),
	        )
		) );	
		listeo_Kirki::add_field( 'listeo', array(
			'type'        => 'slider',
			'settings'    => 'listeo_search_bg_opacity',
			'label'       => esc_html__( 'Banner opacity', 'listeo' ),
			'section'     => 'homepage',
			'default'     => '0.8',
			'choices'     => array(
				'min'  => '0',
				'max'  => '1',
				'step' => '0.01',
			),
			'priority'    => 3,
		
		) ); 

		listeo_Kirki::add_field( 'listeo', array(
		    'type'        => 'color',
		    'settings'     => 'listeo_search_color',
		    'label'       => esc_html__( 'Color for the image overlay on homepage search banner', 'listeo' ),
		    'section'     => 'homepage',
		    'default'     => '#333333',
		    'priority'    => 4,
		     
		) );

		listeo_Kirki::add_field( 'listeo', array(
		    'type'        => 'image',
		    'settings'    => 'listeo_search_video_poster',
		    'label'       => esc_html__( 'Video Poster', 'listeo' ),
		    'section'     => 'homepage',
		    'default'     => false,
		    'priority'    => 5,
		     'active_callback'  => array(
	            array(
	                'setting'  => 'listeo_home_background_type',
	                'operator' => '==',
	                'value'    => 'video',
	            ),
	        )
		) );

		listeo_Kirki::add_field( 'listeo', array(
	    'type'        => 'upload',
	    'settings'    => 'listeo_search_video_webm',
	    'label'       => esc_html__( 'Upload webm file', 'listeo' ),
	    'section'     => 'homepage',
	    'default'     => false,
	    'priority'    => 6,
	     'active_callback'  => array(
	            array(
	                'setting'  => 'listeo_home_background_type',
	                'operator' => '==',
	                'value'    => 'video',
	            ),
	        )
	    
		) );
		listeo_Kirki::add_field( 'listeo', array(
		    'type'        => 'upload',
		    'settings'    => 'listeo_search_video_mp4',
		    'label'       => esc_html__( 'Upload mp4 file', 'listeo' ),
		    'section'     => 'homepage',
		    'default'     => false,
		    'priority'    => 7,
		    'active_callback'  => array(
	            array(
	                'setting'  => 'listeo_home_background_type',
	                'operator' => '==',
	                'value'    => 'video',
	            ),
	        )
		    
		) );
	

		listeo_Kirki::add_field( 'listeo', array(
				'type'        => 'custom',
				'settings'    => 'listeo_home_slider_general)explanation',
				// 'label'       => esc_html__( 'This is the label', 'kirki' ), // optional
			'section'  => 'homepage_slider',
					'default'         => 'This settings are only for specific options on page template Home Page with Search Form & Slider, but for headlines and featured categories configuration, please set it in section "General Home Search Template Options" ',
				'priority'    => 1,
				'active_callback'  => array(
					            array(
					                'setting'  => 'listeo_home_slider_background',
					                'operator' => '==',
					                'value'    => 'svg',
					            ),
					        )
			) );
		listeo_Kirki::add_field( 'listeo', [
				'type'        => 'repeater',
				'label'       => esc_html__( 'Home Page Slider Images', 'kirki' ),
				'section'     => 'homepage_slider',
				'priority'    => 1,
				'row_label' => [
					'type'  => 'field',
					'value' => esc_html__( 'Photo Slide', 'kirki' ),
					'field' => 'link_text',
				],
				'button_label' => esc_html__('Add new image', 'kirki' ),
				'settings'     => 'listeo_home_slider',
		
				'fields' => [
					'image' => [
						'type'        => 'image',
						'settings'    => 'slider_image_id',
						'label'       => esc_html__( 'Image', 'kirki' ),
						'choices'     => [
							'save_as' => 'id',
						],
					],
					
				]
			] );

			listeo_Kirki::add_field( 'listeo', array(
			    'type'        => 'radio',
			    'settings'     => 'listeo_home_slider_background',
			    'label'       => esc_html__( 'Background Options', 'listeo' ),
			    'section'     => 'homepage_slider',
			    'default'     => 'solid_color',
				'priority'    => 2,
				'choices'     => array(
					'solid_color'  => esc_attr__( 'Solid color', 'listeo' ),
					'svg' => esc_attr__( 'SVG Background', 'listeo' ),
				),
				// 'active_callback'  => array(
		  //           array(
		  //               'setting'  => 'listeo_home_transparent_header',
		  //               'operator' => '==',
		  //               'value'    => 'disable',
		  //           ),
		  //       )
			) );

			listeo_Kirki::add_field( 'listeo', array(
			    'type'        => 'color',
			    'settings'     => 'listeo_home_slider_background_color',
			    'label'       => esc_html__( 'Color for the banner background', 'listeo' ),
			    'section'     => 'homepage_slider',
			    'default'     => '#fff1e3',
			 'priority'    => 3,
			    'active_callback'  => array(
		            array(
		                'setting'  => 'listeo_home_slider_background',
		                'operator' => '==',
		                'value'    => 'solid_color',
		            ),
		        )
			     
			) );
			listeo_Kirki::add_field( 'listeo', array(
				'type'        => 'custom',
				'settings'    => 'listeo_home_slider_explanation',
				// 'label'       => esc_html__( 'This is the label', 'kirki' ), // optional
			'section'  => 'homepage_slider',
					'default'         => 'For custom SVG background you can simply copy a code from background creators like <a href="https://www.svgbackgrounds.com/#repeating-triangles">svgbackgrounds.com</a>. Don\'t forget to show attribution when required',
				'priority'    => 4,
				'active_callback'  => array(
					            array(
					                'setting'  => 'listeo_home_slider_background',
					                'operator' => '==',
					                'value'    => 'svg',
					            ),
					        )
			) );
			listeo_Kirki::add_field( 'listeo', array(
				'type'     => 'textarea',
				'settings' => 'listeo_home_slider_background_svg',
				'label'    => esc_html__( 'SVG background code ', 'kirki' ),
				'section'  => 'homepage_slider',
				'priority'    => 4,
				'default'  => "background-color: #ffffff;
	background-image: url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100%25' height='100%25' viewBox='0 0 1600 800'%3E%3Cg %3E%3Cpath fill='%23fffaf5' d='M486 705.8c-109.3-21.8-223.4-32.2-335.3-19.4C99.5 692.1 49 703 0 719.8V800h843.8c-115.9-33.2-230.8-68.1-347.6-92.2C492.8 707.1 489.4 706.5 486 705.8z'/%3E%3Cpath fill='%23fff5ec' d='M1600 0H0v719.8c49-16.8 99.5-27.8 150.7-33.5c111.9-12.7 226-2.4 335.3 19.4c3.4 0.7 6.8 1.4 10.2 2c116.8 24 231.7 59 347.6 92.2H1600V0z'/%3E%3Cpath fill='%23ffefe2' d='M478.4 581c3.2 0.8 6.4 1.7 9.5 2.5c196.2 52.5 388.7 133.5 593.5 176.6c174.2 36.6 349.5 29.2 518.6-10.2V0H0v574.9c52.3-17.6 106.5-27.7 161.1-30.9C268.4 537.4 375.7 554.2 478.4 581z'/%3E%3Cpath fill='%23ffead9' d='M0 0v429.4c55.6-18.4 113.5-27.3 171.4-27.7c102.8-0.8 203.2 22.7 299.3 54.5c3 1 5.9 2 8.9 3c183.6 62 365.7 146.1 562.4 192.1c186.7 43.7 376.3 34.4 557.9-12.6V0H0z'/%3E%3Cpath fill='%23ffe5cf' d='M181.8 259.4c98.2 6 191.9 35.2 281.3 72.1c2.8 1.1 5.5 2.3 8.3 3.4c171 71.6 342.7 158.5 531.3 207.7c198.8 51.8 403.4 40.8 597.3-14.8V0H0v283.2C59 263.6 120.6 255.7 181.8 259.4z'/%3E%3Cpath fill='%23ffead9' d='M1600 0H0v136.3c62.3-20.9 127.7-27.5 192.2-19.2c93.6 12.1 180.5 47.7 263.3 89.6c2.6 1.3 5.1 2.6 7.7 3.9c158.4 81.1 319.7 170.9 500.3 223.2c210.5 61 430.8 49 636.6-16.6V0z'/%3E%3Cpath fill='%23ffefe2' d='M454.9 86.3C600.7 177 751.6 269.3 924.1 325c208.6 67.4 431.3 60.8 637.9-5.3c12.8-4.1 25.4-8.4 38.1-12.9V0H288.1c56 21.3 108.7 50.6 159.7 82C450.2 83.4 452.5 84.9 454.9 86.3z'/%3E%3Cpath fill='%23fff5ec' d='M1600 0H498c118.1 85.8 243.5 164.5 386.8 216.2c191.8 69.2 400 74.7 595 21.1c40.8-11.2 81.1-25.2 120.3-41.7V0z'/%3E%3Cpath fill='%23fffaf5' d='M1397.5 154.8c47.2-10.6 93.6-25.3 138.6-43.8c21.7-8.9 43-18.8 63.9-29.5V0H643.4c62.9 41.7 129.7 78.2 202.1 107.4C1020.4 178.1 1214.2 196.1 1397.5 154.8z'/%3E%3Cpath fill='%23ffffff' d='M1315.3 72.4c75.3-12.6 148.9-37.1 216.8-72.4h-723C966.8 71 1144.7 101 1315.3 72.4z'/%3E%3C/g%3E%3C/svg%3E\");
	background-attachment: fixed;
	background-size: cover;",
				
				'active_callback'  => array(
		            array(
		                'setting'  => 'listeo_home_slider_background',
		                'operator' => '==',
		                'value'    => 'svg',
		            ),
		        )
			) );

			listeo_Kirki::add_field( 'listeo', array(
			    'type'        => 'radio',
			    'settings'     => 'listeo_home_slider_headlines',
			    'label'       => esc_html__( 'Headline text color', 'listeo' ),
			    'section'     => 'homepage_slider',
			    'default'     => 'dark',
				'priority'    => 5,
				'choices'     => array(
					'dark'  => esc_attr__( 'Dark', 'listeo' ),
					'white' => esc_attr__( 'White', 'listeo' ),
				),
				// 'active_callback'  => array(
		  //           array(
		  //               'setting'  => 'listeo_home_transparent_header',
		  //               'operator' => '==',
		  //               'value'    => 'disable',
		  //           ),
		  //       )
			) );


		// listeo_Kirki::add_field( 'listeo', array(
		//     'type'        => 'color',
		//     'settings'     => 'listeo_video_search_color',
		//     'label'       => esc_html__( 'Video overlay color and opacity', 'listeo' ),
		//     'section'     => 'homepage',
		//     'default'     => 'rgba(22,22,22,0.4)',
		//     'priority'    => 9,
		//     'choices'     => array(
		// 		'alpha' => true,
		// 	),
		// 	'active_callback'  => array(
	 //            array(
	 //                'setting'  => 'listeo_home_background_type',
	 //                'operator' => '==',
	 //                'value'    => 'video',
	 //            ),
	 //        )
		// ) );




add_action( 'customize_register', 'jt_load_customize_controls', 0 );
function jt_load_customize_controls() {

	
class Listeo_Customize_Control_Checkbox_Multiple extends WP_Customize_Control {

	/**
	 * The type of customize control being rendered.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $type = 'checkbox-multiple';

	/**
	 * Enqueue scripts/styles.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue() {
		wp_enqueue_script( 'jt-customize-controls', trailingslashit( get_template_directory_uri() ) . 'js/customize-controls.js', array( 'jquery' ) );
	}

	/**
	 * Displays the control content.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function render_content() {

		?>

		<?php if ( !empty( $this->label ) ) : ?>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		<?php endif; ?>

		<?php if ( !empty( $this->description ) ) : ?>
			<span class="description customize-control-description"><?php echo $this->description; ?></span>
		<?php endif; ?>

		<?php $multi_values = !is_array( $this->value() ) ? explode( ',', $this->value() ) : $this->value(); ?>

		<ul>
			<?php 
	 		$terms = get_terms('listing_category');
	 		
			foreach (  $terms as $term) : 
			
				?>
				<li>
					<label>
						<input type="checkbox" value="<?php echo esc_attr( $term->term_id ); ?>" <?php checked( in_array( $term->term_id, $multi_values ) ); ?> />
						<?php echo esc_html( $term->name ); ?>
					</label>
				</li>

			<?php endforeach; ?>
		</ul>

		<input type="hidden" <?php $this->link(); ?> value="<?php echo esc_attr( implode( ',', $multi_values ) ); ?>" />
	<?php }
}
}
add_action( 'customize_register', 'listeo_customizer_register' );

function listeo_customizer_register( $wp_customize ) {

	$wp_customize->add_setting(
		'listeo_home_featured_categories',
		array(
			'default'           => array(),
			'sanitize_callback' => 'listeo_sanitize_listeo_home_featured_categories'
		)
	);

	$wp_customize->add_control(
		new Listeo_Customize_Control_Checkbox_Multiple(
			$wp_customize,
			'listeo_home_featured_categories',
			array(
				'section' => 'homepage',
				'priority' => 100,
				'label'   => __( 'Featured Categories', 'listeo' ),
				'term' => 'listing_category'
			)
		)
	);
}
function listeo_sanitize_listeo_home_featured_categories( $values ) {

	$multi_values = !is_array( $values ) ? explode( ',', $values ) : $values;

	return !empty( $multi_values ) ? array_map( 'sanitize_text_field', $multi_values ) : array();
}
?>