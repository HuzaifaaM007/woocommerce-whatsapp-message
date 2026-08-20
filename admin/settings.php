<?php

if (!defined('ABSPATH')) {
    exit;
}


add_filter("woocommerce_settings_tabs_array", 'wcwm_add_settings_tab', 50);
// add_filter("woocommerce_general_settings", "wcwm_add_admin_phone_number");
add_action("woocommerce_settings_tabs_wcwm_settings", "wcwm_render_settings_tab");
add_action("woocommerce_update_options_wcwm_settings", "wcwm_update_options");


/**
 * filter : woocommerce_settings_tabs_array
 */
function wcwm_add_settings_tab(array $settings_tab)
{
    $settings_tab['wcwm_settings']  = __('WhatsApp Settings', 'woocommerce-whatsapp-message');
    return $settings_tab;
}

/**
 * filter : woocommerce_general_settings
 */
function wcwm_general_settings()
{

    $settings = array(
        array(
            'title' => __('WooCommerce_WhatsApp_Message', 'woocommerce-whatsapp-message'),
            'type' => 'title',
            'id' => 'wcwm_setting_title'
        ),

        array(
            'title' => __('Admin WhatsApp Number', 'woocommerce-whatsapp-message'),
            'desc' => __('Enter WhatsApp number in international format. e.g., +923112345678', 'woocommerce-whatsapp-message'),
            'id' => 'wcwm_admin_phone_number',
            'type' => 'text',
            'default' => '',
            'desc_tip' => true,

        ),

        array(
            'title' => __('WhatsApp_in_Details_page', 'woocommerce-whatsapp-message'),
            'desc' => __('Check it if you want to show the whatsapp option in product details page'),
            'id' => 'wcwm_locations[detail]',
            'type' => 'checkbox',
            'default' => 'yes',
            'desc_tip' => true,

        ),

        array(
            'title' => __('WhatsApp_in_product_list_page', 'woocommerce-whatsapp-message'),
            'desc' => __('Check it if you want to show the whatsapp option in product list page'),
            'id' => 'wcwm_locations[list]',
            'type' => 'checkbox',
            'default' => 'yes',
            'desc_tip' => true,

        ),

        array(
            'title' => __('WhatsApp_in_cart_page', 'woocommerce-whatsapp-message'),
            'desc' => __('Check it if you want to show the whatsapp option on cart page'),
            'id' => 'wcwm_locations[cart]',
            'type' => 'checkbox',
            'default' => 'yes',
            'desc_tip' => true,

        ),


        array(
            'title' => __('WhatsApp_in_checkout_page', 'woocommerce-whatsapp-message'),
            'desc' => __('Check it if you want to show the whatsapp option in checkout page'),
            'id' => 'wcwm_locations[checkout]',
            'type' => 'checkbox',
            'default' => 'yes',
            'desc_tip' => true,

        ),

        array(
            'type' => 'sectionend',
            'id' => 'wcwm_setting_end'
        )
    );

    // return array_merge($settings, $custom_settings);
    return $settings;
}

/**
 * action:  woocommerce_settings_tabs_wcwm_settings
 */
function wcwm_render_settings_tab()
{
?>
    <div class="wcwm-settings-header" style="background:#fff; padding: 15px; border:1px solid #ccc; border-left:4px solid #25D366; margin: bottom 20px;">
        <h2 style="margin:0 0 5px 0; "><?php _e('WhatsApp Integration for WooCommerce', 'woocommerce-whatsapp-message'); ?></h2>
        <p style="margin:0;"><?php _e('Need assistance? Check out our <a href="#" target="_blank">Documentation</a> or submit a <a href="#" target="_blank">Support Ticket</a>.', 'woocommerce-whatsapp-message'); ?></p>
    </div>
<?php
    woocommerce_admin_fields(wcwm_general_settings());
}


/**
 * action: woocommerce_update_options_wcwm_settings
 */
function wcwm_update_options()
{
    woocommerce_update_options(wcwm_general_settings());
}
