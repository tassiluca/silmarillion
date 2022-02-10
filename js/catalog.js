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
            //console.log(data);
            updateCatalogView(data);
        });
}

function updateCatalogView(jsonData){
    var prods = JSON.parse(jsonData);
    console.log(prods);
    var prodListHTML ='';
    for(let e in prods){
        var disabled = e["copies"]<= 0 ? 'class="disabled"' : '';
        var price = e["DiscountedPrice"] === null? e["Price"] : e["DiscountedPrice"];
        
        prodListHTML += '<article><div><img src="img/comics/'+e["CoverImg"]+' alt='+e["CoverImg"]+'></div><header><a href=\"article.php?id=' + e["ProductId"] +
                        '"><h3>'+e["Title"]+'</h3></a></header><footer><div><a ' + disabled+' href="gestisci-richieste.php?action=wish&id='+
                        e["ProductId"]+'"><img src="./img/favourite.svg" alt="Aggiungi ai preferiti"/></a></div>'+
                        '<div><a '+ disabled + ' href="gestisci-richieste.php?action=addtoCart&id='+e["ProductId"]+
                        '"><img src="./img/add.svg" alt="Aggiungi al carrello"/></a></div><div><p>'+price+'</p></div></footer></article>';
    };
    $('main > section').innerHTML = prodListHTML;
}