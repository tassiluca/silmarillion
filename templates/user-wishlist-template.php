<!-- Breadcrumb pagination -->
<div>
    <ul>
        <li><a href="./index.php"><img src="./img/commons/home-icon.svg" alt="Home"></a></li>
        <li><a href="./user-area.php">Area personale</a></li>
        <li><a href="#">Wishlist</a></li>
    </ul>
</div>

<section>
    <h3></h3>
    <table>
        <tr>
            <th id="delete" scope="col" > Delete </th>
            <th id="imgProduct" scope="col">Image</th>
            <th id="product" scope="col">Prodotto</th>
            <th id="price" scope="col">€/pz</th>
            <th id="quantity" scope="col">Stock</th>
            <th id="addToCart" scope="col">Add to Cart</th>
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
                <th id="nameProduct" scope="row" ><?php echo $prod['Name'] ?></th>
                <td headers="price nameProduct"><?php
                    if ($prod['DiscountedPrice']!= null)
                        echo $prod['DiscountedPrice'];
                    else echo $prod['Price'] ; ?> €
                   </td>
                <td headers="quantity nameProduct">
                    <?php if($prod['copies'] == 0)
                            echo "Esaurito";
                        else
                            echo "In Stock";
                    ?><p class="miniText">
                    Quantità: <?php echo $prod['copies'] ?> pz</p></td>
                <td headers="addToCart nameProduct">
                    <div <?php if ($prod['copies'] == null) echo 'class="noProd"'; else echo 'class="whiteBtn"' ?>>
                        <a class="cartButton" href="./engines/process-request.php?action=addtoCart&id=<?php echo $prod['ProductId']; ?>">
                            Aggiungi al carrello
                        </a>
                    </div>
                </td>
            </tr>
            <?php endforeach;
        } ?>
    </table>
</section>
