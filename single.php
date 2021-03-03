<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Listeo
 */

get_header();

$layout = get_post_meta($post->ID, 'listeo_page_layout', true); if(empty($layout)) { $layout = 'right-sidebar'; }
$class  = ($layout !="full-width") ? "col-md-9 col-sm-7 extra-gutter-right" : "col-md-12"; ?>

<?php $titlebar_status = get_option('listeo_blog_titlebar_status','show');

if( $titlebar_status == 'show' ) : ?>
<!-- Titlebar
================================================== -->
<div id="titlebar" class="<?php echo esc_attr(get_option('listeo_blog_titlebar_style','gradient')); ?>">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				
				<h2><?php echo get_option('listeo_blog_title','Blog'); ?></h2>
				<span><?php echo get_option('listeo_blog_subtitle','Latest News'); ?></span>
	
				<!-- Breadcrumbs -->
				<?php if(function_exists('bcn_display')) { ?>
                    <nav id="breadcrumbs">
                        <ul>
                            <?php bcn_display_list(); ?>
                        </ul>
                    </nav>
                <?php } ?>

			</div>
		</div>
	</div>
</div>
<?php 
endif; 
$sidebar_side = get_option('pp_blog_layout'); 

?>
<!-- Content
================================================== -->
<div class="container <?php echo esc_attr($sidebar_side); if( $titlebar_status == 'hide' ) { echo ' margin-top-50'; } ?>">

	<!-- Blog Posts -->
	<div class="blog-page">
	<div class="row">


		<!-- Post Content -->
		<div class="col-lg-9 col-md-8 padding-right-30">

			<?php
			while ( have_posts() ) : the_post(); ?>

				<div class="blog-post single-post" id="post-<?php the_ID(); ?>">
					<?php get_template_part( 'template-parts/content', 'single' ); ?>
				</div>
			
				<?php

				the_post_navigation(array(
			        'prev_text'          => '<span>'.esc_html__('Previous Post','listeo').'</span> %title',
			        'next_text'          => '<span>'.esc_html__('Next Post','listeo').'</span> %title ',
			        'screen_reader_text' => esc_html__( 'Post navigation','listeo' ),
			    )); ?>
				<div class="margin-top-40"></div>
				<?php
				
				if(get_option('listeo_author_widget',true) ) {
					listeo_author_info_box();	
				}
				
				if(get_option('listeo_related_posts',true) ) {
					listeo_related_posts($post->ID); 
				}
				
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					
					comments_template();
				endif;

			endwhile; // End of the loop.
		
			?>

			<div class="margin-top-50"></div>

	</div>
	<!-- Content / End -->

	<?php if($layout !="full-width") { ?>
	<div class="col-lg-3 col-md-4">
		<div class="sidebar right">
				<?php get_sidebar(); ?>
			</div>
		</div>
	<?php } ?>

	</div>
	</div>
	
</div>
<?php get_footer();