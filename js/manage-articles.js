$(document).ready(function(){

    $("ul#products").load("test.php?page=1");

    $("main > section > footer > ul > li > a").click(function(e){
        e.preventDefault();
        $.get("test.php", {page : $(this).text()}, function(data){
            $("ul#products").html(data);
        });
    });

    $("main > section > header > input").keyup(function(){
        $.get("test.php", {pattern : $(this).val()}, function(data){
            $("ul#products").html(data);
        });
    });
    
});