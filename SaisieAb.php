<?php
include('connexion.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>SCO-ENICAR Saisir Absence</title>
</head>

<body>
  <?php
  include("entete.html");
  ?>
  <main role="main">
    <div class="jumbotron">
      <div class="container">
        <h1 class="display-4">Signaler l'absence pour tout un groupe</h1>
        <p>Pour signaler, annuler ou justifier une absence, choisissez d'abord le groupe, le module puis l'étudiant concerné!</p>
      </div>
    </div>

    <div class="container">
      <?php

      if ($_SESSION["autoriser"] != "oui") {
        header("location:login.php");
        exit();
      } else {
        if (isset($_POST['ajouter'])) {
          $date = trim($_POST['deb']);
          $classe = trim($_POST['classe']);
          $module = trim($_POST['module']);
          $desc = trim($_POST['desc']);
          $nom = trim($_POST['nom']);
          $sql = "INSERT INTO absence (nom, classe, module, date, description) values (:nom, :classe, :module, :date, :description)";
          $stmt = $pdo->prepare($sql);
          $stmt->execute([
            ':date' => $date,
            ':classe' => $classe,
            ':module' => $module,
            ':description' => $desc,
            ':nom' => $nom,
          ]);
          $erreur = "Ajout effectué";
        }
      }
      ?>

      <div class="container">
        <form action="saisieAb.php" method="POST" id="myForm">
          <div class="form-group">
            <label for="deb">Choisir une date:</label><br>
            <input type="date" id="deb" name="deb" value="2022-05-01" min="1980-01-01" max="2022-12-31">
          </div>
          <div class="form-group">

            <label for="classe">Select Classe:</label>
            <select name="classe" id="classe" class="custom-select custom-select-sm custom-select-lg">
              <?php
              $sql0 = "SELECT * FROM classe";
              $stmt0 = $pdo->prepare($sql0);
              $stmt0->execute();
              while ($cats = $stmt0->fetch(PDO::FETCH_ASSOC)) { ?>
                <option value="<?php echo $cats['id_groupe']; ?>">
                  <?php echo $cats['name_classe']; ?>
                </option>
              <?php }
              ?>
            </select>
            <label for="module">Ecrire un module:</label><br>
            <input id="module" name="module" class="custom-select custom-select-sm custom-select-lg" type="text" placeholder="Module">

            <label for="nom">Choisir le nom de l'étudiant:</label><br>
            <select id="nom" name="nom" class="custom-select custom-select-sm custom-select-lg" type="text" placeholder="Nom de l'étudiant">
              <?php
              $sql1 = "SELECT * FROM etudiant";
              $stmt1 = $pdo->prepare($sql1);
              $stmt1->execute();
              while ($cat = $stmt1->fetch(PDO::FETCH_ASSOC)) { ?>
                <option value="<?php echo $cat['nom']; ?>">
                  <?php echo $cat['nom']; ?>
                </option>
              <?php }
              ?>
            </select>


            <label for="desc">Donner une description :</label><br>
            <input id="desc" name="desc" class="custom-select custom-select-sm custom-select-lg" type="text" placeholder="Description">
          </div>
          <button type="submit" name="ajouter" value="ajouter" class="btn btn-primary btn-block">Valider</button>
        </form>
      </div>
    </div>
  </main>
  <?php
  include("footer.html");
  ?>
</body>

</html>