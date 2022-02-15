function displayComicFields() {
    $("#funkoFields").css("display", "none");
    $("#comicFields").css("display", "block");
}

function displayFunkoFields() {
    $("#comicFields").css("display", "none");
    $("#funkoFields").css("display", "block");
}

function slide(element) {
    if (element.hasClass("selected")) {
        element.removeClass("selected")
            .next().slideUp();
    } else {
        element.addClass("selected")
            .next().slideDown();
    }
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

    $("select#category + button, select#publisher + button").click(function(e){
        // [NOTE] by default, button elements in forms are submit buttons.
        e.preventDefault();
        slide($(this));
    });
});