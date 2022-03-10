$(document).ready(function(){

    $("ul#products").load("test.php?page=1");

    $("main > section > footer > ul > li > a").click(function(e){
        e.preventDefault();
        $.get("test.php", {page : $(this).text()}, function(data){
            $("ul#products").html(data);
        });
    });
    
});