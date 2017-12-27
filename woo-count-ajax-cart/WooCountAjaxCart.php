<?php
/*
Plugin Name: Woo Count Ajax Cart
Plugin URI: https://www.example.com
Description: Woo Ajax Cart Count plugin allow you to show cart total any where in website, by simply place a shortcode.
Author: Webskitters
Version: 1.1
*/

# WOOCOMMERCE CART TOTAL
add_filter('add_to_cart_fragments', 'WoocommerceCounAjaxCartCount');
function WoocommerceCounAjaxCartCount( $fragments ) {
global $woocommerce;
$imageUrl = plugins_url( 'img/cart.png', __FILE__);

ob_start();
?>
<a class="cart-contents" href="<?php echo wc_get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>"><img src="<?php echo $imageUrl;?>" style="height: 22px;width: 28px;float: left;margin-left: 15px;margin-top: -5px;"><?php echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?>&nbsp;</a>
<?php
$fragments['a.cart-contents'] = ob_get_clean();
return $fragments;
}
add_shortcode( 'WooCounAjaxCartCount','WooCounAjaxCartCount' );
function WooCounAjaxCartCount( $cart_total ){
global $woocommerce;

$cart_total = '<p class="cartcounter"><a class="cart-contents" href="'.$woocommerce->cart->get_cart_url().'" title="View your shopping cart">'.sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count).'&nbsp;</a></p>';
return $cart_total;
}

?>