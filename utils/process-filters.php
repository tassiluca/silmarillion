<?php 
//SQL KEYWORD
const SPACE = ' ';
const EQ = '=';
const AND_S = ' and ';
const OR_S = ' or ';

//PRODS AVAILABILITY
const NOT_AVAILABLE = 0;
const AVAILABLE = 1;
const ALL_AVAILABILITY = 2;

//PRODS SELECTION
const ONLY_COMICS = 0;
const ONLY_FUNKOS = 1;
const ALL_PRODS = 2;

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
                    $filtQuery .= appendEqualFilter($data[$k],'P.CategoryName',$varArray);
                }
                else if(!strcmp($k,'publisher') && $isFunko != ONLY_FUNKOS){
                    $filtQuery .= appendEqualFilter($data[$k],'PB.Name',$varArray);
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
                    $filtQuery .= appendBetweenFilterPrice($data[$k],'P.Price',$priceInterval,$varArray);
                }
                else if(!strcmp($k,'author') && $isFunko != ONLY_FUNKOS){
                    $filtQuery .= appendEqualFilter($data[$k],'C.Author',$varArray);
                }
                else if(!strcmp($k,'lang') && $isFunko != ONLY_FUNKOS){
                    $filtQuery .= appendEqualFilter($data[$k],'C.Lang',$varArray);
                }

            }
            if($isFunko==ONLY_FUNKOS && !in_array('price', $keys)){
                $filtQuery .= ' 1)';
            }
            else{
                $filtQuery .= ' )';
            }
            
            sendData($filtQuery,$availabFilter,$dbh,$isFunko,$varArray);
        }
        else{
            sendData('',$availabFilter,$dbh,ALL_PRODS,$varArray);
        }
    }
   
    /**
     * @param array $arr array of value of same filter to be applied
     * @param string $filt sql attribute to be compared with values
     * @param array &$queryVars array of var used in bind_param
     */
    function appendEqualFilter($arr,$filt,&$queryVars){
        $strQuery ='';
            foreach($arr as $e){
                $concatMode = getCorrectConcat();
                $strQuery .= $concatMode.$filt.SPACE.EQ.SPACE.'?';//"'".$e."'";
                array_push($queryVars,$e);
            }
        return $strQuery;
    }

    /**
     * @param array $priceFilters array of all price-range filters selected
     * @param string $filt Attribute to check in db for compare
     * @param array $interval must be structured as $intervalDef = ["rangeTag"=> ["from"=>'value',"to"=>'value'],
     * "rangeTag-1"=> ["from"=>'value',"to"=>'value'],...];
     * @return string $strQUery partial query, composed query that filter price ranges
     */
    function appendBetweenFilterPrice($priceFilters,$filt,$interval){
        global $isFirst;
        $strQUery ='';
        
            foreach($priceFilters as $e){
                $concatMode = getCorrectConcat();
                if(isset($interval[$e]["to"]) && isset($interval[$e]["from"])){

                    $strQUery .= $concatMode.$filt.SPACE.'BETWEEN'.SPACE.'?'.AND_S.'?';
                    array_push($queryVars,floatval($interval[$e]["from"]));
                    array_push($queryVars,floatval($interval[$e]["to"]));
                    //$strQUery .= $concatMode.$filt.SPACE.'BETWEEN'.SPACE."'".$interval[$e]["from"]."'".AND_S."'".$interval[$e]["to"]."'";
                }
                else if(!isset($interval[$e]["to"]) && isset($interval[$e]["from"])){

                    $strQUery .= $concatMode.$filt.SPACE.'>='.SPACE.'?';
                    array_push($queryVars,floatval($interval[$e]["from"]));
                    //$strQUery .= $concatMode.$filt.SPACE.'>='.SPACE."'".$interval[$e]["from"]."'";
                }
                else if(isset($interval[$e]["to"]) && !isset($interval[$e]["from"])){

                    $strQUery .= $concatMode.$filt.SPACE.'<='.SPACE.'?';
                    array_push($queryVars,floatval($interval[$e]["to"]));
                    //$strQUery .= $concatMode.$filt.SPACE.'<='.SPACE."'".$interval[$e]["to"]."'";
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

    /**
     * Get from db prods that match filters then send json data to client js
    */
    function sendData($query,$avail,$dbh,$typeReq,$varArray){
        
        if($typeReq == ONLY_FUNKOS){
            $prods = $dbh -> getAllFunkosMatch($varArray,$query);
        }
        else if($typeReq == ONLY_COMICS){
            $prods = $dbh -> getAllComicsMatch($varArray,$query); //get all products that match filters
        }
        else if($typeReq == ALL_PRODS){
            $funkos = $dbh -> getAllFunkosMatch($varArray,$query);
            $comics = $dbh -> getAllComicsMatch($varArray,$query);
            $prods = array_merge($funkos,$comics);
        }
        $prods = addIsFavouriteInfo($prods,$dbh);
        $prods = addAvaiableCopiesInfo($prods,$dbh);
        $prods = applyFilterAvailable($prods,$avail);
        echo json_encode($prods); //before send json add numCopies info foreach products
    }
?>