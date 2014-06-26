<?php
/**
 * Content wrappers
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

$id = ( get_option('template') === 'mjsimple' ) ? 'primary' : 'container';
?>
<div id="<?php echo $id; ?>">
	<div id="content" role="main">