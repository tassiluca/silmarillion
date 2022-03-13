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
        updateWishlist(prodId);
        //TODO: check if logged, if not use cookies
        //if customer is logged --> ajax request --> server apply to db --> return status of operation to client javascript
    });

    //add to cart button
    $('article > footer > div:nth-child(2) > a').click(function (e) { 
        e.preventDefault();
        console.log('cart');
    });
});