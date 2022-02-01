<?php
    require_once 'bootstrap.php';
    session_start();  // needed for sessions.
    
    if(isset($_SESSION['url'])) 
       $lastPage = $_SESSION['url']; // holds url for last page visited.
    else 
       $url = "index.php"; 
    
    header("Location: $lastPage"); 
//controllare se l'utente è loggato
//Controllare azione 
/*
if(!isUserLoggedIn() || !isset($_GET["action"])){

        //reindirizzo l'utente al login se viene passata una action non gestita
        header("location: login.php");

}*/

    require 'templates/base.php';

    
?>