/**
 * Makes a new login attempt and displays errors if something wrong.
 * @param {form} form the login form submitted
 * @param {object} formData the login form data to submit
 * @param {string} target the target page to which send the user if login success
 */
function loginAttempt(form, formData, target) {
    // Clear messages results of previous attempts
    $(".hasError").removeClass("hasError");
    $(".message").remove();

    $.ajax({
        type: "POST",
        url: "./engines/process-login.php",
        data: formData,
        dataType: "json",
        encode: true
    }).done(function (data) {
        if (data.error) { // if has been occurred some errors
            // add class hasError to both username and password inputs
            $(form).find("ul > li:nth-of-type(1)").addClass("hasError");
            $(form).find("ul > li:nth-of-type(2)").addClass("hasError");
            // add an error message
            $(form).find("ul > li:nth-of-type(2)").append (
                '<div class="message error">' + data.error + '</div>'
            );
        } else {
            //clear user cookies, cart and favs that where transferred to db is user logged is customer
            initUserCookies();
            // send the user to target
            window.location.href = target;
        }
    }).fail(function(data) { // error connecting to the server
        //console.log(data.responseText);
        $(form).find("ul > li:nth-of-type(2)").append (
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
        /* TODO @NalNemesi: modify the target */
        loginAttempt($(this), formData, 'user-area.php');
        event.preventDefault();
    });
});