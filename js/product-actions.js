const wishImageSelected = "./img/favourite.svg";
const wishImageUnselect = "./img/un-favourite.svg";

$(document).ready(function () {
    if(getCookie("favs") == ""){
        empty = [];
        setCookie("favs", JSON.stringify(empty), 30);
    }

    //Favourite button
    $('article > footer > div:first-child > a').click(function (e) {
        e.preventDefault();
        
        btn = $(this);

        urlRequest = btn.attr("href");
        var prodId = parseInt(getUrlParameter("id",urlRequest));
        
        $.get(urlRequest, function (data) {
            jsonData = JSON.parse(data);
            isLogged = jsonData["isLogged"];
            correctExec = jsonData["execDone"];

            if(!isLogged){ //if customer logged = false --> use cookie
                updateCookieWishlist(prodId);
                updateWishIconLink(btn);
            }
            else{ //user logged = true then check if all goes right on db
                //if something goes wrong with db --> info banner 
                if(!correctExec){//if executon of operation on db has error, shows banner 
                    console.log("errore nella esecuzione della operzione");
                }
                else{
                    updateWishIconLink(btn);
                }
            }
        });
        console.log(getCookie('favs'));
    });

    //add to cart button
    $('article > footer > div:nth-child(2) > a').click(function (e) { 
        e.preventDefault();
        console.log('cart');
    });

    function updateWishIconLink(btn){
        newIcon = $(btn).children("img").attr("src") == wishImageUnselect ? wishImageSelected : wishImageUnselect;
        $(btn).children("img").attr("src",newIcon);
    }
});