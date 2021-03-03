<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package listeo
 */

get_header(); ?>
<!-- Titlebar
================================================== -->
<div id="titlebar">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="archive-description">', '</div>' );
				?>
	
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
<?php $sidebar_side = get_option('pp_blog_layout'); 
 ?>
<!-- Content
================================================== -->
<div class="container <?php echo esc_attr($sidebar_side); ?>">

	<!-- Blog Posts -->
	<div class="blog-page">
		<div class="row">
			<div class="col-lg-9 col-md-8 <?php  echo esc_attr(($sidebar_side == 'left-sidebar') ? 'padding-left-30' : 'padding-right-30' ); ?> col-blog">

			<?php
			if ( have_posts() ) :

				/* Start the Loop */
				while ( have_posts() ) : the_post();

					get_template_part( 'blog-parts/content', get_post_format() );

				endwhile;

				the_posts_navigation();

			else :

				get_template_part( 'template-parts/content', 'none' );

			endif; ?>

			
			</div>

			<!-- Widgets -->
			<div class="col-lg-3 col-md-4 col-sidebar">
				<div class="sidebar right">
					<?php get_sidebar(); ?>
				</div>
			</div>
			<!-- Sidebar / End -->
		</div>
	<!-- Sidebar / End -->

	</div>

</div>

<?php get_footer(); ?>