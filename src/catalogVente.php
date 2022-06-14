<?php
include("includes/before_headers.php");

$title = "Nos produits - Vente";
$description = "Nos produits disponibles à la vente sur notre site";
$display_categories = true;

if (isset($_GET["categorie"])) {
    $display_categories = false;
    $products = $db->prepare("SELECT p.id, p.name, p.image from products p INNER JOIN businessBuy b ON p.id=b.product WHERE category = ?");
    $products->execute(array($_GET["categorie"]));
} else {
    $list_cat = $db->prepare("SELECT * from categories WHERE id IN (SELECT p.category from products p INNER JOIN businessBuy b ON p.id=b.product)");
    $list_cat->execute();
}
?>

<!DOCTYPE html>
<html lang="fr">

<?php include("includes/header.php"); ?>

<body>
    <?php include("includes/navbar.php"); ?>

    <h1>Nos produits disponibles à la vente</h1>

    <?php
    if ($display_categories) {
        foreach ($list_cat as $cat) { ?>

            <div class="w3-card-4">
                <?php echo "<img src=\"" . $cat["image"] . "\" width=\"150\" height=\"150\">"; ?>
                <?php echo "<a href='?categorie=" . $cat["id"] . "'>" . $cat["title"] . "</a><br>"; ?>

            </div>
        <?php
        }
    } else {
        foreach ($products as $product) {
        ?>
            <a href="product.php?id=<?php echo $product["id"]; ?>&action=vente">
                <div class="w3-card-4">
                    <img src="<?php echo $product["image"]; ?>" width="400" height="400" alt="<?php echo $product["name"]; ?>">
                    <div class="w3-container w3-center">
                        <p><?php echo $product["name"]; ?></p>
                    </div>
                </div>
            </a>
    <?php
        }
    }
    ?>
</body>

</html>