<?php 
$SPACE = ' ';
$AND = 'and';
$EQ = ' = ';
$AND_S = ' and '; //and with spaces

define('NOT_AVAILABLE', 0);
define('AVAILABLE', 1);
define('ALL_AVAILABILITY', 2);
/*
filters = lang, author, price, availability, publisher,category*/
    require_once '../bootstrap.php';
   
    //print_r($_POST['lang'][0]);
    if(isset($_POST)){
        $availabFilter = ALL_AVAILABILITY;
        $keys = array_keys($_POST);
        $data = $_POST;
        $query = "SELECT * 
                FROM Products as P, Comics as C, Publisher as PB 
                WHERE C.ProductId = P.ProductId and PB.PublisherId = C.PublisherId";
        if(isset($keys) && count($keys)){
            $filtQuery = $query;
            foreach($keys as $k){
                if(!strcmp($k,'category')){
                    $filtQuery .= appendFilter($data[$k],'P.CategoryName');
                }
                else if(!strcmp($k,'publisher')){
                    $filtQuery .= appendFilter($data[$k],'PB.Name');
                }
                else if(!strcmp($k,'availability')){
                    //available,notavailable
                    if(!strcmp($data[$k][0],'available')){
                        $availabFilter = AVAILABLE;
                    }
                    else if(!strcmp($data[$k][0],'notavailable')){
                        $availabFilter = NOT_AVAILABLE;
                    }
                    else{
                        $availabFilter = ALL_AVAILABILITY;
                    }
                }
                else if(!strcmp($k,'price')){//TODO compare correct price without "-" simbol
                    $filtQuery .= appendFilter($data[$k],'P.Price');
                }
                else if(!strcmp($k,'author')){
                    $filtQuery .= appendFilter($data[$k],'C.Author');
                }
                else if(!strcmp($k,'lang')){
                    $filtQuery .= appendFilter($data[$k],'C.Lang');
                }
            }
            sendData($filtQuery,$availabFilter,$dbh);
        }
        else{
            sendData($query,$availabFilter,$dbh);
        }
        
    }
   
    function sendData($query,$avail,$dbh){
        $prods = addAvaiableCopies($dbh -> getAllComics($query),$dbh); //get all products that match filters
        $prods = applyFilterAvailable($prods,$avail);
        echo json_encode($prods); //befire send json add numCopies info foreach products
    }

    function appendFilter($arr,$filt){
        global $SPACE,$AND,$EQ,$AND_S;
        $strQUery ='';
        foreach($arr as $e){
            $strQUery .= $AND_S.$filt.$EQ.$SPACE."'".$e."'";
        }
        return $strQUery;
    }
    
    function addAvaiableCopies($prods,$dbh){
        $allProd = $prods;
        for($i=0; $i < count($prods);$i++){
            $allProd[$i]["copies"] = $dbh -> getAvaiableCopiesOfProd($allProd[$i]["ProductId"]);
        }
        return $allProd;
    }

    function applyFilterAvailable($prods,$selFilter){
        $allProd = array();
        for($i=0; $i < count($prods);$i++){
            if(($prods[$i]["copies"] > 0 && $selFilter==AVAILABLE) ||  
            ($prods[$i]["copies"] <= 0 && $selFilter==NOT_AVAILABLE) ||
            $selFilter==ALL_AVAILABILITY){
                $allProd[$i] = $prods[$i];
            }
        }
        return $allProd;
    }
?>