<?php
/**
 * Plugin Name: WooCommerce Cart Conditional Discount
 * Description: Applies a 15% discount when cart contains Accessories category items and total >= ₹2000.
 * Version: 1.0
 * Author: Pinky
 * License: GPL2+
 */

if (!defined('ABSPATH')) {
    exit;
}


add_action('plugins_loaded', function () {
    if (!class_exists('WooCommerce')) {
        add_action('admin_notices', function () {
            echo '<div class="error"><p><strong>WooCommerce Cart Conditional Discount:</strong> WooCommerce is not active. Please activate WooCommerce to use this plugin.</p></div>';
        });
        return;
    }

    
    add_action('woocommerce_cart_calculate_fees', 'ccd_apply_accessories_discount', 20, 1);
    add_action('woocommerce_before_cart', 'ccd_show_discount_message');
});


function ccd_apply_accessories_discount($cart) {
    if (is_admin() && !defined('DOING_AJAX')) {
        return;
    }

    if ($cart->is_empty()) {
        return;
    }

    $accessories_category_slug = 'accessories';
    $has_accessories = false;

    foreach ($cart->get_cart() as $cart_item) {
        $product = $cart_item['data'];
        if (has_term($accessories_category_slug, 'product_cat', $product->get_id())) {
            $has_accessories = true;
            break;
        }
    }

    $cart_subtotal = $cart->get_subtotal();

    if ($has_accessories && $cart_subtotal >= 2000) {
        $discount = -($cart_subtotal * 0.15);
        $cart->add_fee(__('Accessories Discount', 'woo-cart-conditional-discount'), $discount, false);
    }
}


function ccd_show_discount_message() {
    if (is_admin() && !defined('DOING_AJAX')) {
        return;
    }

    $cart = WC()->cart;
    if (!$cart) {
        return;
    }

    $accessories_category_slug = 'accessories';
    $has_accessories = false;

    foreach ($cart->get_cart() as $cart_item) {
        $product = $cart_item['data'];
        if (has_term($accessories_category_slug, 'product_cat', $product->get_id())) {
            $has_accessories = true;
            break;
        }
    }

    if ($has_accessories && $cart->get_subtotal() >= 2000) {
        echo '<div class="woocommerce-message">You’ve received a 15% Accessories Discount!</div>';
    }
}
