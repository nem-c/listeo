<?php
/**
 * Template Name: Dashboard Page
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WPVoyager
 */

if ( !is_user_logged_in() ) { 
		
$errors = array();

if ( isset( $_REQUEST['login'] ) ) {
    $error_codes = explode( ',', $_REQUEST['login'] );
 
    foreach ( $error_codes as $code ) {
       switch ( $code ) {
	        case 'empty_username':
	            $errors[] = esc_html__( 'You do have an email address, right?', 'listeo' );
	   		break;
	        case 'empty_password':
	            $errors[] =  esc_html__( 'You need to enter a password to login.', 'listeo' );
	   		break;
	        case 'authentication_failed':
	        case 'invalid_username':
	            $errors[] =  esc_html__(
	                "We don't have any users with that email address. Maybe you used a different one when signing up?",
	                'listeo'
	            );
	   		break;
	        case 'incorrect_password':
	            $err = __(
	                "The password you entered wasn't quite right. <a href='%s'>Did you forget your password</a>?",
	                'listeo'
	            );
	            $errors[] =  sprintf( $err, wp_lostpassword_url() );
	 		break;
	        default:
	            break;
	    }
    }
} 
 // Retrieve possible errors from request parameters
if ( isset( $_REQUEST['register-errors'] ) ) {
    $error_codes = explode( ',', $_REQUEST['register-errors'] );
 
    foreach ( $error_codes as $error_code ) {
 		
         switch ( $error_code ) {
	        case 'email':
			     $errors[] = esc_html__( 'The email address you entered is not valid.', 'listeo' );
			   break;
			case 'email_exists':
			     $errors[] = esc_html__( 'An account exists with this email address.', 'listeo' );
			 	  break;
			case 'closed':
			     $errors[] = esc_html__( 'Registering new users is currently not allowed.', 'listeo' );
			     break;
	 		case 'captcha-no':
			     $errors[] = esc_html__( 'Please check reCAPTCHA checbox to register.', 'listeo' );
			     break;
			case 'captcha-fail':
			     $errors[] = esc_html__( "You're a bot, aren't you?.", 'listeo' );
			     break;
			case 'policy-fail':
			     $errors[] = esc_html__( "Please accept the Privacy Policy to register account.", 'listeo' );
			     break;
			case 'first_name':
			     $errors[] = esc_html__( "Please provide your first name", 'listeo' );
			     break;
			case 'last_name':
			     $errors[] = esc_html__( "Please provide your last name", 'listeo' );
			     break;
			case 'empty_user_login':
			     $errors[] = esc_html__( "Please provide your user login", 'listeo' );
			     break;
	 		case 'password-no':
			     $errors[] = esc_html__( "You have forgot about password.", 'listeo_core', 'listeo' );
			     break;
	        case 'incorrect_password':
	            $err = __(
	                "The password you entered wasn't quite right. <a href='%s'>Did you forget your password</a>?",
	                'listeo'
	            );
	            $errors[] =  sprintf( $err, wp_lostpassword_url() );
	   			break;
	        default:
	            break;
	    }
    }
} 
	get_header();

	$page_top = get_post_meta($post->ID, 'listeo_page_top', TRUE); 

	switch ($page_top) {
		case 'titlebar':
			get_template_part( 'template-parts/header','titlebar');
			break;		

		case 'parallax':
			get_template_part( 'template-parts/header','parallax');
			break;	

		case 'off':

			break;
		
		default:
			get_template_part( 'template-parts/header','titlebar');
			break;
	}

	$layout = get_post_meta($post->ID, 'listeo_page_layout', true); if(empty($layout)) { $layout = 'right-sidebar'; }
	$class  = ($layout !="full-width") ? "col-lg-9 col-md-8 padding-right-30" : "col-md-12"; ?>
	<div class="container <?php echo esc_attr($layout); ?>">

		<div class="row">

			<article id="post-<?php the_ID(); ?>" <?php post_class($class); ?>>
				<div class="col-lg-5 col-md-4 col-md-offset-3 sign-in-form style-1 margin-bottom-45">
					<?php if ( count( $errors ) > 0 ) : ?>
					    <?php foreach ( $errors  as $error ) : ?>
					        <div class="notification error closeable">
								<p><?php echo ($error); ?></p>
								<a class="close"></a>
							</div>
					    <?php endforeach; ?>
					<?php endif; ?>
					<?php if ( isset( $_REQUEST['registered'] ) ) : ?>
				    <div class="notification success closeable">
				    <p>
				        <?php
				        $password_field = get_option('listeo_display_password_field');
				        if($password_field) {
							printf(
				                esc_html__( 'You have successfully registered to %s.', 'listeo' ),
				                '<strong>'.get_bloginfo( 'name' ).'</strong>'
				            );
				        } else {
				        	printf(
				                esc_html__( 'You have successfully registered to <strong>%s</strong>. We have emailed your password to the email address you entered.', 'listeo' ),
				                '<strong>'.get_bloginfo( 'name' ).'</strong>'
				            );
				        }
				            
				        ?>
				    </p></div>
				<?php endif; ?>
					<?php  do_action('listeo_login_form');	 ?>
				</div>
				</article>
			
			<?php if($layout !="full-width") { ?>
				<div class="col-lg-3 col-md-4">
					<div class="sidebar right">
						<?php get_sidebar(); ?>
					</div>
				</div>
			<?php } ?>

		</div>

	</div>
	<div class="clearfix"></div> 
<?php
	get_footer(); 

} else { //is logged

get_header( 'dashboard' );
$current_user = wp_get_current_user();
$user_id = get_current_user_id();
$roles = $current_user->roles;
$role = array_shift( $roles ); 

?>

<!-- Dashboard -->
<div id="dashboard">
	
	<!-- Navigation
	================================================== -->

	<!-- Responsive Navigation Trigger -->
	<a href="#" class="dashboard-responsive-nav-trigger"><i class="fa fa-reorder"></i> <?php esc_html_e('Dashboard Navigation','listeo');?></a>

	<div class="dashboard-nav">
		<div class="dashboard-nav-inner">

			<ul data-submenu-title="<?php esc_html_e('Main','listeo');?>">
				
				<?php if(in_array($role,array('administrator','admin','owner'))) : ?>
					<?php $dashboard_page = get_option('listeo_dashboard_page');  if( $dashboard_page ) : ?>
					<li <?php if( $post->ID == $dashboard_page ) : ?>class="active" <?php endif; ?>><a href="<?php echo esc_url(get_permalink($dashboard_page)); ?>"><i class="sl sl-icon-settings"></i> <?php esc_html_e('Dashboard','listeo');?></a></li>
					<?php endif; ?>
				<?php endif; ?>

				<?php
				$user_bookings_page = get_option('listeo_user_bookings_page');  
				if(get_option('listeo_owners_can_book')) {
						 
						 if( $user_bookings_page ) : ?>
						<li <?php if( $post->ID == $user_bookings_page ) : ?>class="active" <?php endif; ?>><a href="<?php echo esc_url(get_permalink($user_bookings_page)); ?>"><i class="fa fa-calendar-check"></i> <?php esc_html_e('My Bookings','listeo');?></a></li>
					<?php endif; 
				} else {
					if(!in_array($role,array('owner'))) : ?>
						<?php if( $user_bookings_page ) : ?>
						<li <?php if( $post->ID == $user_bookings_page ) : ?>class="active" <?php endif; ?>><a href="<?php echo esc_url(get_permalink($user_bookings_page)); ?>"><i class="fa fa-calendar-check"></i> <?php esc_html_e('My Bookings','listeo');?></a></li>
					<?php endif; ?>
					<?php endif; 
				} ?>
				
				
				<?php $messages_page = get_option('listeo_messages_page');  if( $messages_page ) : ?>
				<li <?php if( $post->ID == $messages_page ) : ?>class="active" <?php endif; ?>><a href="<?php echo esc_url(get_permalink($messages_page)); ?>"><i class="sl sl-icon-envelope-open"></i> <?php esc_html_e('Messages','listeo');?> 
					<?php 
					$counter = listeo_get_unread_counter();
					if($counter) { ?>
					<span class="nav-tag messages"><?php echo esc_html($counter); ?></span>
					<?php } ?>
					</a>
				</li>
				<?php endif; ?>
				
				<?php if(in_array($role,array('administrator','admin','owner'))) : ?>
					<?php $bookings_page = get_option('listeo_bookings_page');  if( $bookings_page ) : ?>
					<li <?php if( $post->ID == $bookings_page ) : ?>class="active" <?php endif; ?>><a><i class="fa fa-calendar-check"></i> <?php esc_html_e('Bookings','listeo');?></a>
						<ul>
							<li>
								<a href="<?php echo esc_url(get_permalink($bookings_page)); ?>?status=waiting"><?php esc_html_e('Pending','listeo');?> 
									<?php 
									$count_pending = listeo_count_bookings($user_id,'waiting');  
									if(isset($count_pending)) : ?><span class="nav-tag blue"><?php echo esc_html($count_pending); ?></span><?php endif; ?>
								</a>
							</li>
							<li>
								<a href="<?php echo esc_url(get_permalink($bookings_page)); ?>?status=approved"><?php esc_html_e('Approved','listeo');?> 
									<?php 
									$count_approved = listeo_count_bookings($user_id,'approved');  
									if(isset($count_approved)) : ?><span class="nav-tag green"><?php echo esc_html($count_approved); ?></span><?php endif; ?>
								</a>
							</li>
							<li>
								<a href="<?php echo esc_url(get_permalink($bookings_page)); ?>?status=cancelled"><?php esc_html_e('Cancelled','listeo');?> 
								<?php 
									$count_cancelled = listeo_count_bookings($user_id,'cancelled');  
									if(isset($count_cancelled)) : ?><span class="nav-tag red"><?php echo esc_html($count_cancelled); ?></span><?php endif; ?>
								</a>
							</li>
							

						</ul>

					</li>
					<?php endif; ?>
				<?php endif; ?>
				<?php if(in_array($role,array('administrator','admin','owner'))) : ?>
					<?php $wallet_page = get_option('listeo_wallet_page');  if( $wallet_page ) : ?>
					<li <?php if( $post->ID == $wallet_page ) : ?>class="active" <?php endif; ?>><a href="<?php echo esc_url(get_permalink($wallet_page)); ?>"><i class="sl sl-icon-wallet"></i> <?php esc_html_e('Wallet','listeo');?></a>
					</li>
					<?php endif; ?>
				<?php endif; ?>
			</ul>
			
			<ul data-submenu-title="<?php esc_html_e('Listings','listeo');?>">
				<?php if(in_array($role,array('administrator','admin','owner'))) : ?>
					<?php $submit_page = get_option('listeo_submit_page');  if( $submit_page ) : ?>
					<li <?php if( $post->ID == $submit_page ) : ?>class="active" <?php endif; ?>><a href="<?php echo esc_url(get_permalink($submit_page)); ?>"><i class="sl sl-icon-plus"></i> <?php esc_html_e('Add Listing','listeo');?></a></li>
					<?php endif; ?>
					
					<?php $listings_page = get_option('listeo_listings_page');  
					if( $listings_page ) : ?>
					<li <?php if( $post->ID == $listings_page ) : ?>class="active" <?php endif; ?>><a><i class="sl sl-icon-layers"></i> <?php esc_html_e('My Listings','listeo'); ?></a>
						
						<ul>
							<li>
								<a href="<?php echo esc_url(get_permalink($listings_page)); ?>?status=active"><?php esc_html_e('Active','listeo');?> 
									<?php 
									$count_published =  listeo_count_posts_by_user($user_id,'listing','publish');  
									if(isset($count_published)) : ?><span class="nav-tag green"><?php echo esc_html($count_published); ?></span><?php endif; ?>
								</a>
							</li>
							<li>
								<a href="<?php echo esc_url(get_permalink($listings_page)); ?>?status=pending"><?php esc_html_e('Pending','listeo');?> 
								<?php
								$count_pending =  listeo_count_posts_by_user($user_id,'listing','pending');  
								$count_pending_payment =  listeo_count_posts_by_user($user_id,'listing','pending_payment');  
								$count_draft =  listeo_count_posts_by_user($user_id,'listing','draft');  
								$total_pending_count = $count_pending+$count_pending_payment+$count_draft;
								 if($total_pending_count) : ?><span class="nav-tag blue"><?php echo esc_html($total_pending_count); ?></span><?php endif; ?>
								</a>
							</li>
							<li>
								<a href="<?php echo esc_url(get_permalink($listings_page)); ?>?status=expired">
									<?php esc_html_e('Expired','listeo');?> 
									<?php 
									$count_expired =  listeo_count_posts_by_user($user_id,'listing','expired');  
									if($count_expired) : ?><span class="nav-tag red"><?php echo esc_html($count_expired) ?></span><?php endif; ?>
								</a>
							</li>

						</ul>	
					</li>
					<?php endif; ?>
				<?php endif; ?>
				<?php if(in_array($role,array('administrator','admin','owner'))) : ?>
				<?php $coupons_page = get_option('listeo_coupons_page');  if( $coupons_page ) : ?>
					<li <?php if( $post->ID == $coupons_page ) : ?>class="active" <?php endif; ?>><a href="<?php echo esc_url(get_permalink($coupons_page)); ?>"><i class="sl sl-icon-credit-card"></i> <?php esc_html_e('Coupons','listeo');?></a></li>
					<?php endif; ?>
				<?php endif; ?>
				<?php $reviews_page = get_option('listeo_reviews_page');  if( $reviews_page ) : ?>
				<li <?php if( $post->ID == $reviews_page ) : ?>class="active" <?php endif; ?>><a href="<?php echo esc_url(get_permalink($reviews_page)); ?>"><i class="sl sl-icon-star"></i> <?php esc_html_e('Reviews','listeo');?></a></li>
				<?php endif; ?>
				<?php if(!in_array($role,array('owner'))) : ?>
					<?php $bookmarks_page = get_option('listeo_bookmarks_page');  if( $bookmarks_page ) : ?>
					<li <?php if( $post->ID == $bookmarks_page ) : ?>class="active" <?php endif; ?>><a href="<?php echo esc_url(get_permalink($bookmarks_page)); ?>"><i class="sl sl-icon-heart"></i> <?php esc_html_e('Bookmarks','listeo');?></a></li>
					<?php endif; ?>
				<?php endif; ?>


			
				
			</ul>	

			<ul data-submenu-title="<?php esc_html_e('Account','listeo');?>">
				<?php $profile_page = get_option('listeo_profile_page');  if( $profile_page ) : ?>
				<li <?php if( $post->ID == $profile_page ) : ?>class="active" <?php endif; ?>><a href="<?php echo esc_url(get_permalink($profile_page)); ?>"><i class="sl sl-icon-user"></i> <?php esc_html_e('My Profile','listeo');?></a></li>
				<?php endif; ?>

		<?php if(in_array($role,array('administrator','admin','owner'))) : ?>
				<?php 

				$orders_page_status = get_option('listeo_orders_page');
				
				if( class_exists( 'woocommerce' ) && $orders_page_status ) : 
				
					$orders_page =  wc_get_endpoint_url('orders', '', get_permalink(get_option('woocommerce_myaccount_page_id')));
				?>
				<li <?php if( $post->ID == $orders_page ) : ?>class="active" <?php endif; ?>><a href="<?php echo esc_url($orders_page); ?>"><i class="sl sl-icon-basket"></i> <?php esc_html_e('My Orders','listeo');?></a></li>
				<?php endif; ?>


				<?php 
				$subscription_page_status = get_option('listeo_subscription_page');
				if( class_exists( 'WC_Subscriptions' ) && $subscription_page_status ) {
					$subscription_page =  wc_get_endpoint_url('subscriptions', '', get_permalink(get_option('woocommerce_myaccount_page_id')));
					
					if( $subscription_page ) : ?>
					<li <?php if( $post->ID == $subscription_page ) : ?>class="active" <?php endif; ?>><a href="<?php echo esc_url($subscription_page); ?>"><i class="sl sl-icon-refresh"></i> <?php esc_html_e('My Subscriptions','listeo');?></a></li>
					<?php endif; 
				} ?>
		<?php endif; ?>

				<li><a href="<?php echo wp_logout_url(home_url()); ?>"><i class="sl sl-icon-power"></i> <?php esc_html_e('Logout','listeo');?></a></li>
			</ul>
			
		</div>
	</div>
	<!-- Navigation / End -->

<!-- Content
	================================================== -->	
<?php 
	$current_user = wp_get_current_user();
	
	$roles = $current_user->roles;
	$role = array_shift( $roles ); 
	if(!empty($current_user->user_firstname)){
		$name = $current_user->user_firstname;
	} else {
		$name =  $current_user->display_name;
	} 
	?>
	<div class="dashboard-content" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<!-- Titlebar -->
<?php  

if(listeo_check_abandoned_cart()){ ?>

	<div class="notice notification" id="unpaid_listing_in_cart">
		<span><?php esc_html_e('You have unpaid listing in cart.','listeo') ?></span>
		<?php esc_html_e(' Please pay or cancel it before submitting new listing.','listeo') ?>
		<a class="" href="<?php echo wc_get_cart_url(); ?>"><strong><?php esc_html_e('View cart &#8594;','listeo') ?></strong></a>
	</div>
<?php }; ?>
				
		<div id="titlebar">
			<div class="row">
				<div class="col-md-12">
					<?php 
					$is_dashboard_page = get_option('listeo_dashboard_page'); 
					$is_booking_page = get_option('listeo_bookings_page');
					global $post;
					if( $is_dashboard_page == $post->ID ) { ?>
					<h2><?php esc_html_e('Howdy,','listeo'); ?> <?php echo esc_html($name); ?> !</h2>
					<?php } else if( $is_booking_page == $post->ID ) { 
						$status = '';
						if(isset($_GET['status'])){
							$status = $_GET['status'];
							switch ($status) {
								case 'approved': ?>
									<h1><?php esc_html_e('Approved Bookings','listeo'); ?></h1>
									<?php
									break;
								case 'waiting': ?>
									<h1><?php esc_html_e('Pending Bookings','listeo'); ?></h1>
									<?php
									break;
								case 'cancelled': ?>
									<h1><?php esc_html_e('Cancelled Bookings','listeo'); ?></h1>
									<?php
									break;
								
								default:
									 ?>
									<h1><?php esc_html_e('Bookings','listeo'); ?></h1>
									<?php
									break;
							}
						} else  { ?>
						<h1><?php the_title(); ?></h1>	
						<?php }
					} else { ?>
					<h1><?php the_title(); ?></h1>	
					<?php } ?>
					<!-- Breadcrumbs -->
					<nav id="breadcrumbs">
						<ul>
							<li><a href="<?php echo home_url(); ?>"><?php esc_html_e('Home','listeo'); ?></a></li>
							<li><?php esc_html_e('Dashboard','listeo'); ?></li>
						</ul>
					</nav>
				</div>
			</div>
		</div>
		<?php 

		while ( have_posts() ) : the_post();
			the_content();
		endwhile; // End of the loop. ?>
	
		<!-- Copyrights -->
		<div class="row">
			<div class="col-md-12">
				<div class="copyrights"> <?php $copyrights = get_option( 'pp_copyrights' , '&copy; Theme by Purethemes.net. All Rights Reserved.' ); 
			
			        echo wp_kses($copyrights,array( 'a' => array('href' => array(),'title' => array()),'br' => array(),'em' => array(),'strong' => array(),));
			         ?></div>
			</div>
		</div>
			
	</div>
</div>
<!-- Dashboard / End -->
<?php 
get_footer('empty'); 
} ?>