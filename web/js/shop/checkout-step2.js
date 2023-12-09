$(document).ready(function(){
    $('input[name="payment_mode"]').on('click',function(){        
        if($(this).val() === 'bank'){
            $('#bank_detail').show();
        } else {
            $('#bank_detail').hide();
        }
    });
});