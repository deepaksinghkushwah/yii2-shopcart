$(document).ready(function () {
    $('.make-featured').on('click', function () {
        $.ajax({
            url: $(this).attr('data-url'),
            type: 'get',
            dataType: 'json',
            success: function (data) {
                alert(data.msg);
                window.location.reload();
            }
        });
    });

    $('.related_product').fancybox({

        /*beforeShow: function () {
         var target = $(".nav-tabs li.active a").attr('href');
         setTabLocation(target);
         },
         afterClose: function () {
         //parent.window.location.reload(true);
         parent.window.location.href = $('#reload_location').val() + '&section=' + $('#section').val();
         },*/
        iframe: {
            css: {
                width: '90%',
                height: '90%',
            },
            scrolling: 'auto',
            preload: true,

        }
    });
});