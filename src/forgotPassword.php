<?php
include("includes/before_headers.php");
$title = "Mot de passe oublié - Komposant";
$description = "Page pour réinitialiser votre mot de passe sur le site komposant.com";

?>


<!DOCTYPE html>
<html lang="fr">

    <?php include("includes/header.php"); ?>
    <body>
        <?php include("includes/navbar.php"); ?>

        <?php if(isset($_GET["code"]) && isset($_GET["email"])) {
            ?>
            <form action="includes/forgotPassword.php" method="post" class="w3-container w3-card">
                <h1>Changement de votre mot de passe</h1>
                <input type="hidden" name="code" value="<?php echo $_GET['code']?>">
                <input type="hidden" name="email" value="<?php echo base64_decode($_GET['email']);?>"> 
                <label for="">Nouveau mot de passe</label>
                <input type="password" name="newpassword" id="" placeholder="Nouveau mot de passe" class="w3-input">
                <label for="">Confirmation du nouveau mot de passe</label>
                <input type="password" name="passwordconfirmation" id="" class="w3-input" placeholder="Confirmation de votre mot de passe"><br>
                <input type="submit" value="Envoyer" class="w3-button w3-green">
            </form>
        <?php
        } else { ?>
            <form action="includes/forgotPassword.php" method="post" class="w3-container w3-card">
                <h1>Réinitialisation de votre mot de passe </h1>
                <label>Adresse mail</label>
                <input type="mail" name="email" placeholder="Adresse mail" class="w3-input" required>
                <br>
                <input type="submit" value="Envoyer" class="w3-button w3-green">
            </form>
        <?php } ?>
    </body>

</html>