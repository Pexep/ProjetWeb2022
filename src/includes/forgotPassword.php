<?php
include("before_headers.php");
include("mail.php");
include("alertmanager.php");

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
            setAlert('success', 'login', 'Votre mot de passe a été modifié avec succès !');
            header("Location: ../login.php");
        } else {
            /* Les mots de passe ne correspondent pas */
            setAlert('error', 'passwordreset', 'Les mots de passe ne correspondent pas');
            header("Location: ../forgotPassword.php?code=".$code."&email=".base64_encode($_POST["email"]));
        }
    } else {
        /* Le code de réinitialisation de mot de passe n'est pas bon */
        setAlert('error', 'passwordreset', 'Le code de réinitialisation de mot de passe n\'est pas bon');
        header("Location: ../forgotPassword.php");
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
        $mail->Body = '<html>Bonjour, <br/> <br/> Vous avez demandé la réinitialisation du mot de passe de votre compte Komposant.<br/>Veuillez trouver le lien pour accéder au formulaire de réinitialiation de mot de passe ci-dessous: <br/><a href="'.$lien.'">'.$lien.'</a></br><i>Si vous n\'êtes pas à l\'origine de cette requête, vous pouvez ignorer ce message.</i></html>';
        $mail->AltBody= "Bonjour \nVous avez demandé la réinitialisation du mot de passe de votre compte Komposant.\nVeuillez trouver le lien pour accéder au formulaire de réinitialiation de mot de passe ci-dessous:\n".$lien."";
        $mail->addAddress($_POST["email"]);
        $mail->isHTML(true);
        $mail->send();

        $update_usr = $db->prepare("UPDATE users SET passwordResetCode = :code WHERE email = :email");
        $update_usr->execute(array(
            "code" => $code,
            "email" => $_POST["email"]
        ));

        include("header.php");
        ?>
        <html>
            <body>
                <div class="w3-container w3-card w3-center w3-green">
                    <h1>Réinitialisation de votre mot de passe</h1>
                    <p>Un lien de réinitialisation de mot de passe vous a été envoyé par mail.</p>
                    <p>N'oubliez pas de verifier vos spams</p>

                    <p>En cas de problèmes de reception du mail, cliquez sur ce lien: <a href="<?php echo $lien?>">lien de confirmation normalement reçu par mail</a></p>
                </div>
            </body>
        </html>
        <?php

    }
}
?>