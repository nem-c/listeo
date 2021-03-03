<?php
/**
 * Template Name: Comming Soon
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Listeo
 */


?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<!-- Wrapper -->
<div id="wrapper">


<!-- Content
================================================== -->
<?php 
$prefix = 'listeo_comming_soon_';
$background = get_post_meta($post->ID, $prefix . 'bg_image', true);
$title = get_post_meta($post->ID, $prefix . 'title', true);
$date = get_post_meta($post->ID, $prefix . 'signup_countdown_date', true);
$form_action = get_post_meta($post->ID, $prefix . 'signup_form_action', true);
$hidden_id = get_post_meta($post->ID, $prefix . 'signup_hidden_id', true);
$logo = get_option( 'pp_dashboard_logo_upload', '' ); 
?>
<!-- Coming Soon Page -->
<div class="coming-soon-page" style="background-image: url(<?php echo esc_url($background); ?>)">
	<div class="container">
		<!-- Search -->
		<div class="row">
			<div class="col-lg-8 col-lg-offset-2">
				<?php if($logo) { ?><img src="<?php echo esc_url($logo); ?>" alt="<?php get_bloginfo('name') ?>"><?php } ?>

				<h3><?php echo esc_html($title); ?></h3>
				
				<!-- Countdown -->
				<div id="countdown" data-countdown="<?php echo esc_attr($date); ?>" class="margin-top-10 margin-bottom-35"></div>
				<!-- Countdown / End -->

				<br>
				<div id="mc_embed_signup">
					<form action="<?php echo ($form_action); ?>" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
						<div class="main-search-input gray-style margin-top-30 margin-bottom-10">
							<div class="main-search-input-item">
								<input type="email" placeholder="<?php esc_html_e('Your email address','listeo') ?>" value="" name="EMAIL" class="required email" id="mce-EMAIL">
							</div>
							<button type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"><?php esc_html_e('Notify Me','listeo') ?></button>
								
						</div>
						<div id="mce-responses" class="clear">
							<div class="response" id="mce-error-response" style="display:none"></div>
							<div class="response" id="mce-success-response" style="display:none"></div>
						</div>
						
						<script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script>						
						<script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
							<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="<?php echo esc_attr($hidden_id); ?>" tabindex="-1" value=""></div>

	    						
					</form>
				</div>
			</div>
		</div>
		<!-- Search Section / End -->
	</div>
</div>
<!-- Coming Soon Page / End -->

</div>
<!-- Wrapper / End -->



<?php get_footer('empty'); ?>