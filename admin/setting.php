<?php

if (!defined('ABSPATH')) {
    exit;
}


add_filter("woocommerce_general_settings","wcwm_add_admin_phone_number");


function wcwm_add_admin_phone_number($settings){

    $custom_settings = array(
        array(
            'title' => __('WooCommerce_WhatsApp_Message','woocommerce'),
            'type' => 'title',
            'id' => 'wcwm_setting_title'
        ),

        array(
            'title' => __('Admin WhatsApp Number','woocommerce'),
            'desc' => __('Enter WhatsApp number in international format. e.g., +923112345678','woocommerce'),
            'id' => 'wcwm_admin_phone_number',  
            'type' => 'text',
            'default' => '',
            'desc_tip' => true,

        ),

        array(
            'title' => __('WhatsApp_in_Details_page','woocommerce'),
            'desc'=> __('Check it if you want to show the whatsapp opiton in product details page'),
            'id' => 'wcwm_locations[detail]',
            'type' => 'checkbox',
            'default' => 'yes',

        ),

                array(
            'title' => __('WhatsApp_in_product_list_page','woocommerce'),
            'desc'=> __('Check it if you want to show the whatsapp opiton in product list page'),
            'id' => 'wcwm_locations[list]',
            'type' => 'checkbox',
            'default' => 'yes',

        ),

                array(
            'title' => __('WhatsApp_in_checkout_page','woocommerce'),
            'desc'=> __('Check it if you want to show the whatsapp option in checkout page'),
            'id' => 'wcwm_locations[checkout]',
            'type' => 'checkbox',
            'default' => 'yes',

        ),

        array(
            'type' => 'sectionend',
            'id' => 'wcwm_setting_end'
        )
    );
 
    return array_merge($settings, $custom_settings);


}

?>