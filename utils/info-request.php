<?php
    require_once '../bootstrap.php';

    if(isset($_POST)){
        $action = $_POST["action"];
        $idProd = $_POST["id"];

        if($action == 'getCopies'){
            echo $dbh -> getAvaiableCopiesOfProd($idProd);
        }
        else {
            echo "to implement";
        }
    }

?>