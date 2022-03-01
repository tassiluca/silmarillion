<?php 
$SPACE = ' ';
$EQ = '=';
$AND_S = ' and '; //and with spaces
$OR_S = ' or ';

define('NOT_AVAILABLE', 0);
define('AVAILABLE', 1);
define('ALL_AVAILABILITY', 2);

$priceInterval = ["cheap"=> ["from"=>'0',"to"=>'99.99'],
"medium"=> ["from"=>'100',"to"=>'199.99'],
"expensive"=>["from"=>'99.99']];
/*
filters = lang, author, price, availability, publisher,category*/
    require_once '../bootstrap.php';
    
    if(isset($_POST)){  //TODO: make some chek of what server receive in post method
        $availabFilter = ALL_AVAILABILITY;
        $keys = array_keys($_POST);
        $data = $_POST;
        
        if(isset($keys) && count($keys)){
            $filtQuery = $AND_S.'(';
        /**
         * is first filter applied ? Used to append or not 'and' keyword in SQLquery
         * If one filter selected not add 'or' statement, if more than one filter is applied
         * add 'or statement in sql query'
         * The change of $isFirst happen in method getCorrectConcat()
         */
            $isFirst = true;
            foreach($keys as $k){
                if(!strcmp($k,'category')){
                    $filtQuery .= appendEqualFilter($data[$k],'P.CategoryName');
                }
                else if(!strcmp($k,'publisher')){
                    $filtQuery .= appendEqualFilter($data[$k],'PB.Name');
                }
                else if(!strcmp($k,'availability')){
                    if(count($keys)==1){ //the only key present is avaialbility
                        $filtQuery .= '1'; //sql condition always true to get all comics
                    }
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
                    $filtQuery .= appendEqualFilter($data[$k],'C.Author');
                }
                else if(!strcmp($k,'lang')){
                    $filtQuery .= appendEqualFilter($data[$k],'C.Lang');
                }

            }
            $filtQuery .= ' )';
            sendData($filtQuery,$availabFilter,$dbh);
        }
        else{
            sendData('',$availabFilter,$dbh);
        }
    }
   
    function appendEqualFilter($arr,$filt){
        global $SPACE,$EQ;
        $strQUery ='';
            foreach($arr as $e){
            $concatMode = getCorrectConcat();
            $strQUery .= $concatMode.$filt.$SPACE.$EQ.$SPACE."'".$e."'";
        }
        return $strQUery;
    }

    /**
     * $interval must be structured as $intervalDef = ["rangeTag"=> ["from"=>'value',"to"=>'value'],
     * "rangeTag-1"=> ["from"=>'value',"to"=>'value'],...];
     */
    function appendBetweenFilter($arr,$filt,$interval){
        global $SPACE,$AND_S,$isFirst;
        $strQUery ='';
            foreach($arr as $e){
                $concatMode = getCorrectConcat();
                if(isset($interval[$e]["to"]) && isset($interval[$e]["from"])){
                    $strQUery .= $concatMode.$filt.$SPACE.'BETWEEN'.$SPACE."'".$interval[$e]["from"]."'".$AND_S."'".$interval[$e]["to"]."'";
                }
                else if(!isset($interval[$e]["to"]) && isset($interval[$e]["from"])){
                    $strQUery .= $concatMode.$filt.$SPACE.'>='.$SPACE."'".$interval[$e]["from"]."'";
                }
                else if(isset($interval[$e]["to"]) && !isset($interval[$e]["from"])){
                    $strQUery .= $concatMode.$filt.$SPACE.'<='.$SPACE."'".$interval[$e]["to"]."'";
                }
        }
        return $strQUery;
    }
    function getCorrectConcat(){
        global $isFirst,$SPACE, $OR_S, $AND_S;
        $concatKeyword = $isFirst ? $SPACE : $AND_S;
        $isFirst = false;
        return $concatKeyword;
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
                array_push($allProd,$prods[$i]);
            }
        }
        return $allProd;
    }
?>