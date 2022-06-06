<?php
$title = "Mon compte - Komposant";
$description = "Accédez à votre compte komposant.com";
include_once("includes/before_headers.php");
?>

<!DOCTYPE html>
<html lang="fr">
    <?php include("includes/header.php"); ?>
    <body>
        <?php include("includes/navbar.php"); ?>
        <div>
            Page profil de <?php echo $_SESSION["username"]; ?>
        </div>
        <div>
            Se déconnecter: <a href="includes/logout.php">se déconnecter</a>
        </div>
    </body>
</html>