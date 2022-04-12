
$(document).ready(function () {
    refreshCart();
});

function refreshCart(){
    let htmlNavBarCart = "";

    $("section > div > div:first-child() > article, section > div > div:first-child() > p").remove();

    $.post("./engines/process-cart.php?request=getCart", function (data) {
        //console.log(data);
        cart = JSON.parse(data);

        if(cart.length > 0){
//
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
    });
}

/*

<?php 
-                $totalOrderPrice = 0.0;
-                if(isset($templateParams["cart"]) && count($templateParams["cart"]) > 0){
-                    foreach($templateParams["cart"] as $prod):
-            ?>
-            <article id="<?php echo $prod['ProductId']?>">
-                <div><img src="<?php echo UPLOAD_DIR_PRODUCTS.$prod['CoverImg']?>" alt="copertina fumetto"></div>
-                <div>
-                    <header><h3><?php echo $prod['Title']?></h3></header>
-                    <p> €</p>
-                </div>
-                <div>
-                    <div>
-                        <!--here we call php page to add or edit quantity of an article sending a query to specify which product and the action to do-->
-                        <div><a class="cartButtonDec" href="./engines/process-request.php?action=decToCart&id=<?php echo $prod['ProductId']?>"><img src="img/cart/subtract.svg" alt="riduci quantità"></a></div>
-                        <div><p><?php echo $prod['Quantity']?></p></div>
-                        <div><a class="cartButton" href="./engines/process-request.php?action=addtoCart&id=<?php echo $prod['ProductId']?>"><img src="img/cart/plus_math.svg" alt="aumenta quantità"></a></div>
-                    </div>
-                    <div><a class="removeCart" href="./engines/process-request.php?action=delFromCart&id=<?php echo $prod['ProductId']?>">Rimuovi</a></div>
-                </div>
-            </article>
-            <?php 
-                    endforeach;
-                }
-                else{
-                    echo "<p>Carrello vuoto</p>";
-                }    
-            ?>
*/