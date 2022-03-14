$(document).ready(function () {
    if(getCookie("favs") == ""){
        empty = [];
        setCookie("favs", JSON.stringify(empty), 30);
    }
    //Favourite button
    $('article > footer > div:first-child > a').click(function (e) { 
        e.preventDefault();
        urlRequest = $(this).attr("href");
        var prodId = parseInt(getUrlParameter("id",urlRequest));
        
        $.get(urlRequest, function (data) {
            console.log(data);
            jsonData = JSON.parse(data);
            isLogged = jsonData["isLogged"];
            correctExec = jsonData["execDone"];

            if(!isLogged){ //if customer logged = false --> use cookie
                updateCookieWishlist(prodId);
            }
            else{ //user logged = true then check if all goes right on db
                //if something goes wrong with db --> info banner 
                if(!correctExec){//if executon of operation on db has error, shows banner 
                    console.log("errore nella esecuzione della operzione");
                }
            }
            }
        );
    });

    //add to cart button
    $('article > footer > div:nth-child(2) > a').click(function (e) { 
        e.preventDefault();
        console.log('cart');
    });
});