<?php
include("includes/before_headers.php");

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
    $achat_req = $db->prepare("SELECT bs.product,bs.business,b.name FROM businessSell bs INNER JOIN Business b ON bs.business=b.id WHERE product = ?");
    $achat_req->execute(array($productID));
    $achat = $achat_req->fetch();
    if ($achat != false) {
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
    $achat_req = $db->prepare("SELECT bs.product,bs.price,bs.business,bs.quantity,b.name FROM businessSell bs INNER JOIN Business b ON bs.business=b.id WHERE product = ? AND business = ?");
    $achat_req->execute(array($productID, $_GET['company']));
    $achat = $achat_req->fetch();
    if ($achat != false) {
        $final = true;
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
    $title = "Achat - " . $product["name"];
    $description = $product["description"];
}

if ($confirm) { ?>
    <?php
    $montant = $achat["price"];
    $montantCagnotte = 0;
    if (isset($_GET["utiliser_cagnotte"])) {
        if ($montant <= $user["coins"]) {
            $montantCagnotte = $montant;
            $montant = 0;
        } else {
            $montantCagnotte = $user["coins"];
            $montant -= $montantCagnotte;
        }
    }
    $nouvelleCagnotte = $user["coins"] - $montantCagnotte;
    $final_req = $db->prepare("UPDATE users SET coins = ? WHERE id = ? ; UPDATE businessSell SET quantity = ? WHERE business = ? AND product = ? ; INSERT INTO usersOrders (user,product,status) VALUES (?,?,?)");
    $final_req->execute(array($nouvelleCagnotte, $userID, $achat["quantity"] - 1, $achat["business"], $productID, $userID, $productID, "En préparation"));
    if ($achat["quantity"] == 1) {
        $del_product = $db->prepare("DELETE FROM businessSell WHERE quantity = 1 AND product = ? AND business = ?");
        $del_product->execute(array($productID, $achat["business"]));
    }
    ?>
    <html>
    <?php include("includes/header.php"); ?>

    <body>
        <?php include("includes/navbar.php"); ?>
        <h1>Achat confirmé</h1><br>
        Vous avez acheté avec succès <?php echo $product["name"] ?> auprès de l'entreprise <?php echo $achat["name"] ?> pour <?php echo $achat['price'] ?>€.<br>
        <?php echo $montantCagnotte ?>€ ont été débités de votre cagnotte, nouveau solde : <?php echo $nouvelleCagnotte ?>€<br>
        <?php echo $montant ?>€ ont été débités de votre compte.<br>
        Vous recevrez votre commande très bientôt.<br><br>
        Merci pour votre achat.
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
        <h1>Achat de <?php echo $product["name"] ?> - Finalisation</h1>
        <br>
        <h3>Produit acheté:</h3>
        <?php echo $product["name"] ?><br>
        <br>
        <h3>Prix:</h3>
        <?php echo $achat['price'] ?>€<br>
        <br>
        <h3>Entreprise marchande:</h3>
        <?php echo $achat["name"] ?><br>
        <br>
        <h3>Votre cagnotte:</h3>
        <?php echo $user["coins"] ?>€<br>
        Pour utiliser votre cagnotte pour cet achat veuillez cocher cette case <input type="checkbox" name="utiliser_cagnotte" form="finalisation"><br>
        <br>
        <input type="submit" value="Confirmer l'achat" form="finalisation">

    </body>

    </html>
<?php
} elseif ($found && $connected && $action) { ?>
    <html>
    <?php include("includes/header.php"); ?>

    <body>
        <?php include("includes/navbar.php"); ?>
        <h1>Achat de <?php echo $product["name"] ?></h1>
        <br>
        <form id="comp-select" method="get" action="">
            <input name="id" type="hidden" value="<?php echo $productID ?>">
        </form>
        <label for="comp-select">Choisissez une entreprise:</label><br>
        <select name="company" id="comp-select" form="comp-select">
            <option value="">--Selectionnez--</option>
            <option value="<?php echo $achat['business'] ?>"><?php echo $achat['name'] ?></option>
            <?php
            foreach ($achat_req->fetchAll() as $entreprise) {
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