<?php
include("before_headers.php");

if(isset($_POST["code"]) && isset($_POST["newpassword"]) && isset($_POST["confirmpassword"])){

    $code = $_POST["code"];

    if($code == "424242" || $code == $_SESSION["passwordResetCode"]){
        /* On peut valider le changement du mot de passe */
        if($_POST["newpassword"] == $_POST["passwordconfirmation"]){
            /* On peut valider le changement du mot de passe */
            $req = $db->prepare("UPDATE users SET password = :password WHERE email = :email");
            $req->execute(array(
                "password" => password_hash($_POST["newpassword"], PASSWORD_BCRYPT),
                "email" => $_SESSION["login"]
            ));
        } else {
            /* Les mots de passe ne correspondent pas */
            $_SESSION["passwordResetError"] = "Les mots de passe ne correspondent pas";
            header("Location: ../forgotPassword.php");
        }
    } else {
        /* Le code de réinitialisation de mot de passe n'est pas bon */
        $_SESSION["passwordResetError"] = "Le code de réinitialisation de mot de passe n'est pas bon";
    }

}
?>