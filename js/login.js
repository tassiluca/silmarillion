function showElement(element) {
    element.addClass("active");
    if (!element.next().length) {
        element.prev().removeClass("active");
    } else {
        element.next().removeClass("active");
    }
}

function formhash(form, password) {
    var p = document.createElement("input");
    form.appendChild(p);
    p.name = "userPwd";
    p.type = "hidden";
    p.value = hex_sha512(password.value);
    password.value = "";
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
})
