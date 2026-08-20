<?php

/**
 * Plugin Name: woocommerce whatsapp message
 * Plugin URI: https://whatsappMessenger.com
 * Description: A simple WooCommerce plugin that send the order details on whatsapp
 * Version: 1.0
 * Author: Huzaifa
 * Author URI:
 * Text Domain: woocommerce-whatsapp-message
 */



require_once plugin_dir_path(__FILE__) . 'admin/settings.php';
require_once plugin_dir_path(__FILE__) . 'includes/features/popups/cart_shipping_info_popup.php';



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

/**
 * Add custom links (e.g., Settings) on the Plugins list page
 *
 * @param array $links Existing plugin action links (Deactivate, Edit, etc.)
 * @return array Modified array with Settings link
 */
function wcwm_add_action_links(array $links)
{

    $settings_url = admin_url('admin.php?page=wc-settings&tab=wcwm_settings');
    $settings_link = sprintf(
        '<a href="%s">%s</a>',
        esc_url($settings_url),
        __('Settings', 'woocommerce-whatsapp-message'),
    );

    array_unshift($links, $settings_link);

    return $links;
}


add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'wcwm_add_action_links');



function wcwm_add_button_after_add_to_cart()
{
    if (!wcwm_is_woocommerce_active() || !is_product()) {
        return;
    }

    $product_id = get_the_ID();

    $product = wc_get_product($product_id);

    $wcwm_locations = get_option('wcwm_locations', []);

    if (!array($wcwm_locations)) {
        return;
    }

    if (($wcwm_locations['detail'] ?? 'no') === 'yes') {

?>

        <button
            type="button"
            class="wcwm-button button"
            data-product-name="<?php echo esc_attr($product->get_name()); ?>"
            data-product-price="<?php echo esc_attr($product->get_price()); ?>"
            data-product-sku="<?php echo esc_attr($product->get_sku()); ?>"
            data-product-url="<?php echo esc_url(get_permalink($product->get_id())); ?>"
            data-admin-phone-number="<?php echo esc_attr(get_option('wcwm_admin_phone_number')); ?>">
            Send to WhatsApp
        </button>

        <div id="wcwm-message" style="margin-top:10px;"></div>
    <?php

    }
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

    $wcwm_locations = get_option('wcwm_locations', []);

    if (!array($wcwm_locations)) {
        return;
    }

    if (($wcwm_locations['list'] ?? 'no') === 'yes') {

    ?>

        <button
            type="button"
            class="wcwm-button button"
            data-product-name="<?php echo esc_attr($product->get_name()); ?>"
            data-product-price="<?php echo esc_attr($product->get_price()); ?>"
            data-product-sku="<?php echo esc_attr($product->get_sku()); ?>"
            data-product-url="<?php echo esc_url(get_permalink($product->get_id())); ?>"
            data-admin-phone-number="<?php echo esc_attr(get_option('wcwm_admin_phone_number')); ?>">
            Send to WhatsApp
        </button>

        <div id="wcwm-message" style="margin-top:10px;"></div>
    <?php
    }
}

add_action('woocommerce_after_shop_loop_item', 'wcwm_add_button_after_product_card');


function wcwm_add_button_after_checkout()
{

    if (! wcwm_is_woocommerce_active()) {
        return;
    }

    $wcwm_locations = get_option('wcwm_locations', []);

    if (!array($wcwm_locations)) {
        return;
    }

    if (($wcwm_locations['checkout'] ?? 'no') === 'yes') {


    ?>

        <div style="margin-top:10px;">
            <button
                type="submit"
                class="wcwm-checkout-button button"
                style="margin-top: 10px;">
                <!-- name="custom-order" -->


                <!-- data-cart="<?php wc()->cart->get_cart() ?>" -->
                <!-- data-cart-total="<?php wc()->cart->get_cart_total() ?>" -->
                <!-- data-cart-subtotal="<?php wc()->cart->get_cart_subtotal() ?>" -->


                CheckOut using WhatsApp</button>
        </div>


    <?php
    }
}

add_action("woocommerce_review_order_after_submit", "wcwm_add_button_after_checkout");


function wcwm_add_button_after_cart_totals()
{
    if (!wcwm_is_woocommerce_active()) {
        return;
    }

    $wcwm_locations = get_option('wcwm_locations', []);

    if (!array($wcwm_locations)) {
        return;
    }

    if (($wcwm_locations['cart'] ?? 'no') === 'yes') {

    ?>

        <button
            type="button"
            class="wcwm-act-button button"
            style="
            padding-left: 1em;
            font-size: 1.1em;
            line-height :1.8em;
            display:block
            ">
            Send to WhatsApp
        </button>
<?php
    }
}

add_action("woocommerce_after_cart_totals", "wcwm_add_button_after_cart_totals");

function wcwm_order_data($order_id)
{

    if (isset($_POST['custom-order'])) {

        $order = wc_get_order($order_id);


        $billing_name = $order->get_billing_first_name() . '' . $order->get_billing_last_name();
        $billing_email = $order->get_billing_email();


        // order data

        $items_data = [];

        foreach ($order->get_items() as $item) {
            $items_data[] = [
                'name' => $item->get_name(),
                'quantity' => $item->get_quantity(),
                // 'total' => $item->get_total(),

            ];
        }

        $total = $order->get_total();

        wc()->session->set('wcwm_order_data', [
            'order_id' => $order_id,
            'billing_name' => $billing_name,
            'billing_email' => $billing_email,
            'items' => $items_data,
            'total' => $total,
        ]);
    }
}

// add_action("woocommerce_checkout_order_processed", "wcwm_order_data");










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



function wcwm_localize_cart_data()
{
    // if (!is_checkout()) {
    //     return;
    // }

    if (wc()->cart->is_empty()) {
        return;
    }

    $admin_phone_number = get_option('wcwm_admin_phone_number');

    if (empty($admin_phone_number)) {
        return;
    }


    $cart_items = [];


    foreach (wc()->cart->get_cart() as $cart_item) {
        $product = $cart_item['data'];


        $cart_items[] = [
            'name' => $product->get_name(),
            'price' => $product->get_price(),
            'quantity' => $cart_item['quantity'],
            'subtotal' => $cart_item['line_total'],
            'tax' => $cart_item['line_tax'],
            'sku' => $product->get_sku(),
            'url' => get_permalink($product->get_id()),
        ];
    }

    wp_localize_script(
        'wcwm-js',
        'wcwm_cart_data',
        [
            'items' => $cart_items,
            'total' => WC()->cart->get_total('edit'),
            'currency' => get_woocommerce_currency_symbol(),
            'admin_phone_number' => $admin_phone_number,
        ]

    );
}

add_action("wp_enqueue_scripts", "wcwm_localize_cart_data");

function wcwm_localize_order_data()
{

    $data = wc()->session->get('wcwm_order_data');

    if (!$data) {
        return;
    }

    wp_localize_script(
        'wcwm-js',
        'wcwm_order',
        $data

    );
}

add_action("wp_enqueue_scripts", "wcwm_localize_order_data");


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
