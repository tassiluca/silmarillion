<?php
    require_once '../bootstrap.php';

    if(isset($_SESSION['url'])){
         $lastPage = $_SESSION['url']; // holds url for last page visited.
    }
    else{
        $lastPage = "index.php"; 
    }

    if(isset($_GET["action"]) && isset($_GET["id"])){
        $action = $_GET["action"];
        $idprod = $_GET["id"];
        if(isCustomerLoggedIn()){
            handleLoggedCustomerRequest($action,$_SESSION['userId'],$idprod);
        }
        else if(isset($_COOKIE['userData'])){ //case where cookie ha been already setted--> append new infos

        }
        else if(!isset($_COOKIE['userData'])){ //first time we save cart and favourite costumer data in cookie

        }   
    }

    function handleLoggedCustomerRequest($action,$idCustomer,$idprod){
        if(!strcmp($action,'wish')){
            $dbh -> addProductToWish($idCustomer,$idprod);
        }
        else if(!strcmp($action,'addtoCart')){
            $dbh -> addProductToCart($idCustomer,$idprod,1);
        }
        else if(!strcmp($action,'decToCart')){
            //decrement quantity of product in cart
            $dbh -> decrementProductToCart($idCustomer,$idprod,1);
        }
        else if(!strcmp($action,'delFromCart')){
            //completely remove product from cart in db
            $dbh -> deleteProductFromCart($idCustomer,$idprod,1);
        }
        else if(!strcmp($action,'notify')){
            //echo 'notify me id'. $idprod;
            $dbh -> addProductAlert($idCustomer,$idprod);
        }
    }
    
    
   header("Location: $lastPage"); //redirect to lastpage where action was sent
?>