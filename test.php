<?php

    require_once './bootstrap.php';

    if (isset($_GET)) {
        echo "GET : " . $_GET['page'];
        $offset = ($_GET['page'] - 1) * 10;
        $products = $dbh->getProducts($offset, 10);
    }

    foreach($products as $product):
?>
        <li>
            <div>
                <img src="<?php echo UPLOAD_DIR_PRODUCTS . $product['CoverImg']; ?>" alt="" />
            </div>
            <div>
                <strong><a href=""><?php echo $product['ProductId']; ?></a></strong>
            </div>
            <div>
                <a href="">Modifica</a>
                <a href="">Elimina</a>
            </div>
        </li>
<?php 
    endforeach; 
?>