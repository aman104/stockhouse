<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/*
 * Execute actions and filters
 * Checks for standard configured actions and filters and attaches these actions and filters
 *
 */
global $wcpgsk_options;

add_filter( 'woocommerce_add_to_cart_validation', 'wcpgsk_maxitems_in_cart', 10, 3 );
add_filter( 'woocommerce_update_cart_validation', 'wcpgsk_minitems_in_cart', 1, 4 );
add_filter( 'woocommerce_is_sold_individually', 'wcpgsk_check_qty_config', 10, 2 );
add_filter( 'woocommerce_quantity_input_max', 'wcpgsk_qtyselector_max', 10, 2 );
add_filter( 'woocommerce_quantity_input_min', 'wcpgsk_qtyselector_min', 10, 2 );
add_filter( 'woocommerce_quantity_input_step', 'wcpgsk_quantity_input_step', 10, 2 );
add_filter( 'woocommerce_quantity_input_args', 'wcpgsk_qty_input_args', 10, 2 );
if ( function_exists('WC') ) :
	add_filter( 'woocommerce_product_single_add_to_cart_text', 'wcpgsk_product_single_cart_button_text', 10, 2 );
	add_filter( 'woocommerce_product_add_to_cart_text', 'wcpgsk_product_cart_button_text', 10, 2 );
else :
	add_filter( 'single_add_to_cart_text', 'wcpgsk_single_cart_button_text', 10, 2 );
	add_filter( 'variable_add_to_cart_text', 'wcpgsk_variable_cart_button_text', 10, 1 );
	add_filter( 'grouped_add_to_cart_text', 'wcpgsk_grouped_cart_button_text', 10, 1 );
	add_filter( 'external_add_to_cart_text', 'wcpgsk_external_cart_button_text', 10, 1 );
	add_filter( 'out_of_stock_add_to_cart_text', 'wcpgsk_outofstock_cart_button_text', 10, 1 );
	add_filter( 'add_to_cart_text', 'wcpgsk_cart_button_text', 10, 1 );
endif;
add_action( 'woocommerce_after_checkout_form','wcpgsk_after_checkout_form', 10, 1 );

add_action( 'woocommerce_after_cart_item_quantity_update', 'wcpgsk_after_cart_item_quantity_update', 10, 2 );
add_filter( 'woocommerce_add_cart_item', 'wcpgsk_add_cart_item', 10, 2 );
add_action( 'woocommerce_check_cart_items', 'wcpgsk_check_cart_items' );
add_filter( 'woocommerce_available_variation', 'wcpgsk_available_variation', 10, 3 );

//fix input quantity problem of woocommerce for variations as variations are configured via javasript overwriting all filters and actions by woocommerce, in fact a bug of woocommerce
function wcpgsk_available_variation($variation_data, $product, $variation) {
	$options = get_option( 'wcpgsk_settings' );
	$ival = apply_filters( 'woocommerce_quantity_input_min', '', $product );
	if ( empty($ival) || !is_numeric($ival) ) :
		$ival = 1;
	endif;
	$variation_data['min_qty'] = $ival;
	return $variation_data;
}

/* 
 * @changed 1.8.1 fix quantity input for grouped products
 * @TODO: actually the min/max/step configuration for grouped products is not effective
 */
function woocommerce_quantity_input( $args = array(), $product = null, $echo = true ) {
	if ( is_null( $product ) )
		$product = $GLOBALS['product'];
	$options = get_option( 'wcpgsk_settings' );
	$product_id = $product->post->ID;		
	$selectqty = get_post_meta($product_id, '_wcpgsk_selectqty', true);		
	$ival = apply_filters( 'woocommerce_quantity_input_min', '', $product );
	$mval = $ival;
	if ( !empty($args) && isset($args['input_name']) && strpos($args['input_name'], 'quantity[') !== false ) :
		$ival = 1;
		$mval = 0;
	elseif ( empty($ival) || !is_numeric($ival) ) :
		$ival = 1;
		$mval = 1;
	endif;
	$defaults = array(
		'input_name'  	=> 'quantity',
		'input_value'  	=> $ival,
		'max_value'  	=> apply_filters( 'woocommerce_quantity_input_max', '', $product ),
		'min_value'  	=> $mval,
		'step' 		=> apply_filters( 'woocommerce_quantity_input_step', '1', $product ),
		'style'		=> apply_filters( 'woocommerce_quantity_style', 'float:left; margin-right:10px;', $product )
	);
	if ( !empty($args) && isset($args['input_name']) && !empty($args['input_name']) ) :
		$defaults['input_name'] = $args['input_name'];
	endif;
	$args = apply_filters( 'woocommerce_quantity_input_args', wp_parse_args( $args, $defaults ), $product );
	
	if ( isset($options['cart']['minmaxstepproduct']) && $options['cart']['minmaxstepproduct'] == 1 && isset($selectqty) && $selectqty == 'yes' ) :
		$minqty = get_post_meta($product_id, '_wcpgsk_minqty', true);
		$maxqty = get_post_meta($product_id, '_wcpgsk_maxqty', true);
		$stepqty = get_post_meta($product_id, '_wcpgsk_stepqty', true);		

		if ( ! empty( $args['min_value'] ) )
			$min = $args['min_value'];
		else $min = $minqty > 0 ? $minqty : '';

		if ( ! empty( $args['max_value'] ) )
			$max = $args['max_value'];
		else $max = $maxqty > 0 ? $maxqty : '';

		if ( ! empty( $args['step'] ) )
			$step = $args['step'];
		else $step = $stepqty > 0 ? $stepqty : 1;
		if ( !empty( $min ) && is_numeric( $min) && !empty( $max ) && is_numeric( $max ) ) :
			$options = '';
			for ( $count = $min; $count <= $max; $count = $count+$step ) {
				$options .= '<option value="' . $count . '">' . $count . '</option>';
			}
			echo '<div class="quantity_select" style="' . $args['style'] . '"><select name="' . esc_attr( $args['input_name'] ) . '" title="' . _x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ) . '" class="qty">' . $options . '</select></div>';
		else :
			extract( $args, EXTR_OVERWRITE );
			?>
				<div class="quantity"><input type="number" step="<?php echo esc_attr( $step ); ?>" <?php if ( is_numeric( $min_value ) ) : ?>min="<?php echo esc_attr( $min_value ); ?>"<?php endif; ?> <?php if ( is_numeric( $max_value ) ) : ?>max="<?php echo esc_attr( $max_value ); ?>"<?php endif; ?> name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $input_value ); ?>" title="<?php _ex( 'Qty', 'Product quantity input tooltip', 'woocommerce' ) ?>" class="input-text qty text" size="4" /></div>
			<?php

		endif;
	else :
		extract( $args, EXTR_OVERWRITE );
		?>
			<div class="quantity"><input type="number" step="<?php echo esc_attr( $step ); ?>" <?php if ( is_numeric( $min_value ) ) : ?>min="<?php echo esc_attr( $min_value ); ?>"<?php endif; ?> <?php if ( is_numeric( $max_value ) ) : ?>max="<?php echo esc_attr( $max_value ); ?>"<?php endif; ?> name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $input_value ); ?>" title="<?php _ex( 'Qty', 'Product quantity input tooltip', 'woocommerce' ) ?>" class="input-text qty text" size="4" /></div>
		<?php
	endif;
}


function wcpgsk_check_cart_items() {
	global $woocommerce;
	$options = get_option( 'wcpgsk_settings' );
	if ( isset($options['cart']['minmaxstepproduct']) && $options['cart']['minmaxstepproduct'] == 1 ) :		
		foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values ) :
			$product_id = $values['product_id'];		
			//$variation_id = $values['variation_id'];
			//$product = get_product($product_id);
			$minqty = get_post_meta($product_id, '_wcpgsk_minqty', true);
			$maxqty = get_post_meta($product_id, '_wcpgsk_maxqty', true);
			$stepqty = get_post_meta($product_id, '_wcpgsk_stepqty', true);		
			$quantity = $values['quantity'];
			if ( $minqty > 0 && $quantity < $minqty ) :
				$woocommerce->cart->set_quantity( $cart_item_key, $minqty );
				wcpgsk_add_message( sprintf( __( 'You have to buy a minimum quantity. We have set the required minimum of %s as quantity for you.', WCPGSK_DOMAIN ), $minqty ) );
				wcpgsk_set_messages();		
			elseif ( $maxqty > 0 && $quantity > $maxqty ) :
				$woocommerce->cart->set_quantity( $cart_item_key, $maxqty );
				wcpgsk_add_message( sprintf( __( 'You cannot buy more than the allowed quantity for this product. We have set the maximum of %s as quantity for you.', WCPGSK_DOMAIN ), $maxqty ) );
				wcpgsk_set_messages();		
			elseif ( $stepqty > 0 && ( $quantity % $stepqty ) > 0 ) :
				$remainder = $quantity % $stepqty;
				$newqty = $quantity - $remainder;
				$woocommerce->cart->set_quantity( $cart_item_key, $newqty );
				wcpgsk_add_message( sprintf( __( 'You have to buy this product in multiples of %s. We have set the product quantity to the closest lower multiple available.', WCPGSK_DOMAIN ), $stepqty ) );
				wcpgsk_set_messages();					
			endif;
		endforeach;
	endif;
}
				
if ( !function_exists('wcpgsk_add_cart_item') ) {
function wcpgsk_add_cart_item( $cart_item_data, $cart_item_key ) {
	global $woocommerce;
	$options = get_option( 'wcpgsk_settings' );
	
	$product_id = $cart_item_data['product_id'];
	$variation_id = $cart_item_data['variation_id'];
	$product = get_product($product_id);
	$quantity = $cart_item_data['quantity'];
	
	$maxqty = isset($options['cart']['maxqty_' . $product->product_type]) ? $options['cart']['maxqty_' . $product->product_type] : 0;
	$minqty = isset($options['cart']['minqty_' . $product->product_type]) ? $options['cart']['minqty_' . $product->product_type] : 0;

	if ( isset($options['cart']['minmaxstepproduct']) && $options['cart']['minmaxstepproduct'] == 1 ) :
		$maxval = get_post_meta($product_id, '_wcpgsk_maxqty', true);
		if ( isset($maxval) && $maxval > 0 ) :
			$maxqty = $maxval;
		endif;
		$minval = get_post_meta($product_id, '_wcpgsk_minqty', true);
		if ( isset($minval) && $minval > 0 ) :
			$minqty = $minval;
		endif;
	endif;
	
	if ($minqty > 0 && $quantity < $minqty) :
		$cart_item_data['quantity'] = $minqty;
		wcpgsk_add_message( sprintf( __( 'You have to buy a minimum quantity. We have set the required minimum of %s as quantity for you.', WCPGSK_DOMAIN ), $minqty ) );
		wcpgsk_set_messages();		
	elseif ($maxqty > 0 && $quantity > $maxqty) :
		$cart_item_data['quantity'] = $maxqty;
		wcpgsk_add_message( sprintf(__( 'You cannot buy more than the allowed maximum quantity. We have set the allowed maximum of %s as quantity for you.', WCPGSK_DOMAIN ), $maxqty ) );
		wcpgsk_set_messages();
	endif;

	
	return $cart_item_data;
}
}
				
if ( !function_exists('wcpgsk_after_cart_item_quantity_update') ) {
function wcpgsk_after_cart_item_quantity_update( $cart_item_key, $quantity ) {
	global $woocommerce;
	$options = get_option( 'wcpgsk_settings' );
	$product_id = $woocommerce->cart->cart_contents[$cart_item_key]['product_id'];
	$variation_id = $woocommerce->cart->cart_contents[$cart_item_key]['variation_id'];
	$product = get_product($product_id);
	
	$maxqty = isset($options['cart']['maxqty_' . $product->product_type]) ? $options['cart']['maxqty_' . $product->product_type] : 0;
	$minqty = isset($options['cart']['minqty_' . $product->product_type]) ? $options['cart']['minqty_' . $product->product_type] : 0;
	if ( isset($options['cart']['minmaxstepproduct']) && $options['cart']['minmaxstepproduct'] == 1 ) :
		$product_id = $product->ID;		
		$maxval = get_post_meta($product_id, '_wcpgsk_maxqty', true);
		$minval = get_post_meta($product_id, '_wcpgsk_minqty', true);
		if ( isset($maxval) && $maxval > 0 ) :
			$maxqty = $maxval;
		endif;
		if ( isset($minval) && $minval > 0 ) :
			$minqty = $minval;
		endif;
	endif;
	
	
	if ($minqty > 0 && $quantity < $minqty) :
		$woocommerce->cart->cart_contents[$cart_item_key]['quantity'] = $minqty;
		wcpgsk_add_message( sprintf( __( 'You have to buy a minimum quantity. We have set the required minimum of %s as quantity for you.', WCPGSK_DOMAIN ), $minqty ) );
		wcpgsk_set_messages();
		
	elseif ($maxqty > 0 && $quantity > $maxqty) :
		$woocommerce->cart->cart_contents[$cart_item_key]['quantity'] = $maxqty;
		wcpgsk_add_message( sprintf(__( 'You cannot buy more than the allowed maximum quantity. We have set the allowed maximum of %s as quantity for you.', WCPGSK_DOMAIN ), $maxqty ) );
		wcpgsk_set_messages();
	endif;
}
}


if ( !function_exists('wcpgsk_maxitems_in_cart') ) {
function wcpgsk_maxitems_in_cart( $valid, $product_id, $quantity ) {
	global $woocommerce;
	$valid = true;
	$options = get_option( 'wcpgsk_settings' );
	
	$cartItems = sizeof( $woocommerce->cart->cart_contents );
	$allowed = isset($options['cart']['maxitemscart']) && $options['cart']['maxitemscart'] != 0 ? $options['cart']['maxitemscart'] : 0;
	
	//check cart items count and diminish if more than one variation for a product exists
	if ( $allowed > 0 && isset($options['cart']['variationscountasproduct']) && $options['cart']['variationscountasproduct'] == 0) {	
		$varproducts = array();
		foreach($woocommerce->cart->cart_contents as $i => $values) {
			$key = $values['product_id'];
			//@TODO: Check layout of the question and answer
			if (isset($values[$key]) && isset($values['variation_id']) && $values[$key] != $values['variation_id']) {
				if (isset($varproducts[$key])) $varproducts[$key] = 1;
				else $varproducts[$key] = 0;
			}
		}
		if (!empty($varproducts)) $cartItems = $cartItems - array_sum($varproducts);
	}
	
	if ( $allowed > 0 && $cartItems >= $allowed ) {
 		// Sets error message.
		wcpgsk_add_message( sprintf( __( 'You have reached the maximum amount of %s items allowed for your cart!', WCPGSK_DOMAIN ), $allowed ) );
		wcpgsk_set_messages();
		$valid = false;
		$cart_url = $woocommerce->cart->get_cart_url();
		wcpgsk_add_message( __('Remove products from the cart', WCPGSK_DOMAIN) . ': <a href="' . $cart_url . '">' . __('Cart', WCPGSK_DOMAIN) . '</a>');
		wcpgsk_set_messages();
	}
	return $valid;
}
}


if ( !function_exists('wcpgsk_minitems_in_cart') ) {
/**
* Validate product quantity on cart update.
*/
function wcpgsk_minitems_in_cart( $valid, $cart_item_key, $values, $quantity ) {
	global $woocommerce;
	$valid = true;
	$options = get_option( 'wcpgsk_settings' );

	//$cartItems = $woocommerce->cart->get_cart_contents_count(); //counts quantities as well and not only items
	$cartItems = sizeof( $woocommerce->cart->cart_contents );
	$allowed = isset($options['cart']['minitemscart']) && $options['cart']['minitemscart'] != 0 ? $options['cart']['minitemscart'] : 0;
	
	//check cart items count and diminish if more than one variation for a product exists
	if ($allowed > 1 && isset($options['cart']['variationscountasproduct']) && $options['cart']['variationscountasproduct'] == 0) {	
		$varproducts = array();
		foreach($woocommerce->cart->cart_contents as $i => $values) {
			$key = $values['product_id'];
			//@TODO: Check layout of the question and answer			
			if (isset($values[$key]) && isset($values['variation_id']) && $values[$key] != $values['variation_id']) {
				if (isset($varproducts[$key])) $varproducts[$key] = 1;
				else $varproducts[$key] = 0;
			}
		}
		if (!empty($varproducts)) $cartItems = $cartItems - array_sum($varproducts);
	}
	
	if ($allowed > 1 && $allowed > $cartItems ) {
 		// Sets error message.
		wcpgsk_add_message( sprintf( __( 'You still have not reached the minimum amount of %s items required for your cart!', WCPGSK_DOMAIN ), $allowed ) );
		wcpgsk_set_messages();
		$valid = false;
		
		$shop_page_id = woocommerce_get_page_id( 'shop' );
		//$shop_page_url = get_permalink(icl_object_id($shop_page_id, 'page', false));
		$shop_page_url = get_permalink($shop_page_id);
		wcpgsk_add_message( __('Select more products from the shop', WCPGSK_DOMAIN) . ': <a href="' . $shop_page_url . '">' . __('Shop', WCPGSK_DOMAIN) . '</a>');
		wcpgsk_set_messages();
		
	}
	return $valid;
}
}

if ( !function_exists('wcpgsk_check_qty_config') ) {
/*
 * @changed 1.8.1 to fix sold_individually problem
 */
function wcpgsk_check_qty_config( $return, $product ) {
	global $woocommerce;
	$options = get_option( 'wcpgsk_settings' );
	//respect established will fix bug communicated
	$switch = $return;
	
    switch ($product->product_type) {
		case 'variation' :
			if( isset($options['cart']['variationproductnoqty']) && $options['cart']['variationproductnoqty'] == 1)
				$switch = true;
			break;
		case 'variable' :
			if(isset($options['cart']['variableproductnoqty']) && $options['cart']['variableproductnoqty'] == 1)
				$switch = true;
			break;
		case 'grouped' :
			 if( isset($options['cart']['groupedproductnoqty']) && $options['cart']['groupedproductnoqty'] == 1)
				$switch = true;
			break;
		case 'external' :
			if( isset($options['cart']['externalproductnoqty']) && $options['cart']['externalproductnoqty'] == 1)
				$switch = true;
			break;
		default :
			if( isset($options['cart']['simpleproductnoqty']) && $options['cart']['simpleproductnoqty'] == 1)
				$switch = true;
			break;
	}
	return $switch;
}
}

if ( !function_exists('wcpgsk_qtyselector_max') ) {
function wcpgsk_qtyselector_max( $whatever, $product ) {
	global $wcpgsk_session;
	$options = get_option( 'wcpgsk_settings' );	
	$maxqty = isset($options['cart']['maxqty_' . $product->product_type]) && $options['cart']['maxqty_' . $product->product_type] != 0 ? $options['cart']['maxqty_' . $product->product_type] : '';	
	if ( isset($options['cart']['minmaxstepproduct']) && $options['cart']['minmaxstepproduct'] == 1 ) :
		$product_id = $product->post->ID;		
		$maxval = get_post_meta($product_id, '_wcpgsk_maxqty', true);
		if ( isset($maxval) && $maxval > 0 ) :
			$maxqty = $maxval;
		endif;
	endif;
	if ($maxqty == '' && isset($wcpgsk_session->qtyargs['max_value']) ) {
		$maxqty = $wcpgsk_session->qtyargs['max_value'];
	}
	return $maxqty;
}
}

if ( !function_exists('wcpgsk_qtyselector_min') ) {
function wcpgsk_qtyselector_min( $whatever, $product ) {
	global $wcpgsk_session;
	$options = get_option( 'wcpgsk_settings' );
	$minqty = isset($options['cart']['minqty_' . $product->product_type]) && $options['cart']['minqty_' . $product->product_type] != 0 ? $options['cart']['minqty_' . $product->product_type] : '';
	if ( isset($options['cart']['minmaxstepproduct']) && $options['cart']['minmaxstepproduct'] == 1 ) :
		$product_id = $product->post->ID;		
		$minval = get_post_meta($product_id, '_wcpgsk_minqty', true);
		if ( isset($minval) && $minval > 0 ) :
			$minqty = $minval;
		endif;
	endif;
	if ($minqty == '' && isset($wcpgsk_session->qtyargs['min_value']) ) {
		$minqty = $wcpgsk_session->qtyargs['min_value'];
	}
	return $minqty;
}
}

if ( !function_exists('wcpgsk_quantity_input_step') ) {
function wcpgsk_quantity_input_step( $whatever, $product ) {
	global $wcpgsk_session;
	$options = get_option( 'wcpgsk_settings' );
	
	$stepqty = isset($options['cart']['stepqty_' . $product->product_type]) && $options['cart']['stepqty_' . $product->product_type] != 0 ? $options['cart']['stepqty_' . $product->product_type] : '1';
	if ( isset($options['cart']['minmaxstepproduct']) && $options['cart']['minmaxstepproduct'] == 1 ) :
		$product_id = $product->post->ID;		
		$stepval = get_post_meta($product_id, '_wcpgsk_stepqty', true);
		if ( isset($stepval) && $stepval > 0 ) :
			$stepqty = $stepval;
		endif;
	endif;
	return $stepqty;
}
}

if ( !function_exists('wcpgsk_qty_input_args') ) {
 /**
 * @changed 1.5.4 to avoid warnings in some php contexts
 * @TODO: revision of this all as the whole process is not meaningful due to some other changes
 */
function wcpgsk_qty_input_args($args, $product) {
	global $wcpgsk_session, $woocommerce;
	
	if ( !isset($wcpgsk_session) ) :
		$wcpgsk_session = $woocommerce->session;
	endif;
	if ( isset($wcpgsk_session) && isset($args) && !empty($args) ) :	
		$wcpgsk_session->qtyargs = $args;
	endif;
	return $args;
}
}

 /**
 * Redirect to fast checkout
 */
if ( !function_exists('wcpgsk_add_to_checkout_redirect') ) {
function wcpgsk_add_to_checkout_redirect() {	
	return get_permalink( woocommerce_get_page_id( 'checkout' ) );
}
}
 /**
 * Redirect to cart
 */
if ( !function_exists('wcpgsk_add_to_cart_redirect') ) {
function wcpgsk_add_to_cart_redirect() {	
	return get_permalink( woocommerce_get_page_id( 'cart' ) );
}
}


if ( isset($wcpgsk_options['process']['fastcart']) && $wcpgsk_options['process']['fastcart'] == 1 && $wcpgsk_options['process']['fastcheckout'] == 0) {
	update_option('woocommerce_cart_redirect_after_add', 'yes');
	//update_option('woocommerce_enable_ajax_add_to_cart', 'no');
}
elseif ( isset($wcpgsk_options['process']['fastcheckout']) && $wcpgsk_options['process']['fastcheckout'] == 1 && $wcpgsk_options['process']['fastcart'] == 0) {
	update_option('woocommerce_cart_redirect_after_add', 'no');
	//update_option('woocommerce_enable_ajax_add_to_cart', 'no'); //@TODO: check if this option is correct like this
	add_filter('add_to_cart_redirect', 'wcpgsk_add_to_checkout_redirect', 99); //late execution, to assure that we overwrite WooCommerce Setting
}


if ( !function_exists('wcpgsk_cart_button_text') ) {
/**
 * Personalize Add to Cart Button
 */
function wcpgsk_cart_button_text($label) {
	$options = get_option( 'wcpgsk_settings' );
	$cart_btn_text = ((!empty($options['process']['fastcheckoutbtn'])) ? __($options['process']['fastcheckoutbtn'], WCPGSK_DOMAIN) : $label);
	if ($cart_btn_text && $cart_btn_text != '')
		return $cart_btn_text;
	else return __('Add to Cart', WCPGSK_DOMAIN);
}
}

if ( !function_exists('wcpgsk_grouped_cart_button_text') ) {
/**
 * Personalize Add to Cart Button
 */
function wcpgsk_grouped_cart_button_text($label) {
	$options = get_option( 'wcpgsk_settings' );
	$cart_btn_text = ((!empty($options['process']['viewproductsbtn'])) ? __($options['process']['viewproductsbtn'], WCPGSK_DOMAIN) : $label);
	if ($cart_btn_text && $cart_btn_text != '')
		return $cart_btn_text;
	else return __('View options', WCPGSK_DOMAIN);
}
}

if ( !function_exists('wcpgsk_variable_cart_button_text') ) {
/**
 * Personalize Add to Cart Button
 */
function wcpgsk_variable_cart_button_text($label) {
	$options = get_option( 'wcpgsk_settings' );
	$cart_btn_text = ((!empty($options['process']['selectoptionsbtn'])) ? __($options['process']['selectoptionsbtn'], WCPGSK_DOMAIN) : $label);
	if ($cart_btn_text && $cart_btn_text != '')
		return $cart_btn_text;
	else return __('Select options', WCPGSK_DOMAIN);
}
}

if ( !function_exists('wcpgsk_external_cart_button_text') ) {
/**
 * Personalize Add to Cart Button
 */
function wcpgsk_external_cart_button_text($label) {
	$options = get_option( 'wcpgsk_settings' );
	$cart_btn_text = ((!empty($options['process']['readmorebtn'])) ? __($options['process']['readmorebtn'], WCPGSK_DOMAIN) : $label);
	if ($cart_btn_text && $cart_btn_text != '')
		return $cart_btn_text;
	else return __('Read more', WCPGSK_DOMAIN);
}
}

if ( !function_exists('wcpgsk_outofstock_cart_button_text') ) {
/**
 * Personalize Add to Cart Button
 */
function wcpgsk_outofstock_cart_button_text($label) {
	$options = get_option( 'wcpgsk_settings' );
	$cart_btn_text = ((!empty($options['process']['outofstockbtn'])) ? __($options['process']['outofstockbtn'], WCPGSK_DOMAIN) : $label);
	if ($cart_btn_text && $cart_btn_text != '')
		return $cart_btn_text;
	else return __('Read more', WCPGSK_DOMAIN);
}
}

if ( !function_exists('wcpgsk_single_cart_button_text') ) {
function wcpgsk_single_cart_button_text($label, $ptype) {
	$options = get_option( 'wcpgsk_settings' );
	$cart_btn_text = ((!empty($options['process']['fastcheckoutbtn'])) ? __($options['process']['fastcheckoutbtn'], WCPGSK_DOMAIN) : 'Add to Cart');
	if ($cart_btn_text && $cart_btn_text != '')
		return $cart_btn_text;
	else return __('Add to Cart', WCPGSK_DOMAIN);
}
}

/**
 * Personalize Add to Cart Button
 */
if ( !function_exists('wcpgsk_product_single_cart_button_text') ) {
function wcpgsk_product_single_cart_button_text($label, $product) {
	$options = get_option( 'wcpgsk_settings' );
	$cart_btn_text = $label;
	if ( $label == __( 'Read more', 'woocommerce' ) ) :
		$cart_btn_text = ((!empty($options['process']['readmorebtn'])) ? __($options['process']['readmorebtn'], WCPGSK_DOMAIN) : $label);
	elseif ($label == __( 'Add to cart', 'woocommerce' ) ) :
		$cart_btn_text = ((!empty($options['process']['fastcheckoutbtn'])) ? __($options['process']['fastcheckoutbtn'], WCPGSK_DOMAIN) : $label);
	elseif ($label == __( 'Buy product', 'woocommerce' ) ) :
		$cart_btn_text = ((!empty($options['process']['buyproductbtn'])) ? __($options['process']['buyproductbtn'], WCPGSK_DOMAIN) : $label);
	elseif ($label == __( 'View products', 'woocommerce' ) ) :
		$cart_btn_text = ((!empty($options['process']['viewproductsbtn'])) ? __($options['process']['viewproductsbtn'], WCPGSK_DOMAIN) : $label);
	elseif ($label == __( 'Select options', 'woocommerce' ) ) :
		$cart_btn_text = ((!empty($options['process']['selectoptionsbtn'])) ? __($options['process']['selectoptionsbtn'], WCPGSK_DOMAIN) : $label);
	endif;
	
	return $cart_btn_text;
}
}

if ( !function_exists('wcpgsk_product_cart_button_text') ) {
function wcpgsk_product_cart_button_text($label, $product) {
	$options = get_option( 'wcpgsk_settings' );
	$cart_btn_text = $label;
	if ( $label == __( 'Read more', 'woocommerce' ) ) :
		$cart_btn_text = ((!empty($options['process']['readmorebtn'])) ? __($options['process']['readmorebtn'], WCPGSK_DOMAIN) : $label);
	elseif ($label == __( 'Add to cart', 'woocommerce' ) ) :
		$cart_btn_text = ((!empty($options['process']['fastcheckoutbtn'])) ? __($options['process']['fastcheckoutbtn'], WCPGSK_DOMAIN) : $label);
	elseif ($label == __( 'Buy product', 'woocommerce' ) ) :
		$cart_btn_text = ((!empty($options['process']['buyproductbtn'])) ? __($options['process']['buyproductbtn'], WCPGSK_DOMAIN) : $label);
	elseif ($label == __( 'View products', 'woocommerce' ) ) :
		$cart_btn_text = ((!empty($options['process']['viewproductsbtn'])) ? __($options['process']['viewproductsbtn'], WCPGSK_DOMAIN) : $label);
	elseif ($label == __( 'Select options', 'woocommerce' ) ) :
		$cart_btn_text = ((!empty($options['process']['selectoptionsbtn'])) ? __($options['process']['selectoptionsbtn'], WCPGSK_DOMAIN) : $label);
	endif;
	
	return $cart_btn_text;
}
}

//Payment gateways
$wcpgsk_options = get_option('wcpgsk_settings');
if ( isset($wcpgsk_options['process']['paymentgateways']) && 1 == ($wcpgsk_options['process']['paymentgateways'])) :
	require_once ABSPATH . WPINC . '/pluggable.php';;
	if ( function_exists('WC') ) :
		require_once dirname(dirname(__FILE__)).'/woocommerce/includes/class-wc-payment-gateways.php';
		require_once dirname(dirname(__FILE__)).'/woocommerce/includes/class-wc-cart.php';
	else :
		require_once dirname(dirname(__FILE__)).'/woocommerce/classes/class-wc-payment-gateways.php';
		require_once dirname(dirname(__FILE__)).'/woocommerce/classes/class-wc-cart.php';
	endif; 

	add_action( 'add_meta_boxes', 'wcpgsk_gateways_meta_box_add' );  
	if ( !function_exists('wcpgsk_gateways_meta_box_add') ) {
	function wcpgsk_gateways_meta_box_add()  
	{  
		add_meta_box( 'payments', 'Payment Gateways', 'wcpgsk_payments_form', 'product', 'side', 'core' ); 
	}
	}
	if ( !function_exists('wcpgsk_payments_form') ) {
	function wcpgsk_payments_form()  
	{
		global $post;//, $woo;
		$postPayments = get_metadata('post', $post->ID, 'payment_gateways', false) ;
		$woogate = new WC_Payment_Gateways();
		
		$payments = $woogate->payment_gateways();//get_available_payment_gateways();
		
		foreach ($payments as $pay) {
			$checked = '';
			
			if ( in_array($pay->id, $postPayments) ) $checked = ' checked="yes" ';
			?>  
				<input type="checkbox" <?php echo $checked; ?> value="<?php echo $pay->id; ?>" name="pays[]" id="payments" />
				<label for="payment_gateway_meta_box_text"><?php echo $pay->title; ?></label>  
				<br />  
			<?php 
		} 
		
	} 
	}
	add_action('save_post', 'wcpgsk_gateways_meta_box_save', 10, 2 );
	if ( !function_exists('wcpgsk_gateways_meta_box_save') ) {
	function wcpgsk_gateways_meta_box_save( $post_id )  
	{   
		if(isset($_POST['post_type']) && $_POST['post_type']=='product') :
		delete_post_meta($post_id, 'payment_gateways');	 
			if($_POST['pays']) :
				foreach($_POST['pays'] as $pay) :
					add_post_meta($post_id, 'payment_gateways', $pay); 					
				endforeach;
			endif;
		
		endif;
	}
	}
	if ( !function_exists('wcpgsk_restrict_payment_gateways') ) {
	function wcpgsk_restrict_payment_gateways( $restrict_gateways ) {
		global $woocommerce;
		$arrayKeys = array_keys($restrict_gateways);
		$items = isset($woocommerce->cart->cart_contents) ? $woocommerce->cart->cart_contents : array();
		$itemGateways = '';
		if($items)
			foreach($items as $item)
			$itemGateways[] = get_metadata('post', $item['product_id'], 'payment_gateways', false) ;
		if($itemGateways)
			foreach($itemGateways as $gateway)
			if(count($gateway)) :
				foreach($arrayKeys as $key) :
					if(!in_array($key, $gateway)) :
						unset($restrict_gateways[$key]);
					endif;
				endforeach;
			endif;
		return $restrict_gateways;
	}
	}
	add_filter( 'woocommerce_available_payment_gateways', 'wcpgsk_restrict_payment_gateways' );
endif;

if ( !function_exists('wcpgsk_after_checkout_form') ) {
function wcpgsk_after_checkout_form($checkout) {
	?>
	<div id="wcpgsk-dialog-validation-errors" title="<?php _e('Validation errors' , WCPGSK_DOMAIN); ?>">
		<p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span><?php _e('Please check the fields marked with a red border. The values do not pass validation.' , WCPGSK_DOMAIN); ?></p>		
	</div>
	<?php
	$options = get_option( 'wcpgsk_settings' );

	
	echo '<script language="javascript">';

	echo 'jQuery(document).ready(function(){
			jQuery("#cartitemfields").tabs();
			var cT = "' . __('Close', WCPGSK_DOMAIN) . '";
			var pT = "' . __('<Prev', WCPGSK_DOMAIN) . '";
			var nT = "' . __('Next>', WCPGSK_DOMAIN) . '";
			var cTT = "' . __('Now', WCPGSK_DOMAIN) . '";
			var cTD = "' . __('Today', WCPGSK_DOMAIN) . '";
			
			var mN = ["' . __('January', WCPGSK_DOMAIN) . '", 
				"' . __('February', WCPGSK_DOMAIN) . '",
				"' . __('March', WCPGSK_DOMAIN) . '",
				"' . __('April', WCPGSK_DOMAIN) . '",
				"' . __('May', WCPGSK_DOMAIN) . '",
				"' . __('June', WCPGSK_DOMAIN) . '",
				"' . __('July', WCPGSK_DOMAIN) . '",
				"' . __('August', WCPGSK_DOMAIN) . '",
				"' . __('September', WCPGSK_DOMAIN) . '",
				"' . __('October', WCPGSK_DOMAIN) . '",
				"' . __('November', WCPGSK_DOMAIN) . '",
				"' . __('December', WCPGSK_DOMAIN) . '"];

			var mNS = ["' . __('Jan', WCPGSK_DOMAIN) . '", 
				"' . __('Feb', WCPGSK_DOMAIN) . '",
				"' . __('Mar', WCPGSK_DOMAIN) . '",
				"' . __('Apr', WCPGSK_DOMAIN) . '",
				"' . __('May', WCPGSK_DOMAIN) . '",
				"' . __('Jun', WCPGSK_DOMAIN) . '",
				"' . __('Jul', WCPGSK_DOMAIN) . '",
				"' . __('Aug', WCPGSK_DOMAIN) . '",
				"' . __('Sep', WCPGSK_DOMAIN) . '",
				"' . __('Oct', WCPGSK_DOMAIN) . '",
				"' . __('Nov', WCPGSK_DOMAIN) . '",
				"' . __('Dec', WCPGSK_DOMAIN) . '"];

			var dN = ["' . __('Sunday', WCPGSK_DOMAIN) . '", 
				"' . __('Monday', WCPGSK_DOMAIN) . '",
				"' . __('Tuesday', WCPGSK_DOMAIN) . '",
				"' . __('Wednesday', WCPGSK_DOMAIN) . '",
				"' . __('Thursday', WCPGSK_DOMAIN) . '",
				"' . __('Friday', WCPGSK_DOMAIN) . '",
				"' . __('Saturday', WCPGSK_DOMAIN) . '"];

			var dNS = ["' . __('Sun', WCPGSK_DOMAIN) . '", 
				"' . __('Mon', WCPGSK_DOMAIN) . '",
				"' . __('Tue', WCPGSK_DOMAIN) . '",
				"' . __('Wed', WCPGSK_DOMAIN) . '",
				"' . __('Thu', WCPGSK_DOMAIN) . '",
				"' . __('Fri', WCPGSK_DOMAIN) . '",
				"' . __('Sat', WCPGSK_DOMAIN) . '"];
			
			

			jQuery("input[display=\'date\']").each(function(i, cal) {
				var minD = "' . $options['checkoutform']['mindate'] . '";
				var maxD = "' . $options['checkoutform']['maxdate'] . '";
				if (jQuery(this).attr("mindays")) minD = jQuery(this).attr("mindays");
				if (jQuery(this).attr("maxdays")) maxD = jQuery(this).attr("maxdays");
				
				var dateF = "yy/mm/dd";
				if (jQuery(this).attr("dateformat")) dateF = jQuery(this).attr("dateformat");
				var exDays = jQuery(this).attr("daysexcluded");
				var exDates = new String(jQuery(this).attr("datesexcluded"));
				var exWeekend = new String(jQuery(this).attr("exweekend"));
				if ( exDays != null && exDays != "" ) exDays = jQuery.map(exDays.split(","), jQuery.trim); 
				if ( exDates != null && exDates != "" ) exDates = jQuery.map(exDates.split(","), jQuery.trim);
				jQuery(this).datepicker({
					beforeShowDay: function(date) {
						show = true;
						if ( exWeekend == "1" ) {
							show = jQuery.datepicker.noWeekends(date)[0];
						}
						if ( show && exDays.length > 0 ) {
							
							if ( jQuery.inArray( date.getDay().toString(), exDays ) !== -1 ) show = false;
						}
						if ( show && exDates.length > 0 ) { 
							checkDate = jQuery.datepicker.formatDate(dateF, date);
							if ( jQuery.inArray( checkDate.toString(), exDates ) !== -1 ) show = false;
						}
						return [show, "", (!show) ? "' . __('Date excluded', WCPGSK_DOMAIN) . '" : ""];
					},
					dateFormat: dateF,
					minDate: minD,
					maxDate: maxD,
					dayNamesShort: dNS,
					dayNames: dN,
					monthNamesShort: mNS,
					monthNames: mN,				
					closeText: cT,
					prevText: pT,
					nextText: nT,
					currentText: cTD,
					firstDay: 1
				});		
			});

			jQuery("input[display=\'time\']").each(function() {
				var hMax = 23;
				var hMin = 0;
				if (jQuery(this).attr("maxhour")) hMax = parseInt(jQuery(this).attr("maxhour"));
				if (jQuery(this).attr("minhour")) hMin = parseInt(jQuery(this).attr("minhour"));
				
				jQuery(this).timepicker({
					timeFormat: "HH:mm",
					hourMax: hMax,
					hourMin: hMin,
					stepHour: parseInt(jQuery(this).attr("hoursteps")),
					stepMinute: parseInt(jQuery(this).attr("minutesteps")),
					addSliderAccess: true,
					sliderAccessArgs: { touchonly: false },
					timeText: "' . __('Time', WCPGSK_DOMAIN) . '",
					hourText: "' . __('Hour', WCPGSK_DOMAIN) . '",
					minuteText: "' . __('Minute', WCPGSK_DOMAIN) . '",
					currentText: cTT,
					closeText: cT,
					timeOnlyTitle: "' . __('Choose Time', WCPGSK_DOMAIN) . '"
				});		
			});

			jQuery("input[display=\'number\']").each(function() {
				var $this = this;
				jQuery(this).after("<div id=\'slider_" + jQuery(this).attr("id") + "\'></div>");

				if (jQuery($this).attr("numpres") == "true") {
					jQuery("#slider_" + jQuery($this).attr("id")).slider({
						range: true,
						min: parseInt(jQuery($this).attr("minvalue")),
						max: parseInt(jQuery($this).attr("maxvalue")),
						step: parseInt(jQuery($this).attr("numstep")),
						values: [ parseInt(jQuery($this).val()), parseInt(jQuery($this).attr("rangemax")) ],
						slide: function( event, ui ) {
							jQuery( $this ).val( ui.values[0] + " - " +  ui.values[1]);
						}		
					});
				}
				else {
					jQuery("#slider_" + jQuery($this).attr("id")).slider({
						range: jQuery($this).attr("numpres"),
						min: parseInt(jQuery($this).attr("minvalue")),
						max: parseInt(jQuery($this).attr("maxvalue")),
						step: parseInt(jQuery($this).attr("numstep")),
						value: parseInt(jQuery($this).val()),
						slide: function( event, ui ) {
							jQuery( $this ).val( ui.value );
						}		
					}).sliderAccess({ touchonly : false });
				}
			});
	
			jQuery("select[presentation=\'radio\']").each(function(i, select){
				var $select = jQuery(select);
				$select.find("option").each(function(j, option){
					var $option = jQuery(option);
					// Create a radio:
					if ($option.val() != null && $option.val() != "") {
						var $radio = jQuery("<input type=\'radio\' />");
						// Set name and value:
						$radio.attr("name", $select.attr("name")).attr("value", $option.val()).attr("class", "radio").attr("style","width:10%");
						// Set checked if the option was selected
						if ($option.attr("selected") != null && $option.attr("selected") == "selected" && $select.attr("hasselected") != null && $select.attr("hasselected") == "true" ) $radio.attr("checked", "checked");
						//$radio.text($option.text());
						// Insert radio before select box:
						$select.before($radio);
						// Insert a label:
						$select.before(
						  jQuery("<span />").attr("for", $select.attr("name")).text($option.text())
						);
						// Insert a <br />:
						$select.before("<br/>");
					}
				});
				$select.remove();
			});
			
			jQuery("select[presentation=\'checkbox\']").each(function(i, select){
				var $select = jQuery(select);
				$select.find("option").each(function(j, option){
					var $option = jQuery(option);
					// Create a radio:
					if ($option.val() != null && $option.val() != "") {
						var $radio = jQuery("<input type=\'checkbox\' />");
						// Set name and value:
						$radio.attr("name", $select.attr("name") + "[" + j + "]").attr("value", $option.val()).attr("class", "checkbox").attr("style","width:10%");
						// Set checked if the option was selected
						if ($option.attr("selected") != null && $option.attr("selected") == "selected" && $select.attr("hasselected") != null && $select.attr("hasselected") == "true" ) $radio.attr("checked", "checked");
						//$radio.text($option.text());
						// Insert radio before select box:
						$select.before($radio);
						// Insert a label:
						$select.before(
						  jQuery("<span />").attr("for", $select.attr("name")).text($option.text())
						);
						$select.before("<br/>");
					}
				});
				$select.remove();
			});
			jQuery("select[multiple=\'multiple\']").each(function(i, select){
				var $select = jQuery(select);
				$select.attr("name", $select.attr("name") + "[]");
			});
			
		});
	</script><!--unit test after checkout end-->';
	//load our user scripts from db...
	$wcpgsk_checkoutjs = get_option('wcpgsk_checkoutjs');
	if ( !empty($wcpgsk_checkoutjs) ) :
		echo '<script language="javascript">';
		echo $wcpgsk_checkoutjs;
		echo '</script>';
	endif;
	
}

}

/**
 * Handle functions deprecated in WooCommerce since 2.1.0 for WooCommerce installations < 2.1
 */
function wcpgsk_add_error( $error ) {
	if ( function_exists('WC') && function_exists('wc_add_notice') ) :
		wc_add_notice( $error, 'error');
	else :
		global $woocommerce;
		$woocommerce->add_error( $error );
	endif;
}

function wcpgsk_add_message( $message ) {
	if ( function_exists('WC') && function_exists('wc_add_notice') ) :
		wc_add_notice( $message );
	else :
		global $woocommerce;
		$woocommerce->add_message( $message );
	endif;
}

function wcpgsk_clear_messages() {
	if ( function_exists('WC') && function_exists('wc_clear_notices') ) :
		wc_clear_notices();
	else :
		global $woocommerce;
		$woocommerce->clear_messages();
	endif;
}

function wcpgsk_show_messages() {
	if ( function_exists('WC') && function_exists('wc_print_notices') ) :
		wc_print_notices();
	else :
		global $woocommerce;
		$woocommerce->show_messages();
	endif;
}

function wcpgsk_set_messages() {
	if ( !function_exists('WC') ) :
		global $woocommerce;
		$woocommerce->set_messages();
	endif;
}

