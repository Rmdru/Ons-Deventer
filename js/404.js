//destroy 404 page
setTimeout(function() {
    destroyTxt();
}, 10000);

function destroyTxt() {
    $(".brokenTxtChar").each(function(i, element) {
        if ($(element).text() == "0") {
            $(element).css({"transform": "rotate(180deg) translateY(-15px)", "transition": "1s", "transition-timing-function": "ease", "letter-spacing": "5px"});
        } else {
            $(element).css("transform", "rotate(" + generateRandomNumber() + "deg) translateY(" + generateRandomNumber() + "px)");
        }
    })
    setTimeout(function() {
        destroyBtn();
    }, 1000);
}

function destroyBtn() {
    $(".brokenBtn").css("transform", "rotate(5deg) translateY(10px)");
}