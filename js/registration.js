/**
 * The min length of password field.
 */
const MIN_PWD_CHARS = 8;

/**
 * Verify a condition on an input field.
 * @param {Array} conditionRes the result of an applied condition
 * @param {HTMLElement} field the label to which apply the condition
 */
function validatePattern(conditionRes, field) {
    if (conditionRes) {
        field.addClass("valid")
            .removeClass("invalid");
    } else {
        field.addClass("invalid")
            .removeClass("valid");
    }
}

/**
 * Makes a new registration attempt and displays errors if something wrong.
 * @param {form} form the login form submitted
 * @param {object} formData the login form data to submit
 * @param {string} target the target page to which send the user if login success
 */
function registrationAttempt(form, formData){
    // Clears messages results of previous attempts
    $(".hasError").removeClass("hasError");
    $(".message").remove();

    $.ajax({
        type: "POST",
        url: "./engines/process-registration.php",
        data: formData,
        dataType: "json",
        encode: true
    }).done(function(data){
        if (data.error) { // if has been occured some error
            // add class hasError to username field
            $(form).find("ul > li:nth-last-of-type(4)").addClass("hasError");
            // add an error message
            $(form).find("ul > li:nth-last-of-type(2)").append (
                '<div class="message error">' + data.error + '</div>'
            );
        } else {
            $(form).find("ul > li:nth-last-of-type(2)").append (
                '<div class="message success">' + data.success + '</div>'
            );
        }
    }).fail(function(data) { // error connecting to the server
        $(form).find("ul > li:nth-of-type(2)").append (
            '<div class="error">Errore connessione al server! Riprova...</div>'
        );
    });
}

$(document).ready(function(){
    $("#password").focus(function() {
        $("#password + section").css("display", "block");
    });

    $("#password").blur(function() {
        $("#password + section").css("display", "none");
    });

    $("#password").keyup(function() {
        validatePattern($(this).val().match(/[a-z]/g), $("#letter"));  // lowercase letters
        validatePattern($(this).val().match(/[A-Z]/g), $("#capital")); // capital letters
        validatePattern($(this).val().match(/[0-9]/g), $("#number"));  // numbers
        validatePattern($(this).val().length >= MIN_PWD_CHARS, $("#length"));
    });

    $("main > section > form").submit(function(event){
        var formData = {
            name: $("#name").val(),
            surname: $("#surname").val(),
            birthday: $("#birthday").val(),
            usr: $("#username").val(),
            email: $("#email").val(),
            pwd: hex_sha512($("#password").val())
        };
        registrationAttempt($(this), formData);
        event.preventDefault();
    });
});