<?php
session_start();

if (!isset($_SESSION["email"]) || $_SESSION["role"] != "client") {
    header("Location: ../authentification/login.php");
    exit;
}
