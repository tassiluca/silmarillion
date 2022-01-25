$(document).ready(function(){
    /*$("body > header > nav > div").hide();*/

    $("body > header > nav > ul > li:first-of-type > button").click(function(){
        if (!$(this).hasClass("navActive")){
            $(this).addClass("navActive");
            $("body > header > nav > div:first-of-type").show();
            $("main").css("opacity", "0.2");
            
        } 
        else{
            $(this).removeClass("navActive");
            $("body > header > nav > div").hide();
            $("main").css("opacity", "1.0");
        }
    });
});

