<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WorkScout
 */

get_header(); ?>
<!-- Titlebar
================================================== -->
<div id="titlebar">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				
				<h1>
					<?php 
						if(is_shop()){
						 	the_archive_title(); 
						} else {
							the_title(); 
						}
					?>
				</h1>
	
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

	
$layout = get_option( 'pp_shop_layout', 'full-width' ); 
$class  = ($layout !="full-width") ? "col-md-8" : "col-md-12";
?>
<div class="container <?php echo esc_attr($layout); ?>">

	<div class="row">

		<article id="post-<?php the_ID(); ?>" <?php post_class($class); ?>>
		<?php woocommerce_content(); ?>
		</article>
	
		<?php if($layout !="full-width") { get_sidebar('shop'); } ?>
	</div>

</div>



<?php get_footer(); ?>
