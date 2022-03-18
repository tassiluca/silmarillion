$(document).ready(function(){
    $.get("test.php", function(data) {
        for (let i = 1; i <= data; i++) {
            $("ul#pagination").append(`<li><a href="">` + i + `</a></li>`);
        }

        $("main > section > footer > ul#pagination > li > a").click(function(e){
            e.preventDefault();
            $.get("test.php", {page : $(this).text()}, function(data){
                $("ul#products").html(data);
            });
        });
    });

    $("ul#products").load("test.php?page=1");

    $("main > section > header > input").keyup(function(){
        $.get("test.php", {pattern : $(this).val()}, function(data){
            $("ul#products").html(data);
        });
    });
    
});