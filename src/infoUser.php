<?php
  include("includes/before_headers.php");
  /* Personnalisation des infos de la page */

  $title="Vos informations";
  $description="Page des informations des utilisateurs sur site komposant.com";

  $login=$_SESSION['login'];
  $req = $db->prepare("SELECT id from users where email=:login;");
  $req->execute(array(
    "login" => $login
  ));

  $result = $req->fetch();
  $userid= $result["id"];
?>

<!DOCTYPE html>
<html>
    <?php include("includes/navbar.php"); ?>
      <h1>Vos informations</h1>
    <?php include("includes/header.php") ?>
  <body>
    <div id="infoLogin">
      <?php
        $req = $db->prepare("SELECT firstname,lastname from users where id=:id;");
        $req->execute(array(
          "id" => $userid
        ));
        $nom=$req->fetch();
        echo "Votre nom : ".$nom['firstname']." ".$nom["lastname"]."<br>\n"
      ?>
      <br>
    </div>
    <div id="infoCagnotte">
      <?php
        $req = $db->prepare("SELECT coins from users where id=:id;");
        $req->execute(array(
          "id" => $userid
        ));
        $result = $req->fetch();
        echo "Votre cagnotte s'élève à ".$result['coins']."€<br>\n";
      ?>
      <br>
    </div>
    <div id="infoMetal">
      Vous avez permis de récupérer :<br>
      <ul>
      <?php
        $req = $db->prepare("SELECT element, sum(quantity) AS sum from usersExtractions where user=:id group by element;");
        $req->execute(array(
          "id" => $userid
        ));

        while ($result = $req->fetch()){
          $qtte=$result['sum'];
          $idElement=$result['element'];
          echo "<li>$qtte mg de ";
          $reqbis = $db->prepare("SELECT name from Mendeleiev where Z=:Z;");
          $reqbis->execute(array(
            "Z" => $idElement
          ));
          $name=$reqbis->fetch();
          echo $name['name']."</li>\n";
        }
      ?>
      </ul>
      <br>
    </div>
    <div id="infoCommandes">
      Vos commandes :<br>
      <ul>
      <?php
        // Les commandes de l'utilisateur
        $req = $db->prepare("SELECT  date,status,product FROM usersOrders where user=:id;");
        $req->execute(array(
          "id" => $userid
        ));

        while ($result = $req->fetch()){
          $reqbis=$db->prepare("SELECT  name FROM products where id=:id;");
            $reqbis->execute(array(
              "id" => $result['product']
            ));
          $nom=$reqbis->fetch();
          $nom=$nom['name'];
          $status=$result['status'];
          $date=$result['date'];
          echo "<li>Votre $nom, commandé le : $date, est $status</li>\n";
        }
      ?>
      </ul>
      <br>
    </div>
    <div id="infoVentes">
      Vous avez vendu :<br>
      <ul>
      <?php
      // Les ventes de l'utilisateur
        $req = $db->prepare("SELECT product,price,status from usersSales where user=:id;");
        $req->execute(array(
          "id" => $userid
        ));

        while ($result = $req->fetch()){
          $reqbis=$db->prepare("SELECT  name FROM products where id=:id;");
            $reqbis->execute(array(
              "id" => $result['product']
            ));
          $nom=$reqbis->fetch();
          $nom=$nom['name'];
          $status=$result['status'];
          $prix=$result['price'];
          echo "<li>Votre $nom, retourné pour $prix"."€, est $status</li>\n";
        }
      ?>
      </ul>
      <br>
    </div>
  </body>
</html>
