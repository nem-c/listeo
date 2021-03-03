<?php
/**
 * Login form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( is_user_logged_in() ) {
	return;
}

?>
<div class="col-lg-5 col-md-4 col-md-offset-3 sign-in-form style-1 margin-bottom-45">
<form class="woocommerce-form woocommerce-form-login login" method="post" <?php echo esc_attr(( $hidden ) ? 'style="display:none;"' : '') ; ?>>

	<?php do_action( 'woocommerce_login_form_start' ); ?>

	<?php echo ( $message ) ? wpautop( wptexturize( $message ) ) : ''; // @codingStandardsIgnoreLine ?>

	<p class="form-row form-row-wide">
		<label for="username">
			<i class="im im-icon-Male"></i>
			<input type="text" placeholder="<?php esc_html_e( 'Username or email', 'listeo_core' ); ?>" class="input-text" name="username" id="username" autocomplete="username" />
		</label>
	</p>
	<p class="form-row form-row-wide">
		<label for="password">
			<i class="im im-icon-Lock-2"></i>
			<input class="input-text" placeholder="<?php esc_html_e( 'Password', 'listeo_core' ); ?>" type="password" name="password" id="password" autocomplete="current-password" />
		</label>
	</p>
	<p class="lost_password">
		<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'listeo_core' ); ?></a>
	</p>
	<div class="clear"></div>

	<?php do_action( 'woocommerce_login_form' ); ?>

	<div class="form-row">
		<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
		<button type="submit" class="button" name="login" value="<?php esc_attr_e( 'Login', 'listeo_core' ); ?>"><?php esc_html_e( 'Login', 'listeo' ); ?></button>
		<div class="checkboxes margin-top-10">
			
		
		<input type="hidden" name="redirect" value="<?php echo esc_url( $redirect ) ?>" />
		<label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline">
			<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /><?php esc_html_e( 'Remember me', 'listeo_core' ); ?>
		</label>
		</div>
	</div>
	

	<div class="clear"></div>

	<?php do_action( 'woocommerce_login_form_end' ); ?>

</form>
</div>
