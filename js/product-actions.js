const wishImageSelected = "./img/favourite.svg";
const wishImageUnselect = "./img/un-favourite.svg";

const wishList = 'favs';
const cartList = 'cart';

$(document).ready(function () {

    if(getCookie(wishList) === ""){
        let emptyWishlist = [];
        setCookie(wishList, JSON.stringify(emptyWishlist), 30);
    }
    if(getCookie(cartList) === ""){
        let emptyCart = new Map();
        setCookie(cartList, JSON.stringify(Array.from(emptyCart.entries())), 30);
        console.log(getCookie(cartList));
    }

    addEventListenerWishButtons(); //wishlist
    addEventListenerCartButtons(); //cart
    addEventListenerAlertButton(); //alert

});

/**
 * Add event listener on Add alert on product link
 */
function addEventListenerAlertButton(){
    $('#productInfo > li:nth-child(3) > a').click(function (e) {
        e.preventDefault();
        let btn = $(this);
        let urlRequest = btn.attr("href");
        handleAddAlertProd(btn,urlRequest);
    });
}

/**
 * Add event listener to all wishlist buttons
 */
function addEventListenerWishButtons(){
    $('.wishButton').click(function (e) {
        e.preventDefault();
        let btn = $(this);
        let urlRequest = btn.attr("href");
        handleWishlistAction(btn,urlRequest);
    });
}

/**
 * Add event listener to all cart buttons
 */
 function addEventListenerCartButtons(){
    $('.cartButton').click(function (e) {
        e.preventDefault();
        let btn = $(this);
        let urlRequest = btn.attr("href");
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
    let curList = JSON.parse(getCookie(listName));

    if(curList.includes(elem)){//remove element from array if already present
        curList.splice(curList.indexOf(elem),1);
    }
    else{//insert to listName
        curList.push(elem);
    }

    let json_str = JSON.stringify(curList);
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

    let prodId = parseInt(getUrlParameter("id",urlLink));
    $.get(urlLink, function (data) {
        let jsonData = JSON.parse(data);
        let isLogged = jsonData["isLogged"];
        let action = jsonData["action"];
        let correctExec = jsonData["execDone"];

        if(!isLogged){ //if customer logged = false --> use cookie
            updateCookielist(wishList,prodId);
            let newIcon = $(clickedBtn).children("img").attr("src") == wishImageUnselect ? wishImageSelected : wishImageUnselect;
            $(clickedBtn).children("img").attr("src",newIcon);
        }
        else{ //user logged = true then check if all goes right on db
            //if something goes wrong with db --> info banner 
            if(!correctExec){//if executon of operation on db has error, shows banner 
                console.log("errore nella esecuzione della operzione: "+action);
            }
            else{
                if(action == 'addFav'){
                    $(clickedBtn).children("img").attr("src",wishImageSelected);
                }
                else if(action == 'removeFav'){
                    $(clickedBtn).children("img").attr("src",wishImageUnselect);
                }
            }
        }
    });
}

//-----------------------WISHLIST--------------------------//

//--------------------------CART--------------------------//
function handleCartAction(clickedBtn,urlLink){
    var prodId = parseInt(getUrlParameter("id",urlLink));
    $.get(urlLink, function (data) {
        let jsonData = JSON.parse(data);
        let isLogged = jsonData["isLogged"];
        let correctExec = jsonData["execDone"];
        let action = jsonData["action"];
        let countCopies = jsonData["count"];
        
        if(countCopies-1 > 0){ 
            if(!isLogged){ //if customer logged = false --> use cookie
                let cart = new Map(JSON.parse((getCookie(cartList))));

                if(cart.has(prodId)){ //if already added update cart quantity of prod
                    let newQuantity = cart.get(prodId)+1;
                    cart.set(prodId,newQuantity);
                }
                else{ //add to cart for first time
                    cart.set(prodId,1);
                }
                setCookie(cartList, JSON.stringify(Array.from(cart.entries())), 30);
            }
            else{ //user logged = true then check if all goes right on db
                //if something goes wrong with db --> info banner 
                if(!correctExec){//if executon of operation on db has error, shows banner 
                    console.log("errore nella esecuzione della operzione: "+action);
                }
            }
        }
        else{//if in a while someone bought the product and becomes un-available, disable add to cart button
            clickedBtn.addClass("disabled");
        }

    });
}

//------------------------ALERT---------------------------//

function handleAddAlertProd(clickedBtn,urlLink){
    $.get(urlLink, function (data) {
        let jsonData = JSON.parse(data);
        let isLogged = jsonData["isLogged"];
        let action = jsonData["action"];
        let correctExec = jsonData["execDone"];

        if(!isLogged){
            console.log("NOT LOGGED TO DO THAT ACTION");
            $("#productInfo > li:nth-child(3) > div ").show();
        }

        if(isLogged && correctExec && action == 'removeAlert' ){
            $("#productInfo > li:nth-child(3) > a ").text("Avvisami quando questo prodotto sarà disponibile");
        }
        else if(isLogged && correctExec && action == 'addAlert'){
            $("#productInfo > li:nth-child(3) > a ").text("Rimuovi notifica");
        }
    });
}