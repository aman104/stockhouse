<?php
/**
* PayU Payment Gateway
*
* Provides a PayU Payment Gateway.
*
* @class WC_Gateway_PayU
* @package WooCommerce
* @category Payment Gateways
* @author Inspire Labs
*
*/

class WC_Gateway_Payu extends WC_Payment_Gateway 
{
	public $pos_id;
	public $pos_auth_key;
	public $key_1;
	public $key_2;
	
	public $check_sig;
	public $testmode;
	
	public $liveurl;
	public $getStatusUrl;
	
	
	/**
	 * __construct public function.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function __construct() {
		global $woocommerce;

        $this->id				= 'payu';
        $this->method_title = __( 'PayU', 'woocommerce_payu' );
        $this->icon 			= $this->plugin_url() . '/assets/images/icon.png';
        $this->has_fields 		= false;

        $this->liveurl			= 'https://www.platnosci.pl/paygw/UTF/NewPayment';
        $this->getStatusUrl		= 'https://www.platnosci.pl/paygw/UTF/Payment/get/txt';

      	// Load the form fields.
		$this->init_form_fields();

		// Load the settings.
		$this->init_settings();

      	// Check if the currency is set to PLN. If not we disable the plugin here.
		if ( get_option( 'woocommerce_currency' ) == 'PLN' ) {
			$gw_enabled = $this->settings['enabled'];
		} else {
			$gw_enabled = 'no';
		} // End check currency

      	$this->enabled			= $gw_enabled;
      	
		$this->title 			= $this->settings['title'];
		$this->description  	= $this->settings['description'];
		
		$this->pos_id			= $this->settings['pos_id'];
		$this->pos_auth_key		= $this->settings['pos_auth_key'];
		$this->key_1			= $this->settings['key_1'];
		$this->key_2			= $this->settings['key_2'];
		
		$this->check_sig		= $this->settings['check_sig'];
		$this->testmode  		= $this->settings['testmode'];

		// Actions
		add_action( 'woocommerce_api_' . strtolower( get_class() ) , array( $this, 'check_payu_response' ) );
		
		add_action( 'woocommerce_receipt_payu', array( $this, 'receipt_page' ) );
		
		add_action( 'woocommerce_update_options_payment_gateways', array( $this, 'process_admin_options' ) );
		add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
    } // End Constructor

    /**
	 * Initialise Gateway Settings Form Fields
	 *
	 * @since 1.0.0
	 */
	public function init_form_fields() {
		$this->form_fields = array(
			'enabled' => array(
							'title' => __( 'Enable/Disable', 'woocommerce_payu' ),
							'type' => 'checkbox',
							'label' => __( 'Enable PayU', 'woocommerce_payu' ),
							'default' => 'yes'
						),
			'title' => array(
							'title' => __( 'Title', 'woocommerce' ),
							'type' => 'text',
							'description' => __( 'This controls the title which the user sees during checkout.', 'woocommerce_payu' ),
							'default' => __( 'PayU', 'woocommerce_payu' )
						),
			'description' => array(
							'title' => __( 'Description', 'woocommerce_payu' ),
							'type' => 'textarea',
							'description' => __( 'This controls the description which the user sees during checkout.', 'woocommerce_payu' ),
							'default' => __( 'Direct payment via PayU', 'woocommerce_payu' ),
						),
			'pos_id' => array(
							'title' => __( 'Id punktu płatności (pos_id)', 'woocommerce_payu' ),
							'type' => 'text',
							'description' => __( 'Please enter your pos_id number; this number should be provided by PayU during registration!', 'woocommerce_payu' ),
							'default' => ''
						),
			'key_1' => array(
							'title' => __( 'Klucz (MD5)', 'woocommerce_payu' ),
							'type' => 'text',
							'description' => __( 'Please enter your MD5 key number; this number should be provided by PayU during registration!', 'woocommerce_payu' ),
							'default' => ''	
					),
			'key_2' => array(
							'title' => __( 'Drugi klucz (MD5)', 'woocommerce_payu' ),
							'type' => 'text',
							'description' => __( 'Please enter your second MD5 key number; this number should be provided by PayU during registration!', 'woocommerce_payu' ),
							'default' => ''
					),
			'pos_auth_key' => array(
							'title' => __( 'Klucz autoryzacji płatności (pos_auth_key)', 'woocommerce_payu' ),
							'type' => 'text',
							'description' => __( 'Please enter your POS auth key; this number should be provided by PayU during registration!', 'woocommerce_payu' ),
							'default' => ''
					),
			'check_sig' => array(
							'title' => __( 'Podpis sig', 'woocommerce_payu' ),
							'type' => 'checkbox',
							'label' => __( 'Zabezpieczaj moje transakcje/Sprawdzaj poprawność sig-a', 'woocommerce_payu' ),
							'description' => __( 'Sig to ciąg znaków pełniący rolę podpisu cyfrowego. Weryfikacja poprawności sig-a zwiększa bezpieczeństwo transakcji.', 'woocommerce_payu' ),
							'default' => 'no'
					)
			,
			'testmode' => array(
							'title' => __( 'Test Mode', 'woocommerce_payu' ),
							'type' => 'checkbox',
							'label' => __( 'Enable Test Mode', 'woocommerce_payu' ),
							'description' => __( 'This is just to test your account information. No payment will be made.', 'woocommerce_payu' ),
							'default' => 'no'
					)
			);
	} // End init_form_fields()


	/**
	 * Get the plugin URL
	 *
	 * @since 1.0.0
	 */
	public function plugin_url() {
		if( isset( $this->plugin_url ) ) return $this->plugin_url;

		if ( is_ssl() ) {
			return $this->plugin_url = str_replace( 'http://', 'https://', WP_PLUGIN_URL ) . '/' . plugin_basename( dirname( dirname( __FILE__ ) ) );
		} else {
			return $this->plugin_url = WP_PLUGIN_URL . '/' . plugin_basename( dirname( dirname( __FILE__ ) ) );
		}
	} // End plugin_url()


	/**
	 * Admin Panel Options
	 * - Options for bits like 'title' and availability on a country-by-country basis
	 *
	 * @since 1.0.0
	 */
	public function admin_options() {
    	?>
    	<h3><?php _e( 'PayU', 'woocommerce_payu' ); ?></h3>
    	<p><?php _e( 'Bramka płatności przekierowuje kupującego na stronę PayU w celu dokonania płatności. <a href="http://www.wpdesk.pl/docs/payu-woocommerce-docs/" target="_blank">Instrukcja instalacji i konfiguracji wtyczki &rarr;</a>', 'woocommerce_payu' ); ?></p>
		<?php
			if ( get_option( 'woocommerce_currency' ) == 'PLN' ) {
		?>
			<table class="form-table">
		<?php
				// Generate the HTML For the settings form.
				$this->generate_settings_html();
		?>
			</table><!--/.form-table-->
		<?php
			} else {
		?>
		<div class="inline error"><p><strong><?php _e( 'Gateway Disabled', 'woocommerce_payu' ); ?></strong> <?php echo sprintf( __( 'Choose Polish Złoty as your store currency in <a href="%s">Pricing Options</a> to enable the PayU Gateway.', 'woocommerce_payu' ), admin_url( '?page=woocommerce&tab=general' ) ); ?></p></div>
		<?php
		} // End check currency
	} // End admin_options()


    /**
	 * There are no payment fields for PayU, but we want to show the description if set.
	 *
	 * @since 1.0.0
	 */
    public function payment_fields() {
    	if ( $this->description ) echo wpautop( wptexturize( $this->description ) );
    } // End payment_fields()
    
    /**
     * 
     * @param array $data
     * @return string Signature
     * 
     * @since 1.0.0
     */
    public function generateFormSig($data)
    {
    	$sig  = $data['pos_id'];
    	$sig .= $data['pay_type'];
    	$sig .= $data['session_id'];
    	$sig .= $data['pos_auth_key'];
    	$sig .= $data['amount'];
    	
    	$sig .= $data['desc'];
    	$sig .= $data['order_id'];
    	$sig .= $data['first_name'];
    	$sig .= $data['last_name'];
    	
    	$sig .= $data['street'];
    	$sig .= $data['city'];
    	
    	$sig .= $data['post_code'];
    	$sig .= $data['email'];
    	$sig .= $data['phone'];
    	$sig .= $data['language'];
    	
    	$sig .= $data['client_ip'];
    	$sig .= $data['ts'];
    	$sig .= $this->key_1;
    	
    	return md5( $sig );
    }


	/**
	 * Generate the PayU button link.
	 *
	 * @since 1.0.0
	 */
    public function generate_payu_form( $order_id ) {
		global $woocommerce;
		$order = new WC_Order( $order_id );

		$payuform = "";


		// Merchant details
		$merchant = array(
			'pos_id'			=> $this->pos_id,
			'pos_auth_key'		=> $this->pos_auth_key,
			'language'			=> 'pl'
		);

		// Customer details
		$customer = array(
			'first_name'				=> $order->billing_first_name,
			'last_name'					=> $order->billing_last_name,
			'email'					    => $order->billing_email,
			'street'					=> $order->billing_address_1 . ' ' . $order->billing_address_2,
			'city'						=> $order->billing_city,
			'post_code'					=> $order->billing_postcode,
			'phone' 		            => $order->billing_phone,
			'client_ip'					=> $_SERVER['REMOTE_ADDR']
		);

		// Item details
		$item = array(
			'desc'			        => sprintf( __( 'Order # %s from ', 'woocommerce_payu' ), $order_id ) . get_bloginfo( 'name' ),
			'amount'				=> $order->order_total * 100,
			'order_id' 				=> $order_id,
			'session_id'			=> $order->order_key
		);

		if ( $this->testmode != 'no' )
		{
			$item['pay_type'] = 't';
		}
		
		$paramsArray = array_merge($merchant, $customer, $item);
		
		if ( $this->check_sig != 'no' )
		{
			$paramsArray['ts'] = time();
			$paramsArray['sig'] = $this->generateFormSig($paramsArray);
		}
		

		foreach( $paramsArray as $key => $value ) 
		{
   			if( $value ) {
	   			$payuform .= '<input type="hidden" name="' . $key . '" value="' . $value . '" />' . "\n";
   			}
		}

		//$payuform .= '<input type="hidden" name="js" value="0" id="js_value" />' . "\n";

		$payuform .= '<script type="text/javascript">
			<!--
				document.getElementById("js_value").value = 1;
			-->
			</script>';

		// The form
		return '<form action="' . $this->liveurl . '" method="POST" name="payform" id="payform">
				' . $payuform . '
				<input type="submit" class="button" id="submit_payu_payment_form" value="' . __( 'Pay via PayU', 'woocommerce_payu' ) . '" /> <a class="button cancel" href="' . $order->get_cancel_order_url() . '">'.__( 'Cancel order &amp; restore cart', 'woocommerce_payu' ) . '</a>
				<script type="text/javascript">
					jQuery(function(){
						jQuery("body").block(
							{
								message: "<img src=\"' . $woocommerce->plugin_url() . '/assets/images/ajax-loader.gif\" alt=\"Redirecting...\" />'.__('Thank you for your order. We are now redirecting you to PayU to make payment.', 'woocommerce_payu').'",
								overlayCSS:
								{
									background: "#fff",
									opacity: 0.6
								},
								css: {
							        padding:        20,
							        textAlign:      "center",
							        color:          "#555",
							        border:         "3px solid #aaa",
							        backgroundColor:"#fff",
							        cursor:         "wait"
							    }
							});
						jQuery("#submit_payu_payment_form").click();
					});
				</script>
			</form>';
	} // End generate_payu_form()


	/**
	 * Process the payment and return the result.
	 *
	 * @since 1.0.0
	 */
	public function process_payment( $order_id ) {
		$order = new WC_Order( $order_id );

		return array(
			'result' 	=> 'success',
			'redirect'	=> add_query_arg( 'order', $order->id, add_query_arg( 'key', $order->order_key, get_permalink( get_option( 'woocommerce_pay_page_id' ) ) ) )
		);
	} // End process_payment()


	/**
	 * Receipt page.
	 *
	 * Display text and a button to direct the user to the payment screen.
	 *
	 * @since 1.0.0
	 */
	public function receipt_page( $order ) {
		echo '<p>' . __( 'Dziękujemy za złożenie zamówienia. Kliknij aby dokonać płatności przez PayU.', 'woocommerce_payu' ) . '</p>';
		echo $this->generate_payu_form( $order );
	} // End receipt_page()
	
	
	/**
	 * 
	 * @param WC_Order $order
	 * @return WC_Order
	 * 
	 */
	public function update_order_status_from_payu(WC_Order $order)
	{
		$data['ts'] = time();
		$data['pos_id'] = $this->pos_id;
		$data['session_id'] = $order->order_key;
		$data['sig'] = md5( $this->pos_id . $order->order_key . $data['ts'] . $this->key_1 );
		
		$response = wp_remote_post($this->getStatusUrl, array(
				'method' => 'POST',
				'body' => $data,
				'timeout' => 100,
				'sslverify' => false
		));
		
		
		$responseTempArray = explode("\n", $response['body']);
		$responseArray = array();
		foreach ($responseTempArray as $value)
		{
			$value = explode(':', $value);
			$responseArray[ trim($value[0]) ] = trim( $value[1] );
		}
		
		// check response sig
		$sig = md5( $responseArray['trans_pos_id'] . $responseArray['trans_session_id'] . $responseArray['trans_order_id'] . $responseArray['trans_status'] . $responseArray['trans_amount'] . $responseArray['trans_desc'] . $responseArray['trans_ts'] . $this->key_2 );
		if ( $responseArray['trans_sig'] == $sig )
		{
			if ($order->status != 'completed')
			{
				// set status from payu
				switch ($responseArray['trans_status'])
				{
					case 1:
						$order->update_status('pending'); 
						break;
					
					case 2:
						//$order->update_status('cancelled');
						$order->update_status('failed');
						break;
					
					case 3:
						$order->update_status('failed');
						break;
					
					case 4:
						$order->update_status('pending');
						break;
						
					case 5:
						$order->update_status('processing');
						break;
					
					case 7:
						$order->update_status('failed');
						break;
					
					case 99:
						$order->update_status('processing');
						break;
					
					case 888:
						$order->update_status('on-hold');
						break;
						
				}
			}
			return true;
		} else {
			return false;
		}
		
		/*var_dump($responseArray);
		die();*/

		return $order;
	}

	/**
	 * Check for PayU Response and verify validity
	 *
	 * @since 1.0.0
	 */
	public function check_payu_response() {
		global $woocommerce;
		
		$order = new WC_Order( (int) $_GET['orderId'] );
		
		if (!empty($_POST['pos_id'])) // if set, then it's report
		{
			$sig = md5( $this->pos_id . $_POST['session_id'] . $_POST['ts'] . $this->key_2);
			
			//$sig = $_POST['sig'];
			
			if ($sig == $_POST['sig']) // if sig ok, change status
			{
				if ($this->update_order_status_from_payu($order))
				{
					die('OK'); // info from payu acknowledged
				} else {
					die('WRONG SIG 2');
				}
				
			} else {
				die('WRONG SIG 1');
			}
			
		} else { // it's user request
			if (!empty($_GET['error'])) // error request
			{
				$statusData = $this->get_order_error_status($_GET['error']);
				
				if (!empty($statusData['tstatus']))
				{
					$order->update_status( $statusData['tstatus'] );
				}
				$woocommerce->add_error( $statusData['tmsg'] );
				
			} else { // success request
				$this->update_order_status_from_payu($order);
			}
			$woocommerce->cart->empty_cart();
			
			wp_redirect( $this->get_return_url( $order ) );
			
		}


	} // End check_payu_response()

	/**
	 * 
	 * @param unknown_type $code
	 * @return multitype:string Ambigous <string, mixed>
	 */
	public function get_order_error_status($code)
	{
		$tstatus = null;
		$tmsg = null;
		
		switch ( $code )
		{
			case '100':
				$tstatus = 'failed';
				$tmsg = __( 'Brak lub błędna wartość parametru POS_ID', 'woocommerce_payu' );
			break;
			case '101':
				$tstatus = 'failed';
				$tmsg = __( 'Brak parametru SESSION_ID', 'woocommerce_payu' );
			break;
			case '102':
				$tstatus = 'failed';
				$tmsg = __( 'Brak parametru TS', 'woocommerce_payu' );
			break;
			case '103':
				$tstatus = 'failed';
				$tmsg = __( 'Brak lub błędna wartość parametru SIG', 'woocommerce_payu' );
			break;
			case '104': 
				$tstatus = 'failed';
				$tmsg = __( 'Brak parametru', 'woocommerce_payu' ) . ' ' .$code;
			break;
			case '105': 
				$tstatus = 'failed';
				$tmsg = __( 'Brak parametru', 'woocommerce_payu' ) . ' ' .$code;
			break;
			case '106': 
				$tstatus = 'failed';
				$tmsg = __( 'Brak parametru', 'woocommerce_payu' ) . ' ' .$code;
			break;
			case '107': 
				$tstatus = 'failed';
				$tmsg = __( 'Brak parametru', 'woocommerce_payu' ) . ' ' .$code;
			break;
			case '108':
				$tstatus = 'failed';
				$tmsg = __( 'Brak parametru', 'woocommerce_payu' ) . ' ' .$code;
			break;
			case '109': 
				$tstatus = 'failed';
				$tmsg = __( 'Brak parametru', 'woocommerce_payu' ) . ' ' .$code;
			break;
			case '110': 
				$tstatus = 'failed';
				$tmsg = __( 'Brak parametru', 'woocommerce_payu' ) . ' ' .$code;
			break;
			case '111': 
				$tstatus = 'failed';
				$tmsg = __( 'Brak parametru', 'woocommerce_payu' ) . ' ' .$code;
			break;
			case '112': 
				$tstatus = 'failed';
				$tmsg = __( 'Błędny numer konta bankowego', 'woocommerce_payu' );
			break;
			case '113': 
				$tstatus = 'failed';
				$tmsg = __( 'Brak parametru', 'woocommerce_payu' ) . ' ' .$code;
			break;
			case '114':
				$tstatus = 'failed';
				$tmsg = __( 'Brak parametru', 'woocommerce_payu' ) . ' ' .$code;
			break;
			case '200':
				$tstatus = 'failed';
				$tmsg = __( 'Chwilowy błąd PayU', 'woocommerce_payu' );
			break;
			case '201': 
				$tstatus = 'failed';
				$tmsg = __( 'Chwilowy błąd PayU, bazy danych', 'woocommerce_payu' );
			break;
			case '202':
				$tstatus = 'failed';
				$tmsg = __( 'POS jest zablokowany', 'woocommerce_payu' );
			break;
			case '203':
				$tstatus = 'on-hold';
				$tmsg = __( 'Błąd', 'woocommerce_payu' ) . ' ' .$code;
			break;
			case '204': 
				$tstatus = 'failed';
				$tmsg = __( 'Błąd', 'woocommerce_payu' ) . ' ' .$code;
			break;
			case '205':
				$tstatus = 'failed';
				$tmsg = __( 'Błąd', 'woocommerce_payu' ) . ' ' .$code;
			break;
			case '206': 
				$tstatus = 'failed';
				$tmsg = __( 'Błąd', 'woocommerce_payu' ) . ' ' .$code;
			break;
			case '207':
				$tstatus = 'failed';
				$tmsg = __( 'Błąd', 'woocommerce_payu' ) . ' ' .$code;
			break;
			case '208': 
				$tstatus = 'failed';
				$tmsg = __( 'Błąd', 'woocommerce_payu' ) . ' ' .$code;
			break;
			case '209': 
				$tstatus = 'failed';
				$tmsg = __( 'Błąd', 'woocommerce_payu' ) . ' ' .$code;
			break;
			case '500': 
				$tstatus = 'failed';
				$tmsg = __( 'Błąd', 'woocommerce_payu' ) . ' ' .$code;
			break;
			case '501': 
				$tstatus = 'failed';
				$tmsg = __( 'Błąd', 'woocommerce_payu' ) . ' ' .$code;
			break;
			case '502': 
				//$tstatus = 'failed';
				$tmsg = __( 'Błąd', 'woocommerce_payu' ) . ' ' .$code;
			break;
			case '503': 
				//$tstatus = 'failed';
				$tmsg = __( 'Błąd', 'woocommerce_payu' ) . ' ' .$code;
			break;
			case '504': 
				$tstatus = 'failed';
				$tmsg = __( 'Błąd', 'woocommerce_payu' ) . ' ' .$code;
				break;
			case '505': 
				//$tstatus = 'failed';
				$tmsg = __( 'Błąd', 'woocommerce_payu' ) . ' ' .$code;
				break;
			case '506': 
				//$tstatus = 'failed';
				$tmsg = __( 'Błąd', 'woocommerce_payu' ) . ' ' .$code;
				break;
			case '507': 
				$tstatus = 'failed';
				$tmsg = __( 'Błąd', 'woocommerce_payu' ) . ' ' .$code;
				break;
			default:
				$tstatus = 'on-hold';
				$tmsg = __( 'Wrong status - we ask user to contact us', 'woocommerce_payu' );
			break;
		}

		return array('tstatus' => $tstatus, 'tmsg' => $tmsg);
	}

} //  End Class
