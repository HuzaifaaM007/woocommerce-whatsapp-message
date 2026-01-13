<?php

/**
 * Plugin Name: woocommerce whatsapp message
 * Plugin URI: https://example.com
 * Description: A simple WooCommerce plugin that send the order details on whatsapp
 * Version: 1.0
 * Author: Huzaifa
//  * Author URI: https://example.com
 * Text Domain: woocommerce-whatsapp-message
 */

// if accessed directly exit
if (!defined('ABSPATH')) {
    exit;
}

function wcwm_is_woocommerce_active()
{
    return class_exists('WooCommerce');
}


function wcwm_wc_missing_notice()
{
    if (!wcwm_is_woocommerce_active()) {
        echo '<div class="notice notice-error" >
        <p><strong> first woocomerce plugin Message : </strong> requires Woo Commerce to be active </p>
            </div>';
    }
}

add_action('admin_notices', 'wcwm_wc_missing_notice');


function wcwm_add_button_after_add_to_cart()
{
    if (!wcwm_is_woocommerce_active() || !is_product()) {
        return;
    }

    $product_id = get_the_ID();

    $product = wc_get_product($product_id);

?>

    <button
        type="button"
        class="wcwm-button button"
        data-product-name="<?php echo esc_attr($product->get_name()); ?>"
        data-product-price="<?php echo esc_attr($product->get_price()); ?>"
        data-product-sku="<?php echo esc_attr($product->get_sku()); ?>"
        data-product-url="<?php echo esc_url(get_permalink($product->get_id())); ?>">
        Send to WhatsApp
    </button>

    <div id="wcwm-message" style="margin-top:10px;"></div>
<?php
}

add_action('woocommerce_after_add_to_cart_button', 'wcwm_add_button_after_add_to_cart');

function wcwm_add_button_after_product_card()
{

    if (!wcwm_is_woocommerce_active()) {
        return;
    }

    $product = wc_get_product(get_the_ID());

    if (!$product) {
        return;
    }

?>

    <button
        type="button"
        class="wcwm-button button"
        data-product-name="<?php echo esc_attr($product->get_name()); ?>"
        data-product-price="<?php echo esc_attr($product->get_price()); ?>"
        data-product-sku="<?php echo esc_attr($product->get_sku()); ?>"
        data-product-url="<?php echo esc_url(get_permalink($product->get_id())); ?>">
        Send to WhatsApp
    </button>

    <div id="wcwm-message" style="margin-top:10px;"></div>
<?php

}

add_action('woocommerce_after_shop_loop_item', 'wcwm_add_button_after_product_card');

function wcwm_enqueue_scripts()
{
    // if (! is_product()) {
    //     return;
    // }

    wp_enqueue_script(
        'wcwm-js',
        plugin_dir_url(__FILE__) . 'wcwm.js',
        array('jquery'),
        '1.0',
        true

    );
}

add_action('wp_enqueue_scripts', 'wcwm_enqueue_scripts');


// used for single product not usable for loop products


// function wcwm_localize_scripts()
// {
//     // if (!is_product()) {
//     //     return;
//     // }

//     // global $product;

    // $product_id = get_the_ID();

    // $product = wc_get_product($product_id);

//     // if (! is_a($product, 'WC_Product')) return; // Ensure $product is object

//     if (!$product) {
//         return;
//     }


//     wp_localize_script(
//         'wcwm-js',
//         'wcwm_products_data',
//         array(
//             'name' => $product->get_name(),
//             'price' => $product->get_price(),
//             'sku' => $product->get_sku(),
//             'url' => get_permalink($product->get_id()),
//             'phone' => '+923149313252'

//         )

//     );
// }

// add_action('wp_enqueue_scripts', 'wcwm_localize_scripts');
