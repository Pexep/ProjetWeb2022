<?php
include("config.php");

if(isset($database_needed) and $database_needed == true) {
    // Connect to the database
    $db = mysqli_connect($db_host, $db_user, $db_passwd, $db_name);
    if(!$db) {
        die("Connection failed: " . mysqli_connect_error());
    }
}

?>