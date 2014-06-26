<?php
/**
 *	
 * theme specific hot patches
 */

// convert FAQ content to wp editor content
$faq_option = get_option( 'sp_faq_converted' );

// if not converted convert
if ( $faq_option !== '1' ) {

	$args = array( 
		'post_type' => 'sp-faq',
		'posts_per_page' => -1,
		'post_status' => 'any'
	);

	$faqs = new WP_Query( $args );

	// loop
	while( $faqs->have_posts() ) : $faqs->the_post();
		// get the content meta
		$content = get_post_meta( get_the_ID(), '_sp_faq_answer', true );

		$post_content = array(
			'ID' => get_the_ID(),
			'post_content' => $content
		);

		wp_update_post( $post_content );
	endwhile;

	wp_reset_postdata();

	// flag converted
	update_option( 'sp_faq_converted', '1' );
}