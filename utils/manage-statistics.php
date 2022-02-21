<?php
    require_once '../bootstrap.php';
    require_once 'functions.php';
    define("UPDATE",0);
    define("DAY",0);
    define("MONTH",1);
    define("YEAR",2);

    if(isset($_POST) && isset($_POST['action'])/*&& isSellerLoggedIn()*/){
        if(count($_POST['action']) >= 1 && $_POST['action'][0]== UPDATE){
            if(isset($_POST['period']) && count($_POST['period']) >= 1 && 
                isset($_POST['year']) && count($_POST['year']) >= 1){

                $stats = $dbh -> getStatsPerPeriod($_POST['period'][0],$_POST['year']);
            }
            else{
                $stats = $dbh -> getStatsPerPeriod(MONTH,getdate(date("U"))['year']);
            } 
            echo json_encode($stats);
        }
    }

?>