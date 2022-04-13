const wishImageSelected = "./img/products/favourite.svg";
const wishImageUnselect = "./img/products/un-favourite.svg";

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

    addEventListenerButton('.wishButton',handleWishlistAction);//add-remove prod from wishlist
    addEventListenerButton('.removeCart',handleRemoveCartAction);//remove prod from cart
    addEventListenerButton('.cartButtonDec',handleCartAction);//decrement quantity prod cart
    addEventListenerButton('.cartButton',handleCartAction);//increment quantity prod cart
    addEventListenerButton('#productInfo > li:nth-child(3) > a',handleAddAlertProd);//add-remove alert on product avaialability

    getCartInfoCounter();
});

function addEventListenerButton(jQuerySelector,methodToRun){
    $(jQuerySelector).click(function (e) {
        e.preventDefault();
        let btn = $(this);
        let urlRequest = btn.attr("href");
        methodToRun(btn,urlRequest);
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

function getCartInfoCounter(){
    $.get('./engines/process-request.php?action=getInfo', function (data) {
        //console.log("Update cart badge");
        let jsonData = JSON.parse(data);
        let isLogged = jsonData["isLogged"];
        let actualcartCount = jsonData["cartCount"];
        if(isLogged){
            refreshCartBadge(actualcartCount);
        }
        else{
            refreshCartBadge(getLenCookie(cartList));
        }
        refreshCartNavbar();
    });
}

function handleCartAction(clickedBtn,urlLink){
    let prodId = parseInt(getUrlParameter("id",urlLink));
    var currentAction = getUrlParameter("action",urlLink);

    $.get(urlLink, function (data) {
        //console.log(data);
        let jsonData = JSON.parse(data);
        let isLogged = jsonData["isLogged"];
        let correctExec = jsonData["execDone"];
        let action = jsonData["action"];
        let countCopies = jsonData["countCopies"];
        let cartCount = jsonData["cartCount"];

        if(countCopies-1 > 0){
            let badgeCount = 0;
            if(!isLogged){ //if customer logged = false --> use cookie
                editProductQuantityCookie(prodId,currentAction);
            }
            else{ //user logged = true then check if all goes right on db
                //if something goes wrong with db --> info banner 
                if(correctExec){//if executon of operation on db has error, shows banner 
                    console.log("errore nella esecuzione della operzione: "+action);
                }
                else{
                    let actualCount = parseInt($("article#"+prodId+" > div > div > div > p").text());
                    let amount = (currentAction === "addtoCart") ? 1 : (currentAction === "decToCart" && actualCount-1 > 0)? -1 : 0;
                    badgeCount = cartCount;
                    $("article#"+prodId+" > div > div > div > p").text(actualCount+amount);
                }
            }
            
            refreshCartNavbar();
            refreshTotalPrice();
        }
        else if(clickedBtn !==null){//if in a while someone bought the product and becomes un-available, disable add to cart button
            clickedBtn.addClass("disabled");
        }

    });
}

function editProductQuantityCookie(prodId,currentAction){

    let cart = new Map(JSON.parse((getCookie(cartList))));
    let newQuantity = 1;

    if(currentAction === "addtoCart" && cart.has(prodId) && !isNaN(prodId)){ //if already added update cart quantity of prod
        newQuantity = cart.get(prodId)+1;
    }else if(currentAction === "decToCart" && cart.has(prodId) && !isNaN(prodId)){
        newQuantity = cart.get(prodId)-1 > 0 ?cart.get(prodId)-1 : cart.get(prodId);
    }
    else if(!isNaN(prodId)){ //add to cart for first time
        newQuantity = 1;
    }
    cart.set(prodId,newQuantity);
    setCookie(cartList, JSON.stringify(Array.from(cart.entries())), 30);
    $("article#"+prodId+" > div > div > div > p").text(newQuantity);
    refreshCartBadge(getLenCookie(cartList));
}

function handleRemoveCartAction(clickedBtn,urlLink){
    var prodId = parseInt(getUrlParameter("id",urlLink));

    $.get(urlLink, function (data) {
        //console.log(data);
        let jsonData = JSON.parse(data);
        let isLogged = jsonData["isLogged"];
        let correctExec = jsonData["execDone"];
        let actualcartCount = jsonData["cartCount"];

        if(!isLogged){
            let cart = new Map(JSON.parse((getCookie(cartList))));
            cart.delete(prodId);
            setCookie(cartList, JSON.stringify(Array.from(cart.entries())), 30);
            correctExec = true;
            actualcartCount = getLenCookie(cartList);;
        }
        if(correctExec === true){
            $("article#"+prodId).remove();
            refreshCartBadge(actualcartCount);
            refreshCartNavbar();
            refreshTotalPrice();
            checkIfEmptyRefreshCart(actualcartCount);
        }
    });
}

function refreshCartBadge(currentCount){
    if(currentCount <= 0){
        $('#cart_badge').hide();
    }
    else{
        $('#cart_badge').text(currentCount);
        $('#cart_badge').show();
    }
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