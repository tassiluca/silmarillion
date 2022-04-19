<?php

    require_once '../bootstrap.php';
    global $dbh;
    use Respect\Validation\Validator as v;

    function validate() {
        $rules = array (
            'address'       => v::stringType()->notEmpty(),
            'cap'           => v::numericVal()->notEmpty(),
            'province'      => v::stringType()->length(2, 2),
        );
        $dataDic = array (
            'address'  => [$_POST['destAddress'], $_POST['city']],
            'cap'      => [$_POST['cap']],
            'province' => [$_POST['prov']]
        );
        // TODO: validate payment method
        return validateInput($rules, $dataDic);
    }

    function getAvailableProds() {
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

    if (isset($_POST['destAddress'], $_POST['cap'], $_POST['city'], $_POST['prov'], $_POST['paymethod'])) {
        list($res, $msg) = validate();
        if (!$res) {
            echo $msg;
            exit(1);
        } else {
            print_r($_POST);
        }
        $address = $_POST['destAddress'] . ", " . $_POST['cap'] . ", " . $_POST['city'];
        list($prodsList, $totalAmount) = getAvailableProds();

        // TODO Manage errors
        // creates a new order
        $orderId = $dbh->addNewOrder($address, $totalAmount , $_SESSION['userId']);
        // creates order details
        foreach ($prodsList as $prod) {
            for ($i = 0; $i < $prod['Quantity']; $i++) {
                $dbh->addOrderDetails($prod['ProductId'], $orderId); // this could involve an error
            }
        }

    }

?>