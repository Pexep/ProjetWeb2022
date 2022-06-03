<?php

$found = false;


/* */
if(!$found){
    /* 
    On précise que le produit n'a pas été trouvé.
    */
    $title = "Produit non trouvé - Komposant";
    $description = "Ce produit n'existe pas.";
}
else {
    /* 
    On peut mettre les informations du produit dans la description et le titre de la page si on les trouve bien.
    */
    $title = "Nom produit - composant";
    $description = "Description du produit";
}

?>
<html>
    <?php include("includes/header.php"); ?>

    <?php include("includes/navbar.php"); ?>

</html>