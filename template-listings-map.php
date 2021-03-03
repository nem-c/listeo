<?php
/**
 * Template Name: Listings With Map
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WPVoyager
 */

get_header(); 
?>

<!-- Map
================================================== -->
<div id="map-container" class="fullwidth-home-map margin-bottom-40">

    <div id="map" data-map-zoom="<?php echo get_option('listeo_map_zoom_global',9); ?>">
        <!-- map goes here -->
    </div>
    
    <div class="main-search-inner">

		<div class="container">
			<div class="row">
				<div class="col-md-12">
					
				<?php echo do_shortcode('[listeo_search_form action='.get_post_type_archive_link( 'listing' ).' source="home" custom_class="main-search-form"]') ?>
				</div>
			</div>
		</div>
	</div>
   	<a href="#" id="show-map-button" class="show-map-button" data-enabled="<?php  esc_attr_e('Show Map ','listeo'); ?>" data-disabled="<?php  esc_attr_e('Hide Map ','listeo'); ?>"><?php esc_html_e('Show Map ','listeo') ?></a>

</div>



<?php

while ( have_posts() ) : the_post();

$layout = get_post_meta($post->ID, 'listeo_page_layout', true); if(empty($layout)) { $layout = 'right-sidebar'; }
$class  = ($layout !="full-width") ? "col-md-8" : "col-md-12"; ?>

<div class="container <?php echo esc_attr($layout); ?>">

	<div class="row">

		<article id="post-<?php the_ID(); ?>" <?php post_class($class); ?>>
			<?php the_content(); ?>

			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'listeo' ),
					'after'  => '</div>',
				) );
			?>
 
			<?php
		        if(get_option('pp_pagecomments','on') == 'on') {
		        	
		            // If comments are open or we have at least one comment, load up the comment template
		            if ( comments_open() || get_comments_number() ) :
		                comments_template();
		            endif;
		        }
		    ?>

		</article>
		
		<?php if($layout !="full-width") { ?>
			<div class="col-md-4">
				<div class="sidebar right">
					<?php get_sidebar(); ?>
				</div>
			</div>
		<?php } ?>

	</div>

</div>
<div class="clearfix"></div>

<div class="margin-top-55"></div>
<?php endwhile; // End of the loop. ?>
<?php get_footer(); ?>