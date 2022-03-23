//header slider with swiper.js
var headerSlider = new Swiper(".headerSlider", {
    spaceBetween: 30,
    loop: true,
    centeredSlides: true,
    speed: 1000,
    grabCursor: true,
    autoplay: {
      delay: 3000,
      disableOnInteraction: false,
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
});

//generate random number
function generateRandomNumber() {
    var randomNumber = Math.floor(Math.random() * (5 - -5 + 1)) + -5;
    return randomNumber;
}

//get url parameter
var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return typeof sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
    return false;
};


//show notification
function showNotification() {
    $("html").addClass("showNotification");
    setTimeout(function() {
        $("html").removeClass("showNotification");
    }, 3000);
}

$(function() {
    $(document).on('click', '.checkbox label', function(e){
        if(e.target.tagName == 'LABEL') {
          $(this).parent().toggleClass('checked');
        }
    });
});

//disable name field
function disableNameField() {
    $("input#name").toggleClass("disabled");
}

//copy link
function copyLink() {
    var url = $(this).data("url");
    navigator.clipboard.writeText(url);
    $(".notification").html("<p class='primaryTxt'><span class='material-icons'>check</span> Link succesvol gekopieerd!</p>");
    showNotification();
}


//load captcha img
if ($("#captchaImg").length > 0) {
    $.ajax({
        url: "functions/functions?action=generateCaptcha",
        method: "POST"
    })
    .done(function() {
        $("#captchaImg").attr("src", "img/captchaImg.php");
    }) 
}


//show psw toggle
if ($(".showPswToggle").length > 0) {
    $(".showPswToggle").on("click" ,function() {
        if ($(this).hasClass("visible")) {
            $("#psw").attr("type", "password");
            $(this).html("visibility");
        } else {
            $("#psw").attr("type", "text");
            $(this).html("visibility_off");
        }
        $(this).toggleClass("visible");
    })
}

//add active class to navbar links
var page = $("html").data("page");
if (page != undefined) {
    $(".navbar .link").each(function() {
        var link = $(this).data("link");
        if (link == page) {
            $(this).addClass("active");
        }
    })
}