/**
 * Makes a new login attempt and displays errors if something wrong.
 * @param {form} form the login form submitted
 * @param {JSON} formData the login form data inserted by the user
 * @param {string} target the target page to which send the user if login success
 */
function loginAttempt(form, formData, target) {
    // Clears errors results of previous attempts
    $(".hasError").removeClass("hasError");
    $(".error").remove();

    $.ajax({
        type: "POST",
        url: "utils/process-login.php",
        data: formData,
        dataType: "json",
        encode: true
    }).done(function (data) {
        if (!data.success) { // if has been occured some error
            // add class hasError to both username and password inputs
            $(form).find("ul > li:first-of-type").addClass("hasError");
            $(form).find("ul > li:nth-of-type(2)").addClass("hasError");
            // add an error message
            if (data.errors.forcing) {
                $(form).find("ul > li:nth-of-type(2)").append (
                    '<div class="error">' + data.errors.forcing + '</div>'
                );
            } else {
                $(form).find("ul > li:nth-of-type(2)").append (
                    '<div class="error">' + data.errors.wrong + '</div>'
                );
            }
        } else {
            // send the user to target
            window.location.href = target;
        }
    }).fail(function(data) { // error connecting to the server
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
        /* TODO: modify the target */
        loginAttempt($(this), formData, 'userArea.php');
        event.preventDefault();
    });
});