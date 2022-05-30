<?php
session_start();
include("database.php");

if(isset($_POST['login']) and isset($_POST['password'])) {
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $req = $db->prepare('SELECT * FROM users WHERE email = :login');
    $req->execute(array(
        'login' => $_POST['login']
    ));

    $result = $req->fetch();

    if($result){
        if(password_verify($_POST['password'], $result['password'])){
            $connexion_valide = true;
        }
    }


    if($connexion_valide){
        $_SESSION['logged_in'] = true;
        echo "\n Connecté";
    }
}

?>