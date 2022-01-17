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
    $("form > header > ul > li:first-child").addClass("active");
    $("#sellerlogin").hide()


    $("#userloginbtn").click(function(){
        showElement($("form > header > ul > li:first-child"));
        $("#sellerlogin").hide()
        $("#userlogin").show()
    });

    $("#sellerloginbtn").click(function(){
        showElement($("form > header > ul > li:last-child"))
        $("#userlogin").hide()
        $("#sellerlogin").show()
    });


})