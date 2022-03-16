<?php
    /** @var DatabaseHelper $dbh */
    require_once __DIR__ . '/bootstrap.php';

    if (isset($_GET)) :
        $offset = ($_GET['page'] - 1) * 4;
        $products = $dbh->getProducts($offset, 4);

        foreach($products as $product):
            $title = ($dbh->isFunko($product['ProductId']) ?
                $dbh->getFunkoById($product['ProductId'])[0]['Title'] :
                $dbh->getComicById($product['ProductId'])[0]['Title']);
?>
            <li>
                <div>
                    <img src="<?php echo UPLOAD_DIR_PRODUCTS . $product['CoverImg']; ?>" alt="" />
                </div>
                <div>
                    <strong><a href="<?php echo "article.php?id=" . $product['ProductId']; ?>">
                            <?php echo $product['ProductId'] . ' ' . $title; ?></a></strong>
                </div>
                <div>
                    <a href="<?php echo "modify-article.php?action=modify&id=" . $product['ProductId']; ?>">Modifica</a>
                    <a href="<?php ?>">Elimina</a>
                </div>
            </li>
<?php
        endforeach;
    endif;
?>