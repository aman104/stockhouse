<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package Mj-simple
 */
 global	$wptuts_option;
?>
</div>
<!-- #main -->

<div id="mj-footer">
  <div class="mj-subcontainer">
    <div class="moduletable mj-grid24 mj-dotted">
      <?php dynamic_sidebar('Latest Products footer');?>
    </div>
    <div class="moduletable  mj-grid24 mj-dotted">
      <h3><?php _e( 'INFORMATION', 'woocommerce'); ?></h3>
      <div class="menu">
        <?php //wp_nav_menu( array('menu' => 'top Menu' , 'menu_class'=> 'nav' )); ?>
        
        <?php wp_nav_menu( array( 'theme_location' => 'footer'  , 'menu_class'=> 'nav' )); ?>
        
        
        
      </div>
    </div>
    <div class="moduletable mj-grid24 mj-dotted">
      <h3><?php _e( 'CONTACT DETAILS', 'woocommerce'); ?></h3>
      <?php echo ot_get_option("footer_two_desc","Enter description from admin side theme options."); ?> </div>
    <div class="moduletable mj-grid24 mj-dotted">
      <h3><?php _e( 'PAYMENTS', 'woocommerce'); ?></h3>
      <div id="mj-payment"> <img class="png" src="<?php echo ot_get_option("footer_last_desc",get_template_directory_uri().'/images/support.png'); ?> " alt="payment-cards" /> </div>
    </div>
  </div>
</div>
<div id="mj-copyright">
  <div class="mj-subcontainer">
    <div class="mj-grid80 copyright">
      <p><?php echo ot_get_option("footer_textlines","&copy; Copyright 2013 by mojoomla.com"); ?></p>
      <p style="font-size:10px;">Wszystkie znaki towarowe i nazwy zastrzeżone zostały użyte tylko w celach informacyjnych i należą do ich właścicieli. Firma Stockhouse nie jest oficjalnym przedstawicielem wymienionych na stronie marek i producentów.</p>
    </div>
    <div class="custom mj-grid16">
      <p><a id="w2b-StoTop" class="top" style="display: block; ">Back to Top</a></p>
    </div>
  </div>
</div>




<?php wp_footer(); ?>
<script type='text/javascript'>
var _glc =_glc || []; _glc.push('all_ag9zfmNsaWNrZGVza2NoYXRyDgsSBXVzZXJzGILD9g4M');
var glcpath = (('https:' == document.location.protocol) ? 'https://my.clickdesk.com/clickdesk-ui/browser/' : 
'http://my.clickdesk.com/clickdesk-ui/browser/');
var glcp = (('https:' == document.location.protocol) ? 'https://' : 'http://');
var glcspt = document.createElement('script'); glcspt.type = 'text/javascript'; 
glcspt.async = true; glcspt.src = glcpath + 'livechat-new.js';
var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(glcspt, s);
</script>
</body></html>