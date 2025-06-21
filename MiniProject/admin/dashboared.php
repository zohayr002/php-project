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

if(isset($_POST["kk"])){
    print_r($_POST["kk"]);
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .modern-table {
            width: 100%;
            border-collapse: collapse;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin-top: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border-radius: 8px;
        }

        .modern-table thead {
            background-color: #4a90e2;
            color: white;
        }

        .modern-table th,
        .modern-table td {
            padding: 12px 16px;
            text-align: left;
        }

        .modern-table tbody tr:nth-child(even) {
            background-color: #f7f9fc;
        }

        .modern-table tbody tr:hover {
            background-color: #e1ecf7;
            transition: background-color 0.3s ease;
        }

        .modern-table td {
            color: #333;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <h1>dashboared</h1>

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
                    echo "<td>".date('Y-m-d', strtotime($res->date))."</td>";
                    echo "<td>$res->heure_debut</td>";
                    echo "<td>$res->heure_fin</td>";
                    echo "<td><form method='post'><button value='$res->id' name='kk'>Approve</button><button>Decline</button></form></td>";
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