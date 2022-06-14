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
        
        <br><br>

        <div class="w3-container w3-center">
            <img src="images/economie_circulaire.jpg" alt="Economie Circulaire" class="w3-margin-right" >
        	<div class="w3-right">
                <p>Notre objectif est de réduire l'impact environnemental de l'informatique. <br>Pour cela, nous appliquons une stratégie d'économie circulaire
                <br>et collaborons avec nos partenaires, qui récupèrent les produits <br>que vous nous ramenez, afin d'en extraire leurs métaux précieux 
                <br>qui vont par la suite être réutilisés pour créer de nouveaux produits !</p>
        	</div>
        </div>

        <br><br>

        <div class="w3-container w3-center">
        	<p>Pour faire face à la pénurie actuelle des composants informatiques et pour leur permettre une deuxième vie, rejoignez nous ! </p>
        </div>



    </body>
</html>