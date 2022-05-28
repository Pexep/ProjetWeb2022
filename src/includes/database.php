<?php
include("config.php");
$database_needed = true;
if(isset($database_needed) and $database_needed == true) {
    // Connect to the database
    try{
        $db = new PDO('mysql:host='.$db_host.';dbname='.$db_name.';charset=utf8', $db_user, $db_password,
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    } catch(PDOException $e) {
        die("Connection failed: ".$e->getMessage());
    }
}

?>