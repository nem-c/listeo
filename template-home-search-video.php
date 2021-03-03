<?php
/**
 * Template Name: Home Page with Search Form over Video
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

$background =  get_post_meta($post->ID, 'listeo_parallax_image', TRUE);
if(empty($background)) {
	$background =  get_option( 'listeo_search_bg');
}
?>
<!-- Banner
================================================== -->



<!-- Banner
================================================== -->
<div class="main-search-container dark-overlay">
	<div class="main-search-inner">

		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h2><?php echo get_option('listeo_home_title','Find Nearby Attractions'); ?> <?php if(( is_page_template('template-home-search.php') || is_page_template('template-home-search-video.php') || is_page_template('template-home-search-splash.php')) && get_option('listeo_home_typed_status','enable') == 'enable') {  ?><span class="typed-words"></span><?php } ?></h2>
					<h4><?php echo get_option('listeo_home_subtitle', 'Expolore top-rated attractions, activities and more'); ?></h4>

					<?php echo do_shortcode('[listeo_search_form action='.get_post_type_archive_link( 'listing' ).' source="home" custom_class="main-search-form"]') ?>
				</div>
			</div>
		</div>

	</div>


	<?php if($video) { ?>
	<!-- Video -->
	<div class="video-container">
		<video poster="<?php echo get_option('listeo_search_video_poster'); ?>" loop autoplay muted>
			<source src="<?php echo get_option('listeo_search_video_mp4'); ?>" type="video/mp4">
			
		</video>
	</div>
	<?php } ?>

	
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