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

    function insertOrder(string $address, int $totalAmount, array $products) {
        global $dbh;
        // creates a new order
        $orderId = $dbh->addNewOrder($address, $totalAmount , $_SESSION['userId']);
        // creates order details
        foreach ($products as $prod) {
            for ($i = 0; $i < $prod['Quantity']; $i++) {
                $res = $dbh->addOrderDetails($prod['ProductId'], $orderId);
                if ($res) {
                    break 2; /* Exit the for and previous foreach */
                }
            }
        }
        // if some errors occurred, delete the order
        if ($res) {
            $dbh->deleteOrder($orderId);
        } else {
            $dbh->addPayment($orderId, );
            $dbh->addLogOrderStatus(OrdersStatus::IN_PREPARATION, $orderId);
        }
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
        insertOrder($address, $totalAmount, $prodsList);
    }

?>