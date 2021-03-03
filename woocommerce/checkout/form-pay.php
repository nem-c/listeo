<?php
/**
 * Pay for order form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-pay.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

$totals = $order->get_order_item_totals();
?>

<form id="order_review" class="listeo-pay-form" method="post">

	<table class="shop_table">
		<thead>
			<tr>
				<th class="product-name"><?php esc_html_e( 'Product', 'listeo' ); ?></th>
				<th class="product-quantity"><?php esc_html_e( 'Qty', 'listeo' ); ?></th>
				<th class="product-total"><?php esc_html_e( 'Totals', 'listeo' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php if ( count( $order->get_items() ) > 0 ) : ?>
				<?php foreach ( $order->get_items() as $item_id => $item ) : 
					
					$services = get_post_meta($order->get_id(),'listeo_services',true);
					?>
					<?php
					if ( ! apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
						continue;
					}
					?>
					<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_order_item_class', 'order_item', $item, $order ) ); ?>">
						<td class="product-name">
							<?php
								echo apply_filters( 'woocommerce_order_item_name', esc_html( $item->get_name() ), $item, false ); // @codingStandardsIgnoreLine

								do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order, false );

								wc_display_item_meta( $item );

								do_action( 'woocommerce_order_item_meta_end', $item_id, $item, $order, false );
								
							?>
							<?php 
							$booking_id = get_post_meta($order->get_id(),'booking_id',true);
							if($booking_id){
								$bookings = new Listeo_Core_Bookings_Calendar;
                   				$booking_data = $bookings->get_booking($booking_id);
								
								$listing_id = get_post_meta($order->get_id(),'listing_id',true);
								
								//get post type to show proper date
								$listing_type = get_post_meta($listing_id,'_listing_type', true);
								echo '<div class="inner-booking-list">';
								if($listing_type == 'rental') { ?>
									<h5><?php esc_html_e('Dates:', 'listeo'); ?></h5>
									<?php echo date_i18n(get_option( 'date_format' ), strtotime($booking_data['date_start'])); ?> - <?php echo date_i18n(get_option( 'date_format' ), strtotime($booking_data['date_end'])); ?></li>
								<?php } else if($listing_type == 'service') { ?>
										<h5><?php esc_html_e('Dates:', 'listeo'); ?></h5>
										<?php echo date_i18n(get_option( 'date_format' ), strtotime($booking_data['date_start'])); ?> 
										<?php esc_html_e('at','listeo'); ?> <?php echo date_i18n(get_option( 'time_format' ), strtotime($booking_data['date_start'])); ?> <?php if($booking_data['date_start'] != $booking_data['date_end']) echo  '- '.date_i18n(get_option( 'time_format' ), strtotime($booking_data['date_end'])); ?></li>
								<?php } else { //event
									
												$meta_value = get_post_meta($listing_id,'_event_date', true);
												$meta_value_date = explode(' ', $meta_value,2); 
												// if(!in_array($date_format,array('F j, Y','Y-m-d','m/d/Y','d/m/Y'))) {
												// 	$meta_value_date[0] = str_replace('/','-',$meta_value_date[0]);
												// }
												$date_format = get_option( 'date_format' );
											
												//$meta_value = date_i18n(get_option( 'date_format' ), strtotime($meta_value_date[0])); 
												$meta_value_stamp = DateTime::createFromFormat(listeo_date_time_wp_format_php(), $meta_value_date[0])->getTimestamp();
												
												$meta_value = date_i18n(get_option( 'date_format' ),$meta_value_stamp);
												
												//echo strtotime(end($meta_value_date));
												//echo date( get_option( 'time_format' ), strtotime(end($meta_value_date)));
												if( isset($meta_value_date[1]) ) { 
													$time = str_replace('-','',$meta_value_date[1]);
													$meta_value .= esc_html__(' at ','listeo'); 
													$meta_value .= date_i18n(get_option( 'time_format' ), strtotime($time));

												}
												echo $meta_value;

									 } ?>
								</div>
								<div class="inner-booking-list">
									<h5><?php esc_html_e('Extra Services:', 'listeo'); ?></h5>
									<?php echo listeo_get_extra_services_html($services); //echo wpautop( $details->service); ?>
								</div>	
								<?php
	                   				$details = json_decode($booking_data['comment']); 
	                   				if (
									 	(isset($details->childrens) && $details->childrens > 0)
									 	||
									 	(isset($details->adults) && $details->adults > 0)
									 	||
									 	(isset($details->tickets) && $details->tickets > 0)
									) { ?>			
									<div class="inner-booking-list">
										<h5><?php esc_html_e('Booking Details:', 'listeo'); ?></h5>
										<ul class="booking-list">
											<li class="highlighted" id="details">
											<?php if( isset($details->childrens) && $details->childrens > 0) : ?>
												<?php printf( _n( '%d Child', '%s Children', $details->childrens, 'listeo' ), $details->childrens ) ?>
											<?php endif; ?>
											<?php if( isset($details->adults)  && $details->adults > 0) : ?>
												<?php printf( _n( '%d Guest', '%s Guests', $details->adults, 'listeo' ), $details->adults ) ?>
											<?php endif; ?>
											<?php if( isset($details->tickets)  && $details->tickets > 0) : ?>
												<?php printf( _n( '%d Ticket', '%s Tickets', $details->tickets, 'listeo' ), $details->tickets ) ?>
											<?php endif; ?>
											</li>
										</ul>
									</div>	
									<?php } 



							}
							?>
						</td>
						<td class="product-quantity"><?php echo apply_filters( 'woocommerce_order_item_quantity_html', ' <strong class="product-quantity">' . sprintf( '&times; %s', esc_html( $item->get_quantity() ) ) . '</strong>', $item ); ?></td><?php // @codingStandardsIgnoreLine ?>
						<td class="product-subtotal"><?php echo wp_kses_post($order->get_formatted_line_subtotal( $item )); ?></td><?php // @codingStandardsIgnoreLine ?>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
		<tfoot>
			<?php if ( $totals ) : ?>
				<?php foreach ( $totals as $total ) : ?>
					<tr>
						<th scope="row" colspan="2"><?php echo wp_kses_post($total['label']); ?></th><?php // @codingStandardsIgnoreLine ?>
						<td class="product-total"><?php echo wp_kses_post($total['value']); ?></td><?php // @codingStandardsIgnoreLine ?>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tfoot>
	</table>

	<div id="payment">
		<?php if ( $order->needs_payment() ) : ?>
			<ul class="wc_payment_methods payment_methods methods">
				<?php
				if ( ! empty( $available_gateways ) ) {
					foreach ( $available_gateways as $gateway ) {
						wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );
					}
				} else {
					echo '<li class="woocommerce-notice woocommerce-notice--info woocommerce-info">' . apply_filters( 'woocommerce_no_available_payment_methods_message', esc_html__( 'Sorry, it seems that there are no available payment methods for your location. Please contact us if you require assistance or wish to make alternate arrangements.', 'listeo' ) ) . '</li>'; // @codingStandardsIgnoreLine
				}
				?>
			</ul>
		<?php endif; ?>
		<div class="form-row">
			<input type="hidden" name="woocommerce_pay" value="1" />

			<?php wc_get_template( 'checkout/terms.php' ); ?>

			<?php do_action( 'woocommerce_pay_order_before_submit' ); ?>

			<?php echo apply_filters( 'woocommerce_pay_order_button_html', '<button type="submit" class="button alt" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '">' . esc_html( $order_button_text ) . '</button>' ); // @codingStandardsIgnoreLine ?>

			<?php do_action( 'woocommerce_pay_order_after_submit' ); ?>

			<?php wp_nonce_field( 'woocommerce-pay', 'woocommerce-pay-nonce' ); ?>
		</div>
	</div>
</form>
