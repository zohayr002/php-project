<?php

echo $_GET["statu"];
echo $_GET["id"];
include "../connect.php";

if($_GET["statu"]== "suprimer"){
    $del = $con->prepare("DELETE FROM sports_ WHERE id=:id");
    $del->bindParam(":id",$_GET["id"]);
    $del->execute();
    
    header("Location: sports.php");
    exit();
}