$(".loginBtn").on("click", function() {
    var error = "";
    var csrfToken = $(".logIn .csrfToken").val();
    var emailPattern = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    var email = $(".logIn .email").val();
    var psw = $(".logIn .psw").val();
    if ($(".logIn .autologin").is(":checked")) {
        var autologin = 1;
    } else {
        var autologin = 0;
    }
    var hiddenField = $(".logIn .hiddenField").val();

    if (!emailPattern.test(email)) {
        error += "<span class='material-icons'>close</span> Vul een geldig e-mailadres in!<br />";
    }

    if (psw == "") {
        error += "<span class='material-icons'>close</span> Vul een wachtwoord in!<br />";
    }

    if (error == "") {
        $.ajax({
            url: "models/user.php?action=logIn",
            method: "POST",
            data: {
                'csrfToken': csrfToken,
                'email': email,
                'psw': psw,
                'autologin': autologin,
                'hiddenField': hiddenField
            }
        })
        .done(function(data) {
            if (data == "loggedInAsAdmin") {
                window.location.href = "/admin/";
            } else if (data == "emailNotFound") {
                $(".logIn .status").html("<p class='primaryTxt error'><span class='material-icons'>close</span> Het ingevulde e-mailadres bestaat niet, voer een ander e-mailadres in!</p>");
            } else if (data == "pswIncorrect") {
                $(".logIn .status").html("<p class='primaryTxt error'><span class='material-icons'>close</span> Vul het juiste wachtwoord in! Als je je wachtwoord niet meer weet kun je <a class='link pswReset'>hier een nieuwe maken</a>.</p>");
            } else if (data == "tooMuchLoginAttempts") {
                $(".logIn .status").html("<p class='primaryTxt error'><span class='material-icons'>close</span> Je account is geblokkeerd omdat je meer dan 5 foutieve inlogpogingen hebt gedaan, herstel je account door <a class='link pswReset'>hier een nieuw wachtwoord aan te maken</a>.</p>");
            } else if (data == "accountBlocked") {
                $(".logIn .status").html("<p class='primaryTxt error'><span class='material-icons'>close</span> Je account is geblokkeerd, herstel je account door <a class='link pswReset'>hier een nieuw wachtwoord aan te maken</a>.</p>");
            } else {
                $(".logIn .status").html("<p class='primaryTxt error'><span class='material-icons'>close</span> Er is iets fout gegaan! Probeer te pagina te herladen en vul vervolgens de velden correct in!</p>");
            }
        })
    } else {
        $(".logIn .status").html("<p class='primaryTxt error'>" + error + "</p>");
    }
})

$(document).on("click", ".link.pswReset", function() {
    goToStep("div.logIn", "div.pswReset");
});

$(document).on("click", ".pswReset .link.back", function() {
    goToStep("div.pswReset", "div.logIn");
});

function goToStep(hide, show) {
    $(hide).fadeOut().promise().then(function() {
        $(show).fadeIn();
    });
}

$(document).on("click", ".pswResetBtn", function() {
    var csrfToken = $(".pswReset .csrfToken").val();
    var email = $(".pswReset .inputField.email").val();
    var hiddenField = $(".pswReset .hiddenField").val();

    $.ajax({
        url: "models/user.php?action=requestPswResetLink",
        method: "POST",
        data: {
            'csrfToken': csrfToken,
            'email': email,
            'hiddenField': hiddenField,
        }
    })
    .done(function(data) {
        if (data == "success") {
            $(".pswReset .status").html("<p class='primaryTxt success'><span class='material-icons'>check</span> Er is een e-mail verzonden met een wachtwoord herstel link. Via die link kan je een nieuw wachtwoord aanmaken. Zorg dat je browser tijdens dit proces niet afsluit.</p>");
        } else if (data == "failed") {
            $(".pswReset .status").html("<p class='primaryTxt error'><span class='material-icons'>close</span> Er is iets fout gegaan, probeer het opnieuw!</p>");
        } else if (data == "noAccount") {
            $(".pswReset .status").html("<p class='primaryTxt error'><span class='material-icons'>close</span> Er is geen account gevonden met het opgegeven e-mailadres.</p>");
        }
    })
})