$(window).on("load", function() {
    if ($("html").hasClass("blog")) {
        viewBlogOverview("dateDesc");
    }
});

function viewBlogOverview(sortBy) {
    $.getJSON("models/blog?action=read&sortBy=" + sortBy, function(data) {
        var output = "";
        if (data == "failed" || data == "noCommentsFound") {
            var amount = 0;
        } else {
            var amount = data.length;
        }
        output += "<h2>Blogs (" + amount + ")</h2>";

        if (data == "failed") {
            output += "<p>Er is iets fout gegaan.</p>";
            $(".content").html(output);
        } else if (data == "noBlogsFound") {
            output += "<p>Er zijn geen blogs gevonden.</p>";
            $(".content").html(output);
        } else {
            output += "<div class='blog'>";
                output += "<table class='table'>";
                    output += "<tr>";
                        output += "<th>Titel</th>";
                        output += "<th>Upload moment</th>";
                        output += "<th>Auteur</th>";
                        output += "<th>Aantal weergaven</th>";
                        output += "<th>Zichtbaarheid</th>";
                        output += "<th>Leestijd</th>";
                        output += "<th></th>";
                        output += "<th></th>";
                        output += "<th></th>";
                    output += "</tr>";
                    for (var i in data) {
                        var url = data[i].url;
                        var title = data[i].title;
                        var dateTime = data[i].dateTimeFormatted;
                        var author = data[i].author;
                        var views = data[i].views;
                        var visibility = data[i].visibility;
                        if (visibility == 0) {
                            visibility = "<span class='material-icons'>lock</span> Privé";
                        } else {
                            visibility = "<span class='material-icons'>public</span> Openbaar";
                        }
                        var readTime = data[i].readTime;
                        output += "<tr data-url='" + url + "'>";
                            output += "<td>" + title + "</td>";
                            output += "<td>" + dateTime + "</td>";
                            output += "<td>" + author + "</td>";
                            output += "<td>" + views + "</td>";
                            output += "<td>" + visibility + "</td>";
                            output += "<td>" + readTime + " minuten</td>";
                            output += "<td><a href='../blog/" + url + "' target='_blank' class='primaryBtn'><span class='material-icons'>open_in_new</span></a></td>";
                            output += "<td><a href='blog-bewerken?blog=" + url + "' class='primaryBtn'><span class='material-icons'>edit</span></a></td>";
                            output += "<td><button class='primaryBtn error deleteBlogPopup'><span class='material-icons'>delete</span></button></td>";
                        output += "</tr>";
                    }
                output += "</table>";
            output += "</div>";

            $(".content").html(output);
        }
    })
}

$(document).on("click", ".deleteBlogPopup", function() {
    var btn = $(this).parent().parent();
    url = $(btn).data("url");
    $(".popup.deleteBlog").css("display", "flex").hide().fadeIn();
    $("body").addClass("noScroll");
    $(document).on("click", ".popup.deleteBlog .primaryBtn.error", function() {
        deleteBlog(url);
    })
})

function deleteBlog(url) {
    $.ajax({
        url: "models/blog.php?action=delete",
        method: "POST",
        data: {
            'url': url,
        }
    })
    .done(function(data) {
        if (data == "failed") {
            $(".status").html("<p class='error'><span class='material-icons'>close</span> Er is iets fout gegaan. Vul alle velden correct in!</p>");
        } else if (data == "success") {
            window.location.href = "blog?blogDeleteStatus=successful";
        }
    })
}

function closePopup() {
    $(".popup").fadeOut();
}

if ($(".inputField.url").length > 0) {
    $(".inputField.title").on("change keyup", function() {
        formatUrl(this);
    });
}

function formatUrl(el) {
    var val = $(el).val();
    val = val.replace(/[ ]/g, "-");
    val = val.replace(/[^a-zA-Z0-9-]/g, "");
    val = val.toLowerCase();
    $(".inputField.url").val(val);
}

if ($(".quillWysiwyg.bodyTxt").length > 0) {
    var quillWysiwygBodyTxt = new Quill('.quillWysiwyg', {
        modules: {
          toolbar: [
            [{ header: [3, 4, false] }],
            ['bold', 'italic', 'underline'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'align': [] }],
          ]
        },
        theme: 'snow'
    });

    quillWysiwygBodyTxt.on("text-change", function() {
        var val = quillWysiwygBodyTxt.root.innerHTML;
        val = val.split(" ");
        readTime = val.length / 250;
        readTime = parseInt(readTime);
        if (readTime == 0) {
            readTime = 1;
        }

        $(".inputField.readTime").val(readTime);
    })
}

$(document).on("change", 'input[type="file"]', function () {
	var el = $(this);
	var filename = el.val().replace(/C:\\fakepath\\/i, "");
	var inputName = el.attr("id");
    el.parent()
        .parent()
        .find('label[for="' + inputName + '"]');
    $("#filename").html("<p>Bestand: " + filename + "</p>");
});

if ($(".inputGroup.uploadMoment").length > 0) {
    $(".inputField.uploadMomentSelect").on("change", function() {
        if ($(this).val() == "scheduled") {
            $(".inputGroup.uploadMoment").slideDown();
        } else {
            $(".inputGroup.uploadMoment").slideUp();
        }
    })
}

if ($(".submitBlog.add").length > 0) {
    $(".submitBlog.add").on("click", function() {
        var error = "";
        var title = $(".inputField.title").val();
        var bodyTxt = quillWysiwygBodyTxt.root.innerHTML;
        var url = $(".inputField.url").val();
        url = url.replace(/[ ]/g, "-");
        url = url.replace(/[^a-zA-Z0-9-]/g, "");
        url = url.toLowerCase();
        var author = $(".inputField.author").val();
        var readTime = $(".inputField.readTime").val();
        var uploadMomentSelect = $(".inputField.uploadMomentSelect").val();
        var uploadMoment = $(".uploadMoment .inputField").val();
        var csrfToken = $("input#csrfToken").val();
        var hiddenField = $(".hiddenField").val();

        if (title == "") {
            error += "<p class='error'><span class='material-icons'>close</span> Vul de titel in!</p>";
        }
        
        if (bodyTxt == "") {
            error += "<p class='error'><span class='material-icons'>close</span> Vul de bodytekst in!</p>";
        }

        if (url == "") {
            error += "<p class='error'><span class='material-icons'>close</span> Vul de URL in!</p>";
        }

        if (author == "") {
            error += "<p class='error'><span class='material-icons'>close</span> Vul de auteur in!</p>";
        }

        if (uploadMomentSelect == "scheduled" && uploadMoment == "") {
            error += "<p class='error'><span class='material-icons'>close</span> Vul het upload moment in!</p>";
        }

        if (error == "") {
            $.ajax({
                url: "models/blog.php?action=write",
                method: "POST",
                data: {
                    'csrfToken': csrfToken,
                    'title': title,
                    'bodyTxt': bodyTxt,
                    'url': url,
                    'author': author,
                    'readTime': readTime,
                    'uploadMomentSelect': uploadMomentSelect,
                    'uploadMoment': uploadMoment,
                    'hiddenField': hiddenField
                }
            })
            .done(function(data) {
                if (data == "failed") {
                    $(".status").html("<p class='error'><span class='material-icons'>close</span> Er is iets fout gegaan. Vul alle velden correct in!</p>");
                } else if (data == "success") {
                    $(".form").submit();
                }
            })
        } else {
            $(".status").html(error);
        }
    })
}

var blogUploadStatusUrlParameter = getUrlParameter("blogUploadStatus");
if (blogUploadStatusUrlParameter == "failed") {
    $(".notification").html("<span class='material-icons'>close</span> Blog uploaden mislukt");
    showNotification();
}

if (blogUploadStatusUrlParameter == "success") {
    $(".notification").html("<span class='material-icons'>check</span> Blog succesvol geupload");
    showNotification();
}

var blogEditStatusUrlParameter = getUrlParameter("blogEditStatus");
if (blogEditStatusUrlParameter == "failed") {
    $(".notification").html("<span class='material-icons'>close</span> Blog bewerken mislukt");
    showNotification();
}

if (blogEditStatusUrlParameter == "success") {
    $(".notification").html("<span class='material-icons'>check</span> Blog succesvol bewerkt");
    showNotification();
}

var blogDeleteStatusUrlParameter = getUrlParameter("blogDeleteStatus");
if (blogDeleteStatusUrlParameter == "successful") {
    $(".notification").html("<span class='material-icons'>check</span> Blog succesvol verwijderd");
    showNotification();
}

if ($(".blogBewerken").length > 0) {
    var output = "";
    var blog = getUrlParameter("blog");
    $.getJSON("models/blog?action=readSingle&blog=" + blog, function(data) {
        if (data == "failed") {
            output += "<p class='txt'>Er is iets fout gegaan.</p>";
            $(".viewBlogOverview").html(output);
        } else if (data == "blogNotFound") {
            window.location.href = "404";
        } else {
            for (var i in data) {
                var uuid = data[i].uuid;
                var title = data[i].title;
                var bodyTxt = data[i].bodyTxt;
                var author = data[i].author;
                var visibility = data[i].visibility;
                var fileType = data[i].fileType;

                $("#uuid").val(uuid);
                $("#fileType").val(fileType);
                $(".inputField.title").val(title);
                formatUrl($(".inputField.title"));
                quillWysiwygBodyTxt.root.innerHTML = bodyTxt;
                $(".inputField.author").val(author);

                $(".inputField.visibility option[value|=" + visibility + "]").prop("selected", true);
            }
        }
    });
}

if ($(".submitBlog.edit").length > 0) {
    $(".submitBlog.edit").on("click", function() {
        var error = "";
        var uuid = $("#uuid").val();
        var title = $(".inputField.title").val();
        var bodyTxt = quillWysiwygBodyTxt.root.innerHTML;
        var url = $(".inputField.url").val();
        url = url.replace(/[ ]/g, "-");
        url = url.replace(/[^a-zA-Z0-9-]/g, "");
        url = url.toLowerCase();
        var author = $(".inputField.author").val();
        var readTime = $(".inputField.readTime").val();
        var visibility = $(".inputField.visibility").val();
        var imgFileType = $("#fileType").val();
        var csrfToken = $("input#csrfToken").val();
        var hiddenField = $(".hiddenField").val();

        if (title == "") {
            error += "<p class='error'><span class='material-icons'>close</span> Vul de titel in!</p>";
        }
        
        if (bodyTxt == "") {
            error += "<p class='error'><span class='material-icons'>close</span> Vul de bodytekst in!</p>";
        }

        if (url == "") {
            error += "<p class='error'><span class='material-icons'>close</span> Vul de URL in!</p>";
        }

        if (author == "") {
            error += "<p class='error'><span class='material-icons'>close</span> Vul de auteur in!</p>";
        }

        if (visibility == "") {
            error += "<p class='error'><span class='material-icons'>close</span> Vul de zichtbaarheid in!</p>";
        }

        if (error == "") {
            $.ajax({
                url: "models/blog.php?action=edit",
                method: "POST",
                data: {
                    'uuid': uuid,
                    'csrfToken': csrfToken,
                    'title': title,
                    'bodyTxt': bodyTxt,
                    'url': url,
                    'author': author,
                    'readTime': readTime,
                    'visibility': visibility,
                    'imgFileType': imgFileType,
                    'hiddenField': hiddenField
                }
            })
            .done(function(data) {
                if (data == "failed") {
                    $(".status").html("<p class='error'><span class='material-icons'>close</span> Er is iets fout gegaan. Vul alle velden correct in!</p>");
                } else if (data == "success") {
                    $(".form").submit();
                }
            })
        } else {
            $(".status").html(error);
        }
    })
}