<?php

    require_once __DIR__ . '/bootstrap.php';

    $templateParams["css"]  = array("./css/payment.css", "./css/cart-payment.css");
    $templateParams["js"]   = array("./js/payment.js");
    $templateParams["main"] = "./templates/payment-page.php";

    if (!isCustomerLoggedIn()) {
        header("location: ./login.php");
    } else {
        list($availableProds, $totalAmount) = computeTotalAmount();
        if (empty($availableProds)) {
            $templateParams["error"] = "Nessun prodotto nel carrello";
        } else {
            $templateParams["totalAmount"] = $totalAmount;
            // TODO to display the list of available products in the page
            $templateParams["availableProds"] = $availableProds;
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