/* jquery che nasconde tutti i banner  tranne il primo*/

$(document).ready(function () {
  $("main > section:first-child > img.banner").hide();
  $("main > section:first-child > img.banner:first-child").show();
  $("main > section:last-child > div.partner").hide();
  $("main > section:last-child > div.partner:first-child").show();

  updateNewArrival(0);
  showSlide(infoidx);
  
  var sizeInfoBanner = $("main > aside > div:first-child > div.infoBanner").length;
  autoSlide();
  function autoSlide(){
    infoidx++;
    if(infoidx > sizeInfoBanner){
      infoidx = 1;
    }
    showSlide(infoidx);
    setTimeout(autoSlide, 5000);
  }
});

var slideIndex = 1;

function updateBanner(n) {
  showDivs(slideIndex += n,"main > section:first-child > img",1);
}

function updatePartner(n) {
  showDivs(slideIndex += n,"main > section:last-child > div",1);
}

function updateNewArrival(n) {
  showDivs(slideIndex += n,"main > section.newArrival > div > article",3);
}

function updateManga(n) {
  showDivs(slideIndex += n,"main > section.manga > div > article",3);
}

function showDivs(n,slider,quantity) {
  var x = $(slider);
  if (n > x.length) {slideIndex = 1}
  if (n < 1) {slideIndex = x.length}
  x.hide();

  for(var k=0; k<quantity && slideIndex-1+k < x.length;k++){
    elem = slideIndex-1+k;
    x[elem].style.display = "inline-block";
  }

}

var infoidx = 1;
/* Aside banner */
function showSlide(n){
  infoidx = n;
  $("main > aside > div:first-child > div.infoBanner").hide();
  $("main > aside > div:first-child > div.infoBanner:nth-child("+n+")").show();
  
  /*dot indicator */
  $("main > aside > div:last-child > div").removeClass("current");
  $("main > aside > div:last-child > div:nth-child("+n+")").addClass("current");
}