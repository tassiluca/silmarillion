const activeFilters = [];

function hideElement(element) {
    element
        .removeClass("selected")
        .next().slideUp();
}

$(document).ready(function(){
    $("main > aside > button").click(function(){
        if ($(this).hasClass("selected")) {
            hideElement($(this));
        } else {
            hideElement($("main > aside > button.selected"));
            $(this)
                .addClass("selected")
                .next().slideDown();
        }
    })

    $("main > aside > ul > li > input").click(function(){
        /* **TODO**
         * Implements logic for filtering categories and others.
         */
        console.log($(this).attr("name"));
    })

});