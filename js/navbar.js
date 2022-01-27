$(document).ready(function(){

    var pressedBtn = false;

    /* Menu button clicked */
    $("body > header > nav > ul > li:first-of-type > button").click(function(){
        if (!$(this).hasClass("navActive")){
            $(this).addClass("navActive");
            $("body > header > nav > div.navMenu").slideDown();
            /* add opacity to the main page */
            $("main").css("opacity", "0.2");
        } 
        else {
            $(this).removeClass("navActive");
            $("body > header > nav > div.navMenu").slideUp();
            /* restore the opacity of the main page */
            $("main").css("opacity", "1.0");
        }
    });

    /* Cart button clicked */
    $("body > header > nav > ul > li:last-of-type > button").click(function(){
        if (!$(this).hasClass("navActive")){
            $(this).addClass("navActive");
            $("body > header > nav > div.navCart").show();
            $("main").css("opacity", "0.2");
        } 
        else {
            $(this).removeClass("navActive");
            $("body > header > nav > div.navCart").hide();
            $("main").css("opacity", "1.0");
        }
    });



});

