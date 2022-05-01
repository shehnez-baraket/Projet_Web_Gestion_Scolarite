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
      <form action="saisirAbsence.php" method="POST">
        <div class="form-group">
          <label for="semaine">Choisir une semaine:</label><br>
          <input id="semaine" type="week" name="debut" size="10" class="datepicker" />
        </div>
        <div class="form-group">
          <!--<label for="classe">Choisir un groupe:</label><br>
<input list="classe">
 <datalist id="classe" name="classe">
    <option value="1-INFOA">1-INFOA</option>
    <option value="1-INFOB">1-INFOB</option>
    <option value="1-INFOC">1-INFOC</option>
    <option value="1-INFOD">1-INFOD</option>
    <option value="1-INFOE">1-INFOE</option>
</datalist> -->

          <select id="classe" name="classe" class="custom-select custom-select-sm custom-select-lg">
            <option value="1-INFOA">1-INFOA</option>
            <option value="1-INFOB">1-INFOB</option>
            <option value="1-INFOC">1-INFOC</option>
            <option value="1-INFOD">1-INFOD</option>
            <option value="1-INFOE">1-INFOE</option>
          </select>
        </div>


        <div class="form-group">
          <label for="module">Choisir un module:</label><br>
          <select id="module" name="module" class="custom-select custom-select-sm custom-select-lg">
            <option value="1-INFOA">Tech.Web</option>
            <option value="1-INFOB">SGBD</option>
          </select>
        </div>

        <?php
        $sql1 = "select * from etudiant";
        $stmt1 = $pdo->prepare($sql1);
        $stmt1->execute();
        $nbeleve = $stmt1->rowCount();
        ?>

        <table rules="cols" frame="box">
          <tr>
            <th><?php echo $nbeleve ?> étudiants</th>

            <!-- <th colspan="2" width="100px" style="padding-left: 5px; padding-right: 5px;">Lundi</th>
<th colspan="2" width="100px" style="padding-left: 5px; padding-right: 5px;">Mardi</th>
<th colspan="2" width="100px" style="padding-left: 5px; padding-right: 5px;">Mercredi</th>
<th colspan="2" width="100px" style="padding-left: 5px; padding-right: 5px;">Jeudi</th>
<th colspan="2" width="100px" style="padding-left: 5px; padding-right: 5px;">Vendredi</th>
<th colspan="2" width="100px" style="padding-left: 5px; padding-right: 5px;">Samedi</th> -->
          </tr>
          <tr>
            <td>&nbsp;</td>
            <?php
            $w = 7;
            for ($i = 1; $i <= 365; $i++) {
              $week = date("W", mktime(0, 0, 0, 1, $i, date("Y")));
              if ($week == $w) {
                for ($d = 0; $d < 6; $d++) {
                  $date = date("l d/m/Y", mktime(0, 0, 0, 1, $i + $d, date("Y")));
                  echo '<th colspan="2" width="100px" style="padding-left: 5px; padding-right: 5px;">' . date("l d/m/Y", mktime(0, 0, 0, 1, $i + $d, date("Y"))) . "</th>" . "<br />";
                }
                break;
              }
            }
            ?>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <th>AM</th>
            <th>PM</th>
            <th>AM</th>
            <th>PM</th>
            <th>AM</th>
            <th>PM</th>
            <th>AM</th>
            <th>PM</th>
            <th>AM</th>
            <th>PM</th>
            <th>AM</th>
            <th>PM</th>
          </tr>
          <?php



          $sql = "SELECT * from etudiant";
          $stmt = $pdo->prepare($sql);
          $stmt->execute();
          while ($etudiants = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $nom = $etudiants['nom'];
            $prenom = $etudiants['prenom'];
            $full_name = $nom . " " . $prenom;
          ?>
            <tr class="row_3">
              <td><b><?php echo $full_name ?></b></td>
              <td><input type="checkbox" name="check[]" value="AM"></td>
              <td><input type="checkbox" name="check[]" value="PM"></td>
              <td><input type="checkbox" name="check[]" value="AM"></td>
              <td><input type="checkbox" name="check[]" value="PM"></td>
              <td><input type="checkbox" name="check[]" value="AM"></td>
              <td><input type="checkbox" name="check[]" value="PM"></td>
              <td><input type="checkbox" name="check[]" value="AM"></td>
              <td><input type="checkbox" name="check[]" value="PM"></td>
              <td><input type="checkbox" name="check[]" value="AM"></td>
              <td><input type="checkbox" name="check[]" value="PM"></td>
              <td><input type="checkbox" name="check[]" value="AM"></td>
              <td><input type="checkbox" name="check[]" value="PM"></td>
            </tr>
          <?php
          }
          ?>
          <!-- <tr class="row_3"><td><b>M. WALID SAAD</b></td>
  <td><input type="checkbox"></td>
  <td><input type="checkbox"></td>
  <td><input type="checkbox"></td>
  <td><input type="checkbox"></td>
  <td><input type="checkbox"></td>
  <td><input type="checkbox"></td>
  <td><input type="checkbox"></td>
  <td><input type="checkbox"></td>
  <td><input type="checkbox"></td>
  <td><input type="checkbox"></td>
  <td><input type="checkbox"></td>
  <td><input type="checkbox"></td>
  </tr> -->
        </table>
        <br>
        <!--Bouton Valider-->
        <button type="submit" class="btn btn-primary btn-block">Valider</button>
      </form>
    </div>
  </main>
  <?php
  include("footer.html");
  ?>
</body>

</html>