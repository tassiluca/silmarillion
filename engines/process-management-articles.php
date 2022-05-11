<?php
    require_once '../bootstrap.php';
    /** @var DatabaseHelper $dbh */

    /** Number of products displayed per page. */
    const PRODUCTS_PER_PAGE = 10;

    if (isset($_GET['pattern']) || isset($_GET['page'])) {
        $offset = ($_GET['page'] - 1) * PRODUCTS_PER_PAGE;
        $products = (isset($_GET['pattern']) ?
            $dbh->getProducts($offset, PRODUCTS_PER_PAGE, $_GET['pattern']) :
            $dbh->getProducts($offset, PRODUCTS_PER_PAGE));
        // In order to send to js the correct path of the cover img concatenate it to the upload folder
        for ($i = 0; $i < count($products); $i++) {
            $products[$i]['CoverImg'] = UPLOAD_DIR_PRODUCTS . $products[$i]['CoverImg'];
        }
        $totalAmountOfProducts = count(isset($_GET['pattern']) ?
            $dbh->getProducts(expression: $_GET['pattern']) :
            $dbh->getProducts());
        $totalPages = ceil($totalAmountOfProducts / PRODUCTS_PER_PAGE);
        echo json_encode(array(
            'products' => $products,
            'pages' => $totalPages
        ));
    }

?>