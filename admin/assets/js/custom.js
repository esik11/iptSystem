$(document).ready(function () {
    // Set alertify position if needed
    alertify.set('notifier', 'position', 'top-right');

    $(document).on('click', '.increment', function () {
        var $quantityInput = $(this).closest('.qtyBox').find('.qty');
        var productId = $(this).closest('.qtyBox').find('.prodId').val();

        var currentValue = parseInt($quantityInput.val().trim());
        if (!isNaN(currentValue)) {
            var qtyVal = currentValue + 1;
            $quantityInput.val(qtyVal);
            quantityIncDec(productId, qtyVal);
        }
    });

    $(document).on('click', '.decrement', function () {
        var $quantityInput = $(this).closest('.qtyBox').find('.qty');
        var productId = $(this).closest('.qtyBox').find('.prodId').val();

        var currentValue = parseInt($quantityInput.val().trim());
        if (!isNaN(currentValue) && currentValue > 1) {
            var qtyVal = currentValue - 1;
            $quantityInput.val(qtyVal);
            quantityIncDec(productId, qtyVal);
        }
    });

    function quantityIncDec(prodId, qty) {
        $.ajax({
            type: "POST",
            url: "orders-code.php",
            data: {
                'productIncDec': true,
                'product_id': prodId,
                'quantity': qty,
            },
            success: function (response) {
                var res = JSON.parse(response);

                if (res.status == 200) {
                    $('#productArea').load(' #productContent');
                    alertify.success(res.message);
                } else {
                    $('#productArea').load(' #productContent');
                    alertify.error(res.message);
                }
            }
        });
    }

    $(document).on('click', '.proceedToPlace', function () {
        console.log('proceedToPlace button clicked');

        var cphone = $('#cphone').val();
        var payment_mode = $('#payment_mode').val();
        console.log('Selected payment mode:', payment_mode);
        console.log('Entered phone number:', cphone);

        if (payment_mode === '' || payment_mode === 'Select Payment Method') {
            swal("Select Payment Mode", "Select your payment mode", "warning");
            return false;
        }

        if (cphone === '') {
            swal("Enter phone number", "enter valid phone number", "warning");
            return false;
        }

        if (!$.isNumeric(cphone)) {
            swal("Enter valid phone number", "Phone number must be numeric", "warning");
            return false;
        }

        var data = {
            'proceedToPlaceBtn': true,
            'cphone': cphone,
            'payment_mode': payment_mode,
        };

        $.ajax({
            type: "POST",
            url: "orders-code.php",
            data: data,
            success: function (response) {
                var res = JSON.parse(response);
                if (res.status == 200) {
                    window.location.href = 'order-summary.php';
                } else if (res.status == 404) {
                    swal(res.message, res.message, res.status_type, {
                        buttons: {
                            catch: {
                                text: "add customer",
                                value: "catch"
                            },
                            cancel: "cancel"
                        }
                    }).then((value) => {
                        switch (value) {
                            case "catch":
                                $('#c_phone').val(cphone);
                                $('#addCustomerModal').modal('show');
                                break;
                            default:
                        }
                    });
                } else {
                    swal(res.message, res.message, res.status_type);
                }
            }
        });
    });

    // Add customer if it doesn't exist
    $(document).on('click', '.saveCustomer', function () {
        var c_name = $('#c_name').val();
        var c_phone = $('#c_phone').val();
        var c_email = $('#c_email').val();

        if (c_name != '' && c_phone != '') {
            if ($.isNumeric(c_phone)) {
                var data = {
                    'saveCustomerBtn': true,
                    'name': c_name,
                    'phone': c_phone,
                    'email': c_email,
                };

                $.ajax({
                    type: "POST",
                    url: "orders-code.php",
                    data: data,
                    success: function (response) {
                        var res = JSON.parse(response);

                        if (res.status == 200) {
                            swal(res.message, res.message, res.status_type);
                            $('#addCustomerModal').modal('hide');
                        } else if (res.status == 422) {
                            swal(res.message, res.message, res.status_type);
                        } else {
                            swal(res.message, res.message, res.status_type);
                        }
                    }
                });
            } else {
                swal("Enter valid phone #", "", "warning");
            }
        } else {
            swal("Please fill required fields", "", "warning");
        }
    });
    
    $(document).on('click', '#saveOrder', function () {
        $.ajax({
            type: "POST",
            url: "orders-code.php",
            data: {
                'saveOrder': true
            },
            success: function (response) {
                console.log(response); // Debug: Log the raw response
    
                try {
                    var res = JSON.parse(response);
    
                    console.log(res); // Debug: Log the parsed response
    
                    if (res.status == 200) {
                        swal("Success", res.message, "success");
                        $('#orderPlaceSuccessMessage').text(res.message);
                        $('#orderSuccessModal').modal('show');
                    } else {
                        swal("Warning", res.message, "warning");
                    }
                } catch (e) {
                    console.error("Error parsing JSON response:", e);
                    console.error("Raw response:", response);
                    swal("Error", "Unexpected response format. Please try again.", "error");
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX error:", status, error);
                swal("Error", "An error occurred while processing your request. Please try again.", "error");
            }
        });
    });

});
