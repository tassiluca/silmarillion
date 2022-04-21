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

//MACRO_CATEGORY
const funkoCategory = 'Funko';
const comicCategory = 'Comics';

$priceInterval = ["cheap"=> ["from"=>0,"to"=>99.99],
"medium"=> ["from"=>100,"to"=>199.99],
"expensive"=>["from"=>200]];
const defaultMaxPrice = 99999.99;
const defaultMinPrice = 0;
$comicBindParam = array();
$funkoBindParam = array();

/*
filters = lang, author, price, availability, publisher,category*/
    require_once '../bootstrap.php';
    
    if(isset($_POST)){  //TODO: make some chek of what server receive in post method
        $availabFilter = ALL_AVAILABILITY;
        $priceFiltersSelected = null; 
        $keys = array_keys($_POST);
        $data = $_POST;

        if(isset($keys) && count($keys) > 0){
            if(isset($data['category']) && in_array(funkoCategory,$data['category'])
                    && !in_array(comicCategory,$data['category'])){
                    $isFunko = ONLY_FUNKOS;
                    //remove comicCategory from list of categories for filtering
                    array_splice($data['category'],array_search(funkoCategory,$data['category']),1);
            }
            else if(isset($data['category']) && in_array(comicCategory,$data['category'])
                    && !in_array(funkoCategory,$data['category'])){
                $isFunko = ONLY_COMICS;
                array_splice($data['category'],array_search(comicCategory,$data['category']),1);
            }
            else{
                $isFunko = ALL_PRODS;

                if(isset($data['category']) && in_array(comicCategory,$data['category'])){
                    array_splice($data['category'],array_search(comicCategory,$data['category']),1);
                }
                if(isset($data['category']) && in_array(funkoCategory,$data['category'])){
                    array_splice($data['category'],array_search(funkoCategory,$data['category']),1);
                }
            }

            if(isset($data['category']) && count($data['category']) <= 0 && in_array('category',$data)){
                array_splice($data,array_search('category',$data),1);
            }
            $keys = array_keys($data);

            $filtQuery = '';
            $comicFilter = $filtQuery;
            $funkoFilter = $filtQuery;

            foreach($keys as $k){

                if(!strcmp($k,'category')){
                    $filtQuery .= appendEqualFilter($data[$k],'P.CategoryName',ALL_PRODS);
                    $comicFilter .= $filtQuery;
                    $funkoFilter .= $filtQuery;
                }
                else if(!strcmp($k,'publisher') && $isFunko != ONLY_FUNKOS){
                    $comicFilter .= appendEqualFilter($data[$k],'PB.Name',ONLY_COMICS);
                }
                else if(!strcmp($k,'availability')){
                    if(count($keys)==1){ //the only key present is avaialbility
                        $filtQuery .= '1'; //sql condition always true to get all comics
                        $comicFilter .= $filtQuery;
                        $funkoFilter .= $filtQuery;
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
                    $priceFiltersSelected = $data[$k];
                }
                else if(!strcmp($k,'author') ){
                    $comicFilter .= appendEqualFilter($data[$k],'C.Author',ONLY_COMICS);
                }
                else if(!strcmp($k,'lang') && $isFunko != ONLY_FUNKOS){
                    $comicFilter .= appendEqualFilter($data[$k],'C.Lang',ONLY_COMICS);
                }
            }


            $queryParams = ['comic'=> $comicBindParam,'funko'=>$funkoBindParam];
            //print_r($comicFilter);
            sendData(['comic'=>$comicFilter,'funko'=>$funkoFilter],$availabFilter,$dbh,$isFunko,
                        $queryParams,$priceFiltersSelected,$priceInterval);
        }
        else{
            $queryParams = ['comic'=> $comicBindParam,'funko'=>$funkoBindParam];
            sendData(['comic'=>'','funko'=>''],$availabFilter,$dbh,ALL_PRODS,$queryParams,$priceFiltersSelected,$priceInterval);
        }
    }

 /**
     * Get from db prods that match filters then send json data to client js
    */
    function sendData($queryArray,$avail,$dbh,$typeReq,$queryParams,$priceFiltersSelected,$pricesInterval){

        if($typeReq == ONLY_FUNKOS){
            $prods = $dbh -> getAllFunkosMatch($queryParams['funko'],$queryArray['funko']);
        }
        else if($typeReq == ONLY_COMICS){
            $prods = $dbh -> getAllComicsMatch($queryParams['comic'],$queryArray['comic']); //get all products that match filters
        }
        else if($typeReq == ALL_PRODS){
            $funkos = $dbh -> getAllFunkosMatch($queryParams['funko'],$queryArray['funko']);
            $comics = $dbh -> getAllComicsMatch($queryParams['comic'],$queryArray['comic']);
            $prods = array_merge($funkos,$comics);
        }
        $prods = addIsFavouriteInfo($prods,$dbh);
        $prods = addAvaiableCopiesInfo($prods,$dbh);
        $prods = applyFilterAvailable($prods,$avail);
        if(isset($priceFiltersSelected)){
            $prods = filterProdsByPrice($prods,$priceFiltersSelected,$pricesInterval);
        }
        echo json_encode($prods); //before send json add numCopies info foreach products
    }

    /**
     * Update correctly array params used for binding values in query
     * funko has less attributes so less params to be binded
     * @param int $prodType type of product -> FUNKO, COMIC, ALL_PRODS
     * @param array $queryparams reference to array values for binding
     * @param mixed $filterVal Value to add to $queryparams
     */
    function addQueryParams($prodType,$filterVal){
        global $comicBindParam,$funkoBindParam;

        if($prodType == ONLY_COMICS){
            array_push($comicBindParam,$filterVal);
        }
        else{
            array_push($comicBindParam,$filterVal);
            array_push($funkoBindParam,$filterVal);
        }
    }
   
    /**
     * @param array $arr array of value of same filter to be applied
     * @param string $filt sql attribute to be compared with values
     * @param int $prodType type of product -> FUNKO, COMIC, ALL_PRODS
     * @param array &$queryVars array of var used in bind_param
     */
    function appendEqualFilter($arr,$filt,$prodType){
        $strQuery ='';
            foreach($arr as $e){
                if($e !== comicCategory || $e !== funkoCategory){

                    $strQuery .= AND_S.$filt.SPACE.EQ.SPACE.'?';//"'".$e."'";
                    //array_push($queryVars,$e);
                    addQueryParams($prodType,$e);
                }
            }
        return $strQuery;
    }

    /**
     * @param array $prods Array of products to be filtered on price
     * @param array $priceFiltersSelected array of all price-range filters selected by customer
     * @param array $pricesInterval must be structured as $intervalDef = ["rangeTag"=> ["from"=>value,"to"=>value],
     * "rangeTag-1"=> ["from"=>value,"to"=>value],...];
     * @return array $allProd array containing all products match any range of prices selected, there could be prods that
     * match only one of the price ranges
     */
    function filterProdsByPrice($prods,$priceFiltersSelected,$pricesInterval){
        $allProd = [];
        foreach($priceFiltersSelected as $filtPrice){
            for($i=0; $i < count($prods);$i++){
                $elem = $prods[$i];
                $from = isset($pricesInterval[$filtPrice]["from"]) ? $pricesInterval[$filtPrice]["from"] : defaultMinPrice;
                $to = isset($pricesInterval[$filtPrice]["to"]) ? $pricesInterval[$filtPrice]["to"] : defaultMaxPrice;

                $prodPrice = isset($elem['DiscountedPrice']) ? $elem['DiscountedPrice'] : $elem['Price'];
                
                if($from <= $prodPrice && $prodPrice <= $to){
                    array_push($allProd,$elem);
                }
                
            }
        }
        return $allProd;
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

?>