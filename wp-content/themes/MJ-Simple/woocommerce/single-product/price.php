<?php
/**
 * Single Product Price, including microdata for SEO
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $post, $product;
?>

<?php 

if( is_user_logged_in() ) {
if (!current_user_can('niezweryfikowany')) {
    echo '<p class="price" style="color:#ffffff; background-color:#19440e;">';
	echo get_post_meta($post->ID, 'Cena jednej sztuki', true);
	echo '</p>'; 
	echo'';
	echo'<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">';
	echo'<p itemprop="price" class="price">' ;
  echo $product->get_price_html(); 
  echo'<span style="font-size:13px;">(netto)</span></p>' ;
  
}
else {
    echo ' ';   
    echo '<div itemprop="offers" itemscope itemtype="http://schema.org/Offer"> ';
} }

else {
    echo ' ';   
    echo '<div itemprop="offers" itemscope itemtype="http://schema.org/Offer"> ';
}?>

 


 
	<?php 
	/* $produkt2 = $product->get_price_html();
	 $ciag = substr($produkt2, 58, 5);
	 $ciag2 = $ciag;
	 $tablica = explode(",", $ciag);
	 $dana = $tablica[0]*1000;
	 $dana2 = $tablica[1];
	 $pln = $dana+$dana2;
	 $euro = $pln/4.20;
	 $wynik = round($euro,2);
	  echo '<br>Od: '.$wynik.' EURO';*/

	?>


	<link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />

</div>