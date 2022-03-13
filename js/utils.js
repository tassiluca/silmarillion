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

function updateWishlist(idProd){
    strCookie = getCookie('favs'); //prendo cookie che mi interessa
    curWishlist =JSON.parse(strCookie); //lo converto in oggetto javascript

    if(curWishlist.includes(idProd)){
    curWishlist.splice(curWishlist.indexOf(idProd));
    }
    else{
    curWishlist.push(idProd);
    }

    var json_str = JSON.stringify(curWishlist);
    setCookie('favs', json_str,30);

    console.log(getCookie('favs'));
}
  