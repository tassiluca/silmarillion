function validatePattern(condition, patternLabel) {
    if (condition) {
        patternLabel.addClass("valid")
            .removeClass("invalid");
    } else {
        patternLabel.addClass("invalid")
            .removeClass("valid");
    }
}

$(document).ready(function(){
    $("#password").focus(function() {
        $("#password + section").css("display", "block");
    });

    $("#password").blur(function() {
        $("#password + section").css("display", "none");
    });

    $("#password").keyup(function() {
        validatePattern($(this).val().match(/[a-z]/g), $("#letter"));
        validatePattern($(this).val().match(/[A-Z]/g), $("#capital"));
        validatePattern($(this).val().match(/[0-9]/g), $("#number"));
        validatePattern($(this).val().length >= 8, $("#length"));
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

        console.log(formData);

        $.ajax({
            type: "POST",
            url: "utils/process-registration.php",
            data: formData,
            dataType: "json",
            encode: true
        }).done(function(data){
            console.log(data);
            if (data.error) { // if has been occured some error
                console.log($(this));
                // add class hasError to username field
                $("main > section > form > ul > li:nth-of-type(7)").addClass("hasError");
                // add an error message
                $("main > section > form > ul > li:nth-last-of-type(2)").append (
                    '<div class="message error">' + data.error + '</div>'
                );
            } else {
                $("main > section > form > ul > li:nth-last-of-type(2)").append (
                    '<div class="message success">' + data.ok + '</div>'
                );
            }
        }).fail(function(data) { // error connecting to the server
            $("main > section > form > ul > li:nth-of-type(2)").append (
                '<div class="error">Errore connessione al server! Riprova...</div>'
            );
        });

        event.preventDefault();
    });
});