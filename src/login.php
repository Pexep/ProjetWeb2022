<?php

$title = "Connexion - Komposant";
$description = "Page de connexion du site komposant.com";

?>

<html>

    <?php include("includes/header.php"); ?>

    <?php include("includes/navbar.php"); ?>

    <form action="includes/login.php" method="post" class="w3-container w3-card">
        <label>Adresse mail</label>
        <input type="mail" name="username" placeholder="Adresse mail" class="w3-input">
        <label>Mot de passe</label>
        <input type="password" name="password" placeholder="Mot de passe" class="w3-input">
        <input type="submit" value="Login" class="w3-button w3-green">
        <p>Vous n'avez pas de compte ? <a href="register.php">s'enregistrer</a></p>
    </form>

</html>