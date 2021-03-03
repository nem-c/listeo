<?php
/**
 * Template Name: Listing With Map - Split Page
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Listeo
 */
get_header('split');?>
<div class="fs-container">

	<div class="fs-inner-container content">
		<div class="fs-content">

			<!-- Search -->

			<section class="search">
				<a href="#" id="show-map-button" class="show-map-button" data-enabled="<?php  esc_attr_e('Show Map ','listeo'); ?>" data-disabled="<?php  esc_attr_e('Hide Map ','listeo'); ?>"><?php esc_html_e('Show Map ','listeo') ?></a>
				<div class="row">
					<div class="col-md-12">
						<?php echo do_shortcode('[listeo_search_form source="half" more_custom_class="margin-bottom-30"]'); ?>
						
					</div>
				</div>

			</section>
			<!-- Search / End -->

			<section class="listings-container margin-top-30">
				

				<!-- Listings -->
				<div class="row fs-listings">
					<?php
						while ( have_posts() ) : the_post();?>
							<article id="post-<?php the_ID(); ?>" <?php post_class('col-md-12'); ?>>
								<?php the_content(); ?>
							</article>
					<?php endwhile;   ?>
					<div class="col-md-12">
						<div class="copyrights margin-top-0"><?php $copyrights = get_option( 'pp_copyrights' , '&copy; Theme by Purethemes.net. All Rights Reserved.' ); 
			
					        
					            echo wp_kses($copyrights,array( 'a' => array('href' => array(),'title' => array()),'br' => array(),'em' => array(),'strong' => array(),));
					         ?></div>
						</div>
					</div>
			</section>

		</div>
	</div>
	<div class="fs-inner-container map-fixed">

		<!-- Map -->
		<div id="map-container" class="">
		    <div id="map" class="split-map" data-map-zoom="<?php echo get_option('listeo_map_zoom_global',9); ?>" data-map-scroll="true">
		        <!-- map goes here -->
		    </div>
		   
		</div>
 		
	</div>
</div>

<div class="clearfix"></div>

<?php get_footer('empty'); ?>