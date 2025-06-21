<?php

include "../connect.php";

include "../auth/authClient.php";

$userEmail = $_SESSION["email"];

$statement = $con->prepare("SELECT * FROM utilisateurs_");
$statement->execute();
$users = $statement->fetchAll(PDO::FETCH_OBJ);


$stmtTerrain = $con->prepare("SELECT * FROM terrains_");
$stmtTerrain->execute();
$terrains = $stmtTerrain->fetchAll(PDO::FETCH_OBJ); 

foreach ($users as $user) {
    if ($userEmail == $user->email) {
        $idUSer = $user->id;
        // print_r($user);
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $terrain = trim($_POST["terrain"] ?? "");
    $date = trim($_POST["date"] ?? "");
    $heure_debut = trim($_POST["heure_debut"] ?? "");
    $heure_fin = trim($_POST["heure_fin"] ?? "");

    if(empty($terrain) ||empty($date) ||empty($heure_debut) ||empty($heure_fin)){
        echo "Completez les liens";
    }

    echo $terrain;
    echo $date;
    echo $heure_debut;
    echo $heure_fin;
    echo $idUSer;

    $stmtReservation = $con->prepare("INSERT INTO reservations_(user_id,terrain_id,date,heure_debut,heure_fin)
     VALUES (:user_id,:terrain_id,:date,:heure_debut,:heure_fin)");
    $stmtReservation->bindParam('user_id',$idUSer);
    $stmtReservation->bindParam('terrain_id',$terrain);
    $stmtReservation->bindParam('date',$date);
    $stmtReservation->bindParam('heure_debut',$heure_debut);
    $stmtReservation->bindParam('heure_fin',$heure_fin);

    if($stmtReservation->execute()){
        echo "data added successufly";
    }else{
        echo "data added UNsuccessufly";
    }
    
}

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
    <h1>reservation</h1>
    <form action="" method="post">
        <div class="con-Input">
            <label for="">Terrain:</label>
            <select name="terrain" id="">
                <?php
                foreach($terrains as $terr){
                    echo "<option value='$terr->id'>$terr->nom</option>";
                }
                ?>
            </select>
        </div>
        <div class="con-Input">
            <label for="">date:</label>
            <input type="date" name="date">
        </div>
        <div class="con-Input">
            <label for="">heure_debut:</label>
            <input type="time" name="heure_debut">
        </div>
        <div class="con-Input">
            <label for="">heure_fin:</label>
            <input type="time" name="heure_fin">
        </div>
        <button type="submit">Send</button>
    </form>
</body>

</html>