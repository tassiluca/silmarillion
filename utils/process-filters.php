<?php 
$SPACE = ' ';
$AND = 'and';
$EQ = ' = ';
$AND_S = ' and '; //and with spaces
/*
filters = lang, author, price, availability, publisher,category*/
    require_once '../bootstrap.php';
   
    //print_r($_POST['lang'][0]);
    if(isset($_POST)){
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
                    //appendFilter($data[$k],'P.CategoryName',$query);
                }
                else if(!strcmp($k,'price')){
                    $filtQuery .= appendFilter($data[$k],'P.Price');
                }
                else if(!strcmp($k,'author')){
                    $filtQuery .= appendFilter($data[$k],'C.Author');
                }
                else if(!strcmp($k,'lang')){
                    $filtQuery .= appendFilter($data[$k],'C.Lang');
                }
            }
            echo json_encode($dbh -> getAllComics($filtQuery));
        }
        else{ //send all comics, no filter selected
            echo json_encode($dbh -> getAllComics($query));
        }
        
    }
    
    function appendFilter($arr,$filt){
        global $SPACE,$AND,$EQ,$AND_S;
        $strQUery ='';
        foreach($arr as $e){
            $strQUery .= $AND_S.$filt.$EQ.$SPACE."'".$e."'";
        }
        return $strQUery;
    }
?>