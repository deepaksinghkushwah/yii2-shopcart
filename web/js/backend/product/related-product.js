$(document).ready(function(){
    $('.toggleRelatedProduct').on('click', function(){
        var status = 0;
        if($(this).is(':checked')){
            status = 1;
        } else {
            status = 0;
        }
        $.ajax({
            url: $('#relatedProductToggleUrl').val(),
            type: 'get',
            data: {values: $(this).val(), status: status},
            dataType: 'json',
            success: function (data) {
                alert(data.msg);                
            }
        });
    })
});