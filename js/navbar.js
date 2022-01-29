$(document).ready(function(){

    var pressedBtn = false;

    /* Menu button clicked */
    $("body > header > nav > ul > li:first-of-type > button").click(function(){
        toggleNavbar($(this), $("body > header > nav > div#navMenu"));
    });

    /* Cart button clicked */
    $("body > header > nav > ul > li:last-of-type > button").click(function(){
        toggleNavbar($(this), $("body > header > nav > div#navCart"));
    });

    /* Login button clicked */
    $("body > header > nav > ul > li:nth-last-of-type(2) > button").click(function(){
        toggleNavbar($(this), $("body > header > nav > div#navLogin"));
    });

    /* Search button clicked */
    $("body > header > nav > ul > li:nth-last-of-type(3) > button").click(function(){
        toggleNavbar($(this), $("body > header > nav > div#navSearch"));
    });

    $("html > body > main").click(function(){
        closePopupOpen();
        $("main").css("opacity", "1.0");
    });

});

function closePopupOpen(){
    /* if a popup was already opened, close it */
    $("body > header > nav > ul > li > button.navActive").removeClass("navActive");
    $("body > header > nav > div.active").slideUp();
}

/**
 * Toggle one element of navbar
 * @param {*} btnPressed the navbar button which has been pressed
 * @param {*} elementToSlide the section of page to show
 */
function toggleNavbar(btnPressed, elementToSlide){
    if (!btnPressed.hasClass("navActive")) {
        closePopupOpen();
        /* add the class navActive in order to color the button pressed */
        btnPressed.addClass("navActive");
        elementToSlide.addClass("active");
        elementToSlide.slideDown();
        /* add opacity to the main page */
        $("main").css("opacity", "0.2");
    } else {
        btnPressed.removeClass("navActive");
        elementToSlide.removeClass("active");
        elementToSlide.slideUp();
        /* restore the opacity of the main page */
        $("main").css("opacity", "1.0");
    }
}