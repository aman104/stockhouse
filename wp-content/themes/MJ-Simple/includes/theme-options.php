



<?php
/**
 * Initialize the options before anything else.
 */
add_action( 'admin_init', 'custom_theme_options', 1 );

/**
 * Build the custom settings & update OptionTree.
 */
function custom_theme_options() {
  /**
   * Get a copy of the saved settings array. 
   */
  $saved_settings = get_option( 'option_tree_settings', array() );
  
  /**
   * Custom settings array that will eventually be 
   * passes to the OptionTree Settings API Class.
   */
  $custom_settings = array( 
    'contextual_help' => array( 
      'sidebar'       => ''
    ),
    'sections'        => array( 
      array(
        'id'          => 'general',
        'title'       => 'General'
      ),
      array(
        'id'          => 'footer_settings',
        'title'       => 'Footer settings'
      ),
      array(
        'id'          => 'woocommerce',
        'title'       => 'Woocommerce'
      )
    ),
    'settings'        => array( 
      array(
        'id'          => 'sample_text',
        'label'       => 'Theme color',
        'desc'        => 'Please select your colour scheme here.',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'blue',
            'label'       => 'blue',
            'src'         => ''
          ),
          array(
            'value'       => 'cyan',
            'label'       => 'cyan',
            'src'         => ''
          ),
          array(
            'value'       => 'gray',
            'label'       => 'gray',
            'src'         => ''
          ),
          array(
            'value'       => 'green',
            'label'       => 'green',
            'src'         => ''
          ),
          array(
            'value'       => 'orange',
            'label'       => 'orange',
            'src'         => ''
          ),
          array(
            'value'       => 'pink',
            'label'       => 'pink',
            'src'         => ''
          ),
          array(
            'value'       => 'red',
            'label'       => 'red',
            'src'         => ''
          ),
          array(
            'value'       => 'yellow',
            'label'       => 'yellow',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'custom_logo',
        'label'       => 'Custom Logo',
        'desc'        => 'Upload a logo for your theme, or specify the image address of your online logo. (http://yoursite.com/logo.png)',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'custom_favicon',
        'label'       => 'Custom Favicon',
        'desc'        => 'Upload a 16px x 16px Png/Gif image that will represent your website\'s favicon.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'call_us',
        'label'       => 'Call us',
        'desc'        => 'Enter Call us text',
        'std'         => '99999999',
        'type'        => 'text',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'tag_line',
        'label'       => 'Tag line',
        'desc'        => 'Enter Logo Tag line',
        'std'         => 'Responsive wordpress template',
        'type'        => 'text',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'footer_textlines',
        'label'       => 'Footer textlines',
        'desc'        => 'Enter your preferred footer text for your theme.',
        'std'         => ' Copyright 2013 by mojoomla.com',
        'type'        => 'text',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'meta_description',
        'label'       => 'Meta Description',
        'desc'        => 'Site meta description content',
        'std'         => 'Meta Description',
        'type'        => 'textarea-simple',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'meta_keywords',
        'label'       => 'Meta Keywords',
        'desc'        => 'Site meta keywords content.',
        'std'         => 'Meta Keywords',
        'type'        => 'text',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'footer_two_title',
        'label'       => 'Footer 3rd Position',
        'desc'        => 'Enter your preferred footer two title for your theme.',
        'std'         => 'Get in touch',
        'type'        => 'text',
        'section'     => 'footer_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'footer_two_desc',
        'label'       => 'Footer 3rd Position Desc',
        'desc'        => 'Enter your preferred footer two desc for your theme.',
        'std'         => '<div class="address"><span class="small">3rd Avenue, New York <br>Find Us On Map</span></div>      				<div class="mail"><span class="small">Email Us At:<br>   <a href="mailto:support@domain.com">support@domain.com</a></span></div>  					<div class="phone"><span class="small">24/7 Phone Support:<br> +1 (888) 888 8888</span></div>  					<div class="skype"><span class="small">Talk to Us:<br> dasinfo2</span></div>',
        'type'        => 'textarea-simple',
        'section'     => 'footer_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'footer_last_title',
        'label'       => 'Footer 4th Position',
        'desc'        => 'Footer last title',
        'std'         => 'Support',
        'type'        => 'text',
        'section'     => 'footer_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'footer_last_desc',
        'label'       => 'Footer 4th Position desc',
        'desc'        => 'Footer last picture upload',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'footer_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'tagline',
        'label'       => 'Tagline',
        'desc'        => 'Tag line of homepage',
        'std'         => 'FREE SHIPPING',
        'type'        => 'text',
        'section'     => 'woocommerce',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'tagline_description',
        'label'       => 'Tagline Description',
        'desc'        => 'Tag line description of homepage',
        'std'         => 'On Orders Over $599. This Offer is valid on all our Store Items.',
        'type'        => 'text',
        'section'     => 'woocommerce',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'home_product_display',
        'label'       => 'Home Product display',
        'desc'        => 'Number of product want to display on home page',
        'std'         => '6',
        'type'        => 'text',
        'section'     => 'woocommerce',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'firtst_tab_name',
        'label'       => 'Firtst Tab name',
        'desc'        => 'first tab name.',
        'std'         => 'Featured',
        'type'        => 'text',
        'section'     => 'woocommerce',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'second_tab_name',
        'label'       => 'Second tab name',
        'desc'        => 'second tab name.',
        'std'         => 'Latest',
        'type'        => 'text',
        'section'     => 'woocommerce',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      )
    )
  );
  
  /* allow settings to be filtered before saving */
  $custom_settings = apply_filters( 'option_tree_settings_args', $custom_settings );
  
  /* settings are not the same update the DB */
  if ( $saved_settings !== $custom_settings ) {
    update_option( 'option_tree_settings', $custom_settings ); 
  }
  
}