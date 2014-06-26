<?php
/*
	Plugin Name: WooCommerce PayU Gateway
	Plugin URI: http://www.wpdesk.pl/sklep/payu-woocommerce/
	Description: Extends WooCommerce. Provides a <a href="http://payu.pl" target="_blank">PayU</a> gateway for WooCommerce.
	Version: 1.0
	Author: Inspire Labs
	Text Domain: woocommerce_payu
	Domain Path: /languages/
	Author URI: http://www.inspirelabs.pl/
	Requires at least: 3.5
	Tested up to: 3.5.2
*/

/**
 * Required functions
 */
if ( ! function_exists( 'woothemes_queue_update' ) )
	require_once( 'woo-includes/woo-functions.php' );

/**
 * Plugin updates
 */
//woothemes_queue_update( plugin_basename( __FILE__ ), 'a12d1b8e370f794b88e497c55bbb80ce', '18667' );

add_action('plugins_loaded', 'woocommerce_payu_init', 0);

function woocommerce_payu_init() {

	if ( ! class_exists( 'WC_Payment_Gateway' ) ) return;

    /**
     * Localisation
     */
    load_plugin_textdomain('woocommerce_payu', false, dirname( plugin_basename( __FILE__ ) ) . '/languages');

    require_once( plugin_basename( 'classes/payu.class.php' ) );

	/**
	 * woocommerce_payu_add function.
	 *
	 * @access public
	 * @param mixed $methods
	 * @return void
	 */
	function woocommerce_payu_add( $methods ) {
		$methods[] = 'WC_Gateway_Payu';
		return $methods;
	}

    add_filter( 'woocommerce_payment_gateways', 'woocommerce_payu_add' );
}
