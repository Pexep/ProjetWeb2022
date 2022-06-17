<?php
include("before_headers.php");
include("mail.php");


if(isset($_POST["email"]) && isset($_POST["newpassword"]) && isset($_POST["passwordconfirmation"]) && isset($_POST["code"])){
    $code = $_POST["code"];
    $user = $db->prepare("SELECT * FROM users WHERE email = :email");
    $user->execute(array(":email" => $_POST["email"]));
    $user = $user->fetch();

    // Le code "424242" est un code de secours en cas de problèmes avec l'envoi des mails pendant la notation de la saé.
    if($code == $user["passwordresetcode"]){
        /* On peut valider le changement du mot de passe */
        if($_POST["newpassword"] == $_POST["passwordconfirmation"]){
            /* On peut valider le changement du mot de passe */
            $req = $db->prepare("UPDATE users SET password = :password, passwordResetCode=null WHERE email = :email");
            $req->execute(array(
                "password" => password_hash($_POST["newpassword"], PASSWORD_BCRYPT),
                "email" => $_POST["email"]
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
} else {
    $req = $db->prepare("SELECT * FROM users WHERE email = :email");
    $req->execute(array(
        "email" => $_POST["email"]
    ));
    $result = $req->fetch();
    if($result){
        /* On a trouvé un compte avec cette adresse mail */
        $code = substr(md5(uniqid(rand(), true)), 0, 8);

        $usrmail = base64_encode($_POST["email"]);

        $mail->Subject = "Réinitialisation de votre mot de passe";

        $lien = "https://iut.yvan.dev/komposant/forgotPassword.php?code=".$code."&email=".$usrmail."";
        $mail->Body = 'Bonjour, <br/> <br/> Vous avez demandé la réinitialisation du mot de passe de votre compte Komposant.<br/>Veuillez trouver le lien pour accéder au formulaire de réinitialiation de mot de passe ci-dessous: <br/><a href="'.$lien.'">'.$lien.'</a></br><i>Si vous n\'êtes pas à l\'origine de cette requête, vous pouvez ignorer ce message.</i>';
        // $mail->Body= 'Bonjour\nVous avez demandé la réinitialisation du mot de passe de votre compte Komposant.\nVeuillez trouver le lien pour accéder au formulaire de réinitialiation de mot de passe ci-dessous:\n';
        $mail->addAddress($_POST["email"]);
        $mail->isHTML(true);
        $mail->send();

        $update_usr = $db->prepare("UPDATE users SET passwordResetCode = :code WHERE email = :email");
        $update_usr->execute(array(
            "code" => $code,
            "email" => $_POST["email"]
        ));

    }
}
?>