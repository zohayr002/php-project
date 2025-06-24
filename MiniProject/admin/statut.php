<?php
include "../connect.php";

$newStatu = $_GET["statut"];
$idReservation = $_GET["id"];

$update = $con->prepare("UPDATE reservations_ SET statut=:statut WHERE id=:id");
$update->bindParam(":statut", $newStatu);
$update->bindParam(":id", $idReservation);
$update->execute();

header("Location: dashboard.php");
exit();
