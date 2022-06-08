<?php
include("database.php");

if(isset($_POST['nom']) and isset($_POST['prenom']) and isset($_POST['password']) and isset($_POST['passwordverif']) and isset($_POST['email'])){

    $insertion_possible = false;

    /* on valide tous les champs (si le mail est bien un mail, si le mot de passe et la confirmation de mot de passe sont pareils, si les noms / prénoms ne disposent que de lettres */

    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && strcmp($_POST['password'], $_POST['passwordverif']) === 0 && preg_match("/^[a-zA-Z-' ]*$/", $_POST['nom']) && preg_match("/^[a-zA-Z-' ]*$/", $_POST['prenom'])){
        echo "connexion valide";
        $insertion_possible = true;
    }

    /* To do: vérifier les champs + vérifier site un compte n'existe pas déjà avec ce login / email.
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

    }

} else{
    header("Location: ../register.php");
}


?>