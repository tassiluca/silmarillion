const filters = {
    lang: [],
    author: [],
    price: [],
    availability: [],
    publisher: [],
    category: []
};

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

function submitFilters(allFilter){
    $.post("utils/process-filters.php", allFilter,
        function (data,status) {
            //console.log(data); //all php prints are showed here in console browser
            updateCatalogView(data);
        });
}

function updateCatalogView(jsonData){
    var prods = JSON.parse(jsonData);
    $('main > section > article').remove();
    $('main > section > p').remove();
    var prodListHTML ='';
    if(prods.length <= 0){
        prodListHTML += '<p>Articoli Non Trovati, hai filtrato tropoo!!</p>';
    }
    else{
        for(let i in prods){
            var disabled = prods[i].copies<= 0 ? 'class="disabled"' : '';
            var price = prods[i].DiscountedPrice === null? prods[i].Price : prods[i].DiscountedPrice;
            prodListHTML += '<article><div><img src="img/comics/'+prods[i].CoverImg+'" alt='+prods[i].CoverImg+'></div><header><a href=\"article.php?id=' + prods[i].ProductId +
                            '"><h3>'+prods[i].Title+'</h3></a></header><footer><div><a ' + disabled+' href="gestisci-richieste.php?action=wish&id='+
                            prods[i].ProductId+'"><img src="./img/favourite.svg" alt="Aggiungi ai preferiti"/></a></div>'+
                            '<div><a '+ disabled + ' href="gestisci-richieste.php?action=addtoCart&id='+prods[i].ProductId+
                            '"><img src="./img/add.svg" alt="Aggiungi al carrello"/></a></div><div><p>'+price+'</p></div></footer></article>';
        };
    }
    
    $('main > section ').prepend(prodListHTML);
}