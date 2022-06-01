<!-- Breadcrumb pagination -->
<div>
    <ul>
        <li><a href="index.php"><img src="./img/commons/home-icon.svg" alt="Home"></a></li>
        <li><a href="../user-area.php">Area personale</a></li>
        <li><a href="#">Wishlist</a></li>
    </ul>
</div>


<!-- TODO - controllare i tag accessibilità non messi!! -->
<section>
    <table>
        <tr>
            <th></th>
            <th></th>
            <th>Prodotto</th>
            <th>€/pz</th>
            <th>Stock</th>
            <th></th>
        </tr>

        <!-- ciclo for che itera tutti gli elementi nella wishlist dal db
                nel templ param


        -->
        <?php
        if (!empty($templateParams)) {
            foreach($templateParams["fav-elem"] as $prod):?>


            <tr>
                <td><img src="../img/user-page/Delete.svg"  alt="" class="delete"></td>
                <td><img src="<?php echo UPLOAD_DIR_PRODUCTS.$prod['CoverImg'] ?>" alt="" /></td>
                <th><?php echo $prod['Name'] ?></th>
                <td><?php echo $prod['Price'] ?><p><?php echo $prod['DiscountedPrice'] ?> </p></td>
                <td>In Stock<p class="miniText">Quantità: <?php echo $prod['copies'] ?> pz</p></td>
                <td><button class="whiteBtn cartButton" href="./engines/process-request.php?action=addtoCart&id=<?php echo $prod['ProductId']?>">Aggiungi al carrello</button></td>
            </tr>

            <?php endforeach;
        } ?>

    </table>

</section>
