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
        else if(!strcmp($action,'addToCart')){
            //add article or increment quantity if avaiable
            $dbh -> addProductToCart(2,$idprod,1); //iduser LO PREDNO DA $SESSION['userid'],id product, quantity
        }
        else if(!strcmp($action,'decToCart')){
            //decrement quantity of product in cart
            $dbh -> decrementProductToCart(2,$idprod,1); //iduser LO PREDNO DA $SESSION['userid'],id product, quantity
        }
        else if(!strcmp($action,'delFromCart')){
            //completely remove product from cart
            $dbh -> deleteProductFromCart(2,$idprod,1); //iduser LO PREDNO DA $SESSION['userid'],id product, quantity
        }
        else if(!strcmp($action,'notify')){
            //echo 'notify me id'. $idprod;
            $dbh -> addProductAlert(2,$idprod);
        }
    }
    
    header("Location: $lastPage"); //redirect to lastpage where action was sent
?>