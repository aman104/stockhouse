<?php
/**
 * Grouped product add to cart
 *
 * actual version 2.1.0
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     5.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $product, $post;

?>

<?php do_action('woocommerce_before_add_to_cart_form'); ?>

<form class="cart" method="post" enctype='multipart/form-data'>
	<ul class="grouped-products">
		<?php foreach ( $grouped_products as $product_id ) : 
			$product = get_product( $product_id );
			$post    = $product->post;
			setup_postdata( $post );			
		?>
			<li class="row">
				<div class="<?php echo sp_column_css( '', '', '', '12' ); ?>">
					<label for="product-<?php echo $product_id; ?>">
						<?php echo $product->is_visible() ? '<a href="' . get_permalink() . '">' . get_the_title() . '</a>' : get_the_title(); ?>
					</label><br />

					<?php do_action ( 'woocommerce_grouped_product_list_before_price', $product ); ?>

					<div class="price-wrap">

					<?php
						echo $product->get_price_html();

						if ( ( $availability = $product->get_availability() ) && $availability['availability'] )
							echo apply_filters( 'woocommerce_stock_html', '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p>', $availability['availability'] );
					?>
					</div><!--close .price-wrap-->
					<br />
					
					<?php if ( $product->is_sold_individually() || ! $product->is_purchasable() ) : ?>
						<?php woocommerce_template_loop_add_to_cart(); ?>
					<?php else : ?>
						
					<?php endif; ?>

				</div><!--close .column-->

			</li>
		<?php endforeach; 
			wp_reset_postdata();
			$product = get_product( $post->ID );
		?>
	</ul>
	
	<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->id ); ?>" />
	
	<?php if ( $quantites_required ) : ?>

		<?php do_action('woocommerce_before_add_to_cart_button'); ?>

		<button type="submit" class="single_add_to_cart_button button alt"><?php echo $product->single_add_to_cart_text(); ?></button>

		<?php do_action('woocommerce_after_add_to_cart_button'); ?>

	<?php endif; ?>

</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>