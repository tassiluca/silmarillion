const wishList = 'favs';
const cartList = 'cart';

function getUrlParameter(sParam,url) {

    var sPageURL = window.location.search.substring(1);
    if(url !== undefined && url.includes('?')){
        sPageURL = url.split('?')[1];
    }

    var sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
    return false;
};

function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    let expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/;SameSite=Lax";
} 

function initUserCookies(){
    if(getCookie(wishList) === ""){
        let emptyWishlist = [];
        setCookie(wishList, JSON.stringify(emptyWishlist), 30);
    }
    if(getCookie(cartList) === ""){
        let emptyCart = new Map();
        setCookie(cartList, JSON.stringify(Array.from(emptyCart.entries())), 30);
    }
}

function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for(let i = 0; i <ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }

function getLenCookie(cookieName){
    var cookieString = getCookie(cookieName);
    let cartLen = 0;

    if(cookieString !== "") {
        cartLen = JSON.parse((getCookie(cookieName))).length;

    }

    return cartLen;
}

function isCartPage(){
    return window.location.href === location.origin+"/cart.php";
}

//----------------CART------------------//

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

        if(isCartPage()){
            $("main > section > div > div:last-child() > a").addClass("disabled");
            
        }
    }
    refreshCartNavbar();
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

function formatPrice(price) {
    return price.toString().replace(".", ",");
}