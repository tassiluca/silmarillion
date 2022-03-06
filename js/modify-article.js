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
    /* [NOTE] select2 for for select box with support for searching. 
     * See more on [https://select2.org/] */
    $("#category").select2();
    $("#publisher").select2();

    $("#addPublisherBtn, #addCategoryBtn").click(function(e){
        // [NOTE] by default, button elements in forms are submit buttons.
        e.preventDefault();
        slide($(this));
    });

    $("section > form").submit(function(e){
        e.preventDefault();
        $.ajax({
            url: $(this).attr("action"),
            type: $(this).attr("method"),
            dataType: "JSON",
            data: new FormData(this),
            processData: false,
            contentType: false,
        }).done(function(data){
            if (data.error) {
                $("section > form").find("ul > li:last-of-type").prepend (
                    '<div class="message error">' + data.error + '</div>'
                );
            } else if (data.success) {
                $("section > form").find("ul > li:last-of-type").prepend (
                    '<div class="message success">' + data.success + '</div>'
                );
            }
        });
    });

});