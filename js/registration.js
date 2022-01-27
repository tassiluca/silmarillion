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
    $("#password").focus(function(){
        $("#password + section").css("display", "block");
    });

    $("#password").blur(function(){
        $("#password + section").css("display", "none");
    });

    $("#password").keyup(function(){
        validatePattern($(this).val().match(/[a-z]/g), $("#letter"));
        validatePattern($(this).val().match(/[A-Z]/g), $("#capital"));
        validatePattern($(this).val().match(/[0-9]/g), $("#number"));
        validatePattern($(this).val().length >= 8, $("#length"));
    });
});