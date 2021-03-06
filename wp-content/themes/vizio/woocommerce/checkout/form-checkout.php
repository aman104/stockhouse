<?php
/**
 * Checkout Form
 *
 * actual version 2.1.0
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     5.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

wc_print_notices();

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'sp-theme' ) );
	return;
}
?>

<div class="signin-section row">
	<?php
	// check if user is not logged in
	if ( ! is_user_logged_in() ) {
	?>
		<div class="checkout-signin row">
			<div class="<?php echo esc_attr( sp_column_css( '', '', '', '6' ) ); ?>">
				<?php echo do_shortcode( '[sp-login custom_class="checkout-login" redirect_to="' . WC()->cart->get_checkout_url() . '" title="' . apply_filters( 'sp_woo_checkout_login_title_text', __( 'I already have an account', 'sp-theme' ) ) . '"]' ); ?>
			</div><!--close .column-->

			<div class="<?php echo esc_attr( sp_column_css( '', '', '', '6' ) ); ?>">
					<h3 class="title-with-line"><span><?php _e( 'I\'m New Here', 'sp-theme' ); ?></span></h3>
					<h3 class="msg"><?php echo apply_filters( 'sp_woo_checkout_guest_message', __( ' Please continue with guest checkout.', 'sp-theme' ) ); ?></h3><a href="#" class="goto-billing button"><?php _e( 'Continue', 'sp-theme' ); ?></a>
			</div><!--close .column-->
		</div><!--close .checkout-signin-->
	<?php
	} else {
	?>
		<h3 class="msg"><?php echo apply_filters( 'sp_woo_checkout_logged_in_message', __( ' Great!  You are already logged in.  Please continue your checkout process.', 'sp-theme' ) ); ?></h3><a href="#" class="goto-billing button"><?php _e( 'Continue', 'sp-theme' ); ?></a>
	<?php
	}	
	?>
</div><!--close .signin-section-->

<?php
// filter hook for include new pages inside the payment method
$get_checkout_url = apply_filters( 'woocommerce_get_checkout_url', WC()->cart->get_checkout_url() ); ?>

<form name="checkout" method="post" class="checkout" action="<?php echo esc_url( $get_checkout_url ); ?>">

	<?php if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>
		<div class="billing-form-section row">

			<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

			<div class="<?php echo sp_column_css( '', '', '', '6' ); ?>" id="customer_details">

			<?php do_action( 'woocommerce_checkout_billing' ); ?>

			</div><!--close .column-->


			<div class="<?php echo sp_column_css( '', '', '', '6' ); ?>">

			<?php do_action( 'woocommerce_checkout_shipping' ); ?>

			</div><!--close .column-->

			<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

		</div><!--close .billing-form-section-->

	<?php endif; ?>
	
	<div class="review-section row">
		<h3 id="order_review_heading" class="title-with-line"><span><?php _e( 'Your order', 'sp-theme' ); ?></span></h3>

		<?php do_action( 'woocommerce_checkout_order_review' ); ?>

	</div><!--close .review-section-->
</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>