function populateHtml(products) {
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
                        <a href="">Modifica</a>
                        <a href="">Elimina</a>
                    </div>
                </li>`;
    }
    $("ul#products").html(productsList);
    paginationList = '';
    for (let i = 1; i <= data['pages']; i++) {
        paginationList += `<li><a href="">` + i + `</a></li>`;
    }
    $("ul#pagination").html(paginationList);
    $("main > section > footer > ul#pagination > li > a").click(function(e){
        e.preventDefault();
        if ($("#search-articles").val() === '') {
            $.get("process-management-articles.php", {page : $(this).text()}, function(data){
                populateHtml(data);
            });
        } else {
            $.get("process-management-articles.php", {pattern: $("#search-articles").val(), page : $(this).text()}, function(data){
                populateHtml(data);
            });
        }
    });
}


$(document).ready(function(){
    $.get("process-management-articles.php", {page:1}, function(products) {
        populateHtml(products);
    });

    $("main > section > header > input").keyup(function(){
        $.get("process-management-articles.php", {pattern : $(this).val(), page: 1}, function(data){
            populateHtml(data);
        });
    });
});