$(document).ready(function(){

    /*$("body > header > nav > div").hide();*/
var pressedBtn = false;
    $("body > header > nav > ul > li:first-of-type > button").click(function(){
        if (!$(this).hasClass("navActive")){
            $(this).addClass("navActive");
            $("body > header > nav > div.navMenu").show();
            $("main").css("opacity", "0.2");
            
        } 
        else{
            $(this).removeClass("navActive");
            $("body > header > nav > div.navMenu").hide();
            $("main").css("opacity", "1.0");
        }
    });

    /* cart navbar*/
    $("body > header > nav > ul > li:last-of-type > button").click(function(){
        
        if (!$(this).hasClass("navActive")){
            $(this).addClass("navActive");
            $("body > header > nav > div.navCart").show();
            $("main").css("opacity", "0.2");
        } 
        else{
            $(this).removeClass("navActive");
            $("body > header > nav > div.navCart").hide();
            $("main").css("opacity", "1.0");
        }
    });
/*
    function resetIfPressed(){
            $("body > header > nav > ul > li > button").removeClass("navActive");
            $("body > header > nav > div").hide();
    }
    */
});

