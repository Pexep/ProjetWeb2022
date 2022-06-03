<?php
// On pourrait faire une condition pour mettre en place des tokens CSRF.
// Pour l'instant, on ne le fait pas.

// TODO: ajouter la supression des cookies

session_start();
header("Location: ../index.php");
session_destroy();

?>