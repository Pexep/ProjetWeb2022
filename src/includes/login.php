<?php
session_start();
include("database.php");

if(isset($_POST['login']) and isset($_POST['password'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $query = "SELECT * FROM users WHERE login='$login' AND password='$password'";
    $result = mysqli_query($db, $query);
    if(mysqli_num_rows($result) == 1) {
        $_SESSION['login'] = $login;
        $_SESSION['password'] = $password;
        header("Location: index.php");
    } else {
        echo "Identifiants incorrects";
    }
}

?>