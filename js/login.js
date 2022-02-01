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
        var formData = {
            customerUsr: $("#customerUsr").val(),
            customerPwd: hex_sha512($("#customerPwd").val())
        };
        /* TODO: modify the target page*/
        loginAttempt($(this), formData, 'userArea.php');
        event.preventDefault();
    });

    $("main > section > form:nth-of-type(2)").submit(function(event) {
        var formData = {
            sellerUsr: $("#sellerUsr").val(),
            sellerPwd: hex_sha512($("#sellerPwd").val())
        };
        /* TODO: modify the target page*/
        loginAttempt($(this), formData, 'sellerArea.php');
        event.preventDefault();
    });
})
