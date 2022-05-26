<?php
// Pour éviter de faire des connexions inutiles à la base de données, on l'appelle que si nécessaire.
if(isset($db_required) && $db_required == true){
    // Initialisation de la connexion à la base de données
?>
