<?php
include_once("database.php");

session_start();

if(isset($_SESSION['connected'])){
    /*
        Vérification si les identifiants sont encore valides
    */

    if(isset($_SESSION["password"])){
        // On check si le mot de passe est toujours valide d'après les données de la base de données
        $req = $db->prepare("SELECT * from users WHERE email = :login");
        $req->execute(array(
            "login" => $_SESSION["login"]
        ));

        $user = $req->fetch();


        if($user["password"] != $_SESSION["password"]){
            // Le mot de passe a changé, on supprime les données de la session
            session_destroy();
        }
    }

}

?>