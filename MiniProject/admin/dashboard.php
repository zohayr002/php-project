<?php


include "../connect.php";
include "../auth/authAdmin.php";

$userEmail = $_SESSION["email"];

$statement = $con->prepare("SELECT * FROM utilisateurs_");
$statement->execute();
$users = $statement->fetchAll(PDO::FETCH_OBJ);


$stmtReservation = $con->prepare("SELECT * FROM reservations_");
$stmtReservation->execute();
$reservs = $stmtReservation->fetchAll(PDO::FETCH_OBJ);

$stmtTerrains = $con->prepare("SELECT * FROM terrains_");
$stmtTerrains->execute();
$terrains = $stmtTerrains->fetchAll(PDO::FETCH_OBJ);

if (isset($_POST["kk"])) {
    print_r($_POST["kk"]);
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/tableaux.css">

</head>

<body>
    <h1>Dashboard</h1>

    <select name="" id="">
        <?php
        $addusers = [];
        foreach($reservs as $res){
            foreach($users as $user){
                if($res->user_id == $user->id && !in_array($user->id,$addusers)){
                    echo "<option>$user->nom</option>";
                    $addusers[]= $user->id;
                }
            }
        }
        
        ?>
    </select>

    <fieldset>
        <legend>Reservations</legend>
        <table class="modern-table">
            <thead>
                <tr>
                    <th>user</th>
                    <th>terrain</th>
                    <th>date</th>
                    <th>heure_debut</th>
                    <th>heure_fin</th>
                    <th>statut</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($reservs as $res) {
                    echo "<tr>";
                    foreach ($users as $user) {
                        if ($user->id == $res->user_id) {
                            echo "<td>$user->nom</td>";
                        }
                    }
                    foreach ($terrains as $terrain) {
                        if ($terrain->id == $res->terrain_id) {
                            echo "<td>$terrain->nom</td>";
                        }
                    }
                    echo "<td>" . date('Y-m-d', strtotime($res->date)) . "</td>";
                    echo "<td>$res->heure_debut</td>";
                    echo "<td>$res->heure_fin</td>";
                    if ($res->statut == "en attente") {
                        echo '<td>
                            <a class="approve" href="statut.php?statut=confirmée&id=' . $res->id . '">Confirmée</a>
                            <a class="decline" href="statut.php?statut=annulée&id=' . $res->id . '">Annulée</a>
                        </td>';
                    } else {
                        echo "<td>$res->statut</td>";
                    }
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

    </fieldset>




    <p>Liens:</p>
    <a href="sports.php">sports</a><br>
    <a href="terrains.php">terrains</a><br>
    <a href="#">date_Ferm</a>
</body>

</html>