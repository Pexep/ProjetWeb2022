<?php
include("includes/before_headers.php");

$found = false;
$action = false;
$connected = isset($_SESSION['connected']) && $_SESSION['connected'] == true;
$final = false;
$userFound = false;
$confirm = false;

if (isset($_SESSION["login"])){
  $user_req = $db->prepare("SELECT * FROM users WHERE email = ?");
  $user_req->execute(array($_SESSION["login"]));
  $user = $user_req->fetch();
  if($user != false){
      $userFound = true;
      $userID = $user["id"];
  }
}

if(isset($_GET["id"])){
    $productID = $_GET["id"];
    $prod_req = $db->prepare("SELECT * FROM products WHERE id = ?");
    $prod_req->execute(array($productID));
    $product = $prod_req->fetch();
    if($product != false){
        $found = true;
    }

}

if($found){
      $achat_req = $db->prepare("SELECT bs.product,bs.business,b.name FROM businessSell bs INNER JOIN Business b ON bs.business=b.id WHERE product = ?");
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

if (isset($_GET['company']) && $connected && $action){
  $achat_req = $db->prepare("SELECT bs.product,bs.price,bs.business,b.name FROM businessSell bs INNER JOIN Business b ON bs.business=b.id WHERE product = ? AND business = ?");
  $achat_req->execute(array($productID,$_GET['company']));
  $achat = $achat_req->fetch();
  if ($achat != false){
    $final = true;
  }
}

if (isset($_GET["confirm"]) && $final){
  $confirm = true;
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

if ($confirm){ ?>
  <html>
      <?php include("includes/header.php"); ?>
      <body>
          <?php include("includes/navbar.php"); ?>
          Achat confirmé


      </body>
  </html>
<?php
}elseif ($final){ ?>
  <html>
      <?php include("includes/header.php"); ?>
      <body>
          <?php include("includes/navbar.php"); ?>
          <form id="finalisation" method="get" action="">
            <input name="id" type="hidden" value="<?php echo $productID ?>">
            <input name="company" type="hidden" value="<?php echo $_GET["company"] ?>">
            <input name="confirm" type="hidden" value="true">
          </form>
          <h1>Achat de <?php echo $product["name"]?> - Finalisation</h1>
          <br>
          <h3>Produit acheté:</h3><br>
            <?php echo $product["name"]?><br>
          <br>
          <h3>Prix:</h3><br>
            <?php echo $achat['price'] ?><br>
          <br>
          <h3>Entreprise marchande:</h3><br>
            <?php echo $achat["name"] ?><br>
          <br>
          <h3>Votre cagnotte:</h3><br>
            <?php echo $user["coin"] ?>€<br>
            Pour l'utiliser pour cet achat veuillez cocher cette case <input type="checkbox" name="utiliser_cagnotte" form="finalisation" checked><br>
          <br>
          <input type="submit" value="Confirmer l'achat" form="finalisation">

      </body>
    </html>
<?php
}elseif($found && $connected && $action){ ?>
  <html>
      <?php include("includes/header.php"); ?>
      <body>
          <?php include("includes/navbar.php"); ?>
          <h1>Achat de <?php echo $product["name"]?></h1>
          <br>
          <form id="comp-select" method="get" action="">
            <input name="id" type="hidden" value="<?php echo $productID ?>">
          </form>
          <label for="comp-select">Choisissez une entreprise:</label><br>
          <select name="company" id="comp-select" form="comp-select">
            <option value="">--Selectionnez--</option>
            <option value="<?php echo $achat['business']?>"><?php echo $achat['name']?></option>
              <?php
              foreach ($achat_req->fetchAll() as $entreprise) {
                  ?>
              <option value="<?php echo $entreprise['business']?>"><?php echo $entreprise['name']?></option>
            <?php } ?>
          </select>
          <br>
          <br>

          <input type="submit" value="Continuer" form="comp-select">
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
