// jQuery(function ($) {

//     $(document).on('click', '.wcwm-act-button', function (e) {
//         e.preventDefault();
//         $('#wcwm-shipping-info-popup').fadeIn();
//     });

//     // CLOSE popup
//     $(document).on('click', '#wcwm-popup-button', function () {
//         $('#wcwm-shipping-info-popup').fadeOut();

//     });

// });


jQuery(function ($) {

    let whatsappUrl = '';

    
    $(document).on('click', '.wcwm-act-button', function () {

        if (typeof wcwm_cart_data === 'undefined' || !wcwm_cart_data.items.length) {
            alert('Cart is empty');
            return;
        }

        let message = 'Cart Details\n\n';

        wcwm_cart_data.items.forEach(function (item, index) {
            message += (index + 1) + '. ' + item.name + '\n';
            message += 'Qty: ' + item.quantity + '\n';
            message += 'Price: ' + wcwm_cart_data.currency + ' ' + item.price + '\n';
            message += 'Subtotal: ' + wcwm_cart_data.currency + ' ' + item.subtotal + '\n';
            message += 'Tax: ' + wcwm_cart_data.currency + ' ' + item.tax + '\n\n';
        });

        message += 'Total: ' + wcwm_cart_data.currency + ' ' + wcwm_cart_data.total;

        whatsappUrl =
            'https://wa.me/' +
            wcwm_cart_data.admin_phone_number +
            '?text=' + encodeURIComponent(message);

        // Show popup
        $('#wcwm-shipping-info-popup').fadeIn();
    });

    $(document).on('click', '#wcwm-popup-button', function () {

        if (whatsappUrl !== '') {
            window.open(whatsappUrl, '_blank');
        }

        // Close popup
        $('#wcwm-shipping-info-popup').fadeOut();
    });

});
