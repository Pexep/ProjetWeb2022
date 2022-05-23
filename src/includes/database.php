<?php
// connect to mysql database PDO
$db = new PDO('mysql:host=localhost;dbname=dbname', 'username', 'password');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->prepare("SELECT * FROM table WHERE id = :id")->execute(array(':id' => 1));

?>