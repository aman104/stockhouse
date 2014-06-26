<?php
/**
 * Customer new account email
 *
 * @author 	  WooThemes
 * @package 	WooCommerce/Templates/Emails
 * @version     1.6.4
 */

if (!defined('ABSPATH')) exit; ?>

<?php do_action('woocommerce_email_header', $email_heading); ?>

<p><?php printf(__("Dziękujemy za założenie konta na stronie stockhouse.com.pl. Twoja dane logowania to:<br> Nazwa firmy: <strong>%s</strong><br> Hasło: <strong>%s</strong>", 'woocommerce'), $user_login, $user_pass ); ?></p>
<p><?php printf(__("<b><u>Uwaga!</u></b> Tymczasowo Twoje konto ma status <b>niezweryfikowanego</b> i oczekuje na weryfikacje przez administratora. Gdy administrator zatwierdzi Twoje konto, będziesz mógł w pełni korzystać z możliwości sklepu internetowego stockhouse.com.pl.</b>", 'woocommerce')); ?></p>
<p><?php printf(__("Możesz uzyskać dostęp do obszaru konta tutaj: %s.", 'woocommerce'), get_permalink(woocommerce_get_page_id('myaccount'))); ?></p>

<div style="clear:both;"></div>

<?php do_action('woocommerce_email_footer'); ?>