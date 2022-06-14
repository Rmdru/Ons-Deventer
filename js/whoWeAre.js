if ($("html").data("page") == "wie-wij-zijn") {
    $.getJSON("api/whoWeAre.json", function(data) {
        $.each(data, function (key, value) {
            $("." + key).html(value);
        })
    })
}