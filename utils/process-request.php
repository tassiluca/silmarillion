<?php
    require_once 'bootstrap.php';

    if(isset($_SESSION['url'])){
         $lastPage = $_SESSION['url']; // holds url for last page visited.
    }
    else{
        $lastPage = "index.php"; 
    }

    if(isCustomerLoggedIn() && isset($_GET["action"]) && isset($_GET["id"])){
        $action = $_GET["action"];
        $idprod = $_GET["id"];
        $idCustomer = $_SESSION['userId'];
        
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