<?php
/*
    Fichier pour personnaliser les titres des pages.
*/
if(!isset($title)){
    $title = "Komposant";
}
if(!isset($description)){
    $description = "Recyclez vos anciens appareils éléctroniques pour sauver la planète et gagnez des bons d'achats !";
}

if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){
    $url = "https://";
} else {
    $url = "http://";
}
$url.= $_SERVER['HTTP_HOST'];
$url.= $_SERVER['REQUEST_URI'];

?>

<head>
    <title><?php echo $title;?> - Komposant</title>
    <meta charset="UTF-8">
    <meta name="description" content="<?php echo $description?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?php echo $title?>">
    <meta property="og:description" content="<?php echo $description?>">
    <meta property="og:url" content="<?php echo $url?>">
    <meta property="og:site_name" content="Komposant">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>