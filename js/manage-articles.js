function pagination(current, maxPages, totalPages) {
    let start, stop;
    if (totalPages <= maxPages) {
        start = 1;
        stop = totalPages;
    } else {
        const maxPagesBeforeCurrent = Math.floor(maxPages / 2);
        const maxPagesAfterCurrent = Math.ceil(maxPages / 2) - 1;
        if (current <= maxPagesBeforeCurrent) {
            start = 1;
            stop = maxPages;
        } else if (current + maxPagesAfterCurrent >= totalPages) {
            start = totalPages - maxPages + 1;
            stop = totalPages;
        } else {
            start = current - maxPagesBeforeCurrent;
            stop = current + maxPagesAfterCurrent;
        }
    }
    return [start, stop];
}

function populateHtml(products, actualPage) {
    const data = JSON.parse(products);
    const prods = data['products'];
    productsList = '';
    for (let i = 0; i < prods.length; i++) {
        productsList += `
                <li>
                    <div>
                        <img src="` + prods[i]['CoverImg'] + `" alt="" />
                    </div>
                    <div>
                        <strong>
                            <a href="">` + prods[i]['Title'] + `</a>
                        </strong>
                    </div>
                    <div>
                        <a href="modify-article.php?action=modify&id=` + prods[i]['ProductId'] + `">Modifica</a>
                        <a href="modify-article.php?action=delete&id=` + prods[i]['ProductId'] + `">Elimina</a>
                    </div>
                </li>`;
    }
    $("ul#products").html(productsList);
    /// ------ PAGINATION ------
    let paginationList = '';
    const [start, stop] = pagination(actualPage, 3, data['pages']);
    for (let i = start; i <= stop; i++) {
        paginationList += `<li><a href="">` + i + `</a></li>`;
    }
    $("ul#pagination").html(paginationList);
    /// ------ PAGINATION ------
    $("main > section > footer > ul#pagination > li > a").click(function(e){
        e.preventDefault();
        const actualPage = parseInt($(this).text());
        if ($("#search-articles").val() === '') {
            $.get("process-management-articles.php", {page : actualPage}, function(data){
                populateHtml(data, actualPage);
            });
        } else {
            $.get("process-management-articles.php", {pattern: $("#search-articles").val(), page : actualPage}, function(data){
                populateHtml(data, actualPage);
            });
        }
    });
}


$(document).ready(function(){
    $.get("process-management-articles.php", {page:1}, function(products) {
        populateHtml(products, 1);
    });

    $("main > section > header > input").keyup(function(){
        $.get("process-management-articles.php", {pattern : $(this).val(), page: 1}, function(data){
            populateHtml(data, 1);
        });
    });
});