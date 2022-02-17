<?php
    require_once '../bootstrap.php';
    require_once 'functions.php';
    define("UPDATE",0);

    if(isset($_POST) && isset($_POST['action'])/*&& isSellerLoggedIn()*/){
        if(count($_POST['action']) >= 1 && $_POST['action'][0]== UPDATE){
            $numOrder = $dbh -> getNumOrdersPerMonth();
            $monthIn = $dbh -> getIncashPerMonth();
            $data = array('countOrder' => $numOrder, 'monthIn' => $monthIn);
            echo json_encode($data);
        }
    }

?>