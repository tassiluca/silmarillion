<?php

use LDAP\Result;

    require_once '../bootstrap.php';

    if(isset($_GET["action"])){
        $action = $_GET["action"];
        $response = array("isLogged" => false,"action" =>"noAction","execDone" => false, "count" => 99,"cartCount"=>0);
        
        if(isCustomerLoggedIn()){
            if(isset($_GET["id"])){
                $resultQuery = handleLoggedCustomerRequest($dbh,$action,$_SESSION['userId'],$_GET["id"]);
                $response["action"] = $resultQuery[0];
                $response["execDone"] = $resultQuery[1] == 0 ? false : true;
                $countCopies = $dbh->getAvaiableCopiesOfProd($_GET["id"]);
            }
            $response["isLogged"] = true;
            $response["cartCount"] = count($dbh->getUserCart($_SESSION['userId']));
        }
        echo json_encode($response);
    }

    /**
     * Handle request about a product from a Customer that is logged-in, all action have effect on user's data on db
     * @param DatabaseHelper $dbh
     * @param string $action What to do with the product 
     * @param int $idCustomer Unique customer id 
     * @param int $idprod Unique product id
     * @return boolean If action not executed for any reason return false
    */
    function handleLoggedCustomerRequest($dbh,$action,$idCustomer,$idprod){
        if(!strcmp($action,'wish')){
            $isFav = $dbh -> isFavourite($idCustomer,$idprod);
            
            if(!$isFav){
                return ["addFav",$dbh -> addProductToWish($idCustomer,$idprod)];
            }
            else{
                return ["removeFav",$dbh -> removeProductToWish($idCustomer,$idprod)];
            }

        }
        else if(!strcmp($action,'addtoCart')){
            return ["addcart",$dbh -> incQuantityProdCart($idCustomer,$idprod)];
        }
        else if(!strcmp($action,'decToCart')){
            //decrement quantity of product in cart, is same as adding to cart but quantity is negative
            return ["decToCart",$dbh -> decQuantityProdCart($idCustomer,$idprod)];
        }
        else if(!strcmp($action,'delFromCart')){
            //completely remove product from cart in db
            return ["delFromCart",$dbh -> deleteProductFromCart($idCustomer,$idprod)];
        }
        else if(!strcmp($action,'notify')){
            $isAlertOnProd = $dbh -> isAlertActive($idCustomer,$idprod);
            if($isAlertOnProd){
                return ["removeAlert",$dbh -> removeAlertOnProd($idCustomer,$idprod)];
            }
            else{
                return ["addAlert",$dbh -> addProductAlert($idCustomer,$idprod)];
            }
        }
    }
    
?>