<?php
require_once("connexion.php");
session_start();
if ($_SESSION["autoriser"] != "oui") {
  header("location:login.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

</head>

<body>
  <?php
  include("entete.html");
  ?>


  <main role="main">
    <div class="jumbotron">
      <div class="container">
        <h1 class="display-4">Chercher des étudiants</h1>
        <p>Cliquer sur le bouton afin d'actualiser la liste!</p>
        <form class="page-header-signup mb-2 mb-md-0" action="chercherEtudiant.php" method="POST">
          <div class="form-row justify-content-center">
            <div class="col-lg-6 col-md-8">
              <div class="form-group mr-0 mr-lg-2">
                <input name="search-keyword" class="form-control form-control-solid rounded-pill" type="text" placeholder="Search Etudiant..." />
              </div>
            </div>
            <div class="col-lg-3 col-md-4">
              <button class="btn btn-primary btn-block btn-marketing rounded-pill" type="submit" name="search">Search</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="table-responsive">
          <table class="table table-striped table-hover">
            <!--Ligne Entete-->

            <tr>
              <th>
                CIN
              </th>
              <th>
                Nom
              </th>
              <th>
                Prénom
              </th>
              <th>
                Email
              </th>
              <th>
                Classe
              </th>
            </tr>
            <!--1er Etudiant-->
            <?php

            if (isset($_POST['search'])) {
              $key = trim($_POST['search-keyword']);
              $sql = "SELECT * from etudiant where nom =:nom ";
              $stmt = $pdo->prepare($sql);
              $stmt->execute([
                ':nom' => $key,
              ]);
              while ($etudiants = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $cin = $etudiants['cin'];
                $nom = $etudiants['nom'];
                $prenom = $etudiants['prenom'];
                $email = $etudiants['email'];
                $classe = $etudiants['Classe'];
            ?>
                <tr>
                  <td>
                    <?php echo $cin ?>
                  </td>
                  <td>
                    <?php echo $nom ?>
                  </td>
                  <td>
                    <?php echo $prenom ?>
                  </td>
                  <td>
                    <?php echo $email ?>
                  </td>
                  <td>
                    <?php echo $classe ?>
                  </td>
                </tr>

            <?php
              }
            }
            ?>
          </table>
          <br>
        </div>
        <button type="button" onload="refresh()" class="btn btn-primary btn-block active">Actualiser</button>
      </div>
    </div>

  </main>


  <?php
  include("footer.html");
  ?>
</body>

</html>