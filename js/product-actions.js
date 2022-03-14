const wishImageSelected = "./img/favourite.svg";
const wishImageUnselect = "./img/un-favourite.svg";

$(document).ready(function () {
    if(getCookie("favs") == ""){
        empty = [];
        setCookie("favs", JSON.stringify(empty), 30);
    }

    //Favourite button
    $('.wishButton').click(function (e) {
        e.preventDefault();

        btn = $(this);
        urlRequest = btn.attr("href");
        
        handleWishlistAction(btn,urlRequest);
        //console.log(getCookie('favs'));
    });

    //add to cart button
    $('article > footer > div:nth-child(2) > a').click(function (e) { 
        e.preventDefault();
        console.log('cart');
    });

    /**
     * Handle request of add/remove product to wishlist, if customer is logged send request 
     * to sevrer using href link else use cookie to keep wishlist elements
     * @param {object} clickedBtn Element that launch click event
     * @param {string} urlLink href link that button point
     */
    function handleWishlistAction(clickedBtn,urlLink){
    
        var prodId = parseInt(getUrlParameter("id",urlLink));
        $.get(urlLink, function (data) {
            jsonData = JSON.parse(data);
            isLogged = jsonData["isLogged"];
            correctExec = jsonData["execDone"];
    
            if(!isLogged){ //if customer logged = false --> use cookie
                updateCookieWishlist(prodId);
                updateWishIconLink(clickedBtn);
            }
            else{ //user logged = true then check if all goes right on db
                //if something goes wrong with db --> info banner 
                if(!correctExec){//if executon of operation on db has error, shows banner 
                    console.log("errore nella esecuzione della operzione");
                }
                else{
                    updateWishIconLink(clickedBtn);
                }
            }
        });
    }

    function updateWishIconLink(btn){
        newIcon = $(btn).children("img").attr("src") == wishImageUnselect ? wishImageSelected : wishImageUnselect;
        $(btn).children("img").attr("src",newIcon);
    }
});

function updateCookieWishlist(idProd){
    strCookie = getCookie('favs'); //prendo cookie che mi interessa
    curWishlist =JSON.parse(strCookie); //lo converto in oggetto javascript

    if(curWishlist.includes(idProd)){
        curWishlist.splice(curWishlist.indexOf(idProd),1);
    }
    else{
        curWishlist.push(idProd);
    }

    var json_str = JSON.stringify(curWishlist);
    setCookie('favs', json_str,30);
}