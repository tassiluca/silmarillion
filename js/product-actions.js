const wishImageSelected = "./img/favourite.svg";
const wishImageUnselect = "./img/un-favourite.svg";

$(document).ready(function () {
    if(getCookie("favs") == ""){
        empty = [];
        setCookie("favs", JSON.stringify(empty), 30);
    }

    addEventListenerWishButtons(); //wishlist
    addEventListenerCartButtons(); //cart

    console.log(getCookie('favs'));
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

function updateCookieWishlist(idProd){
    strCookie = getCookie('favs'); //get cookie about wishlist
    curWishlist =JSON.parse(strCookie);

    if(curWishlist.includes(idProd)){//remove element from array if already present
        curWishlist.splice(curWishlist.indexOf(idProd),1); 
    }
    else{//insert to wishlist
        curWishlist.push(idProd);
    }

    var json_str = JSON.stringify(curWishlist);
    setCookie('favs', json_str,30); //keep cookie for 30 days then delete them
}