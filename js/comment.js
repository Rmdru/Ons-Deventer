//view comments
function viewComments(blog, response = "") {
    $.getJSON("models/comment?action=read&blog=" + blog, function(data) {
        var output = "";
        if (data == "failed" || data == "noCommentsFound") {
            var amount = 0;
        } else {
            var amount = data.length;
        }
        
        output += "<h2 class='title'>Reacties (" + amount + ")</h2>";
        output += "<div class='commentForm'>";
            output += "<input type='hidden' id='hiddenField' />";
            output += "<div class='checkbox'>";
                output += "<label for='anonymous'>";
                    output += "<input type='checkbox' id='anonymous' onchange='disableNameField(this);' />Ik wil anoniem blijven";
                output += "</label>";
            output += "</div>";
            output += "<input type='text' class='inputField' placeholder='Naam' id='name' />";
            output += "<textarea rows='5' class='inputField' placeholder='Reactie' id='comment'></textarea>";
            output += "<button class='primaryBtn submitComment'>Reactie plaatsen</button>";
            output += "<div class='error'></div>";
            output += "<div class='response'>" + response + "</div>";
        output += "</div>";

        if (data == "failed") {
            output += "<p class='txt'>Er is iets fout gegaan.</p>";
            $(".viewComments").html(output);
        } else if (data == "noCommentsFound") {
            output += "<p class='txt'>Er zijn nog geen reacties geplaatst.</p>";
            $(".viewComments").html(output);
        } else {
            for (var i in data) {
                var anonymous = data[i].anonymous;
                if (anonymous == 1) {
                    var name = "Anonieme gebruiker";
                } else {
                    var name = data[i].name;
                }
                var dateTime = data[i].dateTimeFormatted;
                var comment = data[i].comment;

                output += "<div class='comment'>";
                    output += "<p class='txt'><b>" + name + " | " + dateTime + "</b></p>";
                    output += "<p class='txt'>" + comment + "</p>";
                output += "</div>";

                $(".viewComments").html(output);
            }
        }

        $(".submitComment").on("click", function() {
            submitComment();
        });

        function submitComment() {
            $(".error").html("");
            $(".response").html("");
            var error = "";
            var hiddenField = $("#hiddenField").val();
            var csrfToken = $("#csrfToken").val();
            if ($("#anonymous").is(":checked")) {
                var anonymous = 1;
            } else {
                var anonymous = 0;
            }
            var name = $("#name").val();
            var comment = $("#comment").val();

            if (hiddenField != "") {
                error += "<p class='primaryTxt error'><span class='material-icons'>close</span> Er is iets fout gegaan</p>";
            }

            if (csrfToken == "") {
                error += "<p class='primaryTxt error'><span class='material-icons'>close</span> Er is iets fout gegaan</p>";
            }

            if (anonymous == 0 && name == "") {
                error += "<p class='primaryTxt error'><span class='material-icons'>close</span> Er is iets fout gegaan, vul het naam veld in!</p>";
            }

            if (comment == "") {
                error += "<p class='primaryTxt error'><span class='material-icons'>close</span> Er is iets fout gegaan, vul het reactie veld in!</p>";
            }

            if (error == "") {
                $.ajax({
                    url: "models/comment?action=write",
                    type: "POST",
                    data: {
                        blog: blog,
                        hiddenField: hiddenField,
                        csrfToken: csrfToken,
                        anonymous: anonymous,
                        name: name,
                        comment: comment
                    }
                })
                .done(function(data) {
                    var response = "";
                    if (data == "success") {
                        response += "<p class='primaryTxt success'><span class='material-icons'>check</span> Reactie succesvol geplaatst!</p>";
                    } else {
                        response += "<p class='primaryTxt error'><span class='material-icons'>close</span> Er is iets fout gegaan</p>";
                    }
                    viewComments(blog, response);
                })
            } else {
                $(".error").html(error);
            }
        }
    });
}