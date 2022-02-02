$(document).ready(function(){
    $("input[type=radio][name=articleToInsert]").change(function() {
        console.log($(this).attr("id"));
        if ($(this).attr("id") == "comic") {
            $("#funkoFields").css("display", "none");
            $("#comicFields").css("display", "block");
        } else {
            $("#comicFields").css("display", "none");
            $("#funkoFields").css("display", "block");
        }
    });
});