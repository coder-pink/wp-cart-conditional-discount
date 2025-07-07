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

// Apply the discount using WooCommerce cart filters
add_action('woocommerce_cart_calculate_fees', 'ccd_apply_accessories_discount', 20, 1);

function ccd_apply_accessories_discount($cart) {
    if (is_admin() && !defined('DOING_AJAX')) {
        return;
    }

    // Ensure cart is not empty
    if (0 === count($cart->get_cart())) {
        return;
    }

    $has_accessories = false;
    $accessories_category_slug = 'accessories'; // Adjust the category slug if needed

    // Check for Accessories category in cart
    foreach ($cart->get_cart() as $cart_item) {
        $product = $cart_item['data'];
        if (has_term($accessories_category_slug, 'product_cat', $product->get_id())) {
            $has_accessories = true;
            break;
        }
    }

    // Get cart subtotal (before tax & discounts)
    $cart_subtotal = $cart->get_subtotal();

    // Apply discount if both conditions are met
    if ($has_accessories && $cart_subtotal >= 2000) {
        $discount = -($cart_subtotal * 0.15); // 15% discount
        $cart->add_fee(__('Accessories Discount', 'woo-cart-conditional-discount'), $discount, false);
    }
}

// Add a message on the cart page
add_action('woocommerce_before_cart', function () {
    if (is_admin() && !defined('DOING_AJAX')) {
        return;
    }

    WC()->cart->calculate_totals(); // Ensure cart totals are up to date

    $cart = WC()->cart;
    $has_accessories = false;
    $accessories_category_slug = 'accessories';

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
});
