<?php

$localhost = "localhost";
$user = "root";
$password = "";
$dbname = "miniproject";

try {
        $con = new PDO("mysql:host =$localhost;dbname=$dbname", $user, $password);
} catch (PDOException $e) {
        die("impossible de connecte au database" . $e->getMessage());
}
