# WooCommerce Cart Conditional Discount

**Contributors:** Pinky  
**Tags:** WooCommerce, Cart, Discount, Conditional Discount  
**Requires at least:** 6.0  
**Tested up to:** 6.5  
**Stable tag:** 1.0  
**License:** GPLv2 or later  

## Description

This mini WooCommerce plugin automatically applies a **15% discount** to the cart **if**:
- The cart contains at least one product from the **"Accessories"** category.
- The cart subtotal is **₹2000 or more**.

The discount is applied as a **negative fee**, not as a traditional WooCommerce coupon.

## Installation

1. Upload the `woo-cart-conditional-discount` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the WordPress admin dashboard.
3. Ensure your product category slug is `accessories`. (Adjust it in the plugin code if it's different.)
4. Test the discount on your cart page.

## Assumptions

- The target category slug is `accessories`.
- Discount is applied as a **fee** (negative amount), not as a coupon.
- Plugin is **compatible** with other discounts or coupons.
- The ₹2000 check is based on the **cart subtotal**, excluding taxes and existing discounts.

## Changelog

### 1.0
- Initial release.

