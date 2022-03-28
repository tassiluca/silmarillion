<?php
    require_once '../bootstrap.php';

    if(isset($_GET["action"]) && isset($_GET["id"])){
        $action = $_GET["action"];
        $idprod = $_GET["id"];
        $countCopies = $dbh->getAvaiableCopiesOfProd($idprod);
        $response = array("isLogged" => false,"action" =>"null","execDone" => false, "count" => $countCopies);
        
        if(isCustomerLoggedIn()){
            $resultQuery = handleLoggedCustomerRequest($dbh,$action,$_SESSION['userId'],$idprod);

            $response["isLogged"] = true;
            $response["action"] = $resultQuery[0];
            $response["execDone"] = $resultQuery[1] == 0 ? false : true; 
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
            return ["addcart",$dbh -> addProductToCart($idCustomer,$idprod,1)];
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