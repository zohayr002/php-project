<?php

include "../connect.php";
include "../auth/authAdmin.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom = trim($_POST["nom"] ?? "");
    $address = trim($_POST["address"] ?? "");
    $sport = trim($_POST["sport"] ?? "");
    if (empty($nom) || empty($address) || empty($sport)) {
        echo "Completez les liens";
    }

    $statement = $con->prepare("INSERT INTO terrains_(nom,address,sport_id) VALUES (:nom,:address,:sport_id)");
    $statement->bindParam('nom', $nom);
    $statement->bindParam('address', $address);
    $statement->bindParam('sport_id', $sport);

    if ($statement->execute()) {
        echo "data added successfly";
    } else {
        echo "data added UNsuccessfly";
    }
}

$statement = $con->prepare("SELECT * FROM sports_");
$statement->execute();

$sports = $statement->fetchAll(PDO::FETCH_OBJ);


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
        .tabs>:nth-child(3) .hover {
            background-color: #9696ef0a;

            &> :first-child:hover {
                background-color: unset;
            }
        }

        .tabs>:nth-child(3) .hover::after {
            content: "";
            position: absolute;
            background: var(--primary);
            width: 4px;
            height: 100%;
            left: 2px;
            border-radius: 50px;
        }
        input[type="submit"]{
            margin-top: 25px;
        }
    </style>
</head>

<body>
    <div class="con">
        <div class="left">
            <?php include "../navbar/navAdmin.php" ?>
        </div>
        <div class="right">
            <?php
            if (isset($_GET['error']) && $_GET['error'] === 'sport_linked') {
                echo "❌ Vous ne pouvez pas supprimer ce terrain car il est lié une réservation existante.";
            }

            if (isset($_GET['msg']) && $_GET['msg'] === 'deleted') {
                echo "<div class='success'>✅ Terrain supprimé avec succès.</div>";
            }
            ?>
            <h1>Terrains</h1>

            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Terrain</th>
                        <th>Address</th>
                        <th>Sport</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $terrains = $con->prepare("SELECT t.*,s.nom AS sportName FROM terrains_ t
                                                JOIN sports_ s ON t.sport_id=s.id
                    ");
                    $terrains->execute();
                    $terrains = $terrains->fetchAll(PDO::FETCH_OBJ);
                    foreach ($terrains as $terr) {
                        echo "<tr>
                                <td>$terr->nom</td>
                                <td>$terr->address</td>
                                <td>$terr->sportName</td>
                                <td>
                                    <a href=\"gereTerrain.php?statu=modifier&&id=$terr->id \">Modifier</a>
                                    <a href=\"gereTerrain.php?statu=suprimer&&id=$terr->id \">Supprimer</a>
                                </td>
                            </tr>";
                    }
                    ?>

                </tbody>
            </table>
            <h3>Ajouter un terrain</h3>
            <form action="" method="post">
                <div class="con-Input">
                    <label for="nom">Nom:</label>
                    <input id="nom" type="text" name="nom" placeholder="Entrer le nom...">
                </div>
                <div class="con-Input">
                    <label for="address">Address:</label>
                    <input id="address" type="text" name="address" placeholder="Entrer l'address...">
                </div>
                <div class="con-Input">
                    <label for="spo">Sport:</label>
                    <select name="sport" id="spo">
                        <?php
                        foreach ($sports as $sport) {
                            echo "<option value='$sport->id'>$sport->nom</option>";
                        }
                        ?>
                    </select>
                </div>
                <input type="submit" value="send">
            </form>

        </div>
    </div>

</body>

</html>