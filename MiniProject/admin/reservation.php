<?php


include "../connect.php";
include "../auth/authAdmin.php";
// include "../navbar/navAdmin.php";
$userEmail = $_SESSION["email"];
$where = "WHERE 1=1";
$isFilter = false;


if (isset($_GET["filter"])) {
    $userFilter = $_GET["user"] ?? "";
    $terrainFilter = $_GET["terrain"] ?? "";
    if (!empty($userFilter)) {
        $where .= " AND r.user_id=$userFilter";
        $isFilter = true;
    }
    if (!empty($terrainFilter)) {
        $where .= " AND r.terrain_id=$terrainFilter";
        $isFilter = true;
    }
}

$stmtReservation = $con->prepare("SELECT r.*,u.nom AS nomUser,t.nom AS nomTerrain 
                                FROM reservations_ r 
                                JOIN utilisateurs_ u ON u.id=r.user_id 
                                JOIN terrains_ t ON t.id=r.terrain_id $where");

$stmtReservation->execute();
$reservs = $stmtReservation->fetchAll(PDO::FETCH_OBJ);



?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/tableaux.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .tabs>:nth-child(2) .hover {
            background-color: #9696ef0a;

            &> :first-child:hover {
                background-color: unset;
            }
        }

        .tabs >:nth-child(2) .hover::after {
            content: "";
            position: absolute;
            background: var(--primary);
            width: 4px;
            height: 100%;
            left: 2px;
            border-radius: 50px;
        }
    </style>
</head>

<body>
    <div class="con">
        <div class="left">
            <?php include "../navbar/navAdmin.php"?>
        </div>
        <div class="right">
            <h1>Reservation</h1>

            <form method="get">
                <select name="user">
                    <option value="">choissez un client</option>
                    <?php
                    $names = $con->query("SELECT r.user_id AS id, u.nom as nom FROM reservations_ r JOIN utilisateurs_ u ON r.user_id=u.id ")->fetchAll(PDO::FETCH_OBJ);
                    $addusers = [];
                    foreach ($names as $res) {
                        if (!in_array($res->nom, $addusers)) {
                            echo "<option value=\"$res->id\">$res->nom</option>";
                            $addusers[] = $res->nom;
                        }
                    }

                    ?>
                </select>
                <select name="terrain">
                    <option value="">choissez un terrain</option>
                    <?php
                    $names = $con->query("SELECT r.terrain_id AS id, t.nom as nom FROM reservations_ r JOIN terrains_ t ON r.terrain_id=t.id ")->fetchAll(PDO::FETCH_OBJ);
                    $addusers = [];
                    foreach ($names as $res) {
                        if (!in_array($res->nom, $addusers)) {
                            echo "<option value=\"$res->id\">$res->nom</option>";
                            $addusers[] = $res->nom;
                        }
                    }

                    ?>
                </select>
                <input name="filter" type="submit" value="Filtrer">
                <?php
                if ($isFilter) echo "<a href=\"dashboard.php\" style=\"margin-left:10px;\">Annuler le filtre</a>";
                ?>
            </form>

            <table class="modern-table">
                <thead>
                    <tr>
                        <th>user</th>
                        <th>terrain</th>
                        <th>date</th>
                        <th>heure_debut</th>
                        <th>heure_fin</th>
                        <th>statut</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($reservs as $res) {
                        echo "<tr>";
                        echo "<td>$res->nomUser</td>";
                        echo "<td>$res->nomTerrain</td>";
                        echo "<td>$res->date</td>";
                        echo "<td>$res->heure_debut</td>";
                        echo "<td>$res->heure_fin</td>";
                        echo "<td>$res->statut</td>";
                        echo '<td>
                                    <a class="approve" href="statut.php?statut=confirmée&id=' . $res->id . '">Confirmée</a>
                                    <a class="decline" href="statut.php?statut=annulée&id=' . $res->id . '">Annulée</a>
                                </td>';
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>