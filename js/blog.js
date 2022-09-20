

//view blog overview small
if ($(".viewBlogOverviewSm").length > 0) {
    var output = "";
    $.getJSON("models/blog?action=read&sortBy=dateTimeDesc", function(data) {
        if (data == "failed") {
            output += "<p class='txt'>Er is iets fout gegaan.</p>";
            $(".viewBlogOverview").html(output);
        } else if (data == "noBlogsFound") {
            output += "<p class='txt'>Er zijn geen blogs gevonden.</p>";
            $(".viewBlogOverview").html(output);
        } else {
            var j = 0;
            for (var i in data) {
                if (j < 3) {
                    var uuid = data[i].uuid;
                    var url = data[i].url;
                    var title = data[i].title;
                    var bodyTxt = data[i].bodyTxtSanitized;
                    var dateTime = data[i].dateTimeFormatted;
                    var readTime = data[i].readTime;
                    if (readTime == 1) {
                        readTime = "1 minuut";
                    } else {
                        readTime = readTime + " minuten"; 
                    }
                    var imgFileType = data[i].imgFileType;
            
                    output += "<div class='flexItem'>";
                        output += "<img src='img/blog/" + uuid + "." + imgFileType + "' class='gridImg' width='100' height='100' />";
                        output += "<h3 class='title'>" + title + "</h3>";
                        output += "<p class='primaryTxt'>" + bodyTxt + "</p>";
                        output += "<p class='secondaryTxt'>" + dateTime + " - Leestijd: " + readTime + "</p>";
                        output += "<a href='blog/" + url + "' class='primaryBtn'>Lees meer</a>";
                    output += "</div>";
                    j++;
                }
            }

            $(".viewBlogOverviewSm").html(output);
    
            $(".viewBlogOverviewSm .flexItem").on("click", function() {
                var url = $(this).children(".primaryBtn").attr("href");
                window.location.href = url;
            })
        }
    })
}

if ($(".viewBlogOverview").length > 0) {
    viewBlogOverview("dateDesc");
}

if ($(".sortBySelect").length > 0) {
    $(".sortBySelect").on("change", function() {
        viewBlogOverview($(this).val());
    })
}

//view blog overview
function viewBlogOverview(sortBy) {
    var output = "";
    $.getJSON("models/blog?action=read&sortBy=" + sortBy, function(data) {
        if (data == "failed") {
            output += "<p class='txt'>Er is iets fout gegaan.</p>";
            $(".viewBlogOverview").html(output);
        } else if (data == "noBlogsFound") {
            output += "<p class='txt'>Er zijn geen blogs gevonden.</p>";
            $(".viewBlogOverview").html(output);
        } else {
            for (var i in data) {
                var uuid = data[i].uuid;
                var url = data[i].url;
                var title = data[i].title;
                var bodyTxt = data[i].bodyTxtSanitized;
                var dateTime = data[i].dateTimeFormatted;
                var readTime = data[i].readTime;
                if (readTime == 1) {
                    readTime = "1 minuut";
                } else {
                    readTime = readTime + " minuten"; 
                }
                var imgFileType = data[i].imgFileType;
        
                output += "<div class='flexItem displayNone' data-url='blog/" + url + "'>";
                    output += "<img src='img/blog/" + uuid + "." + imgFileType + "' class='gridImg' width='100' height='100' />";
                    output += "<h3 class='title'>" + title + "</h3>";
                    output += "<p class='primaryTxt'>" + bodyTxt + "</p>";
                    output += "<p class='secondaryTxt'>" + dateTime + " - Leestijd: " + readTime + "</p>";
                    output += "<a href='blog/" + url + "' class='primaryBtn'>Lees meer</a>";
                output += "</div>";
            }

            $(".viewBlogOverview").html(output);
        
            $(".viewBlogOverview .flexItem").on("click", function() {
                var url = $(this).children(".primaryBtn").attr("href");
                window.location.href = url;
            })

            var visibleItems = 0;
            var showPerClick = 9;

            if ($(".flexItem").length < showPerClick) {
                $(".loadMoreBtn").hide();
            }

            $(".flexItem.displayNone").each(function(i) {
                if (i < showPerClick) {
                    $(this).removeClass("displayNone");
                    visibleItems++;
                }
            })

            $(".loadMoreBtn").on("click", function() {
                $(".flexItem.displayNone").each(function(i) {
                    if (i < showPerClick) {
                        $(this).removeClass("displayNone");
                        visibleItems++;
                    }
                    
                    if (visibleItems == $(".flexItem").length) {
                        $(".loadMoreBtn").hide();
                    }
                })
            })
        }
    })
}

//view blog detail
if ($(".viewBlogDetail").length > 0) {
    var blog = /[^/]*$/.exec(window.location.href)[0];
    $.getJSON("../models/blog?action=readSingle&blog=" + blog, function(data) {
        var output = "";
        if (data == "failed") {
            output += "<p class='txt'>Er is iets fout gegaan.</p>";
            $(".viewBlogOverview").html(output);
        } else if (data == "blogNotFound") {
            window.location.href = "404";
        } else {
            for (var i in data) {
                var uuid = data[i].uuid;
                var url = data[i].url;
                var title = data[i].title;
                var bodyTxt = data[i].bodyTxt;
                var dateTimeFormatted = data[i].dateTimeFormatted;
                var readTime = data[i].readTime;
                if (readTime == 1) {
                    readTime = "1 minuut";
                } else {
                    readTime = readTime + " minuten"; 
                }
                var author = data[i].author;
                var imgFileType = data[i].imgFileType;
                
                $(".blogTitle").html(title + " - Ons Deventer");
                output += "<header class='header'>";
                    output += "<img src='../img/blog/" + uuid + "." + imgFileType + "' class='headerImg' width='100' height='100' />";
                    output += "<div class='headerBar'>";
                        output += "<div class='wrapper'>";
                            output += "<h1 class='title'>" + title + "</h1>";
                        output += "</div>";
                    output += "</div>";
                output += "</header>";
                output += "<div class='wrapper'>";
                    output += "<div class='row'>";
                        output += "<div class='column65'>";
                            output += "<div class='tile mobileOnly'>";
                                output += "<p class='primaryTxt'><i class='material-icons'>event</i> " + dateTimeFormatted + "</p>";
                                output += "<p class='primaryTxt'><i class='material-icons'>schedule</i> Leestijd: " + readTime + "</p>";
                                output += "<p class='primaryTxt'><i class='material-icons'>person</i> Door: " + author + "</p>";
                                output += "<hr class='secondaryDivider' />";
                                output += "<p class='primaryTxt'><i class='material-icons'>share</i> Deel deze blog:</p>";
                                output += "<div class='socialIconsWrapper'>";
                                    output += "<a class='socialIcon' onclick='copyLink();' data-url='https://" + window.location.hostname + "/blog/" + url + "'><i class='material-icons'>link</i></a>";
                                    output += "<a class='socialIcon' href='mailto:?body=https://" + window.location.hostname + "/blog/" + url + "' target='_blank'><i class='material-icons'>email</i></a>";
                                    output += "<a class='socialIcon' href='https://wa.me/?text=https://" + window.location.hostname + "/blog/" + url + "' target='_blank'><i class='fab fa-whatsapp'></i></a>";
                                    output += "<a class='socialIcon' href='http://www.facebook.com/sharer/sharer.php?u=https://" + window.location.hostname + "/blog/" + url + "' target='_blank'><i class='fab fa-facebook'></i></a>";
                                    output += "<a class='socialIcon' href='https://twitter.com/intent/tweet?url=https://" + window.location.hostname + "/blog/" + url + "' target='_blank'><i class='fab fa-twitter'></i></a>";
                                    output += "<a class='socialIcon' href='https://www.linkedin.com/cws/share?url=https://" + window.location.hostname + "/blog/" + url + "' target='_blank'><i class='fab fa-linkedin'></i></a>";
                                output += "</div>";
                            output += "</div>";
                            output += "<p class='primaryTxt bodyTxt'>" + bodyTxt + "</p>";
                            output += "<hr class='primaryDivider' />";
                            output += "<div class='viewComments'></div>";
                        output += "</div>";
                        output += "<div class='column30'>";
                            output += "<div class='tile desktopOnly'>";
                                output += "<p class='primaryTxt'><i class='material-icons'>event</i> " + dateTimeFormatted + "</p>";
                                output += "<p class='primaryTxt'><i class='material-icons'>schedule</i> Leestijd: " + readTime + "</p>";
                                output += "<p class='primaryTxt'><i class='material-icons'>person</i> Door: " + author + "</p>";
                                output += "<hr class='secondaryDivider' />";
                                output += "<p class='primaryTxt'><i class='material-icons'>share</i> Deel deze blog:</p>";
                                output += "<div class='socialIconsWrapper'>";
                                    output += "<a class='socialIcon' onclick='copyLink();' data-url='https://" + window.location.hostname + "/blog/" + url + "'><i class='material-icons'>link</i></a>";
                                    output += "<a class='socialIcon' href='mailto:?body=https://" + window.location.hostname + "/blog/" + url + "' target='_blank'><i class='material-icons'>email</i></a>";
                                    output += "<a class='socialIcon' href='https://wa.me/?text=https://" + window.location.hostname + "/blog/" + url + "' target='_blank'><i class='fab fa-whatsapp'></i></a>";
                                    output += "<a class='socialIcon' href='http://www.facebook.com/sharer/sharer.php?u=https://" + window.location.hostname + "/blog/" + url + "' target='_blank'><i class='fab fa-facebook'></i></a>";
                                    output += "<a class='socialIcon' href='https://twitter.com/intent/tweet?url=https://" + window.location.hostname + "/blog/" + url + "' target='_blank'><i class='fab fa-twitter'></i></a>";
                                    output += "<a class='socialIcon' href='https://www.linkedin.com/cws/share?url=https://" + window.location.hostname + "/blog/" + url + "' target='_blank'><i class='fab fa-linkedin'></i></a>";
                                output += "</div>";
                            output += "</div>";
                            output += "<hr class='primaryDivider mobileOnly' />";
                            output += "<div class='tile'>";
                                output += "<p class='txt'>Recente blogs:</p>";
                                output += "<div class='viewRecentBlogs'></div>";
                            output += "</div>";
                        output += "</div>";
                    output += "</div>";
                output += "</div>";

                $(".viewBlogDetail").html(output);

                viewRecentBlogs(url);
                viewComments(url);
            }
        }
    })

    function viewRecentBlogs(url) {
        $.getJSON("../models/blog?action=readRecent&sortBy=dateTimeDesc&url=" + url, function(data) {
            var output = "";
            if (data == "failed") {
                output += "<p class='txt'>Er is iets fout gegaan.</p>";
                $(".viewBlogOverview").html(output);
            } else if (data == "noBlogsFound") {
                output += "<p class='txt'>Er zijn geen blogs gevonden.</p>";
                $(".viewBlogOverview").html(output);
            } else {
                var j = 0;
                for (var i in data) {
                    if (j < 3) {
                        var uuid = data[i].uuid;
                        var url = data[i].url;
                        var title = data[i].title;
                        var imgFileType = data[i].imgFileType;
    
                        output += "<a href='" + url + "' class='recentBlog'>";
                            output += "<img class='img' src='../img/blog/" + uuid + "." + imgFileType + "' width='100' height='100'>";
                            output += "<p class='txt'>" + title + "</p>";
                        output += "</a>";
        
                        $(".viewRecentBlogs").html(output);
                        j++;
                    }
                }
            }
        })
    }
}