
<!-- Breadcrumb pagination -->
<div>
    <ul>
        <li><a href="index.php"><img src="./img/commons/home-icon.svg" alt="Home"></a></li><li>Carrello</li>
    </ul>
</div>
<section>
    <header><h2>Carrello</h2></header>
    <div>
        <div>
            <!-- insert foreach product in cart an article-->
            <!-- insert foreach product in cart an article-->
            <?php 
                $totalOrderPrice = 0.0;
                if(isset($templateParams["cart"]) && count($templateParams["cart"]) > 0){
                    foreach($templateParams["cart"] as $prod):
                        
            ?>
            <article <?php
                    $av = $dbh -> getAvaiableCopiesOfProd($prod['ProductId']);
                    if($prod['Quantity'] > $av){
                        echo 'class="notAvialable" ';
                    }
                    ?>id="<?php echo $prod['ProductId']?>">
                <div><img src="<?php echo UPLOAD_DIR_PRODUCTS.$prod['CoverImg']?>" alt="copertina fumetto"></div>
                <div>
                    <header><h3><?php echo $prod['Title']?></h3></header>
                    <p><?php 
                            if(isset($prod['DiscountedPrice'])){
                                echo $prod['DiscountedPrice'];
                                $totalOrderPrice += $prod['DiscountedPrice']*$prod['Quantity'];
                            }
                            else{
                                echo $prod['Price'];
                                $totalOrderPrice += $prod['Price']*$prod['Quantity'];
                            }?> €</p>
                </div>
                <div>
                    <div>
                        <!--here we call php page to add or edit quantity of an article sending a query to specify which product and the action to do-->
                        <div><a class="cartButtonDec" href="./engines/process-request.php?action=decToCart&id=<?php echo $prod['ProductId']?>"><img src="img/cart/subtract.svg" alt="riduci quantità"></a></div>
                        <div><p><?php echo $prod['Quantity']?></p></div>
                        <div><a class="cartButton" href="./engines/process-request.php?action=addtoCart&id=<?php echo $prod['ProductId']?>"><img src="img/cart/plus_math.svg" alt="aumenta quantità"></a></div>
                    </div>
                    <div><a class="removeCart" href="./engines/process-request.php?action=delFromCart&id=<?php echo $prod['ProductId']?>">Rimuovi</a></div>
                </div>
            </article>
            <?php 
                    endforeach;
                }
                else{
                    echo "<p>Carrello vuoto</p>";
                }    
            ?>
            <!-- end of article list-->
        </div>
        <div>
            <p>Totale:</p><p id="totalPrice"></p>
        </div>
    <div><a <?php 
                    if(isset($templateParams["cart"]) && count($templateParams["cart"]) <= 0){echo "class=disabled";}
                ?> href="payment.html">PROCEDI ALL'ORDINE</a></div>
    </div>
</section>

<!--

-->
