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
            $(this)
                .addClass("selected")
                .next().slideDown();
        }
    })

    $("main > aside > ul > li > input").click(function(){
        /* **TODO**
         * Implements logic for filtering categories and others.
         */
        var isChecked = $(this).is(':checked');
        if(isChecked){
            activeFilters.push($(this).attr("name"));
        }
        else{
            activeFilters.splice(activeFilters.indexOf($(this).attr("name")),1);
        }
        
        console.log(activeFilters);
        var str = JSON.stringify(activeFilters);

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
            }
        };
        xmlhttp.open("GET", "filtering.php?filter=" + str, true);
        xmlhttp.send();
    })

});