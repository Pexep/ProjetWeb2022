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

    if($result){ /* Si on trouve un compte dans la base de données avec le même mot de passe alors on continue la vérification */ 
        if(password_verify($_POST['password'], $result['password'])){
            $connexion_valide = true;
        }
    }

    if($connexion_valide){
        /* On ajoute les détails de connexion dans la session de l'utilisateur */
        $_SESSION['connected'] = true;
        $_SESSION['login'] = $result['email'];
        $_SESSION['password'] = $password;
        $_SESSION['fullname'] = $result['firstname'] . " " . $result['lastname'];

        /* Ajout des cookies pour rester connecté (pour l'instant on ne les utilise pas) */
        if (isset($_POST['stayconnected']) && $_POST['stayconnected'] == "on") {
            setcookie('adresseavoler', $result['email'], time()+60*60*24*30);
            setcookie('mdpavoler', $password, time()+60*60*24*30);
            print_r($_COOKIE);
        }

        /** Redirection à la page où le client était */
        if(isset($_SESSION['redirect_to'])){
            $redirect_to = $_SESSION['redirect_to'];
            unset($_SESSION['redirect_to']);
            header('Location: '.$redirect_to);
        }
        else{
            header('Location: ../index.php');
        }

    } else {
        /* Todo: rediriger à la page de login avec un message mauvais mot de passe */
        $_SESSION['loginerror']="Mauvaise adresse mail ou mot de passe";
        header("Location: ../login.php");

    }
} else {
    /* Aucun champ n'a été rempli on demande à l'utilisateur de recommencer en le redirigeant sur la page de login*/
    $_SESSION['loginerror']="Champs vides";
    header('Location: ../login.php');
}
