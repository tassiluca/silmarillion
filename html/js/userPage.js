function showAndActive(element){
    element
        .show()
        .removeAttr('disabled'); 
}


function hideAndDisabled(element){
    element
        .hide()
        .attr('disabled', '');
}


$(document).ready(function(){


    $(".btnGeneral").click(function(){

       if($(this).children(".pop").css('display') == 'block') {
           $(this)
                .children(".pop").hide();
           $(this)
                .css("background-color", "rgb(0, 71, 158)")
                .children(".text").css("color", "white");

            $(".container").css("background", "#00d5ff4d");  
       }
       else { 
        
            $(".btnGeneral")
                .css("background-color", "rgb(0, 71, 158)")
                .children(".text").css("color", "white");

            $(".pop").css("display", "none");
            $(this).children(".pop").slideDown(250);

            $(".container").css("background", "rgba(0, 71, 158, 0.3)");

            $(this).css("background-color", "rgb(170, 241, 255)");
            $(this).children(".text").css("color", "rgb(0, 71, 158)");
       }
    });

    //PAGINA PROFILO

    // modifica dati personali
    $(".modifyData").click(function(){
        
        hideAndDisabled($(this));
        showAndActive($(".cancelData"));
        showAndActive($(".submitData"));

        $(".notDisData").removeAttr('disabled'); 


        // Se clicco su annulla
        $(".cancelData").click(function(){
            hideAndDisabled($(this));
            hideAndDisabled($(".submitData"));
            showAndActive($(".modifyData"));

            $(".notDisData").attr('disabled', '');
        });
    });



    // modifica dati login
    $(".modifyLog").click(function(){

        hideAndDisabled($(this));
        showAndActive($(".cancelLog"));
        showAndActive($(".submitLog"));

        $(".notDisLog").removeAttr('disabled'); 


        // popup username
        $(".popUpUsername").click(function(){
            $(".miniPopText").fadeIn(300);
            $(".miniPopText").delay(500).fadeOut(500);
        });
        

        // Se clicco su annulla
        $(".cancelLog").click(function(){

            hideAndDisabled($(this));
            hideAndDisabled($(".submitLog"));
            showAndActive($(".modifyLog"));
            
            $(".notDisLog").attr('disabled', '');
        });
    });


    // Metodi di pagamento
    $(".modifyPaypal").click(function(){
        $(this).css("display", "none");
        $(".confirmAll").css("display", "none");
        $(".others button").css("display", "inline-block");
        $(".confirmModify").css("display", "block")

    });

    $(".erasePaypal").click(function(){
        $(this).parent().css("display", "none");

    });

    $(".confirmModify").click(function(){
        $(this).css("display", "none");
        $(".confirmAll").css("display", "inline-block");
        $(".others button").css("display", "none");
        $(".modifyPaypal").css("display", "inline-block")
    });

   
  











    /* Pagina Messaggi*/

    $(".inbox").click(function(){  
        $(".inboxMail").css("display", "block");
        $(".sentMail").css("display", "none");
        $(".binMail").css("display", "none");
    });

    $(".sent").click(function(){
        $(".inboxMail").css("display", "none");
        $(".sentMail").css("display", "block");
        $(".binMail").css("display", "none");
    });

    $(".bin").click(function(){
        $(".inboxMail").hide();
        $(".sentMail").hide();
        $(".binMail").show();
    });

});

