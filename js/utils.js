function getUrlParameter(sParam,url) {

    var sPageURL = window.location.search.substring(1);
    if(url !== undefined){
        sPageURL = url;
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
  