<html>
    <head>
    </head>
    <body>
<?php
    include("connexion.php");
     
    // Stockage des horaires dans un tableau
    $horaires = Array();
    $sql="select * from temps ";
    $requete = mysqli_query($a,$sql);
    while( $horaire = mysqli_fetch_array($requete) ) {
        array_push( $horaires, $horaire );
    }
?>
        <form method="POST" action="abs.php">
            <table  width="700">
                <thead>
                    <tr>
                        <td height="58" colspan="10" align="center" >
                            <strong>Date</strong>
                            <input type="date" name="date" required>
                        </td>
                    </tr>
                    <tr>
                        <th width="10%" >Nom</th>
                        <th width="13%" >Prenom</th>
<?php
    foreach( $horaires as $horaire ) {
?>
                        <th width="77%" style="color:#3A52E4"><?php echo $horaire['temps'];?></th>
<?php
    }
?>
                    </tr>
                </thead>
                <tbody>
<?php
    $sql = "select * from eleve ";
    $eleves = mysqli_query($a,$sql);
    while( $eleve=mysqli_fetch_array($eleves) ) {
?>
                    <tr bgcolor="">   
                        <td height="28" ><strong><?php echo $eleve['nom'];?></strong></td>
                        <td><strong><?php echo $eleve['prenom'];?></strong></td>
<?php
        foreach( $horaires as $horaire ) {
?>
                        <td align="center">
                            <input type="checkbox" name="absences[<?php echo $eleve['id_eleve'];?>]" value="<?php echo $horaire['id_temps'];?>" />
                        </td>
<?php
        }
?>
                    </tr>
<?php
    }
    $a->close();
?>
                    <tr>
                        <td height="33" colspan="10" align="center">
                            <input type="submit" name="sub" value="Marquer" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </body>
</html>