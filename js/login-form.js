function loginAttempt(form, formData, target) {
    $(".hasError").removeClass("hasError");
    $(".error").remove();

    $.ajax({
        type: "POST",
        url: "utils/process-login.php",
        data: formData,
        dataType: "json",
        encode: true
    }).done(function (data) {
        if (!data.success) { // there was an error
            $(form).find("ul > li:first-of-type").addClass("hasError");
            $(form).find("ul > li:nth-of-type(2)").addClass("hasError");
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
            window.location.href = target;
        }
    }).fail(function(data) {
        $(form).find("ul > li:nth-of-type(2)").append (
            '<div class="error">Errore connessione db! Riprova...</div>'
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