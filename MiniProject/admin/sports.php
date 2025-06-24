<?php
include "../connect.php";

include "../auth/authAdmin.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = trim($_POST["nom"] ?? "");
    if (empty($nom)) {
        echo "completez les liens";
        exit;
    }

    $statement = $con->prepare("INSERT INTO sports_(nom) VALUES (:nom)");
    $statement->bindParam('nom', $nom);
    if ($statement->execute()) {
        echo "data added successfly";
    } else {
        echo "data added UNsuccessfly";
    }
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
    <h1>ajouter Sport</h1>
    <form action="" method="post">
        <label for="">name</label>
        <input type="text" name="nom">
        <input type="submit" value="Send">
    </form>

    <h3>sports:</h3>
    <table style="width: 45%;" class="modern-table">
        <thead>
            <tr>
                <th>Sport name</th>
                <th>action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sports = $con->prepare("SELECT * FROM sports_");
            $sports->execute();
            $sports = $sports->fetchAll(PDO::FETCH_OBJ);
            foreach ($sports as $sport) {
                echo "<tr>
                <td>$sport->nom</td>
                <td>
                    <a href=\"gere.php?statu=modifier&&id=$sport->id \">Modifier</a>
                    <a href=\"gere.php?statu=suprimer&&id=$sport->id \">Supprimer</a>
                </td>
            </tr>";
            }
            ?>

        </tbody>
    </table>


    <a href="dashboard.php">dashboared</a>
</body>

</html>