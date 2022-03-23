$(window).on("load", function() {
    viewNavbar();
})

function viewNavbar() {
    var output = "";
    $.getJSON("models/user?action=readName", function(data) {
        if (data == "failed") {
            output += "<p class='txt'>Er is iets fout gegaan.</p>";
            $(".userInfo").html(output);
        } else {
            for (var i in data) {
                var name = data[i].name;
                output += "<p class='primaryTxt'>Ingelogd als: " + name + "<a href='uitloggen' class='link'>Uitloggen</a></p>";
            }

            $(".userInfo").html(output);
        }
    })
}