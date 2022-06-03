<?php
session_start();
include("database.php");

if(isset($_POST['login']) and isset($_POST['password'])) {
    $connexion_valide = false;
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
        /* On ajoute les détails de connexion dans la session de l'utilisateur */
        $_SESSION['connected'] = true;
        $_SESSION['username'] = $result['email'];
        $_SESSION['password'] = $password;
        if (isset($_POST['stayconnected']) && $_POST['stayconnected'] == "on") {
            setcookie('adresseavoler', $result['email'], time()+60*60*24*30);
            setcookie('mdpavoler', $password, time()+60*60*24*30);
            print_r($_COOKIE);
        }
    } else {
        echo "\n Mauvais mot de passe / adresse mail";
    }
}

?>