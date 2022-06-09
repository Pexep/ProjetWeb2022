<?php
include("includes/before_headers.php");

$title = "Nos produits";
$description = "Nos produits disponibles sur notre site";
$display_categories = true;

if(isset($_GET["categorie"])){
    $display_categories = false;
    $products = $db->prepare("SELECT * from products WHERE category = ?");
    $products->execute(array($_GET["categorie"]));
}
else {
    $list_cat = $db->prepare("SELECT * from categories");
    $list_cat->execute();
}
?>

<!DOCTYPE html>
<html lang="fr">

    <?php include("includes/header.php"); ?>
    <body>
        <?php include("includes/navbar.php"); ?>

        <h1>Nos produits</h1>

        <?php
        if($display_categories){
            foreach($list_cat as $cat){
                echo "<a href='?categorie=".$cat["id"]."'>".$cat["title"]."</a><br>";
            }
        } else {
            foreach($products as $product){
                echo "<a href='product.php?id=".$product["id"]."'>".$product["name"]."</a><br>";
            }
        }
        ?>
    </body>
</html>