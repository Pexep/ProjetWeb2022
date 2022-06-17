<?php
//session_start();
include("before_headers.php");
include("database.php");

if(isset($_POST['actualpassword']) and isset($_POST['newpassword']) and isset($_POST['checknewpassword'])) {
    
    $changement_valide = false;

    $login = $_SESSION['login'];

    $req = $db->prepare('SELECT password FROM users WHERE email = :login');
    $req->execute(array(
        'login' => $login
    ));

    $result = $req->fetch();
    $pwd = $result["password"];
    
    if(strcmp($_POST['newpassword'], $_POST['checknewpassword']) === 0 && password_verify($_POST['actualpassword'], $pwd)){
        $changement_valide = true;
        // si toutes les conditions sont réunies, on peut changer le mdp dans la BD
    }

    if($changement_valide){
        
        /* on change le mdp dans la bd */
        $req2 = $db->prepare("UPDATE users SET password = :password WHERE email = :email");
            $req2->execute(array(
                "password" => password_hash($_POST["newpassword"], PASSWORD_BCRYPT),
                "email" => $login
            ));

        /* Redirection à la page d'accueil en déconnectant le client */
        header('Location: logout.php');

        

    } else {
        /* Todo: rediriger à la page de login avec un message mauvais mot de passe */
        $_SESSION['passwordchangeerror']="Erreur dans la saisie des mots de passe<br/>Mot de passe oublié: <a href='../forgotPassword.php'>Cliquez ici pour le changer par mail</a>";
        header("Location: ../changePassword.php");
    }
} else {
    /* Aucun champ n'a été rempli on demande à l'utilisateur de recommencer en le redirigeant*/
    $_SESSION['passwordchangeerror']="Champs vides";
    header('Location: ../changePassword.php');
}