<?php
/**
 * SP FRAMEWORK FILE - DO NOT EDIT!
 * 
 * @package SP FRAMEWORK
 *
 * clear caches
 */

if ( ! defined( 'ABSPATH' ) ) exit; // no direct access

/**
 * Function that clears the carousel slider cache
 *
 * @access private
 * @since 3.0
 * @param int $post_id | the post id of the carousel
 * @return boolean true
 */
function _sp_clear_slider_cache( $post_id ) {
	delete_transient( 'sp-carousel-slider-' . $post_id );

	return true;
}

/**
 * Function that clears the portfolio cache
 *
 * @access private
 * @since 3.0
 * @param int $category_id | the category id of the portfolio
 * @return boolean true
 */
function _sp_clear_portfolio_cache( $category_id ) {
	delete_transient( 'sp-portfolio-' . $category_id );

	return true;
}

/**
 * Function that clears the testimonial pending notice cache
 *
 * @access private
 * @since 3.0
 * @return boolean true
 */
function _sp_clear_testimonial_pending_notice_cache() {
	delete_transient( 'sp-testimonial-pending-notice' );

	return true;
}