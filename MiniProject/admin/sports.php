<?php
include "../connect.php";
include "../auth/authAdmin.php";





if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = trim($_POST["nom"] ?? "");
    if (empty($nom)) {
        echo "completez les liens";
        exit;
    }

    $statement = $con->prepare("INSERT INTO sports_(nom) VALUES (:nom)");
    $statement->bindParam('nom', $nom);
    $statement->execute();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/tableaux.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .tabs>:nth-child(4) .hover {
            background-color: #9696ef0a;

            &> :first-child:hover {
                background-color: unset;
            }
        }

        .tabs>:nth-child(4) .hover::after {
            content: "";
            position: absolute;
            background: var(--primary);
            width: 4px;
            height: 100%;
            left: 2px;
            border-radius: 50px;
        }

        input[type="submit"] {
            margin-top: 18px;
        }
    </style>
</head>

<body>
    <div class="con">
        <div class="left">
            <?php include "../navbar/navAdmin.php" ?>
        </div>
        <div class="right">
            <?php
            if (isset($_GET['error']) && $_GET['error'] === 'sport_linked') {
                echo "❌ Vous ne pouvez pas supprimer ce sport car il est lié à un terrain ou une réservation existante.";
            }

            if (isset($_GET['msg']) && $_GET['msg'] === 'deleted') {
                echo "<div class='success'>✅ Sport supprimé avec succès.</div>";
            }
            ?>
            <h1>Sports</h1>

            <table style="width: 45%;" class="modern-table">
                <thead>
                    <tr>
                        <th>Sport name</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sports = $con->prepare("SELECT * FROM sports_");
                    $sports->execute();
                    $sports = $sports->fetchAll(PDO::FETCH_OBJ);
                    foreach ($sports as $sport) {
                        echo "<tr>
                                <td>$sport->nom</td>
                                <td>
                                    <a href=\"#\" onclick=\"modifySport($sport->id,'" . $sport->nom . "')\">Modifier</a>
                                    <a href=\"gereSport.php?statu=suprimer&id=$sport->id \">Supprimer</a>
                                </td>
                            </tr>";
                    }
                    ?>

                </tbody>
            </table>
            <h3>Ajouter un sport</h3>
            <form action="" method="post">
                <div class="con-Input">
                    <label for="name">Nom:</label>
                    <input id="name" type="text" name="nom" placeholder="Entrer le nom...">
                </div>
                <input type="submit" value="Send">
            </form>
        </div>
    </div>
    <script>
        function modifySport(id, currentName) {
            const newName = prompt("Entrez le nouveau nom du sport:", currentName);
            if (!newName || newName.trim() === "") return;
            fetch('gereSport.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id=${encodeURIComponent(id)}&nom=${encodeURIComponent(newName)}`
                })
                .then(respone => respone.text())
                .then(result => {
                    location.reload();
                })
                .catch(error => {
                    console.log(error)
                })
        }
    </script>
</body>

</html>