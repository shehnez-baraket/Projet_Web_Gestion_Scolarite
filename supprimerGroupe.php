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
        <h1 class="display-4">Supprimer les groupes</h1>
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
                ID
              </th>
              <th>
                Nom
              </th>
              <th>
                Supprimer
              </th>
            </tr>
            <!--1er Etudiant-->
            <?php



            $sql = "SELECT * from classe";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            while ($groupes = $stmt->fetch(PDO::FETCH_ASSOC)) {
              $id = $groupes['id_groupe'];
              $groupe_name = $groupes['name_classe'];

            ?>
              <tr>
                <td>
                  <?php echo $id ?>
                </td>
                <td>
                  <?php echo $groupe_name ?>
                </td>
                <td>
                  <?php
                  if (isset($_POST['delete-delete-groupe'])) {
                    $sql = "DELETE FROM classe WHERE id_groupe = :id";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([
                      ':id' => $_POST['id'],
                    ]);
                    //  header("Location: supprimerEtudiant.php");
                  }
                  ?>

                  <form action="supprimerGroupe.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $id ?>" />
                    <button name="delete-delete-groupe" class="btn btn-danger">Supprimer</button>
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