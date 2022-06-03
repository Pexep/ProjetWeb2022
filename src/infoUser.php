<?php
  include("includes/database.php");
  /* Personnalisation des infos de la page */
  session_start();
  $title="Vos informations";
  $description="Page des informations des utilisateurs sur site komposant.com";

  $login=$_SESSION['login'];
  $req = $db->prepare("SELECT id from Customer where login=:login;");
  $req->execute(array(
    "login" ->  $_SESSION['login']
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
      Votre nom d'utilisateur :
      <?php
        echo $login;
        echo "\n";
      ?>
      <br>
    </div>
    <div id="infoCagnotte">
      Votre cagnotte s'élève à
      <?php
        echo mysqli_fetch_assoc(mysqli_query($bd,"Select stash from Customer where id=\'$id\';"));
        echo "\n";
      ?>
      €<br>
    </div>
    <div id="infoMetal">
      Vous avez permis de récupérer :<br>
      <ul>
      <?php
        $res=mysqli_query($bd,"Select element, sum(element) as sum from usersExtraction where id=\'$id\' group by element;");
        while ($element=mysqli_fetch_assoc($res)){
          $qtte=$element['sum'];
          $idElement=$element['element'];
          echo "<li>$qtte mg de ";
          echo mysqli_fetch_assoc(mysqli_query($bd,"Select name from Mendeleiev where Z=\'$idElement\';"));
          echo "</li>\n";
        }
      ?>
      </ul>
      <br>
    </div>
  </body>
</html>
