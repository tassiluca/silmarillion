const filters = {
    lang: [],
    author: [],
    price: [],
    availability: [],
    publisher: [],
    category: []
};
var recvData;
function hideElement(element) {
    element
        .removeClass("selected")
        .next().slideUp();
}

$(document).ready(function(){
    submitFilters(filters);
    $("main > aside > button").click(function(){
        if ($(this).hasClass("selected")) {
            hideElement($(this));
        } else {
            $(this)
                .addClass("selected")
                .next().slideDown();
        }
    })

    $("main > aside > ul > li > input").click(function(){
        var isChecked = $(this).is(':checked');
        var type = $(this).attr('class');

        if(isChecked){
            filters[type].push($(this).attr("name"));
        }
        else{
            filters[type].splice(filters[type].indexOf($(this).attr("name")),1);
        }
        submitFilters(filters);
    })

});

var numPages = 1;
var prods;
var idxPage = 0;
const NUM_PROD_PAGE = 8; //amount of products per page to be shown

function submitFilters(allFilter){
    $.post("utils/process-filters.php", allFilter,
        function (data,status) {
            console.log(status);
            prods = JSON.parse(data);
            numPages = Math.floor(prods.length / NUM_PROD_PAGE);

            changePage(0); //passing zero when don't affect default page idxPage = 0
            updateCatalogView(0);//show all products of page 0
        });
}

function changePage(incOrDec){
    var tmpIdxPage = idxPage + incOrDec;
    idxPage = tmpIdxPage < 0 ? 0 : tmpIdxPage > numPages ? numPages: tmpIdxPage;
    //console.log('idx: ' + idxPage + ' numPages: ' + numPages );
    updateCatalogView(idxPage);
}

/**
 * Refresh catalog page, showing prods that correpsond to filters selected
 */
function updateCatalogView(idxPage){
    $('main > section > article').remove();
    $('main > section > p').remove();
    var prodListHTML ='';
    if(prods.length <= 0){
        prodListHTML += '<p>Articoli Non Trovati, hai filtrato tropoo!!</p>';
    }
    else{
        var start = idxPage * NUM_PROD_PAGE;
        var end = (idxPage * NUM_PROD_PAGE) + NUM_PROD_PAGE;
        //console.log('Start: ' + start + ' end: ' + end);

        for(let i=start; i < end && i < prods.length;i++){
            var disabled = prods[i].copies<= 0 ? 'class="disabled"' : '';
            var price = prods[i].DiscountedPrice === null? prods[i].Price : prods[i].DiscountedPrice;
            prodListHTML += '<article><div><img src="img/comics/'+prods[i].CoverImg+'" alt='+prods[i].CoverImg+'></div><header><a href=\"article.php?id=' + prods[i].ProductId +
                            '"><h3>'+prods[i].Title+'</h3></a></header><footer><div><a href="gestisci-richieste.php?action=wish&id='+
                            prods[i].ProductId+'"><img src="./img/favourite.svg" alt="Aggiungi ai preferiti"/></a></div>'+
                            '<div><a '+ disabled + ' href="gestisci-richieste.php?action=addtoCart&id='+prods[i].ProductId+
                            '"><img src="./img/add.svg" alt="Aggiungi al carrello"/></a></div><div><p>'+price+'</p></div></footer></article>';
        };
    }
    
    $('main > section:first-of-type()').append(prodListHTML);
}