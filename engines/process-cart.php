<?php

    require_once '../bootstrap.php';

    if(isset($_GET["request"]) && $_GET["request"] === "getCart"){
        $response = getCart();
        echo json_encode($response);
    }
?>