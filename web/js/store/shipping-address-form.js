$(document).ready(function () {
    $('#shippingaddress-country').on('change', function () {
        $.ajax({
            url: $('#getStateUrl').val() + '?id=' + $(this).val(),
            dataType: 'json',
            type: 'get',
            success: function (data) {
                $('#shippingaddress-state').find('option').remove().end();
                $('#shippingaddress-city').find('option').remove().end();
                if (data.status == 0) {
                    $.each(data.records, function (id, row) {
                        //console.log(id+name);
                        $('#shippingaddress-state').append($('<option>', {
                            value: row.id,
                            text: row.name,
                        }));
                    });

                }
            }
        });
    });

    $('#shippingaddress-state').on('change', function () {
        $.ajax({
            url: $('#getCityUrl').val() + '?id=' + $(this).val(),
            dataType: 'json',
            type: 'get',
            success: function (data) {
                $('#shippingaddress-city').find('option').remove().end();
                if (data.status == 0) {
                    $.each(data.records, function (id, row) {
                        //console.log(id+name);
                        $('#shippingaddress-city').append($('<option>', {
                            value: row.id,
                            text: row.name,
                        }));
                    });

                }
            }
        });
    })
});

