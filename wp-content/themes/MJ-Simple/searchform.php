<?php
/**
 * The template for displaying search forms in mj simple
 *
 * @package Mj-simple
 */
?>

<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
  <label for="s" class="assistive-text">
  <?php _e( 'Search', 'woocommerce' ); ?>
  </label>
  <input type="text" class="field" name="s" id="s" placeholder="<?php _e( 'Search', 'woocommerce' ); ?>" />
  <input type="submit" class="submit" name="submit" id="searchsubmit" value="<?php _e( 'Search', 'woocommerce' ); ?>" />
</form>
