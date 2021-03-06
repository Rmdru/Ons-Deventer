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
        url: "https://" + window.location.hostname + "/functions/functions?action=generateCaptcha",
        method: "POST"
    })
    .done(function() {
        $("#captchaImg").attr("src", "https://" + window.location.hostname + "/img/captchaImg.php");
    }) 
}


//show psw toggle
if ($(".showPswToggle").length > 0) {
    $(".showPswToggle").on("click" ,function() {
        if ($(this).hasClass("visible")) {
            $(".inputField.psw").attr("type", "password");
            $(this).html("visibility");
        } else {
            $(".inputField.psw").attr("type", "text");
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

//generate random psw
$(document).on("click", ".generateRandomPswBtn", function() {
    $.ajax({
        url: "https://" + window.location.hostname + "/functions/functions?action=generatePsw",
        method: "POST"
    })
    .done(function(data) {
        $(".inputField.psw").val(data);
        $(".inputField.pswRepeat").val(data);
    }) 
})

if ($(".hamburgerIcon").length > 0) {
	$(document).on("click", ".hamburgerIcon", function() {
		$("html").toggleClass("hamburgerOpen");
	})
	
	$(document).on("click", ".menu-item-61 a", function() {
		$("html").removeClass("hamburgerOpen");
	})
}

if ($(".shareSiteBttn").length > 0) {
    const btn = document.querySelector('.shareSiteBttn');
    
    var title = btn.getAttribute("data-title");
    var url = btn.getAttribute("data-url");
    const shareData = {
        title: title,
        url: url
    }
    
    
    btn.addEventListener('click', async () => {
        navigator.share(shareData)
    });
}