<?php
session_start();
include("database.php");

if(isset($_POST['login']) and isset($_POST['password'])) {

    $connexion_valide = true;

    if($connexion_valide){
        $_SESSION['logged_in'] = true;
    }

}

?>