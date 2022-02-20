<?php
    require_once '../bootstrap.php';
    require_once 'functions.php';
    define("UPDATE",0);
    define("DAY",0);
    define("MONTH",1);
    define("YEAR",2);

    if(isset($_POST) && isset($_POST['action'])/*&& isSellerLoggedIn()*/){
        if(count($_POST['action']) >= 1 && $_POST['action'][0]== UPDATE){
            if(count($_POST['period']) >= 1){
                $numOrder = $dbh -> getNumOrdersPerPeriod($_POST['period'][0]);
                $cashIn = $dbh -> getIncashPerPeriod($_POST['period'][0]);
            }
            else{
                $numOrder = $dbh -> getNumOrdersPerPeriod();
                $cashIn = $dbh -> getIncashPerPeriod();
            } 
            $data = array('countOrder' => $numOrder, 'period' => $cashIn);
            echo json_encode($data);
        }
    }

?>