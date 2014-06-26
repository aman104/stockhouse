<?php
/**
 * SP FRAMEWORK FILE - DO NOT EDIT!
 * 
 * @package SP FRAMEWORK
 * if you want to add your own functions, create a file called user-functions.php inside your theme root folder and put your functions in there
 *
 * include all the functions
*/

if ( ! defined( 'ABSPATH' ) ) exit; // no direct access

/////////////////////////////////////////////////////
// checks for child theme and if user functions is found
/////////////////////////////////////////////////////

if ( is_child_theme() ) {
	if ( is_file( get_stylesheet_directory() . '/user-functions.php' ) ) {
		require_once( get_stylesheet_directory() . '/user-functions.php' );
	}
} else {
	if ( is_file( get_template_directory() . '/user-functions.php' ) ) {
		require_once( get_template_directory() . '/user-functions.php' );
	}	
}

/////////////////////////////////////////////////////
// load the framework
/////////////////////////////////////////////////////
require_once( get_template_directory() . '/sp-framework/sp-framework.php' );

/////////////////////////////////////////////////////
// load theme specific functions
/////////////////////////////////////////////////////
if ( is_file( get_template_directory() . '/theme-functions/theme-functions.php' ) ) {
	require_once( get_template_directory() . '/theme-functions/theme-functions.php' );
}

/////////////////////////////////////////////////////
// load theme specific woocommerce functions
/////////////////////////////////////////////////////
if ( is_file( get_template_directory() . '/theme-functions/theme-woo-functions.php' ) && sp_woo_exists() ) {
	require_once( get_template_directory() . '/theme-functions/theme-woo-functions.php' );
}

/////////////////////////////////////////////////////
// load user hooks
/////////////////////////////////////////////////////
if ( is_child_theme() ) {
	if ( is_file( get_stylesheet_directory() . '/user-hooks.php' ) ) {
		require_once( get_stylesheet_directory() . '/user-hooks.php' );
	}
} else {
	if ( is_file( get_template_directory() . '/user-hooks.php' ) ) {
		require_once( get_template_directory() . '/user-hooks.php' );
	}	
}

//custom hooks
//override woocommerce function
function woocommerce_template_single_price() {
    global $product;
    if ( ! $product->is_type('variable') ) { 
        woocommerce_get_template( 'single-product/price.php' );
    }
}
// Use WC 2.0 variable price format, now include sale price strikeout
add_filter( 'woocommerce_variable_sale_price_html', 'wc_wc20_variation_price_format', 10, 2 );
add_filter( 'woocommerce_variable_price_html', 'wc_wc20_variation_price_format', 10, 2 );
function wc_wc20_variation_price_format( $price, $product ) {
// Main Price
$prices = array( $product->get_variation_price( 'min', true ), $product->get_variation_price( 'max', true ) );
$price = $prices[0] !== $prices[1] ? sprintf( __( 'Pakiet: %1$s', 'woocommerce' ), wc_price( $prices[0] ) ) : wc_price( $prices[0] );
// Sale Price
$prices = array( $product->get_variation_regular_price( 'min', true ), $product->get_variation_regular_price( 'max', true ) );
sort( $prices );
$saleprice = $prices[0] !== $prices[1] ? sprintf( __( 'Pakiet: %1$s', 'woocommerce' ), wc_price( $prices[0] ) ) : wc_price( $prices[0] );
 
if ( $price !== $saleprice ) {
$price = '<del>' . $saleprice . '</del> <ins>' . $price . '</ins>';
}
return $price;
}
// Woocommerce New Customer Admin Notification Email
add_action('woocommerce_created_customer', 'admin_email_on_registration');
function admin_email_on_registration() {
    $user_id = get_current_user_id();
    wp_new_user_notification( $user_id );
}
function my_admin_users_registered_column_sortable( $columns ) {
    $custom = array(
        "column-user_registered" => "user_registered",
    );

    return wp_parse_args( $custom, $columns );
}
add_filter( "manage_users_sortable_columns", "my_admin_users_registered_column_sortable" );
//add additional columns to the users.php admin page
function modify_user_columns($column) {
	$column = array(
		"cb" => "<input type=\"checkbox\" />",
		"username" => "Username",
		"telefon" => "Telefon",//the new column
		"email" => "E-mail",
		"role" => "Role"
	);
    return $column;
}
add_filter('manage_users_columns','modify_user_columns');

//add content to your new custom column
function modify_user_column_content($val,$column_name,$user_id) {
    $user = get_userdata($user_id);
	switch ($column_name) {
        case 'telefon':
            return $user->billing_phone;
            break;
		//I have additional custom columns, hence the switch. But am only showing one here
        default:
    }
    return $return;
}
add_filter('manage_users_custom_column','modify_user_column_content',10,3);
//Adding Registration fields to the form 
