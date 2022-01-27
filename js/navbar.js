$(document).ready(function(){

    var pressedBtn = false;

    /* Menu button clicked */
    $("body > header > nav > ul > li:first-of-type > button").click(function(){
        toggleNavbar($(this), $("body > header > nav > div.navMenu"));
    });

    /* Cart button clicked */
    $("body > header > nav > ul > li:last-of-type > button").click(function(){
        toggleNavbar($(this), $("body > header > nav > div.navCart"));
    });

});

/**
 * Toggle one element of navbar
 * @param {*} btnPressed the navbar button which has been pressed
 * @param {*} elementToSlide the section of page to show
 */
function toggleNavbar(btnPressed, elementToSlide){
    if (!btnPressed.hasClass("navActive")){
        /* add the class navActive in order to color the button pressed */
        btnPressed.addClass("navActive");
        elementToSlide.slideDown();
        /* add opacity to the main page */
        $("main").css("opacity", "0.2");
    } else {
        btnPressed.removeClass("navActive");
        elementToSlide.slideUp();
        /* restore the opacity of the main page */
        $("main").css("opacity", "1.0");
    }
}