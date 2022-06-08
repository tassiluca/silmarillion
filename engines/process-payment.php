<?php

    require_once '../bootstrap.php';
    global $dbh;
    use Respect\Validation\Validator as v;

    function validate(): array
    {
        if (!validatePaymentMethod()) {
            return [false, "Il metodo di pagamento non risulta appartenere all'utente loggato"];
        }
        $rules = array (
            'address'       => v::stringType()->notEmpty(),
            'cap'           => v::numericVal()->notEmpty(),
            'province'      => v::stringType()->length(2, 2),
            'paymethod'     => v::numericVal()->notEmpty()
        );
        $dataDic = array (
            'address'   => [$_POST['destAddress'], $_POST['city']],
            'cap'       => [$_POST['cap']],
            'province'  => [$_POST['prov']],
            'paymethod' => [$_POST['paymethod']]
        );
        return validateInput($rules, $dataDic);
    }

    function validatePaymentMethod(): bool
    {
        global $dbh;
        foreach ($dbh->getPaymentMethodsOfUser($_SESSION['userId']) as $usrPayMethod) {
            if ($usrPayMethod["MethodId"] == $_POST["paymethod"]) {
                return true;
            }
        }
        // the cash payment is always accepted!
        return $_POST["paymethod"] == -1;
    }

    function getAvailableProds(): array
    {
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

    function insertOrder() {
        global $dbh;
        $res = 1;
        list($products, $totalAmount) = getAvailableProds();
        if (!empty($products)) {
            // creates a new order
            $orderId = $dbh->addNewOrder($_POST['destAddress'], $_POST['city'], $_POST['cap'],
                $_POST['prov'], $totalAmount, $_SESSION['userId']);
            // creates order details
            foreach ($products as $prod) {
                for ($i = 0; $i < $prod['Quantity']; $i++) {
                    $res = $dbh->addOrderDetails($prod['ProductId'], $orderId);
                    if ($res) {
                        break 2; /* Exit the for and previous foreach */
                    }
                }
            }
            if ($res) { // if some errors occurred, delete the order
                $dbh->deleteOrder($orderId);
            } else { // otherwise, the process continues
                if ($_POST['paymethod'] !== -1) {
                    $dbh->addPayment($orderId, $_POST['paymethod']);
                }
                $dbh->addLogOrderStatus(OrdersStatus::IN_PREPARATION, $orderId);
                // Aggiunta messaggio
                $dbh->insertMessageNew("Articolo inviato",
                    "Il tuo articolo é stato inviato",
                    $_SESSION['userId']);
                // clears the customer cart
                $dbh->clearCustomerCart($_SESSION['userId']);
            }
        }
        header("location:../payment.php?result=" . ($res ? "error" : "success"));
    }

    if (isset($_POST['destAddress'], $_POST['cap'], $_POST['city'], $_POST['prov'], $_POST['paymethod'])) {
        list($res, $msg) = validate();
        if (!$res) {
            header("location:../payment.php?inputError=Errore inserimento. Ricontrolla i campi! (" . $msg .")");
            exit(1);
        }
        insertOrder();
    }

?>