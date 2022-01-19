/* jquery che nasconde tutti i banner  tranne il primo*/

$(document).ready(function () {
  $("main > section:first-child > img.banner").hide();
  $("main > section:first-child > img.banner:first-child").show();
  $("main > section:last-child > div.partner").hide();
  $("main > section:last-child > div.partner:first-child").show();

  $("main > section.comics > div > article").hide();
  $("main > section.comics > div > article:first-child").show();
  
});

var slideIndex = 1;

function updateBanner(n) {
  showDivs(slideIndex += n,"main > section:first-child > img");
}

function updatePartner(n) {
  showDivs(slideIndex += n,"main > section:last-child > div");
}

function updateNewArrival(n) {
  showDivs(slideIndex += n,"main > section.newArrival > div > article");
}

function updateManga(n) {
  showDivs(slideIndex += n,"main > section.manga > div > article");
}

function showDivs(n,slider) {
  var i;
  var x = $(slider);
  if (n > x.length) {slideIndex = 1}
  if (n < 1) {slideIndex = x.length}
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  x[slideIndex-1].style.display = "inline-block";  
}