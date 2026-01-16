jQuery(document).ready(function ($) {

    $('.wcwm-button').on('click', function () {

        let name = $(this).data('product-name');
        let price = $(this).data('product-price');
        let sku = $(this).data('product-sku') ? $(this).data('product-sku') : 'N/A';
        let url = $(this).data('product-url');
        let phone = $(this).data('admin-phone-number');

        let message = 'Hello\n';
        message += 'I am interested in this product:\n\n';
        message += 'Name: ' + name + '\n';
        message += 'Price: Rs ' + price + '\n';
        message += 'SKU: ' + sku + '\n';
        message += 'Link: ' + url + '\n';

        let whatsApp_url =
            'https://wa.me/' + phone + '?text=' + encodeURIComponent(message);

        window.open(whatsApp_url, '_blank');
    });


    $(document).on('click', '.wcwm-checkout-button', function () {

        // Safety check
        if (typeof wcwm_cart_data === 'undefined' || !wcwm_cart_data.items.length) {
            alert('Cart is empty');
            return;
        }

        //  Read user checkout fields
        let firstName = $('#billing_first_name').val() || '';
        let lastName = $('#billing_last_name').val() || '';
        let phone = $('#billing_phone').val() || '';
        let email = $('#billing_email').val() || '';
        let address = $('#billing_address_1').val() || '';
        let city = $('#billing_city').val() || '';
        let notes = $('#order_comments').val() || '';
        let payment = $('input[name="payment_method"]:checked').val() || '';

        let message = 'Order Details\n\n';

        //  Add user info
        message += 'Customer Details:\n';
        message += 'Name: ' + firstName + ' ' + lastName + '\n';
        message += 'Phone: ' + phone + '\n';
        message += 'Email: ' + email + '\n';
        message += 'Address: ' + address + ', ' + city + '\n';
        message += 'Payment Method: ' + payment + '\n';

        if (notes) {
            message += 'Order Notes: ' + notes + '\n';
        }

        message += '\n----------------------\n\n';

        console.log("cart items : ", wcwm_cart_data);

        wcwm_cart_data.items.forEach(function (item, index) {

            console.log(item);

            message += (index + 1) + '. ' + item.name + '\n';
            message += 'Qty: ' + item.quantity + '\n';
            message += 'Price: ' + wcwm_cart_data.currency + ' ' + item.price + '\n';
            message += 'Subtotal: ' + wcwm_cart_data.currency + ' ' + item.subtotal + '\n\n';
            message += 'tax: ' + wcwm_cart_data.currency + ' ' + item.tax + '\n\n';
        });

        message += 'Total: ' + wcwm_cart_data.currency + ' ' + wcwm_cart_data.total;

        let admin_phone_number = wcwm_cart_data.admin_phone_number;
        let whatsapp_url =
            'https://wa.me/' + admin_phone_number + '?text=' + encodeURIComponent(message);

        window.open(whatsapp_url, '_blank');
    });




    // $(document).on('click', '.wcwm-act-button', function () {

    //     console.log("cart:  wcwm-act-button clicked");


    //     if (typeof wcwm_cart_data === 'undefined' || !wcwm_cart_data.items.length) {
    //         alert('Cart is empty');
    //         return;
    //     }



    //     let message = 'Cart data\n\n';

    //     wcwm_cart_data.items.forEach(function (item, index) {

    //         console.log(item);

    //         message += (index + 1) + '. ' + item.name + '\n';
    //         message += 'Qty: ' + item.quantity + '\n';
    //         message += 'Price: ' + wcwm_cart_data.currency + ' ' + item.price + '\n';
    //         message += 'Subtotal: ' + wcwm_cart_data.currency + ' ' + item.subtotal + '\n\n';
    //         message += 'tax: ' + wcwm_cart_data.currency + ' ' + item.tax + '\n\n';
    //     });

    //     message += 'Total: ' + wcwm_cart_data.currency + ' ' + wcwm_cart_data.total;

    //     let admin_phone_number = wcwm_cart_data.admin_phone_number;
    //     let whatsapp_url =
    //         'https://wa.me/' + admin_phone_number + '?text=' + encodeURIComponent(message);

    //     window.open(whatsapp_url, '_blank');

    // })

    //     $(document).on('click','.wcwm-checkout-button', function () {

    //         console.log("printing : " + wcwm_order);

    //         if (typeof wcwm_order === 'undefined' || !wcwm_order.items.length) {
    //             alert('No items in order');
    //             return;
    //         }


    //         let message = 'Order Details\n\n';

    //         message += 'Order ID: '+ wcwm_order.order_id +'\n';
    //         message +=  'name: ' + wcwm_order.billing_name + '\n';
    //         message += 'email: ' + wcwm_order.billing_email + '\n';


    //         console.log("cart items : " , wcwm_order);

    //         wcwm_order.items.forEach(function (item, index) {

    //          console.log(item);

    //             message += (index + 1) + '. ' + item.name + '\n';
    //             message += 'Qty: ' + item.quantity + '\n';
    //             message += 'Price: ' + wcwm_order.currency  +' '+ item.price + '\n';
    //             message += 'Subtotal: ' + wcwm_order.currency +' '+ item.subtotal + '\n\n';
    //         });

    //         message += 'Total: ' + wcwm_order.currency + wcwm_order.total;

    //         let whatsapp_url =
    //             'https://wa.me/' + '+923149313252' + '?text=' + encodeURIComponent(message);

    //         window.open(whatsapp_url, '_blank');
    //     });

});
