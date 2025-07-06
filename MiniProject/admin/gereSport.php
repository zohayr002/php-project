<?php
include "../connect.php";

if ($_GET["statu"] == "suprimer") {
    try {
        $del = $con->prepare("DELETE FROM sports_ WHERE id = :id");
        $del->bindParam(":id", $_GET["id"]);
        $del->execute();

        header("Location: sports.php?msg=deleted");
        exit();
    } catch (PDOException $e) {
        header("Location: sports.php?error=sport_linked");
        exit();
    }
}

$id = $_POST["id"] ?? null;
$nom = $_POST["nom"] ?? "";
if (!isset($id) || !isset($nom)) {
    echo "choix invalid";
}
$update = $con->prepare("UPDATE sports_ SET nom=:nom WHERE id=:id");
$update->bindParam("id", $id);
$update->bindParam("nom", $nom);
$update->execute();
