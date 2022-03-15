const wishImageSelected = "./img/favourite.svg";
const wishImageUnselect = "./img/un-favourite.svg";

const wishList = 'favs';
const cartList = 'cart';

$(document).ready(function () {
    empty = []; //TODO: make it better and keep D.R.Y.
    if(getCookie("favs") == ""){
        setCookie("favs", JSON.stringify(empty), 30);
    }
    if(getCookie("cart") == ""){
        setCookie("cart", JSON.stringify(empty), 30);
    }

    addEventListenerWishButtons(); //wishlist
    addEventListenerCartButtons(); //cart

    //console.log(getCookie('favs'));
});

/**
 * Add event listener to all wishlist buttons
 */
function addEventListenerWishButtons(){
    $('.wishButton').click(function (e) {
        e.preventDefault();
        btn = $(this);
        urlRequest = btn.attr("href");
        handleWishlistAction(btn,urlRequest);
    });
}

/**
 * Add event listener to all cart buttons
 */
 function addEventListenerCartButtons(){
    $('.cartButton').click(function (e) {
        e.preventDefault();
        btn = $(this);
        urlRequest = btn.attr("href");
        handleCartAction(btn,urlRequest);
    });
}
/**
 * Update cookie list adding or removing the idProd param from list saved in cookie of name listName
 * If elem is and object the check if already present become always true, make check before passing
 * @param {string} listName name of cookie-list where add/remove idProd
 * @param {*} elem unique product id
 */
function updateCookielist(listName,elem){
    curList =JSON.parse(getCookie(listName));

    if(curList.includes(elem)){//remove element from array if already present
        curList.splice(curList.indexOf(elem),1);
    }
    else{//insert to listName
        curList.push(elem);
    }

    var json_str = JSON.stringify(curList);
    setCookie(listName, json_str,30); //keep cookie for 30 days then delete them
}

//-----------------------WISHLIST--------------------------//
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
            updateCookielist(wishList,prodId);
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
//-----------------------WISHLIST--------------------------//

//--------------------------CART--------------------------//
function handleCartAction(clickedBtn,urlLink){
    var prodId = parseInt(getUrlParameter("id",urlLink));
    $.get(urlLink, function (data) {

        jsonData = JSON.parse(data);
        isLogged = jsonData["isLogged"];
        correctExec = jsonData["execDone"];
        countCopies = jsonData["count"];

        if(!isLogged){ //if customer logged = false --> use cookie
            isPresent = isInCookieCart(prodId);
            console.log(article);
            if(isPresent){

            }
            else{ //append new article
                updateCookielist(cartList,article);
            }
            
        }
        else{ //user logged = true then check if all goes right on db
            //if something goes wrong with db --> info banner 
            if(!correctExec){//if executon of operation on db has error, shows banner 
                console.log("errore nella esecuzione della operzione");
            }
            else{
                updateCartLink(clickedBtn);
            }
        }
    });
}

/**
 * Find fisrt occurence of product-obj that 'id' is equal to prodId
 * @param {*} prodId Product id to search
 * @returns Product object
 */
function isInCookieCart(prodId){
    cart = JSON.parse(getCookie(cartList));
    len = cart.length;
    for(var i=0;i<len;i++){
        console.log(cart[i]);
        if(cart[i].id == prodId){
           return true;
        }
    }
    return false;
}