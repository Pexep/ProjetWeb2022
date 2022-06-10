<?php
$title = "S'enregistrer - Komposant";
$description = "Page pour créer un compte sur le site komposant.com";
include("includes/before_headers.php");
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
            <input type="mail" name="email" placeholder="Adresse mail" class="w3-input" required>
            <label>Mot de passe</label>
            <input type="password" name="password" placeholder="Mot de passe" class="w3-input" required>
            <label>Confirmez votre mot de passe</label>
            <input type="password" name="passwordverif" placeholder="Entrer à nouveau votre mot de passe" class="w3-input" required>
            <br>
            <input type="submit" value="Inscription" class="w3-button w3-green">
            <br>
        </form>
        
        <?php if (isset($_SESSION['registererror'])){?>
        <div class="w3-panel w3-red">
            <h4><?php echo $_SESSION['registererror']; ?></h4>
        </div>
        <?php 
                unset($_SESSION['registererror']);
            } 
        ?>

    </body>

</html>