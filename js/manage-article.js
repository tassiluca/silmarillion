function displayComicFields() {
    $("#funkoFields").css("display", "none");
    $("#comicFields").css("display", "block");
}

function displayFunkoFields() {
    $("#comicFields").css("display", "none");
    $("#funkoFields").css("display", "block");
}

$(document).ready(function() {
    // at the beginiggin the default choice is comics
    displayComicFields();
    $("input[type=radio][name=articleToInsert]").change(function() {
        if ($(this).attr("id") == "comic") {
            displayComicFields();
        } else {
            displayFunkoFields();
        }
    });
});