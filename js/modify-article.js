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
    $("#addPublisherBtn, #addCategoryBtn").click(function(e){
        // [NOTE] by default, button elements in forms are submit buttons.
        e.preventDefault();
        slide($(this));
    });

    $("section > form").submit(function(e){
        e.preventDefault();
        console.log(this);
        $.ajax({
            url: $(this).attr("action"),
            type: $(this).attr("method"),
            dataType: "JSON",
            data: new FormData(this),
            processData: false,
            contentType: false,
        }).done(function(data){
            console.log(data);
        });  
    });

});