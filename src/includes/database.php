<?php
include("config.php");

// Connexion à la base de données grâce à PDO
try{
    $db = new PDO('mysql:host='.$db_host.';dbname='.$db_name.';charset=utf8', $db_user, $db_passwd, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch(PDOException $e) {
    die("Connection failed: ".$e->getMessage());
    // Le die va arrête l'execution d'autres lignes php qui suivent
    // On pourrait faire en sorte qu'à la place, l'utilisateur soit redirigé vers une page d'erreur
    // s/o : https://stackoverflow.com/questions/8665985/php-utilizing-exit-or-die-after-headerlocation
    // Ex:
    // header("Location: error.php");
    // exit();
}

?>