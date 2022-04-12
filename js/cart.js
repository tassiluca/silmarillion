
$(document).ready(function () {
    refreshCart();
});

function refreshTotalPrice(){
    $("#totalPrice").text('');
    $.post("./engines/process-cart.php?request=getCart", function (data) {
        let cart = JSON.parse(data);
        let totalPrice = 0;
        for(let i=0 ;i< cart.length;i++){
            let prod = cart[i];
            price = prod['DiscountedPrice'] !==null ? prod['DiscountedPrice'] : prod['Price'];
            totalPrice += (price*prod['Quantity']);
        }
        $("#totalPrice").text(totalPrice+" €");
    });
}

function checkIfEmptyRefreshCart(actualcartCount){
    if(actualcartCount <= 0){
        $("section > div > div:first-child()").append("<p>Carrello vuoto</p>");
    }
}


function refreshCart(){
    let htmlNavBarCart = "";

    $("section > div > div:first-child() > article, section > div > div:first-child() > p").remove();

    $.post("./engines/process-cart.php?request=getCart", function (data) {
        //console.log(data);
        cart = JSON.parse(data);

        if(cart.length > 0){
            for(let i=0 ;i< cart.length;i++){
                let prod = cart[i];
                price = prod['DiscountedPrice'] !==null ? prod['DiscountedPrice'] : prod['Price'];
                
                htmlNavBarCart += `
                    <article id="`+prod['ProductId']+`">
                        <div><img src="`+UPLOAD_DIR_PRODUCTS+prod['CoverImg']+`" alt="`+prod['CoverImg']+`"></div>
                        <div>
                            <header><h3>`+prod['Title']+`</h3></header>
                            <p>`+price+` €</p>
                        </div>
                        <div>
                            <div>
                                <div><a class="cartButtonDec" href="./engines/process-request.php?action=decToCart&id=`+prod['ProductId']+`"><img src="img/cart/subtract.svg" alt="riduci quantità"></a></div>
                                <div><p>`+prod['Quantity']+`</p></div>
                                <div><a class="cartButton" href="./engines/process-request.php?action=addtoCart&id=`+prod['ProductId']+`"><img src="img/cart/plus_math.svg" alt="aumenta quantità"></a></div>
                            </div>
                            <div><a class="removeCart" href="./engines/process-request.php?action=delFromCart&id=`+prod['ProductId']+`">Rimuovi</a></div>
                        </div>
                    </article>
                `;
            };
        }
        else{
            htmlNavBarCart += "<p>Carrello vuoto</p>";
        }
        
        $("section > div > div:first-child()").append(htmlNavBarCart);
        addEventListenerButton('.removeCart',handleRemoveCartAction);//remove prod from cart
        addEventListenerButton('.cartButtonDec',handleCartAction);//decrement quantity prod cart
        addEventListenerButton('.cartButton',handleCartAction);//increment quantity prod cart
    });
}