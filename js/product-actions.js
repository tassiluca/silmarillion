const wishImageSelected = "./img/products/favourite.svg";
const wishImageUnselect = "./img/products/un-favourite.svg";
/*
const wishList = 'favs';
const cartList = 'cart';*/

$(document).ready(function () {

    //if not already created -> create empty struct cookie cart and favs
    if(getCookie(wishList) === ""){
            let emptyWishlist = [];
            setCookie(wishList, JSON.stringify(emptyWishlist), 30);
    }
    if(getCookie(cartList) === ""){
        let emptyCart = new Map();
        setCookie(cartList, JSON.stringify(Array.from(emptyCart.entries())), 30);
    }

    addEventListenerButton('.wishButton',handleWishlistAction);//add-remove prod from wishlist
    addEventListenerButton('.removeCart',handleRemoveCartAction);//remove prod from cart
    addEventListenerButton('.cartButtonDec',handleCartAction);//decrement quantity prod cart
    addEventListenerButton('.cartButton',handleCartAction);//increment quantity prod cart
    addEventListenerButton('#productInfo > li:nth-child(3) > a',handleAddAlertProd);//add-remove alert on product avaialability

    getCartInfoCounter();

    // hide message to log in if want to be notified when the product is again available
    $("#productInfo > li:nth-child(3) > div").hide();
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

function handleCartAction(clickedBtn,urlLink){
    let prodId = parseInt(getUrlParameter("id",urlLink));
    var currentAction = getUrlParameter("action",urlLink);
    //console.log("linkRequest: " +urlLink);

    $.get(urlLink, function (data) {
        //console.log("recvData: " + data);
        let jsonData = JSON.parse(data);
        let isLogged = jsonData["isLogged"];
        let correctExec = jsonData["execDone"];
        let countCopies = jsonData["countCopies"];
        let cartCount = jsonData["cartCount"];

        if(countCopies-1 >= 0){
            if(!isLogged){
                //if customer not logged add/edit quantity of prod in cookie cart
                editProductQuantityCookie(prodId,countCopies,currentAction);
            }
            else{ //user logged then check if all goes right on db
                editProdQuantityDatabase(prodId,countCopies,cartCount,currentAction,correctExec);
            }
            refreshCartNavbar();

            if(isCartPage()){
                refreshTotalPrice();
            }
        }
        else if(clickedBtn !==null || countCopies <= 0){
            //if in a while someone bought the product and becomes un-available, disable add to cart button
            clickedBtn.addClass("disabled");
        }

    });
}

function editProdQuantityDatabase(prodId,countCopies,cartCount,currentAction,correctExec){
    if(correctExec){//if executon of operation on db has error, shows banner 
        console.log("errore nella esecuzione della operazione");
    }
    else{
        let prodQuantity = parseInt($("article#"+prodId+" > div > div > div > p").text());
        let amount = (currentAction === "addtoCart") ? 1 : (currentAction === "decToCart" && prodQuantity-1 > 0)? -1 : 0;
        prodQuantity = prodQuantity+amount > countCopies ? countCopies : prodQuantity+amount;
        $("article#"+prodId+" > div > div > div > p").text(prodQuantity);
        refreshCartBadge(cartCount);
    }
}

function editProductQuantityCookie(prodId,countCopies,currentAction){

    let cart = new Map(JSON.parse((getCookie(cartList))));
    let newQuantity = 1;

    if(currentAction === "addtoCart" && cart.has(prodId) && !isNaN(prodId)){ //if already added update cart quantity of prod
        newQuantity = cart.get(prodId)+1 > countCopies ? countCopies : cart.get(prodId)+1;
    }else if(currentAction === "decToCart" && cart.has(prodId) && !isNaN(prodId)){
        newQuantity = cart.get(prodId)-1 >= 0 ?cart.get(prodId)-1 : cart.get(prodId);
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
            //console.log($(".notAvaialable"));
            if($(".notAvaialable").length <= 0){
                $("#cartInfoBanner").remove();
            }
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
            //console.log("NOT LOGGED TO DO THAT ACTION");
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