<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package listeo
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">

<?php wp_head(); ?>
</head>

<body <?php if(get_option('listeo_dark_mode')){ echo 'id="dark-mode"';} ?> <?php body_class(); ?>>
<?php wp_body_open(); ?>
<!-- Wrapper -->
<div id="wrapper">
<?php do_action('listeo_after_wrapper'); ?>

<!-- Header Container
================================================== -->
<header id="header-container" class="fixed fullwidth">


	<!-- Header -->
	<div id="header">
		<div class="container">
			
			<!-- Left Side Content -->
			<div class="left-side" >
				<div id="logo">
					<?php 
		                $logo = get_option( 'pp_logo_upload', '' ); 
		                $logo_retina = get_option( 'pp_retina_logo_upload', '' ); 
		             	if($logo) {
		                    if(is_front_page()){ ?>
		                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home"><img src="<?php echo esc_url($logo); ?>" data-rjs="<?php echo esc_url($logo_retina); ?>" alt="<?php esc_attr(bloginfo('name')); ?>"/></a>
		                    <?php } else { ?>
		                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo esc_url($logo); ?>" data-rjs="<?php echo esc_url($logo_retina); ?>" alt="<?php esc_attr(bloginfo('name')); ?>"/></a>
		                    <?php }
		                } else {
		                    if(is_front_page()) { ?>
		                    <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		                    <?php } else { ?>
		                    <h2><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h2>
		                    <?php }
		                }
	                ?>
                </div>
              

				<!-- Mobile Navigation -->
				<div class="mmenu-trigger <?php if (wp_nav_menu( array( 'theme_location' => 'primary', 'echo' => false )) == false) { ?> hidden-burger <?php } ?>">
					<button class="hamburger hamburger--collapse" type="button">
						<span class="hamburger-box">
							<span class="hamburger-inner"></span>
						</span>
					</button>
				</div>


				<!-- Main Navigation -->
				<nav id="navigation" class="style-1">
					<?php wp_nav_menu( array( 
							'theme_location' => 'primary', 
							'menu_id' => 'responsive', 
							'container' => false,
							'walker' => new listeo_megamenu_walker
					) );  ?>
			
				</nav>
				<div class="clearfix"></div>
				<!-- Main Navigation / End -->
				
			</div>
			<!-- Left Side Content / End -->
			<?php 
			
			$my_account_display = get_option('listeo_my_account_display', true );
			$submit_display = get_option('listeo_submit_display', true );
			
			if($my_account_display != false || $submit_display != false ) :	?> 
			<!-- Right Side Content / End -->

			<div class="right-side">
				<div class="header-widget">
					<?php 
					if(class_exists('Listeo_Core_Template_Loader')):
						$template_loader = new Listeo_Core_Template_Loader;		
						$template_loader->get_template_part( 'account/logged_section' ); 
					endif;
					?>
				</div>
			</div>
			
			<!-- Right Side Content / End -->
			<?php endif; ?>
			
		</div>
	</div>
	<!-- Header / End -->

</header>
<?php 
if( true == $my_account_display) : ?>
<!-- Sign In Popup -->
<div id="sign-in-dialog" class="zoom-anim-dialog mfp-hide">

	<div class="small-dialog-header">
		<h3><?php esc_html_e('Sign In','listeo'); ?></h3>
	</div>
	<!--Tabs -->
	<div class="sign-in-form style-1"> 
		<?php  do_action('listeo_login_form'); ?>
	</div>
</div>
			<!-- Sign In Popup / End -->
<?php endif; ?>
<div class="clearfix"></div>
<!-- Header Container / End -->