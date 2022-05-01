<?php include("connexion.php");
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  

  <style>
    .erreur {
      color: red;
      text-align: center;
    }
  </style>
</head>

<body>
  <?php
  include("entete.html");
  ?>


  <main role="main">
    <div class="jumbotron">
      <div class="container">
        <h1 class="display-4">Ajouter un groupe</h1>
        <p>Remplir le formulaire ci-dessous afin d'ajouter un groupe!</p>
      </div>
    </div>


    <div class="container">
      <?php
      $erreur = "";
      if ($_SESSION["autoriser"] != "oui") {
        header("location:login.php");
        exit();
      } else {
        if (isset($_POST['ajouter'])) {
          $nom = trim($_POST['nomGroupe']);
          $sel = $pdo->prepare("select name_classe from classe where name_classe=?");
          $sel->execute(array($nom));
          $tab = $sel->fetchAll();
          if (count($tab) > 0)
            $erreur = "NOT OK"; // Etudiant existe déja
          else {
            $sql = "INSERT INTO classe (name_classe) values (:name)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
              ':name' => $nom,
            ]);
            $erreur = "Ajout effectué";
          }
        }
      }
      ?>

      <form id="myform" method="POST" action="ajouterGroupe.php">
        <!--Nom-->
        <!-- <div class="alert alert-primary" role="alert">
        
        </div> -->
        <div class="form-group">
          <label for="nom">Nom de Groupe:</label><br>
          <input type="text" id="nom" name="nomGroupe" class="form-control" required autofocus>
        </div>
        <div class="erreur"><?php echo $erreur ?></div>
        <!--Bouton Ajouter-->
        <button type="submit" name="ajouter" value="ajouter" class="btn btn-primary btn-block">Ajouter</button>
      </form>

    </div>
  </main>


  <?php
  include("footer.html");
  ?>

  <script src="./assets/dist/js/inscrire.js"></script>
</body>

</html>