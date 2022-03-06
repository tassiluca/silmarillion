<?php 
//SQL KEYWORD
define('SPACE', ' ');
define('EQ', '=');
define('AND_S', ' and ');
define('OR_S', ' or ');

//PRODS AVAILABILITY
define('NOT_AVAILABLE', 0);
define('AVAILABLE', 1);
define('ALL_AVAILABILITY', 2);

//PRODS SELECTION
define('ONLY_COMICS', 0);
define('ONLY_FUNKOS', 1);
define('ALL_PRODS', 2);

$varTypes = ''; //string containing all types of passed var to bind_param()
$varArray = []; //array of references of all variables to be binded

$priceInterval = ["cheap"=> ["from"=>'0',"to"=>'99.99'],
"medium"=> ["from"=>'100',"to"=>'199.99'],
"expensive"=>["from"=>'99.99']];
/*
filters = lang, author, price, availability, publisher,category*/
    require_once '../bootstrap.php';
    
    if(isset($_POST)){  //TODO: make some chek of what server receive in post method
        $availabFilter = ALL_AVAILABILITY;
        $varTypes = '';
        $varArray = [];
        $keys = array_keys($_POST);
        $data = $_POST;
        
        if(isset($keys) && count($keys)){
            $filtQuery = AND_S.'(';
        /**
         * is first filter applied ? Used to append or not 'and' keyword in SQLquery
         * If one filter selected not add 'or' statement, if more than one filter is applied
         * add 'or statement in sql query'
         * The change of $isFirst happen in method getCorrectConcat()
         */
            $isFirst = true;
            foreach($keys as $k){
                
                if(isset($data['category']) && in_array('funko',$data['category'])){
                    $isFunko = ONLY_FUNKOS;
                }
                else{
                    $isFunko = ONLY_COMICS;
                }

                if(!strcmp($k,'category') && $isFunko != ONLY_FUNKOS){
                    $filtQuery .= appendEqualFilter($data[$k],'P.CategoryName',$varTypes,$varArray);
                }
                else if(!strcmp($k,'publisher') && $isFunko != ONLY_FUNKOS){
                    $filtQuery .= appendEqualFilter($data[$k],'PB.Name',$varTypes,$varArray);
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
                    $filtQuery .= appendBetweenFilterPrice($data[$k],'P.Price',$priceInterval,$varTypes,$varArray);
                }
                else if(!strcmp($k,'author') && $isFunko != ONLY_FUNKOS){
                    $filtQuery .= appendEqualFilter($data[$k],'C.Author',$varTypes,$varArray);
                }
                else if(!strcmp($k,'lang') && $isFunko != ONLY_FUNKOS){
                    $filtQuery .= appendEqualFilter($data[$k],'C.Lang',$varTypes,$varArray);
                }

            }
            if($isFunko==ONLY_FUNKOS && !in_array('price', $keys)){
                $filtQuery .= ' 1)';
            }
            else{
                $filtQuery .= ' )';
            }
            print_r($varTypes);
            print_r($varArray);
            sendData($filtQuery,$availabFilter,$dbh,$isFunko,$varTypes,$varArray);
        }
        else{
            sendData('',$availabFilter,$dbh,ALL_PRODS,$varTypes,$varArray);
        }
    }
   
    /**
     * @param array $arr array of value of same filter to be applied
     * @param string $filt sql attribute to be compared with values
     * @param string &$queryTypes string containing all type of values for bind_param
     * @param array &$queryVars array of var used in bind_param
     */
    function appendEqualFilter($arr,$filt,&$queryTypes, &$queryVars){
        $strQuery ='';
            foreach($arr as $e){
                $concatMode = getCorrectConcat();
                $strQuery .= $concatMode.$filt.SPACE.EQ.SPACE.'?';//"'".$e."'";
                $queryTypes .= getSqlStringType($e);
                array_push($queryVars,$e);
            }
        return $strQuery;
    }

    /**
     * $interval must be structured as $intervalDef = ["rangeTag"=> ["from"=>'value',"to"=>'value'],
     * "rangeTag-1"=> ["from"=>'value',"to"=>'value'],...];
     */
    function appendBetweenFilterPrice($arr,$filt,$interval,&$queryTypes,&$queryVars){
        global $isFirst;
        $strQUery ='';
        
            foreach($arr as $e){
                $concatMode = getCorrectConcat();
                if(isset($interval[$e]["to"]) && isset($interval[$e]["from"])){
                    $queryTypes .= getSqlStringType(floatval($interval[$e]["from"]));
                    $queryTypes .= getSqlStringType(floatval($interval[$e]["to"]));
                    array_push($queryVars,floatval($interval[$e]["from"]));
                    array_push($queryVars,floatval($interval[$e]["to"]));

                    $strQUery .= $concatMode.$filt.SPACE.'BETWEEN'.SPACE."'".$interval[$e]["from"]."'".AND_S."'".$interval[$e]["to"]."'";
                }
                else if(!isset($interval[$e]["to"]) && isset($interval[$e]["from"])){
                    $queryTypes .= getSqlStringType(floatval($interval[$e]["from"]));
                    array_push($queryVars,floatval($interval[$e]["from"]));

                    $strQUery .= $concatMode.$filt.SPACE.'>='.SPACE."'".$interval[$e]["from"]."'";
                }
                else if(isset($interval[$e]["to"]) && !isset($interval[$e]["from"])){
                    $queryTypes .= getSqlStringType(floatval($interval[$e]["to"]));
                    array_push($queryVars,floatval($interval[$e]["to"]));

                    $strQUery .= $concatMode.$filt.SPACE.'<='.SPACE."'".$interval[$e]["to"]."'";
                }
        }
        return $strQUery;
    }
    function getCorrectConcat(){
        global $isFirst;
        $concatKeyword = $isFirst ? SPACE : AND_S;
        $isFirst = false;
        return $concatKeyword;
    }
    
    function getSqlStringType($var){
        if(is_int($var)){
            return 'i';
        }
        else if(is_double($var)){
            return 'd';
        }
        else if(is_string($var)){
            return 's';
        }
    }

    function addAvaiableCopiesInfo($prods,$dbh){
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

    function sendData($query,$avail,$dbh,$typeReq,$varTypes,$varArray){
        
        if($typeReq == ONLY_FUNKOS){
            $prods = $dbh -> getAllFunkosMatch($query,$varTypes,$varArray);
        }
        else if($typeReq == ONLY_COMICS){
            $prods = $dbh -> getAllComicsMatch($query,$varTypes,$varArray); //get all products that match filters
        }
        else if($typeReq == ALL_PRODS){
            $funkos = $dbh -> getAllFunkosMatch($query,$varTypes,$varArray);
            $comics = $dbh -> getAllComicsMatch($query,$varTypes,$varArray);
            $prods = array_merge($funkos,$comics);
        }
        $prods = addAvaiableCopiesInfo($prods,$dbh);
        $prods = applyFilterAvailable($prods,$avail);
        echo json_encode($prods); //before send json add numCopies info foreach products
    }
?>