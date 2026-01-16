<?php

if (!defined('ABSPATH')) {
    exit;
}




add_action("woocommerce_before_cart_totals", "wcwm_cart_shipping_info_popup", 5);
add_action("wp_enqueue_scripts", "wcwm_enqueue_style_assets");
add_action("wp_enqueue_scripts","wcwm_enqueue_popups_scripts");

function wcwm_enqueue_style_assets()
{
    wp_enqueue_style(
        'wcwm-cart-ship-popup-css',
        plugin_dir_url(__FILE__) . 'popups.css',
        array(),
        '1.0.0'
    );
}

function wcwm_enqueue_popups_scripts(){
    wp_enqueue_script(
        'wcwm-cart-ship-popup-js',
        plugin_dir_url(__FILE__). 'popups.js',
        array('jquery'),
        '1.0.0',
        true
    );
}



function wcwm_cart_shipping_info_popup()
{

    if (!WC()->cart || WC()->cart->is_empty()) {
        return;
    }

    $customer = WC()->customer;
    if (!$customer) {
        return;
    }

    $customer_html = '<p><strong>Customer Information:</strong></p>';
    $customer_html .= '<p>Name: ' . esc_html($customer->get_billing_first_name() . ' ' . $customer->get_billing_last_name()) . '</p>';
    $customer_html .= '<p>Email: ' . esc_html($customer->get_billing_email()) . '</p>';
    $customer_html .= '<p>Phone: ' . esc_html($customer->get_billing_phone()) . '</p>';


    $packages = WC()->shipping()->get_packages();
    $shipping_html = '<h4>Available Shipping Methods:</h4>';

    foreach ($packages as $package) {
        if (isset($package['rates'])) {
            foreach ($package['rates'] as $rate) {
                $shipping_html .= '<p>'
                    . esc_html($rate->get_label())
                    . '-'
                    . wc_price($rate->get_cost())
                    . '</p>';
            }
        }
    }




    wc_add_notice(
        '<div id="wcwm-shipping-info-popup">
        <h3>Shipping Information</h3>
        ' . $customer_html . '
        ' . $shipping_html . '
        <button id="wcwm-popup-button"> OK </button>
        </div>
        ',
        'notice'

    );
}
