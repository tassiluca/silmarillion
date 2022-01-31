function showElement(element) {
    element.addClass("active");
    if (!element.next().length) {
        element.prev().removeClass("active");
    } else {
        element.next().removeClass("active");
    }
}

/**
 * Hashes the password in order to NOT send it unencrypted.
 * @param {form} form: the submitted form
 * @param {string} password: the password to hash
 * @param {string} nameAttr: the name attribute of password input to replace.
 */
function formHash(form, password, nameAttr) {
    var p = document.createElement("input");
    form.appendChild(p);
    p.name = nameAttr;
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
