<?php
    require_once 'bootstrap.php';
    session_start();  // needed for sessions.

    if(isset($_SESSION['url'])){
         $lastPage = $_SESSION['url']; // holds url for last page visited.
    }
    else{
        $lastPage = "index.php"; 
    }

    //TODO: CONTROLLO DI LOGIN EFFETTUATO E STRINGA AZIONE GESTIBILE
    //AGGIUNGERE VERIFICA CORRETTO LOGIN
    if(isset($_GET["action"]) && isset($_GET["id"])){
        $action = $_GET["action"];
        $idprod = $_GET["id"];

        if(!strcmp($action,'wish')){
            //echo 'add to wishlist id'. $idprod;
            $dbh -> addProductToWish(2,$idprod); //user and prodid
        }
        else if(!strcmp($action,'toCart')){
            //echo 'add to cart id'. $idprod;
            $dbh -> addProductToCart(2,$idprod,5); //iduser,id product, quantity
        }
        else if(!strcmp($action,'notify')){
            //echo 'notify me id'. $idprod;
            $dbh -> addAlert(2,$idprod);
        }
    }
    
    header("Location: $lastPage"); //redirect to lastpage where action was sent
?>