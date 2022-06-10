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
                ?><div class="w3-quarter">
                    <?php
                    echo "<img src=".echo $cat["image"].">";
                    echo "<a href='?categorie=".$cat["id"]."'>".$cat["title"]."</a><br>";
                    ?>
                </div>
                <?php
            }
        } else {
            foreach($products as $product){
                ?>
                    <a href="product.php?id=<?php echo $product["id"]; ?>">
                        <div class="w3-card-4">
                            <img src="<?php echo $product["image"];?>" width="400" height="400" alt="<?php echo $product["name"];?>">
                            <div class="w3-container w3-center">
                                <p><?php echo $product["name"];?></p>
                            </div>
                        </div> 
                    </a>
                <?php
            }
        }
        ?>
    </body>
</html>