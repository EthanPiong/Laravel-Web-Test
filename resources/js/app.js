require('./bootstrap');
require('./cart');

// Add to cart with AJAX
$(function() {
    $('.add-to-cart-ajax').click(function(e) {
        e.preventDefault();
        
        let form = $(this).closest('.add-to-cart-form');
        let url = form.attr('action');
        let data = form.serialize();
        
        $.ajax({
            url: url,
            method: 'POST',
            data: data,
            success: function(response) {
                showNotification('Item added to cart!', 'success');
                updateCartCount();
            },
            error: function(xhr) {
                showNotification('Failed to add item to cart', 'danger');
            }
        });
    });
    
    function showNotification(message, type) {
        let notification = $('<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
            message +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
            '<span aria-hidden="true">&times;</span>' +
            '</button>' +
            '</div>');
        
        $('#notifications').append(notification);
        
        setTimeout(function() {
            notification.alert('close');
        }, 3000);
    }
    
    function updateCartCount() {
        $.ajax({
            url: '/cart/count',
            method: 'GET',
            success: function(response) {
                $('.cart-count').text(response.count);
            }
        });
    }
});