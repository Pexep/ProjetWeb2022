<?php
include("includes/before_headers.php");

$found = false;
$action = false;

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

if(isset($_GET["action"]) && $found){
    if ($_GET["action"]=="achat"){
      $achat_req = $db->prepare("SELECT * FROM businessSell WHERE product = ?");
      $achat_req->execute(array($productID));
      $achat = $achat_req->fetch();
      if ($achat != false){
        $action = true;
      }
    }elseif ($_GET["action"]=="vente") {
      $vente_req = $db->prepare("SELECT * FROM businessBuy WHERE product = ?");
      $vente_req->execute(array($productID));
      $vente = $vente_req->fetch();
      if ($vente != false){
        $action = true;
      }
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
            <body>
                <?php include("includes/navbar.php"); ?>

                <h1>
                    <?php echo $product["name"]; ?>
                </h1>

                <p>
                    <?php echo $product["description"]; ?>
                </p>

                <img src="<?php echo $product["image"];?>" alt="Image produit" width="500" height="500" srcset="">

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

                <?php
                if ($action){
                  if ($_GET["action"]=="achat"){?>
                     <form action="achat.php?id=<?php echo $productID?>">
                       <input type="button" value="Acheter">
                     </form>
                  <?php
                  }elseif ($_GET["action"]=="vente"){?>
                    <form action="vente.php?id=<?php echo $productID?>">
                      <input type="button" value="Vendre">
                    </form>
                <?php
                  }
                }else{
                  echo " Produit non disponible ";
                  if ($_GET["action"]=="achat"){
                    echo "à l'achat\n";
                  }elseif ($_GET["action"]=="vente") {
                    echo "à la vente\n";
                  }
                }
                ?>
            </body>
        </html>
    <?php }
else{
    ?>
<html>
    <?php include("includes/header.php"); ?>
    <body>
        <?php include("includes/navbar.php"); ?>
        <h1>Produit non trouvé</h1>
    </body>
</html>
<?php
}
