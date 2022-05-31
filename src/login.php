<?php

$title = "Connexion - Komposant";
$description = "Page de connexion du site komposant.com";

?>

<html>

    <?php include("includes/header.php"); ?>

    <body>
        
        <?php include("includes/navbar.php"); ?>
    
        <form action="includes/login.php" method="post" class="w3-container w3-card">
            <h2>Se connecter</h2>
            <label>Adresse mail</label>
            <input type="mail" name="login" placeholder="Adresse mail" class="w3-input" required>
            <label>Mot de passe</label>
            <input type="password" name="password" placeholder="Mot de passe" class="w3-input" autocomplete="current-password" required>
            <label for="stayconnected">Rester connecté</label>
            <input type="checkbox" name="stayconnected" id="stayconnected" class="w3-check">
            <br>
            <input type="submit" value="Login" class="w3-button w3-green">
    
            <p>Vous n'avez pas de compte ? <a href="register.php">s'enregistrer</a></p>
        </form>
    </body>

</html>