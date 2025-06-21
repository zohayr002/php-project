<?php
session_start();
session_unset();
session_destroy();



include "../connect.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"] ?? '');
    $password = trim($_POST["password"] ?? '');

    if (empty($email) || empty($password)) {
        echo "completez les liens";
    }

    $statement = $con->prepare("SELECT * FROM utilisateurs_ WHERE email=:email");
    $statement->bindParam('email', $email);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_OBJ);

    if ($user && password_verify($password, $user->password_hash)) {
        $_SESSION["email"] = $email;
        $_SESSION["role"] = $user->role;
        if ($user->role == "admin") {
            header("Location: ../admin/dashboared.php");
            exit;
        } else {
            header("Location: ../client/reservation.php");
            exit;
        }
    } else {
        echo "email ou mot de passe incorrects";
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
    <h1>Login</h1>
    <form action="" method="post">
        <div class="con-Input">
            <label for="">Email:</label>
            <input type="email" name="email">
        </div>
        <div class="con-Input">
            <label for="">Mot de passe:</label>
            <input type="text" name="password">
        </div>
        <button type="submit">Send</button>
    </form>
</body>

</html>