jQuery(document).ready(function($){

     $('.wcwm-button').on('click',function(){
        let name = $(this).data('product-name');
        let price = $(this).data('product-price');
        let sku = $(this).data('product-sku') ? $(this).data('product-sku') : 'N/A';
        let url = $(this).data('product-url');
        let phone = '+923000000000'; // modify this number to send message....

        let message = 'Hello %0A';
        message += 'I am intrested in this product: %0A';
        message += 'Name: ' +name + '%0A';
        message += 'Price: Rs' +price + '%0A';
        message += 'SKU: ' + sku + '%0A';
        message += 'Link: ' + url + '%0A';

        let whatsApp_url = 'https://wa.me/'+phone+'?text='+message;

        window.open(whatsApp_url, '_blank');
     })
    

})
