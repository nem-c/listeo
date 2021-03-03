<?php 
/**
* 
*/
class ListeoMaps 
{
	
	protected $plugin_slug = 'listeo-map';

	function __construct() {

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'wp_print_scripts', array( $this, 'listeo_map_dequeue_script'), 100 );
	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		$map_provider = get_option( 'listeo_map_provider');
		if($map_provider == 'google') {
		wp_register_script( $this->plugin_slug . '-script',  get_template_directory_uri() . '/js/listeo.big.map.min.js', array( 'jquery','listeo-custom' ),'1.0', false );
		} else {
			wp_register_script( $this->plugin_slug . '-script',  get_template_directory_uri() . '/js/listeo.big.leaflet.min.js', array( 'jquery','listeo-custom' ),'1.0', false );
		}
	}

	public function show_map(){
		
		$height = '500';
			

	
		$query_args = array( 
			 	'post_type'              => 'listing',
        		'post_status'            => 'publish',
        		'posts_per_page'		 => -1,
			);

		
		$markers = array();
		// The Loop
		 $wp_query = new WP_Query( $query_args );
   		if ( $wp_query->have_posts() ):
			$i = 0;
			while( $wp_query->have_posts() ) : 
				$wp_query->the_post(); 
				
				$lat = $wp_query->post->_geolocation_lat;
				$id = $wp_query->post->ID;
					if (!empty($lat)) {
					    $icon = false;
						$title = get_the_title();
						$map_provider = get_option( 'listeo_map_provider');
		
						$ibcontet = '';
						ob_start(); ?><a href="<?php the_permalink(); ?>" class="<?php if($map_provider != 'google') { echo 'leaflet-';} ?>listing-img-container">
							<div class="infoBox-close"><i class="fa fa-times"></i></div>
							<?php
							if(has_post_thumbnail()){ 
								the_post_thumbnail('listeo-listing-grid'); 
							} else {
								$gallery = get_post_meta( $id, '_gallery', true );
								if(!empty($gallery)){
									$ids = array_keys($gallery);
									$image = wp_get_attachment_image_src( $ids[0], 'listeo-listing-grid' );	
									echo '<img src="'.esc_url($image[0]).'">';
								} else {
									echo '<img src="'.get_listeo_core_placeholder_image().'" >';
								}
								
							}?><div class="<?php if($map_provider != 'google') { echo 'leaflet-';} ?>listing-item-content">
				                  <h3><?php the_title(); ?></h3> 
				                  <span>
				                  	<?php 
										$friendly_address = get_post_meta( $id, '_friendly_address', true );
										$address = get_post_meta( $id, '_address', true );
										echo (!empty($friendly_address)) ? $friendly_address : $address ;
									?>													
									</span>
				              </div>
						</a><?php $rating = get_post_meta($id, 'listeo-avg-rating', true); ?>
							<div class="<?php if($map_provider != 'google') { echo 'leaflet-';} ?>listing-content">
								<div class="listing-title">
									<?php if(isset($rating) && $rating > 0 ) : ?>
						                <div class="star-rating" data-rating="<?php echo esc_attr($rating); ?>">
						                    <?php $number = get_comments_number($id);  ?>
						                    <div class="rating-counter">(<?php printf( _n( '%s review', '%s reviews', $number, 'listeo' ), number_format_i18n( $number ) );  ?>)</div>
						                </div>
						        <?php else: ?>
						                <div class="star-rating" >
						                    
						                    <div class="rating-counter"><span><?php esc_html_e('No reviews yet','listeo') ?></span></div>
						                </div>
						        <?php endif; ?>
								</div>
							</div><?php 
					$terms = get_the_terms( $id, 'listing_category' );
					
					if($terms ) {
						$term = array_pop($terms);	
						
						$t_id = $term->term_id;
						// retrieve the existing value(s) for this meta field. This returns an array
						$icon = get_term_meta($t_id,'icon',true);
						if($icon) {
							$icon = '<i class="'.$icon.'"></i>';	
						}	
					}
					if(isset($t_id)){
						$_icon_svg = get_term_meta($t_id,'_icon_svg',true);
						$_icon_svg_image = wp_get_attachment_image_src($_icon_svg,'medium');
					}
					if (isset($_icon_svg_image) && !empty($_icon_svg_image)) { 
				    	$icon = listeo_render_svg_icon($_icon_svg);
				        //$icon = '<img class="listeo-map-svg-icon" src="'.$_icon_svg_image[0].'"/>';

				    
				    } else { 

						if(empty($icon)){
							$icon = get_post_meta( $id, '_icon', true );
						}
					
						if(empty($icon)){
							$icon = '<i class="im im-icon-Map-Marker2"></i>';
						}
					}
					$ibcontet =  ob_get_clean();
					$ibdata = $ibcontet;

					$mappoint = array(
						'lat' =>  $lat,
						'lng' =>  $wp_query->post->_geolocation_long,
						'id' => $i,
						'ibcontent' => $ibdata,
						'icon' => $icon,
					);

					// check if such element exists in the array
				
				    $markers[] = $mappoint;
				    $i++;
				
				}

			 endwhile;
	    
	    endif; 
    	wp_reset_postdata();
		
		
		
		wp_enqueue_script( $this->plugin_slug . '-script' );
		wp_localize_script( $this->plugin_slug . '-script', 'listeo_big_map', $markers );
		wp_localize_script( $this->plugin_slug . '-script', 'listeo_big_map', $markers );
		ob_start();
		?>
		<div id="map" style="height:<?php echo esc_attr( $height ); ?>px;" ><!-- map goes here --></div>';
 		<?php 
		echo ob_get_clean();
		;
	}

	function listeo_map_dequeue_script() {
		if(is_page_template('template-home-search-map.php')){
		   wp_dequeue_script( 'listeo_core-leaflet' );
		}
	}


	private function find_matching_location($haystack, $needle) {

	    foreach ($haystack as $index => $a) {

	        if ($a['lat'] == $needle['lat']
	                && $a['lng'] == $needle['lng']
	              ) {
	            return $index;
	        }
	    }
	    return null;
	}

}
new ListeoMaps();
?>