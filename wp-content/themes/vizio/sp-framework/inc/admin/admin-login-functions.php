<?php
/**
 * SP FRAMEWORK FILE - DO NOT EDIT!
 * 
 * @package SP FRAMEWORK
 *
 * admin login functions
 */

if ( ! defined( 'ABSPATH' ) ) exit; // no direct access

add_filter( 'login_headerurl', 'sp_login_url' );

/**
 * Function that filters the default login link
 *
 * @access public
 * @since 3.0
 * @return string URL
 */
function sp_login_url() {
	return home_url(); 
}

add_filter( 'login_headertitle', 'sp_login_headertitle' );

/**
 * Function that filters the backend header link title
 * 
 * @access public
 * @since 3.0
 * @return string URL
 */
function sp_login_headertitle() {
    return get_bloginfo( 'name' );
}

add_action( 'login_head', '_sp_backend_login_styles' );

/**
 * Function that loads scripts to the login page
 *
 * @access private
 * @since 3.0
 * @return html $output
 */
function _sp_backend_login_styles() {
	// recommended size of logo by WP not to exceed 323x67
	$theme_logo = get_template_directory_uri() . '/images/logo.png'; // default if nothing is set

	$theme_mod_logo = get_theme_mod( 'logo_upload' );

	// check if logo is set in site logo upload
	if ( isset( $theme_mod_logo ) && ! empty( $theme_mod_logo ) )
		$theme_logo = $theme_mod_logo;

	// check if custom backend logo is set
	if ( sp_get_option( 'admin_login_logo', 'isset' ) )
		$theme_logo = sp_get_option( 'admin_login_logo' );

	// get the image size
	$image_size = sp_get_image_size( $theme_logo );

	$bg_image = '';

	// check if bg is user uploaded or predefined
	if ( sp_get_option( 'admin_login_background_image', 'isset' ) && sp_get_option( 'admin_login_background_image', 'is', 'custom' ) ) {
		// get background image
		$bg_image = sp_get_option( 'admin_login_background_image_custom', 'isset' ) ? sp_get_option( 'admin_login_background_image_custom' ) : '';
	} elseif ( sp_get_option( 'admin_login_background_image', 'isset' ) && ! sp_get_option( 'admin_login_background_image', 'is', 'none' ) ) {
		// get background image
		$bg_image = sp_get_option( 'admin_login_background_image', 'isset' ) ? sp_get_option( 'admin_login_background_image' ) : '';	
	}

	$bg_image_position = sp_get_option( 'admin_login_bg_position', 'isset' ) ? sp_get_option( 'admin_login_bg_position' ) : '';

	$bg_image_repeat = sp_get_option( 'admin_login_bg_repeat', 'isset' ) ? sp_get_option( 'admin_login_bg_repeat' ) : '';

	$bg_image_attachment = sp_get_option( 'admin_login_bg_attachment', 'isset' ) ? sp_get_option( 'admin_login_bg_attachment' ) : '';

	$bg_image_color = sp_get_option( 'admin_login_bg_color', 'isset' ) ? sp_get_option( 'admin_login_bg_color' ) : '';

	$output = '';

	$output .= '<link rel="stylesheet" type="text/css" href="' . get_template_directory_uri() . '/css/theme-admin-login-styles.css" />' . "\r\n";

	$output .= '<style type="text/css">' . "\r\n";

	$output .= '.login h1 a { background-image:url(' . $theme_logo . '); }' . "\r\n";

	$output .= '.login h1 a { background-size:' . $image_size['width'] . 'px ' . $image_size['height'] . 'px;}' . "\r\n";

	// link text color
	if ( sp_get_option( 'admin_login_link_text_color', 'isset' ) )
		$output .= 'body.login div#login p#nav a, body.login div#login p#backtoblog a { color:#' . str_replace( '#', '', sp_get_option( 'admin_login_link_text_color' ) ) . ' !important;}' . "\r\n";

	// link text color hover
	if ( sp_get_option( 'admin_login_link_text_color_hover', 'isset' ) )
		$output .= 'body.login div#login p#nav a:hover, body.login div#login p#backtoblog a:hover { color:#' . str_replace( '#', '', sp_get_option( 'admin_login_link_text_color_hover' ) ) . ' !important;}' . "\r\n";

	// check if background image color is set
	if ( ! empty( $bg_image_color ) )
		$output .= 'body.login { background-color:#' . str_replace( '#', '', $bg_image_color ) . ' !important;}' . "\r\n";

	// check if background image is set
	if ( ! empty( $bg_image ) ) {
		$output .= 'body.login { background-image:url(' . $bg_image . ') !important;}' . "\r\n";

		$output .= 'body.login { background-repeat:' . $bg_image_repeat . ' !important;}' . "\r\n";

		$output .= 'body.login { background-attachment:' . $bg_image_attachment . ' !important;}' . "\r\n";

		$output .= 'body.login { background-position:' . $bg_image_position . ' !important;}' . "\r\n";
	}

	$output .= '</style>' . "\r\n";

	echo $output;
}