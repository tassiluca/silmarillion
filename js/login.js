function showElement(element) {
    element.addClass("active");
    if (!element.next().length) {
        element.prev().removeClass("active");
    } else {
        element.next().removeClass("active");
    }
}

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

$(document).ready(function(){
    /* By default user login form is active and seller one is hidden */
    $("main > section > header > ul > li:first-child").addClass("active");
    $("#sellerlogin").hide()

    $("#userloginbtn").click(function(){
        showElement($(this));
        $("#sellerlogin").hide()
        $("#userlogin").show()
    });

    $("#sellerloginbtn").click(function(){
        showElement($(this))
        $("#userlogin").hide()
        $("#sellerlogin").show()
    });

    $("main > section > form:first-of-type").submit(function(event) {
        var formData = {
            customerUsr: $("#customerUsr").val(),
            customerPwd: hex_sha512($("#customerPwd").val())
        };
        /* TODO: modify the target */
        loginAttempt($(this), formData, 'registration.php');
        event.preventDefault();
    });

    $("main > section > form:nth-of-type(2)").submit(function(event) {
        var formData = {
            sellerUsr: $("#sellerUsr").val(),
            sellerPwd: hex_sha512($("#sellerPwd").val())
        };
        /* TODO: modify the target */
        loginAttempt($(this), formData, 'registration.php');
        event.preventDefault();
    });
})
