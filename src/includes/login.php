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
            // On peut vérifier ici si l'utilisateur a bien vérifié son email
        }
    }

    if($connexion_valide){
        /* On ajoute les détails de connexion dans la session de l'utilisateur */
        $_SESSION['connected'] = true;
        $_SESSION['login'] = $result['email'];
        $_SESSION['password'] = $result['password']; // On stocke le hash dans la session pour vérifier si l'utilisateur ne change pas de mot de passe entre temps
        $_SESSION['fullname'] = $result['firstname'] . " " . $result['lastname'];

        /* Redirection à la page où le client était */
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
        $_SESSION['loginerror']="Mauvaise adresse mail ou mot de passe<br/>Mot de passe oublié: <a href='forgotPassword.php'>Cliquez ici pour le changer</a>";
        header("Location: ../login.php");
    }
} else {
    /* Aucun champ n'a été rempli on demande à l'utilisateur de recommencer en le redirigeant sur la page de login*/
    $_SESSION['loginerror']="Champs vides";
    header('Location: ../login.php');
}
