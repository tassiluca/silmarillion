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
    if(getCookie(wishList) !== ""){
        let emptyWishlist = [];
        setCookie(wishList, JSON.stringify(emptyWishlist), 30);
    }
    if(getCookie(cartList) !== ""){
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
    var fixePrice = toFixedTrunc(price, 2).replace(".", ",");;
    return fixePrice;
}

function toFixedTrunc(x, n) {
    x = toFixed(x)

    // From here on the code is the same than the original answer
    const v = (typeof x === 'string' ? x : x.toString()).split('.');
    if (n <= 0) return v[0];
    let f = v[1] || '';
    if (f.length > n) return `${v[0]}.${f.substr(0,n)}`;
    while (f.length < n) f += '0';
    return `${v[0]}.${f}`
  }

  function toFixed(x) {
    if (Math.abs(x) < 1.0) {
      let e = parseInt(x.toString().split('e-')[1]);
      if (e) {
          x *= Math.pow(10,e-1);
          x = '0.' + (new Array(e)).join('0') + x.toString().substring(2);
      }
    } else {
      let e = parseInt(x.toString().split('+')[1]);
      if (e > 20) {
          e -= 20;
          x /= Math.pow(10,e);
          x += (new Array(e+1)).join('0');
      }
    }
    return x;
  }