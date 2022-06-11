<?php
// Utilisé pour afficher la barre de navigation

// Récupérer le path de l'utilisateur pour le mettre dans le lien de la barre de navigation
$path = $_SERVER['PHP_SELF'];
$path = urlencode($path);
$connected = isset($_SESSION['connected']) && $_SESSION['connected'] == true;
?>

<div class="w3-bar w3-light-grey">
    <a href="index.php" class="w3-bar-item w3-button">Komposant</a>
    <a href="catalogAchat.php" class="w3-bar-item w3-button">Acheter</a>
    <a href="catalogVente.php" class="w3-bar-item w3-button">Vendre</a>
    <div class="w3-dropdown-hover">
    <button class="w3-button">À propos</button>
        <div class="w3-dropdown-content w3-bar-block w3-card-4">
            <a href="team.php" class="w3-bar-item w3-button">Notre équipe</a>
            <a href="partners.php" class="w3-bar-item w3-button">Nos partenaires</a>
            <a href="#" class="w3-bar-item w3-button">Link 3</a>
        </div>
    </div>
    <?php
    if($connected){
        ?>
            <div class="w3-dropdown-hover w3-right">
                <a class="w3-button" href="infoUser.php"><?php echo $_SESSION["fullname"]; ?></a>
                <div class="w3-dropdown-content w3-bar-block w3-card-4">
                    <a href="infoUser.php" class="w3-bar-item w3-button">Mon compte</a>
                    <a href="includes/logout.php" class="w3-bar-item w3-button">Déconnexion</a>
                </div>
            </div>

        <?php
    }
    else{
        echo '<a href="login.php?redirect_to='.$path.'" class="w3-bar-item w3-button w3-right">Se connecter</a>';
    }
    ?>
</div>
