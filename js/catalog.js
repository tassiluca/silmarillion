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
    
    var numPages = 1;
    var prods;
    var idxPage = 0;
    const NUM_PROD_PAGE = 3; //amount of products per page to be shown

    /**
     * Send a request to server to get all prods matching filters
     * then refresh showed prods
     * @param {*} allFilter filters of priducts to be applied
     */
    function submitFilters(allFilter){
        $.post("utils/process-filters.php", allFilter,
            function (data,status) {
                prods = JSON.parse(data);
                numPages = Math.floor(prods.length / NUM_PROD_PAGE);
                updateCatalogView(0);//show all products of page 0
            });
    }

    //go to previous page of catalog
    $('main > section:last-of-type > footer > ul > li:first-child > a').click(function(e){
        e.preventDefault();
        var newIdx = updateIdxPage(-1,numPages);
        updateCatalogView(newIdx);

    })

    //next page of catalog
    $('main > section:last-of-type > footer > ul > li:last-child > a').click(function(e){
        e.preventDefault();
        var newIdx = updateIdxPage(1,numPages);
        updateCatalogView(newIdx);
    })

    /**
     * Get updated index of catalog page
     * @param {int} incOrDec increment or decremet value to calc new index
     * @param {int} numPages amount of catalog pages
     * @returns updated idx page to be shown
     */
    function updateIdxPage(incOrDec,numPages){
        var tmpIdxPage = idxPage + incOrDec;
        idxPage = tmpIdxPage < 0 ? 0 : tmpIdxPage > numPages ? numPages: tmpIdxPage;
        idxPage = (idxPage * NUM_PROD_PAGE) +1 > prods.length ? idxPage -1 : idxPage;
        return idxPage;
    }

    /**
     * Refresh catalog page, showing prods that correpsond to filters selected and the page selected
     * @param {int} idxPage index page to be shown
     */
    function updateCatalogView(idxPage){
        $('main > section > article').remove();
        $('main > section > p').remove();
        $('main > section:last-of-type > footer > ul > li > p').empty();
        $('main > section:last-of-type > footer > ul > li > p').append(idxPage+1 +'/'+numPages );
        var prodListHTML ='';
        if(prods.length <= 0){
            prodListHTML += '<p>Articoli Non Trovati</p>';
        }
        else{
            var start = idxPage * NUM_PROD_PAGE;
            var end = (idxPage * NUM_PROD_PAGE ) + NUM_PROD_PAGE;
            
            for(let i=start; i < end && i < prods.length;i++){
                var disabled = prods[i].copies<= 0 ? 'class="disabled"' : '';
                var price = prods[i].DiscountedPrice === null? prods[i].Price : prods[i].DiscountedPrice;
                prodListHTML += '<article><div><a href="article.php?id='+prods[i].ProductId+'"><img src="img/comics/'+prods[i].CoverImg+'" alt='+prods[i].CoverImg+'></a></div><header><a href=\"article.php?id=' + prods[i].ProductId +
                                '"><h3>'+prods[i].Title+'</h3></a></header><footer><div><a href="gestisci-richieste.php?action=wish&id='+
                                prods[i].ProductId+'"><img src="./img/favourite.svg" alt="Aggiungi ai preferiti"/></a></div>'+
                                '<div><a '+ disabled + ' href="gestisci-richieste.php?action=addtoCart&id='+prods[i].ProductId+
                                '"><img src="./img/add.svg" alt="Aggiungi al carrello"/></a></div><div><p>'+price+'</p></div></footer></article>';
            };
        }
        $('main > section:first-of-type()').append(prodListHTML);
    }

});