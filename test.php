<?php
    /** @var DatabaseHelper $dbh */
    require_once __DIR__ . '/bootstrap.php';

    const PRODUCTS_PER_PAGE = 3;

    if (isset($_GET['page'])) :
        $offset = ($_GET['page'] - 1) * PRODUCTS_PER_PAGE;
        $products = $dbh->getProducts($offset, PRODUCTS_PER_PAGE);
    elseif (isset($_GET['pattern'])):
        $products = $dbh->getProducts(0, 10, $_GET['pattern']);
    else:
        $totalAmountOfProducts = count(array_merge($dbh->getComics(), $dbh->getFunkos()));
        $totalPages = ceil($totalAmountOfProducts / PRODUCTS_PER_PAGE);
        echo $totalPages;
    endif;

    if (isset($_GET['page']) || isset($_GET['pattern'])):
        foreach($products as $product):
            ?>
            <li>
                <div>
                    <img src="<?php echo UPLOAD_DIR_PRODUCTS . $product['CoverImg']; ?>" alt="" />
                </div>
                <div>
                    <strong>
                        <a href="<?php echo "article.php?id=" . $product['ProductId']; ?>">
                            <?php echo $product['Title'] . ' (cod. ' . $product['ProductId'] . ')'; ?>
                        </a>
                    </strong>
                </div>
                <div>
                    <a href="<?php echo "modify-article.php?action=modify&id=" . $product['ProductId']; ?>">Modifica</a>
                    <a href="<?php echo "modify-article.php?action=delete&id=" . $product['ProductId']; ?>">Elimina</a>
                </div>
            </li>
        <?php
        endforeach;
    endif;
?>