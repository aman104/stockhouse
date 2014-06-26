
<?php get_header(); ?>

<div id="mj-slideshow">
  <div class="mj-subcontainer">
    <div class="sp-slideshow">
      <input id="button-1" type="radio" name="radio-set" class="sp-selector-1" checked="checked" />
      <label for="button-1" class="button-label-1"></label>
      <input id="button-2" type="radio" name="radio-set" class="sp-selector-2" />
      <label for="button-2" class="button-label-2"></label>
      <input id="button-3" type="radio" name="radio-set" class="sp-selector-3" />
      <label for="button-3" class="button-label-3"></label>
      <input id="button-4" type="radio" name="radio-set" class="sp-selector-4" />
      <label for="button-4" class="button-label-4"></label>
      <input id="button-5" type="radio" name="radio-set" class="sp-selector-5" />
      <label for="button-5" class="button-label-5"></label>
      <label for="button-1" class="sp-arrow sp-a1"></label>
      <label for="button-2" class="sp-arrow sp-a2"></label>
      <label for="button-3" class="sp-arrow sp-a3"></label>
      <label for="button-4" class="sp-arrow sp-a4"></label>
      <label for="button-5" class="sp-arrow sp-a5"></label>
      <div class="sp-content">
        <div class="sp-parallax-bg"></div>
        <ul class="sp-slider clearfix">
          <?php 
	$my_query = new WP_Query( array(
	'post_status' => 'publish',
	'post_type' => 'product',
	'product_cat' => 'slideshow',
	'posts_per_page' => '5'
	) );

if ($my_query ->have_posts()) : while ($my_query ->have_posts()) : $my_query ->the_post();
?>
          <li>
            <h1 class="slititle"><a href="<?php echo get_permalink( $my_query->post->ID ) ?>" title="<?php echo esc_attr($my_query->post->post_title ? $my_query->post->post_title : $my_query->post->ID); ?>">
              <?php the_title(); ?>
              </a></h1>
            <div class="txtcontent">
              <p><?php echo substr(strip_tags($post->post_content), 0,80);?></p>
              <div class="slicat a-btn"> <a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>"><span class="a-btn-text"><?php _e( 'Buy now!', 'woocommerce' ); ?></span></a> <a href="<?php echo get_permalink( $my_query->post->ID ) ?>" title="<?php echo esc_attr($my_query->post->post_title ? $my_query->post->post_title : $my_query->post->ID); ?>"><span class="a-btn-slide-text"><?php _e( 'DETAILS', 'woocommerce' ); ?></span></a> <span class="a-btn-icon-right"><span></span></span> </div>
             
             <?php if ( is_user_logged_in() ) {
    echo '<div class="price-tag"><span class="tag">';
    _e( 'PROMOTION', 'woocommerce');
    echo '</span><br />';
	echo $product->get_price_html(); 
	echo '</div>';
} else {
    echo '<div class="price-tag"><span class="tag">';
    _e( 'GOOD PRICE', 'woocommerce' );
    echo '</span></div>';
}?>
             
              <!--<div class="price-tag"><span class="tag">PROMOCJA</span><br />
                <?php /*echo $product->get_price_html();*/ ?></div> -->
            </div>
            <div class="dm" >
              <?php if ( has_post_thumbnail() ) : ?>
              <a href="<?php echo get_permalink( $my_query->post->ID ) ?>" title="<?php echo esc_attr($my_query->post->post_title ? $my_query->post->post_title : $my_query->post->ID); ?>"><?php echo the_post_thumbnail( $post->ID) ?></a>
              <?php else : ?>
              <img src="<?php echo woocommerce_placeholder_img_src(); ?>" alt="Placeholder" />
              <?php endif; ?>
              <?php do_action('woocommerce_product_thumbnails'); ?>
            </div>
          </li>
          <?php
endwhile;
endif;
?>
        </ul>
      </div>
      <!-- sp-content -->
    </div>
  </div>
</div>
<div id="mj-maincontent">
  <div class="mj-subcontainer">
    <div class="mj-full breadcrumb"> </div>
    <div class="mj-grid96">
      <div class="mj-full buytext">
        <?php $a= ot_get_option("home_product_display","6"); ?>
        <span class="mj-grid16"><?php _e( 'SPECIAL OFFER', 'woocommerce' ); ?></span>
        <p class="mj-grid80"><?php _e( 'Recent tip collection!', 'woocommerce' ); ?></p>
        <!--<span class="mj-grid16"><?php /*echo ot_get_option("tagline","FREE SHIPPING");*/ ?></span>
        <p class="mj-grid80"><?php /*echo ot_get_option("tagline_description","On Orders Over $599. This Offer is valid on all our Store Items.");*/ ?></p>-->
      </div>
    </div>
    <table class="mj-grid96">
      <tr id="shopping_items">
        <td  id="mj-contentareas" class="mj-grid64 mj-lspace"><div id="example-one" class="mj-grid96">
            <ul class="nav">
              <li class="nav-one"><a href="#featured" class="current"><?php _e( 'Featured Products', 'woocommerce' ); ?></a></li>
              <li class="nav-two"><a href="#core"><?php _e( 'Recently Added', 'woocommerce' ); ?></a></li>
            </ul>
            <div class="list-wrap">
              <ul id="featured">
                <li class="mj-grid96 tit"><?php _e( 'Featured Products', 'woocommerce' ); ?></li>
                <?php   $args = array( 'post_type' => 'product','posts_per_page' =>  $a ,'meta_key' => '_featured',
'meta_value' => 'yes',  'orderby' => 'rand' );
        $loop = new WP_Query( $args );
        while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
                <li class="mj-grid32 homepro">
                  <div class="productlisting">
                    <?php woocommerce_show_product_sale_flash( $post, $product ); ?>
                    <a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">
                    <p class="imagpart images">
                      <?php if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID,medium ); else echo '<img src="'.woocommerce_placeholder_img_src().'" width="300px" height="300px"  alt= " the_title()" />'; ?>
                    </p>
                    </a>
                    <h3 class="imagpart">
                      <?php the_title(); ?>
                    </h3>
                    <h4 class="imagpart"><?php echo substr(strip_tags($post->post_content), 0, 50);?></h4>
                    <div class="priceadd"> <span class="price imagpart"><?php echo $product->get_price_html(); ?></span>
                      <?php woocommerce_template_loop_add_to_cart( $loop->post, $product ); ?>
                    </div>
                  </div>
                </li>
                <?php endwhile; ?>
                <?php wp_reset_query(); ?>
              </ul>
              <ul id="core" class="hide">
                <li class="mj-grid96 tit"><?php _e( 'Recently Added', 'woocommerce' ); ?></li>
                <?php   $args = array( 'post_type' => 'product','posts_per_page' =>  $a ,  'orderby' => 'latest' );
        $loop = new WP_Query( $args );
        while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
                <li class="mj-grid32 homepro">
                  <div class="productlisting">
                    <?php woocommerce_show_product_sale_flash( $post, $product ); ?>
                    <a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">
                    <p class="imagpart images">
                      <?php if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID,medium); else echo '<img src="'.woocommerce_placeholder_img_src().'" alt="Placeholder" width="300px" height="300px" alt= " the_title()" />'; ?>
                    </p>
                    </a>
                    <h3 class="imagpart">
                      <?php the_title(); ?>
                    </h3>
                    <h4 class="imagpart"><?php echo substr(strip_tags($post->post_content), 0, 50);?></h4>
                    <div class="priceadd"> <span class="price imagpart"><?php echo $product->get_price_html(); ?></span>
                      <?php woocommerce_template_loop_add_to_cart( $loop->post, $product ); ?>
                    </div>
                  </div>
                </li>
                <?php endwhile; ?>
                <?php wp_reset_query(); ?>
              </ul>

            </div>
            <!-- END List Wrap -->
          </div></td>
        <td id="mj-left" class="mj-grid16 mj-lspace"><?php dynamic_sidebar('Home left sidebar'); ?>
        </td>
        <td id="mj-rights" class="mj-grid16 mj-lspace mj-rspace"><?php dynamic_sidebar('Home right sidebar'); ?>
        </td>
      </tr>
    </table>
    <div class="mj-grid56 brands">
      <h3> </h3>
      <ul>
        <li> <img src="<?php  echo get_template_directory_uri();?>/images/1.jpg" alt=" " /></li>
        <li><img src="<?php echo get_template_directory_uri();?>/images/2.jpg" alt=" " /></li>
        <li><img src="<?php echo get_template_directory_uri(); ?>/images/3.jpg" alt=" " /></li>
        <li><img src="<?php echo get_template_directory_uri(); ?>/images/4.jpg" alt=" " /></li>
        <li><img src="<?php echo get_template_directory_uri(); ?>/images/5.jpg" alt=" " /></li>
        
        <li> <img src="<?php  echo get_template_directory_uri();?>/images/6.jpg" alt=" " /></li>
        <li><img src="<?php echo get_template_directory_uri();?>/images/7.jpg" alt=" " /></li>
        <li><img src="<?php echo get_template_directory_uri(); ?>/images/8.jpg" alt=" " /></li>
        <li><img src="<?php echo get_template_directory_uri(); ?>/images/9.jpg" alt=" " /></li>
        <li><img src="<?php echo get_template_directory_uri(); ?>/images/10.jpg" alt=" " /></li>
        
        <li> <img src="<?php  echo get_template_directory_uri();?>/images/11.jpg" alt=" " /></li>
        <li><img src="<?php echo get_template_directory_uri();?>/images/12.jpg" alt=" " /></li>
        <li><img src="<?php echo get_template_directory_uri(); ?>/images/13.jpg" alt=" " /></li>
        <li><img src="<?php echo get_template_directory_uri(); ?>/images/14.jpg" alt=" " /></li>
        <li><img src="<?php echo get_template_directory_uri(); ?>/images/15.jpg" alt=" " /></li>
        
        <li> <img src="<?php  echo get_template_directory_uri();?>/images/16.jpg" alt=" " /></li>
        <li><img src="<?php echo get_template_directory_uri();?>/images/17.jpg" alt=" " /></li>
        <li><img src="<?php echo get_template_directory_uri(); ?>/images/18.jpg" alt=" " /></li>
        <li><img src="<?php echo get_template_directory_uri(); ?>/images/9.jpg" alt=" " /></li>
        <li><img src="<?php echo get_template_directory_uri(); ?>/images/20.jpg" alt=" " /></li>
        
        <li> <img src="<?php  echo get_template_directory_uri();?>/images/21.jpg" alt=" " /></li>
        <li><img src="<?php echo get_template_directory_uri();?>/images/22.jpg" alt=" " /></li>
        <li><img src="<?php echo get_template_directory_uri(); ?>/images/23.jpg" alt=" " /></li>
        <li><img src="<?php echo get_template_directory_uri(); ?>/images/24.jpg" alt=" " /></li>
        <li><img src="<?php echo get_template_directory_uri(); ?>/images/25.jpg" alt=" " /></li>
      
      </ul>
    </div>
    <div class="mj-grid40 stay">
      <h3><?php _e( 'STAY IN TOUCH', 'woocommerce' ); ?></h3>
      <div class="mj-newsletter"> <a href="<?php home_url(); ?>/" class="mj-newstext">Newsletter</a>
        <p><?php _e( 'We will notify you about new products and supplies', 'woocommerce' ); ?></p>
      </div>
      <div class="mj-storelocator mj-lspace mj-rspace"> <a href="<?php home_url(); ?>/sklep" class="mj-storetext"><?php _e( 'Shop for you', 'woocommerce' ); ?></a>
        <p><?php _e( 'Search of your products!', 'woocommerce' ); ?></p>
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>
