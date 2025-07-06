<?php
include "../connect.php";

$statement = $con->prepare("SELECT * FROM sports_");
$statement->execute();
$sports = $statement->fetchAll(PDO::FETCH_OBJ);




if ($_GET["statu"] == "suprimer") {
    try {
        $del = $con->prepare("DELETE FROM terrains_ WHERE id = :id");
        $del->bindParam(":id", $_GET["id"]);
        $del->execute();

        header("Location: terrains.php?msg=deleted");
        exit();
    } catch (PDOException $e) {
        header("Location: terrains.php?error=sport_linked");
        exit();
    }
}
if ($_GET["statu"] == "modifier") {
    $terrain = $con->prepare("SELECT * FROM terrains_ WHERE id=:id");
    $terrain->bindParam("id", $_GET["id"]);
    $terrain->execute();
    $terr = $terrain->fetch(PDO::FETCH_OBJ);


    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $nom = trim($_POST["nom"] ?? "");
        $address = trim($_POST["address"] ?? "");
        $sport = trim($_POST["sport"] ?? "");
        if (empty($nom) || empty($address) || empty($sport)) {
            echo "Completez les liens";
        }

        $statement = $con->prepare("UPDATE terrains_ SET nom=:nom, address=:address, sport_id=:id WHERE id=:terrid");
        $statement->bindParam('nom', $nom);
        $statement->bindParam('address', $address);
        $statement->bindParam('id', $sport);
        $statement->bindParam('terrid', $_GET["id"]);

        $statement->execute();
        header("Location:terrains.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/main.css">
    <title>Document</title>
    <style>
        form{
                margin-top: 32px;
        }
    </style>

</head>

<body>
    <div class="con">
        <div class="left">
            <?php include "../navbar/navAdmin.php" ?>
        </div>
        <div class="right">
            <h1>Modifier Terrain</h1>
            <form action="" method="post">
                <div class="con-Input">
                    <label for="nom">Nom:</label>
                    <input id="nom" type="text" name="nom" placeholder="Entrer le nom..." value="<?= $terr->nom ?>">
                </div>
                <div class="con-Input">
                    <label for="address">Address:</label>
                    <input id="address" type="text" name="address" placeholder="Entrer l'address..." value="<?= $terr->address ?>">
                </div>
                <div class="con-Input">
                    <label for="spo">Sport:</label>
                    <select name="sport" id="spo">
                        <?php
                        foreach ($sports as $sport) {
                            $selected = ($sport->id == $terr->sport_id) ? "selected" : "";
                            echo "<option value='$sport->id' $selected>$sport->nom</option>";
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