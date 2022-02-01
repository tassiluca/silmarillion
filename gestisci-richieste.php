<?php
    require_once 'bootstrap.php';

//controllare se l'utente è loggato
//Controllare azione 
if(!isUserLoggedIn() || !isset($_GET["action"])){

        //reindirizzo l'utente al login se viene passata una action non gestita
        header("location: login.php");

}
//controllare se modifico o csncello , nel caso leggo dal db
    $action = $_GET["action"];
    if($action != 1){
        $idarticolo = $_GET["id"];
        $articolo = $dbh->getPostById($idarticolo)[0];
        $templateParams["articolo"]=$articolo;
        //var_dump($templateParams["articolo"]);
        if($action == 3){ //cancella TODO:da fare senza numeri, confornto fra stirnghe
            $dbh->deleteCategoriesOfArticle($articolo["idarticolo"]);
            //get id autore dal nome 
            $dbh->deleteArticleOfAuthor($articolo["idarticolo"], $articolo["nome"]);

        }
    }
    $templateParams["titolo"] = "Blog TW - ". getAction($action)." Articolo";
    
//impostiamo paramentri tmeplate 
    
    $templateParams["nome"] = "admin-form.php";
    $templateParams["categorie"] = $dbh->getCategories();
    $templateParams["articolicasuali"] = $dbh->getRandomPosts(2);

    // inlcudiamo template
    require "template/base.php";
?>