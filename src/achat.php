<?php
include("includes/before_headers.php");

$found = false;
$action = false;
$connected = isset($_SESSION['connected']) && $_SESSION['connected'] == true;
$final = false;

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

if($found){
      $achat_req = $db->prepare("SELECT bs.product,bs.price,bs.business,b.name FROM businessSell bs INNER JOIN Business b ON bs.business=b.id WHERE product = ?");
      $achat_req->execute(array($productID));
      $achat = $achat_req->fetch();
      if ($achat != false){
        $action = true;
      }
}

if ($connected){
  $login=$_SESSION['login'];
  $req = $db->prepare("SELECT id from users where email=:login;");
  $req->execute(array(
    "login" => $login
  ));

  $result = $req->fetch();
  $userid= $result["id"];
}

if (isset($_GET['comp-select']) && $connected && $action){
  $achat_final_req = $db->prepare("SELECT bs.product,bs.price,bs.business,b.name FROM businessSell bs INNER JOIN Business b ON bs.business=b.id WHERE product = ? AND business = ?");
  $achat_final_req->execute(array($productID),array($_GET['comp-select']));
  $achat_final = $achat_final_req->fetch();
  if ($achat_final != false){
    $final = true;
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
    $title = "Achat - ".$product["name"];
    $description = $product["description"];
}


if ($final){

echo "finalisation";



}elseif($found && $connected && $action){ ?>
  <html>
      <?php include("includes/header.php"); ?>
      <body>
          <?php include("includes/navbar.php"); ?>
          <h1>Achat de <?php echo $product["name"]?></h1>
          <br>
          <label for="comp-select">Choisissez une entreprise:</label>
          <select name="company" id="comp-select" form="comp-select">
              <?php
              foreach ($achat_req->fetchAll() as $entreprise) {
                  ?>
              <option value="<?php echo $entreprise['business']?>"><?php echo $entreprise['name']?></option>
            <?php } ?>
          </select>

          <form id="comp-select" method="get" action="">
            <input type="submit" value="Continuer">
          </form>
      </body>
    </html>
<?php
}else{ ?>
  <html>
      <?php include("includes/header.php"); ?>
      <body>
          <?php include("includes/navbar.php"); ?>
          <?php if (!$found){?>
          <h1>Produit non trouvé</h1>
          <?php }elseif (!$action) {?>
          <h1>Produit non disponible</h1>
          <?php }elseif (!$connected) {?>
          <h1>Veuillez vous connecter pour continuer</h1>
        <?php } ?>
      </body>
  </html>
<?php
} ?>
