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
            echo handleLoggedCustomerRequest($dbh,$action,$_SESSION['userId'],$idprod);
        }
        else {
            //handleUsingCookieRequest($dbh,$action,$idprod);
            
            var_dump($_COOKIE);
        }
    }

    /**
     * Handle request about a product from a Customer that is NOT logged-in, all action have effect on user's data on db
     * @param DatabaseHelper $dbh
     * @param string $action What to do with the product 
     * @param int $idCustomer Unique customer id 
     * @param int $idprod Unique product id
     * @return boolean $correctExec If action not executed for any reason return false
    */
    function handleUsingCookieRequest($dbh,$action,$idprod){
        if(!strcmp($action,'wish')){
            $correctExec = false;
            //cookie favourite is already setted
            if(isset($_COOKIE['favs'])){ 
                $favs = json_decode(stripslashes($_COOKIE['favs']), true);

                if(!in_array($idprod, $favs)){
                    array_push($favs,$idprod);
                }
                else if(in_array($idprod, $favs)){
                    unset($favs[array_search(strval($idprod), $favs)]);
                }
                setcookie('favs', json_encode($favs), time()+3600,"/");
                $correctExec = true;
            }//first time we save cart and favourite costumer data in cookie
            else if(!isset($_COOKIE['favs'])){ 
                $favs = array($idprod);
                setcookie('favs', json_encode($favs), time()+3600,"/");
                $correctExec = true;
            }



        }//--VVVVVVVV--NO ROBA MIA----VVVVVVVVVVV
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

        return $correctExec;
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
            $isFav = $dbh -> isFavourite($_SESSION['userId'],$idprod);
            
            if(!$isFav){
                return $dbh -> addProductToWish($idCustomer,$idprod);
            }
            else{
                return $dbh -> removeProductToWish($idCustomer,$idprod);
            }


        }//--VVVVVVVV--NO ROBA MIA----VVVVVVVVVVV
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
    
   //header("Location: $lastPage"); //redirect to lastpage where action was sent
?>