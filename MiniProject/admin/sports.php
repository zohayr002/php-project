<?php
include "../connect.php";

include "../auth/authAdmin.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = trim($_POST["nom"]?? "");
    if(empty($nom)){
       echo "completez les liens"; 
       exit;
    }

    $statement = $con->prepare("INSERT INTO sports_(nom) VALUES (:nom)");
    $statement->bindParam('nom',$nom);
    if($statement->execute()){
        echo "data added successfly";
    }else{
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
</head>
<body>
    <h1>ajouter Sport</h1>
    <form action="" method="post">
        <label for="">name</label>
        <input type="text" name="nom">
        <input type="submit" value="Send">
    </form>
        <a href="dashboared.php">dashboared</a>
</body>
</html>