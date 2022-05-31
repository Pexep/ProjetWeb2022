<?php
include("database.php");

if(isset($_POST['login']) and isset($_POST['password']) and isset($_POST['email'])){

    $insertion_possible = false;

    /* To do: vérifier les champs + vérifier site un compte n'existe pas déjà avec ce login / email.
    */

    if($insertion_possible){
        
        /* Insérer dans la base de données le nouvel utilisateur si les conditions sont respectées */

        $req = $db->prepare('INSERT INTO users (login, password, email) VALUES (:login, :password, :email)');
        $req->execute(array(
            'login' => $_POST['login'],
            'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
            'email' => $_POST['email']
        ));

    }

}


?>