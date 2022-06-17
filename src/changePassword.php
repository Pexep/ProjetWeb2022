<?php
include("includes/before_headers.php");
$title = "Réinitialisation du mot de passe - Komposant";
$description = "Page de réinitialisation du mot de passe sur le site komposant.com";

if (isset($_GET["redirect_to"])) {
    $redirect_to = $_GET["redirect_to"];
} else {
    $redirect_to = "index.php";
}

$_SESSION["redirect_to"] = $redirect_to;

if (!isset($_SESSION["connected"]) /*&& $_SESSION["connected"] == false*/) {
    // L'utilsateur n'est pas connecté, il ne peut donc pas accéder à cette page
    /*header("Location: infoUser.php");*/
    echo "Vous n'êtes pas connecté.";
}

?>

<html>

<?php include("includes/header.php"); ?>

<body>

    <?php include("includes/navbar.php"); ?>

    <form action="includes/changePassword.php" method="post" class="w3-container w3-card">
        <h2>Réinitialiser son mot de passe</h2>
        <label>Mot de passe actuel</label>
        <input type="password" name="actualpassword" placeholder="Mot de passe actuel" class="w3-input" required>
        <label>Nouveau mot de passe</label>
        <input type="password" name="newpassword" placeholder="Nouveau mot de passe" class="w3-input" required>
        <label>Confirmer votre nouveau mot de passe</label>
        <input type="password" name="checknewpassword" placeholder="Confirmer votre nouveau mot de passe" class="w3-input" required>
        <!--<label for="stayconnected">Rester connecté</label>-->
        <!--<input type="checkbox" name="stayconnected" id="stayconnected" class="w3-check">-->
        <br>
        <input type="submit" value="Confirmer" class="w3-button w3-green">
    </form>

    <?php if (isset($_SESSION['passwordchangeerror'])) { ?>
        <div class="w3-panel w3-red">
            <span onclick="this.parentElement.style.display='none'" class="w3-button w3-right">X</span> <!-- on crée un bouton qui, au clic, va fermer l'alerte -->
            <h4><?php echo $_SESSION['passwordchangeerror']; ?></h4>
        </div>
    <?php
        unset($_SESSION['passwordchangeerror']);
    }
    ?>

</body>

</html>