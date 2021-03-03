<?php
/**
 * Template Name: Home Page with Search Form & Slider
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Listeo
 */

get_header(); 

if(get_option('listeo_home_background_type')=='video'){
	$video = get_option('listeo_search_video_mp4'); 	
} else {
	$video = false;
}


$form_type = get_option('listeo_home_form_type','wide');


$background =  get_post_meta($post->ID, 'listeo_parallax_image', TRUE);
if(empty($background)) {
	$background =  get_option( 'listeo_search_bg');
}
?>

<div class="main-search-container plain-color main-search-container-with-slider <?php if(get_option('listeo_home_slider_headlines') == 'white') { echo 'white-text'; } ?>">
	<div class="main-search-inner">

		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="main-search-headlines">
					
					<h2><?php echo get_option('listeo_home_title','Find Nearby Attractions'); ?> <span class="typed-words"></span></h2>
					<h4><?php echo get_option('listeo_home_subtitle', 'Explore top-rated attractions, activities and more!'); ?></h4>
					</div>
					<?php echo do_shortcode('[listeo_search_form action='.get_post_type_archive_link( 'listing' ).' source="home" custom_class="main-search-form"]') ?>
					
					
				</div>
			</div>

			<?php
			if(get_option('listeo_home_featured_categories_status')=='enable') :
				$terms = get_theme_mod('listeo_home_featured_categories');
				
				if(!empty($terms)) : ?>
				<div class="row">
					<div class="col-md-12">
						<h5 class="highlighted-categories-headline"><?php esc_html_e('Or browse featured categories:','listeo') ?></h5>
						
							  
						<div class="highlighted-categories">
							
							<?php

							foreach ($terms as $key => $value) {
								$term = get_term($value,'listing_category');
								if( $term && ! is_wp_error( $term ) ) {
									$icon = get_term_meta($value,'icon',true); 
									$_icon_svg = get_term_meta($value,'_icon_svg',true);
									?>
									<!-- Box -->
									<a href="<?php echo get_term_link($term->slug, 'listing_category'); ?>" class="highlighted-category">
										<?php if (!empty($_icon_svg)) { ?>
										<i>
											<?php echo listeo_render_svg_icon($_icon_svg); ?>
										</i>
								    	<?php } else if($icon && $icon != 'empty')  : ?><i class="<?php echo esc_attr($icon); ?>"></i><?php endif; ?>
										<h4><?php echo esc_html($term->name) ?></h4>
									</a>	

							<?php }
							} ?>
					
						</div>
						
					</div>
				</div>
			<?php endif;
			endif; ?>

			
		</div>

	</div>

		<!-- Main Search Photo Slider -->
		<div class="container msps-container">
<?php
$slider = get_option( 'listeo_home_slider' ); 

if(!empty($slider)){ ?>


			<div class="main-search-photo-slider">
				<div class="msps-slider-container">
					<div class="msps-slider">
						<?php foreach ($slider as $value) {
						
							$image = wp_get_attachment_image_src( $value['image'],'full' ); ?>
							<div class="item"><img src="<?php echo $image[0]; ?>"class="item" title="Title 1"/></div>
						<?php } ?>
						
						
					</div>
				</div>
			</div>
<?php 			}
?>

			<div class="msps-shapes" id="scene">

				<div class="layer" data-depth="0.2">
					<svg height="40" width="40" class="shape-a">
						<circle cx="20" cy="20" r="17" stroke-width="4" fill="transparent" stroke="#C400FF" />
					</svg>
				</div>

				<div class="layer" data-depth="0.5">
					<svg width="90" height="90" viewBox="0 0 500 800" class="shape-b">
					<g transform="translate(281,319)">
					<path fill="transparent" style="transform:rotate(25deg)" stroke-width="35" stroke="#F56C83" fill  d="M260.162831,132.205081
					A18,18 0 0,1 262.574374,141.205081
					A18,18 0 0,1 244.574374,159.205081H-244.574374
					A18,18 0 0,1 -262.574374,141.205081
					A18,18 0 0,1 -260.162831,132.205081L-15.588457,-291.410162
					A18,18 0 0,1 0,-300.410162
					A18,18 0 0,1 15.588457,-291.410162Z"/></g></svg>
				</div>

				<div class="layer" data-depth="0.2" data-invert-x="false" data-invert-y="false" style="z-index: -10">
					<svg height="200" width="200" viewbox="0 0 250 250" class="shape-c">
					<path d="
					    M 0, 30
					    C 0, 23.400000000000002 23.400000000000002, 0 30, 0
					    S 60, 23.400000000000002 60, 30
					        36.599999999999994, 60 30, 60
					        0, 36.599999999999994 0, 30
					" fill="#FADB5F" transform="rotate(
					    -25,
					    100,
					    100
					) translate(
					    0
					    0
					) scale(3.5)"></path>
					</svg>
				</div>


				<div class="layer" data-depth="0.6" style="z-index: -10">
					<svg height="120" width="120" class="shape-d">
						<circle cx="60" cy="60" r="60" fill="#222" />
					</svg>
				</div>


				<div class="layer" data-depth="0.2">
					<svg height="70" width="70" viewBox="0 0 200 200"  class="shape-e">
						<path fill="#FF0066" d="M68.5,-24.5C75.5,-0.8,58.7,28.5,33.5,46.9C8.4,65.4,-25.2,73.1,-42.2,60.2C-59.2,47.4,-59.6,13.9,-49.8,-13.7C-40,-41.3,-20,-63.1,5.4,-64.8C30.7,-66.6,61.5,-48.3,68.5,-24.5Z" transform="translate(100 100)" />
					</svg>
				</div>

			</div>
		</div>
	
	</div>
</div>



<?php while ( have_posts() ) : the_post(); ?>
	
	<!-- 960 Container -->
	<div class="container page-container home-page-container">
	    <article <?php post_class(); ?>>
	        <?php the_content(); ?>
	    </article>
	</div>

<?php endwhile; // end of the loop.
?>



<script src="https://cdnjs.cloudflare.com/ajax/libs/parallax/2.1.3/parallax.min.js"></script>

<script>


/* ----------------- Start Document ----------------- */
(function($){
"use strict";

$(document).ready(function(){
	
		$(window).on('load', function() {
			$('.msps-shapes').addClass('shapes-animation')

		});
		const parent = document.getElementById('scene');
		const parallax = new Parallax(parent, {
		  limitX: 50,
		  limitY: 50,  
		});


		$('.msps-slider').slick({
			infinite: true,
			slidesToShow: 1,
			slidesToScroll: 1,
			dots: true,
			arrows: false,
			autoplay: true,
			autoplaySpeed: 5000,
			speed: 1000,
			fade: true,
			cssEase: 'linear'
		});
	
});

})(this.jQuery);

</script>
<?php get_footer(); ?>