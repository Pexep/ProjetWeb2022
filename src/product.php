<?php
include("includes/before_headers.php");

$found = false;

if(isset($_GET["id"])){
    $productID = $_GET["id"];
    $prod_req = $db->prepare("SELECT * FROM products WHERE id = ?");
    $prod_req->execute(array($productID));
    $product = $prod_req->fetch();
    if($product != false){
        $found = true;

        $details_req = $db->prepare("SELECT * from productsDetails WHERE product = ?");

        $details_req->execute(array($productID));
    }


}


/* On change la description du site en fonction de si le produit a été trouvé ou non */
if(!$found){
    /* 
    On précise que le produit n'a pas été trouvé.
    */
    $title = "Produit non trouvé - Komposant";
    $description = "Ce produit n'existe pas.";
} else {
    /* 
    On peut mettre les informations du produit dans la description et le titre de la page si on les trouve bien.
    */
    $title = $product["name"];
    $description = $product["description"];
}

if($found){ ?>
        <html>
            <?php include("includes/header.php"); ?>
            <?php include("includes/navbar.php"); ?>

            <h1>
                <?php echo $product["name"]; ?>
            </h1>

            <p>
                <?php echo $product["description"]; ?>
            </p>

            <table>
            <?php
            foreach ($details_req->fetchAll() as $detail) {
                ?>
                    <tr>
                        <td><?php echo $detail["name"]?></td>
                        <td><?php echo $detail["value"]?></td>
                    </tr>
                <?php } 
            ?> 
            </table>
        </html>
    <?php }
else{
    ?> 
<html>
    <?php include("includes/header.php"); ?>
    <?php include("includes/navbar.php"); ?>
    <h1>Produit non trouvé</h1>
</html>
    
<?php   
}