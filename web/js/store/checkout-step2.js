$(document).ready(function () {
    toggleBankDetail();
    $('input[name="payment_mode"]').on('click', function () {
        toggleBankDetail();
    });

    /*$('.btn-submit').on('click', function () {
        var payment_mode = $('input[name="payment_mode"]:checked').val();
        var err = [];
        if (payment_mode == 'paypal_rest_api') {
            if ($('#card_number').val() == '') {
                err.push("You must enter card number");
                $('#card_number').addClass('invalid');
            } else {
                $('#card_number').removeClass('invalid');
            }

            if ($('#name_on_card').val() == '') {
                err.push("You must enter name on your card");
                $('#name_on_card').addClass('invalid');
            } else {
                $('#name_on_card').removeClass('invalid');
            }

            if ($('#cvc_number').val() == '') {
                err.push("You must enter cvc number");
                $('#cvc_number').addClass('invalid');
            } else {
                $('#cvc_number').removeClass('invalid');
            }

            if (err.length > 0) {
                return false;
            } else {
                //return false;
                $('#checkout-form').submit();
            }
        }
    });*/
});

function toggleBankDetail() {
    var value = $('input[name="payment_mode"]:checked').val();
    if (value == 'bank') {
        $('#bank_detail').show();
        $('.rest_api_fields').hide();
    } else if (value == 'paypal') {
        $('#bank_detail').hide();
        $('.rest_api_fields').hide();
    } else {
        $('#bank_detail').hide();
        $('.rest_api_fields').show();
    }
}

