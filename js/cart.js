
$(document).ready(function () {
    refreshCart();
});

function refreshCart(){
    let htmlNavBarCart = "";
    let amountProds = 2;
    $("#navCart > ul > p").remove();
    $("#navCart > ul > li").remove();

    $.post("./engines/process-cart.php?request=navBar", function (data) {
        //console.log(data);
        cart = JSON.parse(data);

        if(cart.length > 0){
            for(let i = cart.length-1; i >= 0 && i > cart.length-amountProds-1;i--){
                let prod = cart[i];
                console.log(prod);
                price = prod['DiscountedPrice'] !==null ? prod['DiscountedPrice'] : prod['Price'];
                htmlNavBarCart += `
                    <li>
                        <img src="`+UPLOAD_DIR_PRODUCTS+prod['CoverImg']+`" alt="">
                        <div>
                            <p>`+prod['Title']+`</p>
                            <div>
                                <p>`+price+` €</p>
                                <p>x`+prod["Quantity"]+`</p>
                            </div>
                        </div>
                    </li>`;
            }
        }
        else{
            htmlNavBarCart += "<p>Carrello vuoto</p>";
        }
        
        $("#navCart > ul").append(htmlNavBarCart);
    });