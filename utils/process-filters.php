<?php 
$SPACE = ' ';
$AND = 'and';
$EQ = '=';
$AND_S = ' and '; //and with spaces

define('NOT_AVAILABLE', 0);
define('AVAILABLE', 1);
define('ALL_AVAILABILITY', 2);

$priceInterval = ["cheap"=> ["from"=>'0',"to"=>'99.99'],
"medium"=> ["from"=>'100',"to"=>'199.99'],
"expensive"=>["from"=>'99.99']];
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
                    $filtQuery .= appendEqualFilter($data[$k],'P.CategoryName',$EQ);
                }
                else if(!strcmp($k,'publisher')){
                    $filtQuery .= appendEqualFilter($data[$k],'PB.Name',$EQ);
                }
                else if(!strcmp($k,'availability')){
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
                else if(!strcmp($k,'price')){
                    $filtQuery .= appendBetweenFilter($data[$k],'P.Price',$priceInterval);
                }
                else if(!strcmp($k,'author')){
                    $filtQuery .= appendEqualFilter($data[$k],'C.Author',$EQ);
                }
                else if(!strcmp($k,'lang')){
                    $filtQuery .= appendEqualFilter($data[$k],'C.Lang',$EQ);
                }
            }
            sendData($filtQuery,$availabFilter,$dbh);
        }
        else{
            sendData($query,$availabFilter,$dbh);
        }
        
    }
   
    function appendEqualFilter($arr,$filt){
        global $SPACE,$AND,$EQ,$AND_S;
        $strQUery ='';
            foreach($arr as $e){
            $strQUery .= $AND_S.$filt.$SPACE.$EQ.$SPACE."'".$e."'";
        }
        return $strQUery;
    }

    /**
     * $interval must be structured as $intervalDef = ["rangeTag"=> ["from"=>'value',"to"=>'value'],
     * "rangeTag-1"=> ["from"=>'value',"to"=>'value'],...];
     */
    function appendBetweenFilter($arr,$filt,$interval){
        global $SPACE,$AND,$BETWEEN,$AND_S;
        $strQUery ='';
            foreach($arr as $e){
                if(isset($interval[$e]["to"]) && isset($interval[$e]["from"])){
                    $strQUery .= $AND_S.$filt.$SPACE.'BETWEEN'.$SPACE."'".$interval[$e]["from"]."'".$AND_S."'".$interval[$e]["to"]."'";
                }
                else if(!isset($interval[$e]["to"]) && isset($interval[$e]["from"])){
                    $strQUery .= $AND_S.$filt.$SPACE.'>='.$SPACE."'".$interval[$e]["from"]."'";
                }
                else if(isset($interval[$e]["to"]) && !isset($interval[$e]["from"])){
                    $strQUery .= $AND_S.$filt.$SPACE.'<='.$SPACE."'".$interval[$e]["to"]."'";
                }
        }
        print_r($strQUery);
        return $strQUery;
    }

    function sendData($query,$avail,$dbh){
        $prods = addAvaiableCopies($dbh -> getAllComics($query),$dbh); //get all products that match filters
        $prods = applyFilterAvailable($prods,$avail);
        echo json_encode($prods); //before send json add numCopies info foreach products
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