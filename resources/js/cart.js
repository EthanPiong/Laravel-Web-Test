$(function() {
    // Update cart quantity
    $('.update-cart').change(function(e) {
        e.preventDefault();
        
        let ele = $(this);
        
        $.ajax({
            url: '/cart/update',
            method: "PATCH",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                id: ele.parents("tr").attr("data-id"),
                quantity: ele.parents("tr").find(".quantity").val()
            },
            success: function(response) {
                window.location.reload();
            }
        });
    });
    
    // Remove item from cart
    $('.remove-from-cart').click(function(e) {
        e.preventDefault();
        
        let ele = $(this);
        
        if(confirm("Are you sure you want to remove this item?")) {
            $.ajax({
                url: '/cart/remove',
                method: "DELETE",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: ele.parents("tr").attr("data-id")
                },
                success: function(response) {
                    window.location.reload();
                }
            });
        }
    });
});