<?php
/* Personnalisation des infos de la page */
include("includes/before_headers.php");
$title="Accueil";
$description="Page d'accueil du site komposant.com";
?>

<!DOCTYPE html>
<html>
    <?php include("includes/header.php") ?>
    <body>
        <?php include("includes/navbar.php"); ?>
        
        <br>
        
        <div class="w3-center">
        	<img src="images/komposant_logo.png" alt="Logo Komposant" width="300" height="300">
        	<div class="w3-container">
        		<h2>Bienvenue sur notre site Komposant !</h2>
        	</div>
        </div>
        
        <br>

        <div class="w3-center">
        	
        	<div class="w3-container">
        		<h1>Notre objectif est de réduire l'impact environnemental de l'informatique. <br>Pour cela, nous appliquons une stratégie d'économie circulaire </h1>
                <h1>et collaborons avec <br>nos partenaires, </h1>
        	</div>
            <img src="images/economie_circulaire.jpg" alt="Economie Circulaire">
        </div>



    </body>
</html>