<?php
include("before_headers.php");

if(isset($_POST['nom']) and isset($_POST['prenom']) and isset($_POST['password']) and isset($_POST['passwordverif']) and isset($_POST['email'])){
    unset($_SESSION["redirect_to"]);
    $insertion_possible = false;

    /* on valide tous les champs (si le mail est bien un mail, si le mot de passe et la confirmation de mot de passe sont pareils, si les noms / prénoms ne disposent que de lettres */

    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && strcmp($_POST['password'], $_POST['passwordverif']) === 0 && preg_match("/^[a-zA-Z-' ]*$/", $_POST['nom']) && preg_match("/^[a-zA-Z-' ]*$/", $_POST['prenom'])){

        $reqverif = $db->prepare('SELECT * FROM  users WHERE email=?');
        $reqverif->execute(array($_POST['email']));

        $verif = $reqverif->fetch();

        if (!$verif){ /* si l'email n'est pas déjà présent dans la BD, on peut valider l'insertion */
            $insertion_possible = true;
        } else {
            $_SESSION['registererror'] = "Adresse mail déjà utilisée";
            header("Location: ../register.php");
        }
    }

    /* To do: vérifier site un compte n'existe pas déjà avec ce login / email.
    */

    if($insertion_possible){
        
        /* Insérer dans la base de données le nouvel utilisateur si les conditions sont respectées */

        $req = $db->prepare('INSERT INTO users (password, email, firstname, lastname) VALUES (:password, :email, :firstname, :lastname)');
        $req->execute(array(
            'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
            'email' => $_POST['email'],
            'firstname' => $_POST['prenom'],
            'lastname' => $_POST['nom']
        ));
        
        /* Redirection vers la page de login */
        header("Location: ../login.php");

    }

} else{
    $_SESSION['registererror'] = "Champs vides, veuillez être intelligent....";
    header("Location: ../register.php");
}


?>