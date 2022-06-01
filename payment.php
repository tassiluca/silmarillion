<?php

    require_once __DIR__ . '/bootstrap.php';
    global $dbh;

    $templateParams["css"]  = array("./css/payment.css", "./css/cart-payment.css");
    $templateParams["js"]   = array("./js/payment.js");
    $templateParams["main"] = "./templates/payment-page.php";

    if (!isCustomerLoggedIn()) {
        header("location: ./login.php");
    } elseif (isset($_GET['result']) && ($_GET['result'] === 'success' || $_GET['result'] === 'error')) {
        $templateParams["msg"] = ($_GET['result'] === 'success'
            ? "Ordine effettuato con successo &#129297; &#129316; &#129321;"
            : "Ordine rifiutato: il/i prodotto/i selezionati non sono più disponibili &#128546;");
    } else {
        list($availableProds, $totalAmount) = computeTotalAmount();
        $templateParams["totalAmount"] = $totalAmount;
        // TODO to display the list of available products in the page
        $templateParams["availableProds"] = $availableProds;
        $templateParams["paymentMethods"] = $dbh->getPaymentMethodsOfUser($_SESSION['userId']);
        if (empty($availableProds)) {
            $templateParams["msg"] = "Nessun prodotto nel carrello è al momento disponibile";
        } elseif (isset($_GET["inputError"])) {
            $templateParams["inputError"] = $_GET["inputError"];
        }
    }

    function computeTotalAmount() {
        global $dbh;
        $availableProds = [];
        $totalAmount = 0;
        foreach (getCart() as $prod) {
            if ($dbh->getAvaiableCopiesOfProd($prod['ProductId']) >= $prod['Quantity']) {
                $availableProds[] = $prod;
                $totalAmount += $prod['Quantity'] *
                    (empty($prod['DiscountedPrice']) ? $prod['Price'] : $prod['DiscountedPrice'] );
            }
        }
        return [$availableProds, $totalAmount];
    }

    require "./templates/base.php";
?>