$(document).ready(function () {
    $("form").submit(function (event) {
        var formData = {
            query: $("#ip").val(),
        };

        var url = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/iplocate/address?ip=";
        var token = "40a9dcc3e0ade43272679f62964053189b46957a";
        var temp1 = {};

        $.ajax({
            type: "GET",
            url: url + formData.query,
            beforeSend: function(xhr) {
                xhr.setRequestHeader("Authorization", "Token "+ token)
            },
            data: formData,
            dataType: "json",
            encode: true,
        }).done(function (result) {
            $("#result").html('<p>' + result.location.value + '</p>');
            console.log(result);
        });

        

        event.preventDefault();
    });
});