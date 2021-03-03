<?php
/**
 * Template Name: Classic Home Page with Search Form
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WPVoyager
 */

get_header(); 
$video = get_option('listeo_search_video_mp4'); 
?>
<!-- Banner
================================================== -->


<!-- Banner
================================================== -->
<div class="main-search-container" data-background-image="<?php echo get_option( 'listeo_search_bg'); ?>">
	<div class="main-search-inner">

		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h2><?php echo get_option('listeo_home_title','Find Nearby Attractions'); ?></h2>
					<h4><?php echo get_option('listeo_home_subtitle', 'Expolore top-rated attractions, activities and more!'); ?></h4>
					
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
</div>


<?php while ( have_posts() ) : the_post(); ?>
	
	<!-- 960 Container -->
	<div class="container page-container home-page-container">
	    <article <?php post_class(); ?>>
	        <?php the_content(); ?>
	    </article>
	</div>

<?php endwhile; // end of the loop.

get_footer(); ?>