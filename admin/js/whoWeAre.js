var personAmount = 0;

if ($(".wieWijZijnBewerken").length > 0) {
    $.getJSON("../api/whoWeAre.json", function(data) {
        $.each(data, function(key) {
            if (key.includes("-name")) {
                personAmount++;

                var output = "<div class='person'><p>Sectie 3 - persoon " + personAmount + " - naam</p>";
                output += "<input type='text' class='inputField section-3-person-" + personAmount + "-name' />";
                output += "<p>Sectie 3 - persoon " + personAmount + " - tekst</p>";
                output += "<textarea type='text' class='inputField section-3-person-" + personAmount + "-txt' rows='5'></textarea></div>";
                $("#team").append(output);
            }
        })

        $.each(data, function (key, value) {
            $("." + key).val(value);
        })
    })
}

if ($(".addPerson").length > 0) {
    $(document).on("click", ".addPerson", function() {
        personAmount++;
        var output = "<div class='person'><p>Sectie 3 - persoon " + personAmount + " - naam</p>";
        output += "<input type='text' class='inputField section-3-person-" + personAmount + "-name' />";
        output += "<p>Sectie 3 - persoon " + personAmount + " - tekst</p>";
        output += "<textarea type='text' class='inputField section-3-person-" + personAmount + "-txt' rows='5'></textarea></div>";
        $("#team").append(output);
    })
}

if ($(".deletePerson").length > 0) {
    $(document).on("click", ".deletePerson", function() {
        if ($("#team .person:last-child").length > 0) {
            $("#team .person:last-child").remove();
            personAmount--;
        }
    })
}

if ($(".submitWhoWeAre").length > 0) {
    $(document).on("click", ".submitWhoWeAre", function() {
        var error = "";
        var data = {};

        $("input, textarea").each(function() {
            var key = $(this)[0].classList[1];
            var value = $(this).val();
            data[key] = value;
        })

        if (error == "") {
            $.ajax({
                url: "models/whoWeAre.php?action=edit",
                method: "POST",
                data: {
                    data: data
                }
            })
            .done(function(data) {
                if (data == "failed") {
                    $(".status").html("<p class='error'><span class='material-icons'>close</span> Er is iets fout gegaan. Vul alle velden correct in!</p>");
                } else if (data == "success") {
                    $(".status").html("<p class='success'><span class='material-icons'>check</span> Wie wij zijn pagina succesvol bewerkt</p>");
                }
            })
        } else {
            $(".status").html(error);
        }
    })
}