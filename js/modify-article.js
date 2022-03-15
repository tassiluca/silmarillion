function slide(element) {
    if (element.hasClass("selected")) {
        element.removeClass("selected").next().slideUp();
        // [NOTE] Be aware select2 inserts a span between the button and the select item
        element.prev().prev().attr("required", "true");
        element.next().children().children().not("label").removeAttr("required");
    } else {
        element.addClass("selected").next().slideDown();
        // [NOTE] Be aware select2 inserts a span between the button and the select item
        element.prev().prev().removeAttr("required");
        element.next().children().children().not("label").attr("required", true);
    }
}

$(document).ready(function() {
    /* [NOTE] select2 for for select box with support for searching. 
     * See more on [https://select2.org/]. */
    $("#category").select2();
    $("#publisher").select2();

    /* [NOTE] at the reload page re-format correctly prices input (in db are dot-formatted)!
     * See below. */
    $("#price").val($("#price").val().replace(".", ","));
    $("#discountedPrice").val($("#discountedPrice").val().replace(".", ","));

    $("#addPublisherBtn, #addCategoryBtn").click(function(e){
        // [NOTE] by default, button elements in forms are submit buttons.
        e.preventDefault();
        slide($(this));
    });

    $("section > form").submit(function(e){
        e.preventDefault();
        // Clears messages results of previous attempts
        $(".message").remove();
        // [NOTE] prices must be dot-formatted instead of comma-formatted
        $("#price").val($("#price").val().replace(",", "."));
        $("#discountedPrice").val($("#discountedPrice").val().replace(",", "."));
        $.ajax({
            url: $(this).attr("action"),
            type: $(this).attr("method"),
            dataType: "JSON",
            data: new FormData(this),
            processData: false,
            contentType: false,
        }).done(function(data){
            if (data.error) {
                $("section > form > ul > li:last-of-type").prepend (
                    '<div class="message error">' + data.error + '</div>'
                );
            } else if (data.success) {
                $("section > form > ul > li:last-of-type").prepend (
                    '<div class="message success">' + data.success + '</div>'
                );
            }
        });
    });

});