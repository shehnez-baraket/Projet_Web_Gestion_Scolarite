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
  
  <title>SCO-ENICAR Afficher Etudiants</title>
  

</head>

<body>
  <?php
  include("entete.html");
  ?>
  <main role="main">
    <div class="jumbotron">
      <div class="container">
        <h1 class="display-4">Supprimer les étudiants</h1>
        <p>Cliquer sur le bouton afin d'actualiser la liste!</p>
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
              <th>
                Supprimer
              </th>
            </tr>
            <!--1er Etudiant-->
            <?php



            $sql = "SELECT * from etudiant";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
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
                <td>
                  <?php
                  if (isset($_POST['delete-category'])) {
                    $sql = "DELETE FROM etudiant WHERE cin = :id";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([
                      ':id' => $_POST['id']
                    ]);
                    //  header("Location: supprimerEtudiant.php");
                  }
                  ?>

                  <form action="supprimerEtudiant.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $cin ?>" />
                    <button name="delete-category" class="btn btn-danger">Supprimer</button>
                  </form>

                </td>
              </tr>

            <?php
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