<?php
include("includes/before_headers.php");
$title = "Connexion - Komposant";
$description = "Page de connexion du site komposant.com";

if(isset($_GET["redirect_to"])){
    $redirect_to = $_GET["redirect_to"];
} else {
    $redirect_to = "index.php";
}

$_SESSION["redirect_to"] = $redirect_to;

if(isset($_SESSION["connected"]) && $_SESSION["connected"] == true){
    // On redirige l'utilisateur sur la page précédente vu qu'il est déjà connecté pour éviter qu'il perde son temps à retrouver la page où il était
    header("Location: infoUser.php");
}

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
            <!--<label for="stayconnected">Rester connecté</label>-->
            <!--<input type="checkbox" name="stayconnected" id="stayconnected" class="w3-check">-->
            <br>
            <input type="submit" value="Login" class="w3-button w3-green">
    
            <p>Vous n'avez pas de compte ? <a href="register.php">s'enregistrer</a></p>
        </form>

        <?php if (isset($_SESSION['loginerror'])){?>
        <div class="w3-panel w3-red">
        <span onclick="this.parentElement.style.display='none'" class="w3-button w3-display-right">X</span>
            <h4><?php echo $_SESSION['loginerror']; ?></h4>
        </div>
        <?php 
                unset($_SESSION['loginerror']);
            } 
        ?>

    </body>

</html>