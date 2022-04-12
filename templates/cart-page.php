
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
            
            <!-- end of article list-->
        </div>
        <div>
            <p>Totale:</p><p> €</p>
        </div>
    <div><a <?php 
                    if(isset($templateParams["cart"]) && count($templateParams["cart"]) <= 0){echo "class=disabled";}
                ?> href="payment.html">PROCEDI ALL'ORDINE</a></div>
    </div>
</section>

<!--

-->
