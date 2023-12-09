$(document).ready(function () {
    $('.fancybox').fancybox({
        iframe: {
            css: {
                width: '90%',
                height: '90%',
            },
        }
    });
    $('.cStatus').on('change', function () {
        if (confirm("Are you sure want to update status?")) {
            var rowID = $(this).parent().parent().attr('data-key');
            var status = $(this).val();
            $.ajax({
                url: $('#ajaxURL').val(),
                data: {id: rowID, status: status},
                dataType: 'json',
                type: 'post',
                success: function (data) {
                    alert(data.msg);
                    window.location.reload();
                },
            });
        }
        
    })
});

