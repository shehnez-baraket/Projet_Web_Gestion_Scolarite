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
                <h1 class="display-4">État des absences pour un groupe</h1>
                <p>Pour afficher l'état des absences, choisissez d'abord le groupe et la periode concernée!</p>
            </div>
        </div>

        <div class="container">
            <form action="EtatAb1.php" method="POST" id="myForm">
                <div class="form-group">
                    <label for="classe">Choisir une classe:</label><br>
                    <select id="classe" name="classe" class="custom-select custom-select-sm custom-select-lg">
                        <?php
                        $sql0 = "SELECT DISTINCT * FROM absence";
                        $stmt0 = $pdo->prepare($sql0);
                        $stmt0->execute();
                        while ($cats = $stmt0->fetch(PDO::FETCH_ASSOC)) { ?>
                            <option value="<?php echo $cats['classe']; ?>">
                                <?php echo $cats['classe']; ?>
                            </option>
                        <?php }
                        ?>
                    </select>
                    <button type="submit" name="afficherpar">afficher</button>
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
                                Nom
                            </th>
                            <th>
                                Classe
                            </th>
                            <th>
                                Date
                            </th>
                            <th>
                                Module
                            </th>
                            <th>
                                Description
                            </th>
                        </tr>
                        <?php

                        if ($_SESSION["autoriser"] != "oui") {
                            header("location:login.php");
                            exit();
                        } else {
                            if (isset($_POST['afficherpar'])) {
                                $classe = $_POST['classe'];
                                $sql = "SELECT  * from absence where classe = :classe";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute([
                                    ':classe' => $classe,
                                ]);
                                while ($etudiants = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $nom = $etudiants['nom'];
                                    $classe = $etudiants['classe'];
                                    $date = $etudiants['date'];
                                    $module = $etudiants['module'];
                                    $description = $etudiants['description'];
                        ?>
                                    <tr>
                                        <td>
                                            <?php echo $nom ?>
                                        </td>
                                        <td>
                                            <?php echo $classe ?>
                                        </td>
                                        <td>
                                            <?php echo $date ?>
                                        </td>
                                        <td>
                                            <?php echo $module ?>
                                        </td>
                                        <td>
                                            <?php echo $description ?>
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