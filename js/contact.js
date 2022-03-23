$(".submitContactForm").on("click", function() {
    var error = "";
    var csrfToken = $("#csrfToken").val();
    var name = $("#name").val();
    var emailPattern = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    var email = $("#email").val();
    var subject = $("#subject").val();
    var msg = $("#msg").val();
    var captcha = $("#captcha").val();
    var hiddenField = $("#hiddenField").val();

    if (name == "") {
        error += "<span class='material-icons'>close</span> Vul een naam in!<br />";
    }

    if (!emailPattern.test(email)) {
        error += "<span class='material-icons'>close</span> Vul een geldig e-mailadres in!<br />";
    }

    if (subject == "") {
        error += "<span class='material-icons'>close</span> Vul het onderwerp in!<br />";
    }

    if (msg == "") {
        error += "<span class='material-icons'>close</span> Vul een bericht in!<br />";
    }

    if (msg.search("http") != -1) {
        error += "<span class='material-icons'>close</span> Je mag geen linkjes plaatsen in je bericht!<br />";
    }

    if (captcha == "") {
        error += "<span class='material-icons'>close</span> Vul de CAPTCHA in!<br />";
    }

    if (error == "") {
        $.ajax({
            url: "models/contact.php?action=send",
            method: "POST",
            data: {
                'csrfToken': csrfToken,
                'name': name,
                'email': email,
                'subject': subject,
                'msg': msg,
                'captcha': captcha,
                'hiddenField': hiddenField
            }
        })
        .done(function(data) {
            if (data == "success") {
                $(".status").html("<p class='primaryTxt success'><span class='material-icons'>check</span> Contactformulier succesvol verzonden!</p>");
            } else {
                $(".status").html("<p class='primaryTxt error'><span class='material-icons'>close</span> Er is iets fout gegaan! Probeer te pagina te herladen en vul vervolgens de velden correct in!</p>");
            }
        })
    } else {
        $(".status").html("<p class='primaryTxt error'>" + error + "</p>");
    }
    $("#captcha").val("");
    $("#captchaImg").attr("src", "img/captchaImg.php");
})

$("#captchaReloadBtn").on("click", function() {
    $("#captchaImg").fadeOut();
    setTimeout(function() {
        $.ajax({
            url: "functions/functions?action=generateCaptcha",
            method: "POST"
        })
        .done(function() {
            $("#captchaImg").attr("src", "img/captchaImg.php");
        }) 
    }, 500);
    $("#captchaImg").fadeIn();
})