function showElement(element) {
    element.addClass("active");
    if (!element.next().length) {
        element.prev().removeClass("active");
    } else {
        element.next().removeClass("active");
    }
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
        $(".hasError").removeClass("hasError");
        $(".error").remove();

        var formData = {
            customerUsr: $("#customerUsr").val(),
            customerPwd: hex_sha512($("#customerPwd").val())
        };

        $.ajax({
            type: "POST",
            url: "utils/process-login.php",
            data: formData,
            dataType: "json",
            encode: true
        }).done(function (data) {
            if (!data.success) { // there was an error
                $("ul#userlogin > li:first-of-type").addClass("hasError");
                $("ul#userlogin > li:nth-of-type(2)").addClass("hasError");
                if (data.errors.forcing) {
                    $("ul#userlogin > li:nth-of-type(2)").append (
                        '<div class="error">' + data.errors.forcing + '</div>'
                    );
                } else {
                    $("ul#userlogin > li:nth-of-type(2)").append (
                        '<div class="error">' + data.errors.wrong + '</div>'
                    );
                }
            } else {
                window.location.href = 'registration.php';
            }
        });

        event.preventDefault();
    });
})
