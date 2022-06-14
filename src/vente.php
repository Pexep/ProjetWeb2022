<?php
include("includes/before_headers.php");
$db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
$found = false;
$action = false;
$connected = isset($_SESSION['connected']) && $_SESSION['connected'] == true;
$final = false;
$userFound = false;
$confirm = false;

if (isset($_SESSION["login"])) {
    $user_req = $db->prepare("SELECT * FROM users WHERE email = ?");
    $user_req->execute(array($_SESSION["login"]));
    $user = $user_req->fetch();
    if ($user != false) {
        $userFound = true;
        $userID = $user["id"];
    }
}

if (isset($_GET["id"])) {
    $productID = $_GET["id"];
    $prod_req = $db->prepare("SELECT * FROM products WHERE id = ?");
    $prod_req->execute(array($productID));
    $product = $prod_req->fetch();
    if ($product != false) {
        $found = true;
    }
}

if ($found) {
    $vente_req = $db->prepare("SELECT bs.product,bs.business,b.name FROM businessBuy bs INNER JOIN Business b ON bs.business=b.id WHERE product = ?");
    $vente_req->execute(array($productID));
    $vente = $vente_req->fetch();
    if ($vente != false) {
        $action = true;
    }
}

if ($connected) {
    $login = $_SESSION['login'];
    $req = $db->prepare("SELECT id from users where email=:login;");
    $req->execute(array(
        "login" => $login
    ));

    $result = $req->fetch();
    $userid = $result["id"];
}

if (isset($_GET['company']) && $connected && $action) {
    $vente_final_req = $db->prepare("SELECT bs.product,bs.price,bs.business,bs.quantity,b.name FROM businessBuy bs INNER JOIN Business b ON bs.business=b.id WHERE product = ? AND business = ?");
    $vente_final_req->execute(array($productID, $_GET['company']));
    $vente_final = $vente_final_req->fetch();
    if ($vente_final != false) {
        $final = true;
		$vente = $vente_final;
		$vente_req = $vente_final_req;
    }
}

if (isset($_GET["confirm"]) && $final) {
    $confirm = true;
}

/* On change la description du site en fonction de si le produit a été trouvé ou non */
if (!$found) {
    /*
    On précise que le produit n'a pas été trouvé.
    */
    $title = "Produit non trouvé - Komposant";
    $description = "Ce produit n'existe pas.";
} else {
    /*
    On peut mettre les informations du produit dans la description et le titre de la page si on les trouve bien.
    */
    $title = "Vente - " . $product["name"];
    $description = $product["description"];
}

if ($confirm) { ?>
    <?php
    $montantCagnotte = $vente["price"];
    $nouvelleCagnotte = $user["coins"] + $montantCagnotte;
    $final_req = $db->prepare("UPDATE users SET coins = ? WHERE id = ? ; UPDATE businessBuy SET quantity = ? WHERE business = ? AND product = ? ; INSERT INTO usersSales (user,product,price,status) VALUES (?,?,?,?)");
    $final_req->execute(array($nouvelleCagnotte, $userID, $vente["quantity"] - 1, $vente["business"], $productID, $userID, $productID, $montantCagnotte, "En attente"));
    if ($vente["quantity"] == 1) {
        $del_product = $db->prepare("DELETE FROM businessBuy WHERE quantity = 1 AND product = ? AND business = ?");
        $del_product->execute(array($productID, $vente["business"]));
    }
	$extract_req = $db->prepare("SELECT * FROM ExtractionFromTypeItem WHERE typeItem = ?");
	$extract_req->execute(array($productID));
	// foreach ($extract_req->fetchAll() as $extract) {
	// 	$user_extract_req = $db->prepare("INSERT INTO usersExtractions (user,element, quantity) VALUES (?,?,?)");
	// 	$user_extract_req->execute(array($userID,$extract['element'],$extract['quantity']));
	// }
	while ($extract = $extract_req->fetch()){
		$user_extract_req = $db->prepare("INSERT INTO usersExtractions (user,element, quantity) VALUES (?,?,?)");
		$user_extract_req->execute(array($userID,$extract['element'],$extract['quantity']));
	}
    ?>
    <html>
    <?php include("includes/header.php"); ?>

    <body>
        <?php include("includes/navbar.php"); ?>
        <h1>Vente confirmée</h1><br>
        Vous avez vendu avec succès <?php echo $product["name"] ?> à l'entreprise <?php echo $vente["name"] ?>.<br>
        <?php echo $montantCagnotte ?>€ ont été crédités sur votre cagnotte, nouveau solde : <?php echo $nouvelleCagnotte ?>€<br><br>
        Merci pour votre vente.
    </body>

    </html>
<?php
} elseif ($final) { ?>
    <html>
    <?php include("includes/header.php"); ?>

    <body>
        <?php include("includes/navbar.php"); ?>
        <form id="finalisation" method="get" action="">
            <input name="id" type="hidden" value="<?php echo $productID ?>">
            <input name="company" type="hidden" value="<?php echo $_GET["company"] ?>">
            <input name="confirm" type="hidden" value="true">
        </form>
        <h1>Vente de <?php echo $product["name"] ?> - Finalisation</h1>
        <br>
        <h3>Produit vendu:</h3>
        <?php echo $product["name"] ?><br>
        <br>
        <h3>Prix:</h3>
        <?php echo $vente['price'] ?>€<br>
        <br>
        <h3>Entreprise acheteuse:</h3>
        <?php echo $vente["name"] ?><br>
        <br>
        <h3>Votre cagnotte:</h3>
        <?php echo $user["coins"] ?>€<br><br>
        <input type="submit" value="Confirmer la vente" form="finalisation">

    </body>

    </html>
<?php
} elseif ($found && $connected && $action) { ?>
    <html>
    <?php include("includes/header.php"); ?>

    <body>
        <?php include("includes/navbar.php"); ?>
        <h1>Vente de <?php echo $product["name"] ?></h1>
        <br>
        <form id="comp-select" method="get" action="">
            <input name="id" type="hidden" value="<?php echo $productID ?>">
        </form>
        <label for="comp-select">Choisissez une entreprise:</label><br>
        <select name="company" id="comp-select" form="comp-select">
            <option value="0">--Selectionnez--</option>
            <option value="<?php echo $vente['business'] ?>"><?php echo $vente['name'] ?></option>
            <?php
            foreach ($vente_req->fetchAll() as $entreprise) {
            ?>
                <option value="<?php echo $entreprise['business'] ?>"><?php echo $entreprise['name'] ?></option>
            <?php } ?>
        </select>
        <br>
        <br>

        <input type="submit" value="Continuer" form="comp-select">
    </body>

    </html>
<?php
} else { ?>
    <html>
    <?php include("includes/header.php"); ?>

    <body>
        <?php include("includes/navbar.php"); ?>
        <?php if (!$found) { ?>
            <h1>Produit non trouvé</h1>
        <?php } elseif (!$action) { ?>
            <h1>Produit non disponible</h1>
        <?php } elseif (!$connected) { ?>
            <h1>Veuillez vous connecter pour continuer</h1>
        <?php } ?>
    </body>

    </html>
<?php
} ?>
