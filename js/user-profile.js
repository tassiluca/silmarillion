function hideDisable(element) {
    element
        .hide()
        .prop('disabled', true);
}

function showActivate(element) {
    element
        .show()
        .prop('disabled', false);
}

$(document).ready(function(){

    if($('#modifyData').click(function(){
        hideDisable($('#modifyData'));
        showActivate($('#cancelData'));
        showActivate($('#submitData'));

        $('#nome').prop("disabled", false);
        $('#cognome').prop("disabled", false);
        $('#compleanno').prop("disabled", false);
    }));

    if($('#cancelData').click(function(){
        hideDisable($('#cancelData'));
        hideDisable($('#submitData'));
        showActivate($('#modifyData'));

        $('#nome').prop("disabled", true);
        $('#cognome').prop("disabled", true);
        $('#compleanno').prop("disabled", true);
    }));


    // buttons login form
    if($('#modifyLog').click(function(){
        hideDisable($('#modifyLog'));
        showActivate($('#cancelLog'));
        showActivate($('#submitLog'));

        $('#email').prop("disabled", false);
    }));

    if (!$('#cancelLog').click(function() {
        hideDisable($('#cancelLog'));
        hideDisable($('#submitLog'));
        showActivate($('#modifyLog'));

        $('#email').prop("disabled", true);
    })) {
        return;
    }

    // TODO - fare la paypal e carta
    if($('select option[value=0]').prop('selected', true)) {

        console.log("0");
       // $('fieldset#paypal').css("display", "block");
        //$('fieldset#creditCard').css("display", "none");
    }

    if($('select option[value=1]').prop('selected', true)) {
        console.log("1");
       // $('fieldset#paypal').css("display", "none");
        //$('fieldset#creditCard').css("display", "block");
    }
   












    if($('.request').click(function(){
        $('aside#requestForm').css("display", "block");
        $('aside#reviewForm').css("display", "none");
    }));

    if ($('button#closeRequest').click(function(){
        $('aside#requestForm').css("display", "none");
    }));


    if($('.review').click(function(){
        console.log('hihi');
        $('aside#reviewForm').css("display", "block");
        $('aside#requestForm').css("display", "none");
    }));

    if ($('button#closeReview').click(function(){
        $('aside#reviewForm').css("display", "none");
    }));




    /* Pagina Messaggi*/


    $(".bin").click(function(){
        $(".inboxMail").hide();
        $(".binMail").show();
    });


    $(".inbox").click(function(){
        $(".binMail").css("display", "none");
        $(".inboxMail").show();
    });

});