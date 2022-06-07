<?php
  include("includes/database.php");
  /* Personnalisation des infos de la page */
  session_start();
  $title="Vos informations";
  $description="Page des informations des utilisateurs sur site komposant.com";

  //$login=$_SESSION['login'];
  $login='golgot77@gmail.com';
  $req = $db->prepare("SELECT id from users where email=:login;");
  $req->execute(array(
    "login" => $login
  ));

  $result = $req->fetch();
  $userid= $result["id"];
  // $userId=mysqli_fetch_assoc(mysqli_query($bd,"Select id from Customer where login=\'$login\';"));
?>

<!DOCTYPE html>
<html>
    <?php include("includes/navbar.php"); ?>
      <div>Vos informations</div>
    <?php include("includes/header.php") ?>
  <body>
    <div id="infoLogin">
      <?php
        $req = $db->prepare("SELECT nom from usersAdresses where user=:id;");
        $req->execute(array(
          "id" => $userid
        ));
        $nom=$req->fetch();
        echo "Votre nom : ".$nom['nom']."<br>\n"
      ?>
      <br>
    </div>
    <div id="infoCagnotte">
      <?php
        $req = $db->prepare("SELECT coins from usersCoins where user=:id;");
        $req->execute(array(
          "id" => $userid
        ));
        $result = $req->fetch();
        echo "Votre cagnotte s'élève à ".$result['coins']."€<br>\n";
      ?>
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
      // Les commandes de l'utilisateur (à finir quand les informations seront dans la bd)
        // $req = $db->prepare("SELECT element, sum(element) AS sum from Customer where id=:id group by element;");
        // $req->execute(array(
        //   "id" => $userid
        // ));
        //
        // while ($result = $req->fetch();){
        //   $qtte=$result['sum'];
        //   $idElement=$result['element'];
        //   echo "<li>$qtte mg de ";
        //   $reqbis = $db->prepare("SELECT name from Mendeleiev where Z=:Z;");
        //   $reqbis->execute(array(
        //     "Z" => $idElement
        //   ));
        //   echo $reqbis->fetch();
        //   echo "</li>\n";
        // }
      ?>
      </ul>
      <br>
    </div>
    <div id="infoVentes">
      Vous avez vendu :<br>
      <ul>
      <?php
      // Les ventes de l'utilisateur (à finir quand les informations seront dans la bd)
        // $req = $db->prepare("SELECT element, sum(element) AS sum from Customer where id=:id group by element;");
        // $req->execute(array(
        //   "id" => $userid
        // ));
        //
        // while ($result = $req->fetch();){
        //   $qtte=$result['sum'];
        //   $idElement=$result['element'];
        //   echo "<li>$qtte mg de ";
        //   $reqbis = $db->prepare("SELECT name from Mendeleiev where Z=:Z;");
        //   $reqbis->execute(array(
        //     "Z" => $idElement
        //   ));
        //   echo $reqbis->fetch();
        //   echo "</li>\n";
        // }
      ?>
      </ul>
      <br>
    </div>
  </body>
</html>
