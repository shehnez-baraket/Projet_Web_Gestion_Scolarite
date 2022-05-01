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



  <form class="form-inline my-2 my-lg-0">
    <input class="form-control mr-sm-2" type="text" placeholder="Saisir un groupe" aria-label="Chercher un groupe">
    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Chercher Groupe</button>
  </form>
  </div>
  </nav>

  <main role="main">
    <div class="jumbotron">
      <div class="container">
        <h1 class="display-4">Ajouter un étudiant</h1>
        <p>Remplir le formulaire ci-dessous afin d'ajouter un étudiant!</p>
      </div>
    </div>


    <div class="container">
      <?php

      if ($_SESSION["autoriser"] != "oui") {
        header("location:login.php");
        exit();
      } else {
        if (isset($_POST['ajouter'])) {
          $cin = trim($_POST['cin']);
          $nom = trim($_POST['nom']);
          $prenom = trim($_POST['prenom']);
          $email = trim($_POST['email']);
          $adresse = trim($_POST['adresse']);
          $pwd = trim($_POST['pwd']);
          $cpwd = trim($_POST['cpwd']);
          $classe = $_POST['classe'];
          $sel = $pdo->prepare("select cin from etudiant where cin=? limit 1");
          $sel->execute(array($cin));
          $tab = $sel->fetchAll();
          if (count($tab) > 0)
            $erreur = "NOT OK"; // Etudiant existe déja
          else {
            $sql = "INSERT INTO etudiant (cin, email, password, cpassword, nom, prenom, adresse, Classe) values (:cin, :email, :password, :cpassword, :nom, :prenom, :adresse, :classe)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
              ':cin' => $cin,
              ':email' => $email,
              ':password' => md5($pwd),
              ':cpassword' => md5($cpwd),
              ':nom' => $nom,
              ':prenom' => $prenom,
              ':adresse' => $adresse,
              ':classe' => $classe,
            ]);
            $erreur = "Ajout effectué";
          }
        }
      }
      ?>

      <form id="myform" method="POST" action="ajouterEtudiant.php">

        <!--
                        TODO: Add form inputs
                        Prenom - required string with autofocus
                        Nom - required string
                        Email - required email address
                        CIN - 8 chiffres
                        Password - required password string, au moins 8 letters et chiffres
                        ConfirmPassword
                        Classe - Commence par la chaine INFO, un chiffre de 1 a 3, un - et une lettre MAJ de A à E
                        Adresse - required string
                    -->
        <!--Nom-->
        <div class="form-group">
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
              <option value="<?php echo $cats['id_groupe']; ?>">
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
        <!--Bouton Ajouter-->
        <button type="submit" name="ajouter" value="ajouter" class="btn btn-primary btn-block">Ajouter</button>
        <div class="erreur"><?php echo $erreur ?></div>


      </form>
    </div>
  </main>


  <?php
  include("footer.html");
  ?>
  <script src="./assets/dist/js/inscrire.js"></script>
</body>

</html>