const filters = {
    lang: [],
    author: [],
    price: [],
    availability: [],
    publisher: [],
};

function hideElement(element) {
    element
        .removeClass("selected")
        .next().slideUp();
}

$(document).ready(function(){
    $("main > aside > button").click(function(){
        if ($(this).hasClass("selected")) {
            hideElement($(this));
        } else {
            $(this)
                .addClass("selected")
                .next().slideDown();
        }
    })

    $("main > aside > ul > li > input").click(function(){
        /* **TODO**
         * Implements logic for filtering categories and others.
         */
        var isChecked = $(this).is(':checked');
        var type = $(this).attr('class');

        if(isChecked){
            console.log($(this).attr('class'));
            filters[type].push($(this).attr("name"));
        }
        else{
            filters[type].splice(filters[type].indexOf($(this).attr("name")),1);
        }
        console.log(filters);
    })

});


/*
 
function loginAttempt(form, formData, target) {
    // Clears messages results of previous attempts
    $(".hasError").removeClass("hasError");
    $(".message").remove();

    $.ajax({
        type: "POST",
        url: "utils/process-login.php",
        data: formData,
        dataType: "json",
        encode: true
    }).done(function (data) {
        if (data.error) { // if has been occured some error
            // add class hasError to both username and password inputs
            $(form).find("ul > li:nth-of-type(2)").addClass("hasError");
            $(form).find("ul > li:nth-of-type(3)").addClass("hasError");
            // add an error message
            $(form).find("ul > li:nth-of-type(3)").append (
                '<div class="message error">' + data.error + '</div>'
            );
        } else {
            // send the user to target
            window.location.href = target;
        }
    }).fail(function(data) { // error connecting to the server
        $(form).find("ul > li:nth-of-type(3)").append (
            '<div class="error">Errore connessione al server! Riprova...</div>'
        );
    });
}

$(document).ready(function() { 
    $("div#navLogin > form").submit(function(event) {
        var formData = {
            customerUsr: $("#usernameNav").val(),
            customerPwd: hex_sha512($("#userpasswordNav").val())
        };
        /* TODO: modify the target 
        loginAttempt($(this), formData, 'userArea.php');
        event.preventDefault();
    });
});
 */