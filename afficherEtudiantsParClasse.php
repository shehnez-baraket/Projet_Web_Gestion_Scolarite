<?php include("connexion.php");
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
</head>

<body>
  <?php
  include("entete.html");
  ?>

  <form class="form-inline my-2 my-lg-0">
    <input class="form-control mr-sm-2" type="text" placeholder="Saisir un groupe" aria-label="Chercher un groupe">
    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Chercher Groupe</button>
  </form>
  </div>
  </nav>

  <main role="main">
    <div class="jumbotron">
      <div class="container">
        <h1 class="display-4">Afficher la liste d'étudiants par groupe</h1>
        <p>Cliquer sur la liste afin de choisir une classe!</p>
      </div>
    </div>

    <div class="container">
      <form action="" method="POST">
        <div class="form-group">
          <label for="classe">Choisir une classe:</label><br>
          <!--
<input list="classe">
<datalist id="classe" name="classe">
    <option value="1-INFOA">1-INFOA</option>
    <option value="1-INFOB">1-INFOB</option>
    <option value="1-INFOC">1-INFOC</option>
    <option value="1-INFOD">1-INFOD</option>
    <option value="1-INFOE">1-INFOE</option>
</datalist>
-->

          <select id="classe" name="classe" class="custom-select custom-select-sm custom-select-lg">
            <?php
            $sql0 = "SELECT * FROM classe";
            $stmt0 = $pdo->prepare($sql0);
            $stmt0->execute();
            while ($cats = $stmt0->fetch(PDO::FETCH_ASSOC)) { ?>
              <option value="<?php echo $cats['name_classe']; ?>">
                <?php echo $cats['name_classe']; ?>
              </option>
            <?php }
            ?>
          </select>
          <button type="submit" name="afficherpar">afficher</button>
        </div>
      </form>
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

            if ($_SESSION["autoriser"] != "oui") {
              header("location:login.php");
              exit();
            } else {
              if (isset($_POST['afficherpar'])) {
                $classe = $_POST['classe'];
                $sql = "SELECT * from etudiant where Classe = :classe";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                  ':classe' => $classe,
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