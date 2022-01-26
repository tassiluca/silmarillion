$(document).ready(function(){

    $("body > header > nav > ul > li:first-of-type > button").click(function(){
        if (!$(this).hasClass("navActive")){
            $(this).addClass("navActive");
            $("body > header > nav > div").slideDown();
            $("main").css("opacity", "0.2");
            
        } 
        else{
            $(this).removeClass("navActive");
            $("body > header > nav > div").slideUp();
            $("main").css("opacity", "1.0");
        }
    });

});

