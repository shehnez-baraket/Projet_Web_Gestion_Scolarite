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
        <h1 class="display-4">Modifier les étudiants</h1>
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
                Editer
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
                  if ($_SESSION["autoriser"] != "oui") {
                    header("location:login.php");
                    exit();
                  } else {
                    if (isset($_POST['editpost'])) {
                      $cinu = trim($_POST['cin']);
                      $nom = trim($_POST['nom']);
                      $prenom = trim($_POST['prenom']);
                      $email = trim($_POST['email']);
                      $adresse = trim($_POST['adresse']);
                      $pwd = trim($_POST['pwd']);
                      $cpwd = trim($_POST['cpwd']);
                      $classe = $_POST['classe'];
                      $id = $_POST['id'];
                      $sql = "UPDATE etudiant SET cin = :cin, email = :email, password = :password, cpassword = :cpassword, nom = :nom, prenom = :prenom, adresse = :adresse, Classe = :classe WHERE cin = :id";
                      $stmt = $pdo->prepare($sql);
                      $stmt->execute([
                        ':cin' => $cinu,
                        ':email' => $email,
                        ':password' => md5($pwd),
                        ':cpassword' => md5($cpwd),
                        ':nom' => $nom,
                        ':prenom' => $prenom,
                        ':adresse' => $adresse,
                        ':classe' => $classe,
                        ':id' => $id
                      ]);
                      $erreur = "L'ajout sera términer";
                    }
                  }

                  ?>
                  <form action="modifierEtudiant.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $cin ?>" />
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal1">
                      Editer
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Editer Etudiant</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <div class="form-group">
                              <input type="hidden" name="id" value="<?php echo $cin ?>" />
                              <label for="nom">Nom:</label><br>
                              <input type="text" id="nom" name="nom" class="form-control" required autofocus>
                            </div>
                            <!--Prénom-->
                            <div class="form-group">
                              <label for="prenom">Prénom:</label><br>
                              <input type="text" id="prenom" name="prenom" class="form-control" required>
                            </div>
                            <!--Email-->
                            <div class="form-group">
                              <label for="email">Email:</label><br>
                              <input type="email" id="email" name="email" class="form-control" required>
                            </div>
                            <!--CIN-->
                            <div class="form-group">
                              <label for="cin">CIN:</label><br>
                              <input type="text" id="cin" name="cin" class="form-control" required pattern="[0-9]{8}" title="8 chiffres" />
                            </div>
                            <!--Password-->
                            <div class="form-group">
                              <label for="pwd">Mot de passe:</label><br>
                              <input type="password" id="pwd" name="pwd" class="form-control" required pattern="[a-zA-Z0-9]{8,}" title="Au moins 8 lettres et nombres" />
                            </div>
                            <!--ConfirmPassword-->
                            <div class="form-group">
                              <label for="cpwd">Confirmer Mot de passe:</label><br>
                              <input type="password" id="cpwd" name="cpwd" class="form-control" required />
                            </div>
                            <!--Classe-->
                            <div class="form-group">
                              <label for="select-classe">Select Classe:</label>
                              <select name="classe" class="form-control" id="select-classe">
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
                            </div>
                            <!-- <div class="form-group">
                        <label for="classe">Classe:</label><br>
                        <input type="text" id="classe" name="classe" class="form-control" required pattern="INFO[1-3]{1}-[A-E]{1}"
                        title="Pattern INFOX-X. Par Exemple: INFO1-A, INFO2-E, INFO3-C">
                        </div> -->
                            <!--Adresse-->
                            <div class="form-group">
                              <label for="adresse">Adresse:</label><br>
                              <textarea id="adresse" name="adresse" rows="10" cols="30" class="form-control" required>
                        </textarea>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="close" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="editpost" value="editer" class="btn btn-primary">Update</button>
                          </div>

                        </div>
                      </div>
                    </div>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

</html>