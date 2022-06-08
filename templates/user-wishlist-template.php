<!-- Breadcrumb pagination -->
<div>
    <ul>
        <li><a href="./index.php"><img src="./img/commons/home-icon.svg" alt="Home"></a></li>
        <li><a href="./user-area.php">Area personale</a></li>
        <li><a href="#">Wishlist</a></li>
    </ul>
</div>


<!-- TODO - controllare i tag accessibilità non messi!! -->
<section>
    <table>
        <tr>
            <th id="delete" > Delete </th>
            <th id="imgProduct" >Image</th>
            <th id="product" >Prodotto</th>
            <th id="price" >€/pz</th>
            <th id="quantity" >Stock</th>
            <th id="addToCart">Add to Cart</th>
        </tr>

        <?php
        if (!empty($templateParams)) {
            foreach($templateParams["fav-elem"] as $prod):?>

            <tr>
                <td headers="delete nameProduct">
                <a class="wishButton" href="./engines/process-request.php?action=wish&amp;id=<?php echo $prod['ProductId']?>">
                    <img src="./img/products/favourite.svg"  alt="rimuovi articolo" class="delete">
                </a>
                </td>
                <td headers="imgProduct nameProduct"><img src="<?php echo UPLOAD_DIR_PRODUCTS.$prod['CoverImg'] ?>" alt="" /></td>
                <th id="nameProduct" ><?php echo $prod['Name'] ?></th>
                <td headers="price nameProduct"><?php echo $prod['Price'] ?><p><?php echo $prod['DiscountedPrice'] ?> </p></td>
                <td headers="quantity nameProduct">In Stock<p class="miniText">Quantità: <?php echo $prod['copies'] ?> pz</p></td>
                <td headers="addToCart nameProduct"><div class="whiteBtn"><a class=" cartButton" href="./engines/process-request.php?action=addtoCart&id=<?php echo $prod['ProductId']?>">Aggiungi al carrello</a></div></td>
            </tr>

            <?php endforeach;
        } ?>

    </table>

</section>
