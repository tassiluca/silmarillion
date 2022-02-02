/**
 * Makes a new login attempt and displays errors if something wrong.
 * @param {form} form the login form submitted
 * @param {object} formData the login form data to submit
 * @param {string} target the target page to which send the user if login success
 */
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
        /* TODO: modify the target */
        loginAttempt($(this), formData, 'userArea.php');
        event.preventDefault();
    });
});