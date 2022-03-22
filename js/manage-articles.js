/**
 * A string containing the URL to which the ajax requests are sent.
 * @type {string}
 */
const processPage = 'process-management-articles.php';
/**
 * The number of page items to display into the pagination.
 * @type {number}
 */
const pageItems = 3;

/**
 * Calculates the start and stop index according to the current page,
 * the maximum number of pages and the total ones.
 * @param current the current page which is displayed
 * @param maxPages the max number of page items
 * @param totalPages the total amount of products pages
 * @returns {(number|*)[]} an array with the start index in the first
 * position and the stop one in the second.
 */
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

/**
 * Layouts the products list into the section page and the pagination.
 * @param data an array with all the products and the total amount of products.
 * @param actualPage the page currently displayed.
 */
function populateProducts(data, actualPage) {
    const prods = data['products'];
    const totalPages = data['pages'];
    // Layouts the products list
    let productsList = ``;
    for (let i = 0; i < prods.length; i++) {
        productsList += `
            <li>
                <div>
                    <img src="` + prods[i]['CoverImg'] + `" alt="" />
                </div>
                <div>
                    <strong>
                        <a href="article.php?id=` + prods[i]['ProductId'] + `">` + prods[i]['Title'] + `</a>
                    </strong>
                </div>
                <div>
                    <a href="modify-article.php?action=modify&id=` + prods[i]['ProductId'] + `">Modifica</a>
                    <a href="modify-article.php?action=delete&id=` + prods[i]['ProductId'] + `">Elimina</a>
                </div>
            </li>`;
    }
    if (prods.length === 0) {
        productsList += `Nessun prodotto trovato!`;
    }
    $("ul#products").html(productsList);
    // Layouts the pagination
    let paginationList = '';
    const [start, stop] = pagination(actualPage, pageItems, totalPages);
    for (let i = start; i <= stop; i++) {
        paginationList += `<li><a href="">` + i + `</a></li>`;
    }
    $("ul#pagination").html(paginationList);
    // Attach to the pagination item links itself as event handler to re-display the products list
    // when one of them is clicked.letter
    $("main > section > footer > ul#pagination > li > a").click(function(e){
        e.preventDefault();
        const actualPage = parseInt($(this).text());
        if ($("#search-articles").val() === '') {
            $.get(processPage, {page : actualPage}, function(data){
                populateProducts(data, actualPage);
            });
        } else {
            $.get(processPage, {pattern: $("#search-articles").val(), page : actualPage}, function(data){
                populateProducts(data, actualPage);
            });
        }
    });
}

$(document).ready(function() {
    /**
     * [NOTE] The products list is retrieved page per page in order to not get all
     * the products (which could also be **MANY**) and get them only if necessary.
     */
    $.get(processPage, {page:1}, function(data) {
        populateProducts(JSON.parse(data), 1);
    });

    $("main > section > header > input").keyup(function(){
        $.get(processPage, {pattern : $(this).val(), page: 1}, function(data){
            populateProducts(JSON.parse(data), 1);
        });
    });
});