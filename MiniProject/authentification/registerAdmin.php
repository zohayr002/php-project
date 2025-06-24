<?php
session_start();
session_unset();
session_destroy();

session_start();

include "../connect.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = trim($_POST["nom"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $password = trim($_POST["password"] ?? '');
    $password2 = trim($_POST["password2"] ?? '');
    $role = "Admin";

    if (empty($nom) || empty($email) || empty($password) || empty($password2)) {
        echo "Complétez tous les champs.";
    } elseif ($password !== $password2) {
        echo "Les mots de passe ne correspondent pas.";
    }
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $statement = $con->prepare("INSERT INTO utilisateurs_ (nom,email,password_hash,role) VALUES (:nom,:email,:password_hash,:role) ");
    $statement->bindParam('nom', $nom);
    $statement->bindParam('email', $email);
    $statement->bindParam('password_hash', $password_hash);
    $statement->bindParam('role', $role);

    if ($statement->execute()) {
        echo "Inscription réussie.";
        $_SESSION["email"] = $email;
        $_SESSION["role"] = $role;
        header("Location: ../admin/dashboard.php");
    } else {
        echo "Erreur lors de l'inscription.";
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
    <h1>Register (Admin)</h1>
    <form action="" method="post">
        <div class="con-Input">
            <label for="">Nom:</label>
            <input type="text" name="nom">
        </div>
        <div class="con-Input">
            <label for="">Email:</label>
            <input type="email" name="email">
        </div>
        <div class="con-Input">
            <label for="">Mot de passe:</label>
            <input type="text" name="password">
        </div>
        <div class="con-Input">
            <label for="">Confirme mot de passe:</label>
            <input type="text" name="password2">
        </div>
        <button type="submit">Send</button>
    </form>
</body>

</html>