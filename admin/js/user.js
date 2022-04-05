$(document).on("click", ".newPswBtn", function() {
    var error = 0;
    var csrfToken = $(".csrfToken").val();
    var psw = $(".inputField.psw").val();
    var pswRepeat = $(".inputField.pswRepeat").val();
    var hiddenField = $(".hiddenField").val();

    if (psw != pswRepeat) {
        error++;
    }

    if (error == 0) {
        $.ajax({
            url: "models/user.php?action=resetPsw",
            method: "POST",
            data: {
                'csrfToken': csrfToken,
                'psw': psw,
                'hiddenField': hiddenField,
            }
        })
        .done(function(data) {
            if (data == "success") {
                $(".status").html("<p class='primaryTxt success'><span class='material-icons'>check</span> Wachtwoord succesvol gewijzigd. Het oude wachtwoord is vanaf nu ongeldig. Vanaf nu kan je alleen nog maar inloggen met je nieuwe wachtwoord.</p>");
            } else {
                $(".status").html("<p class='primaryTxt error'><span class='material-icons'>close</span> Er is iets fout gegaan, probeer het opnieuw!</p>");
            }
        })
    } else {
        $(".status").html("<p class='primaryTxt error'><span class='material-icons'>close</span> Er is iets fout gegaan, mogelijk komen de wachtwoorden niet overeen, probeer het opnieuw!</p>");
    }
})