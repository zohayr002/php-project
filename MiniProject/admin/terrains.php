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
    <style>
        .con-Input {
            margin-block: 10px;
        }
    </style>
</head>

<body>
    <h1>Terrains</h1>
    <form action="" method="post">
        <div class="con-Input">
            <label for="">nom:</label>
            <input type="text" name="nom">
        </div>
        <div class="con-Input">
            <label for="">Address:</label>
            <input type="text" name="address">
        </div>
        <div class="con-Input">
            <label for="">Sport:</label>
            <select name="sport" id="">
                <?php
                foreach ($sports as $sport) {
                    echo "<option value='$sport->id'>$sport->nom</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit">Send</button>
    </form>
    <a href="dashboared.php">dashboared</a>

</body>

</html>