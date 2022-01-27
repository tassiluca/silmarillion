/* jquery che nasconde tutti i banner  tranne il primo*/

$(document).ready(function () {
  $("main > section:first-child > img.banner").hide();
  $("main > section:first-child > img.banner:first-child").show();
  $("main > section:last-child > div.partner").hide();
  $("main > section:last-child > div.partner:first-child").show();

  updateNewArrival(0);
  showSlide(infoidx);
  
  $(window).resize(function () { 
    updateNewArrival(0);
    updateManga(0);
  });

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
  showDivs(slideIndex += n,"main > section.newArrival > div > article",checkScreenSize());
}

function updateManga(n) {
  showDivs(slideIndex += n,"main > section.manga > div > article",checkScreenSize());
}

function checkScreenSize(){
  var w = window.innerWidth;
  var numElem=1;
  if(w >=1200){
    return 3;
  }
  else if(w >= 820 && w < 1200){
    return 2;
  }
  else{
    return 1;
  }
}

function showDivs(n,slider,slideToShow) {
  var x = $(slider);
  var maxIdxBlock = x.length/slideToShow; //massimo indice di gruppo di slide
  
  if(n > maxIdxBlock){
    n=maxIdxBlock;
    slideIndex=maxIdxBlock;
  }
  if(n < 1){
    n=1;
    slideIndex=1;
  }
  
  x.hide();
  var start=(n*slideToShow)-slideToShow;
  for(k=start;k<x.length && k < n*slideToShow ; k++){
    console.log("slide num: "+ k);
    x[k].style.display = "inline-block";
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