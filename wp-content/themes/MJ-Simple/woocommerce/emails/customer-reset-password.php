<?php
/**
 * Customer Reset Password email
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates/Emails
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<?php do_action('woocommerce_email_header', $email_heading); ?>

<p><?php _e( 'Ktoś poprosił o przywrócenia hasłe dla następującego konta:', 'woocommerce' ); ?></p>
<p><?php printf( __( 'Username: %s', 'woocommerce' ), $user_login ); ?></p>
<p><?php _e( 'Jeśli to był błąd, zignoruj ​​ten e-mail i nic się nie stanie.', 'woocommerce' ); ?></p>
<p><?php _e( 'Aby zresetować hasło, odwiedź następujący adres:', 'woocommerce' ); ?></p>
<p>
    <a href="<?php echo esc_url( add_query_arg( array( 'key' => $reset_key, 'login' => rawurlencode( $user_login ) ), get_permalink( woocommerce_get_page_id( 'lost_password' ) ) ) ); ?>">
			<?php _e( 'Kliknij tutaj, aby zresetować hasło', 'woocommerce' ); ?></a>
</p>
<p></p>

<?php do_action('woocommerce_email_footer'); ?>