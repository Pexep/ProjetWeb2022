<?php
$title = "S'enregistrer - Komposant";
$description = "Page pour créer un compte sur le site komposant.com";
?>

<html>
    
    <?php include("includes/header.php"); ?>

    <body>

        <?php include("includes/navbar.php"); ?>

        <form action="includes/register.php" method="post" class="w3-container w3-card">
            <h2>S'inscrire</h2>
            <label>Nom</label>
            <input type="text" name="nom" placeholder="Nom" class="w3-input" required>
            <label>Prénom</label>
            <input type="text" name="prenom" placeholder="Prénom" class="w3-input" required>
            <label>Adresse mail</label>
            <input type="mail" name="login" placeholder="Adresse mail" class="w3-input" required>
            <label>Mot de passe</label>
            <input type="password" name="password" placeholder="Mot de passe" class="w3-input" required>
            <label>Confirmer votre mot de passe</label>
            <input type="password" name="passwordverif" placeholder="Entrer à nouveau votre mot de passe" class="w3-input" required>
            <br>
            <input type="submit" value="Login" class="w3-button w3-green">
        </form>

</html>