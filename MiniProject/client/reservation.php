<?php

include "../connect.php";
include "../auth/authClient.php";

$idUser = $_SESSION["user_id"];

$stmtTerrain = $con->prepare("SELECT * FROM terrains_");
$stmtTerrain->execute();
$terrains = $stmtTerrain->fetchAll(PDO::FETCH_OBJ);

$reser = $con->prepare("SELECT r.*, u.nom AS nomUser, t.nom AS nomTerrain FROM reservations_ r 
                        JOIN terrains_ t ON r.terrain_id = t.id
                        JOIN utilisateurs_ u ON r.user_id = u.id
                        WHERE r.user_id = :id");
$reser->bindParam(":id", $idUser);
$reser->execute();
$reservations = $reser->fetchAll(PDO::FETCH_OBJ);

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $terrain = $_POST["terrain"] ?? null;
    $date = trim($_POST["date"] ?? "");
    $heure_debut_raw = $_POST["heure_debut"] ?? null;
    $heure_fin_raw = $_POST["heure_fin"] ?? null;

    if (empty($terrain) || empty($date) || $heure_debut_raw === null || $heure_fin_raw === null) {
        $message = "❗ Veuillez remplir tous les champs.";
    } elseif ((int)$heure_debut_raw >= (int)$heure_fin_raw) {
        $message = "❌ L'heure de début doit être inférieure à l'heure de fin.";
    } else {
        $heure_debut = sprintf('%02d:00:00', (int)$heure_debut_raw);
        $heure_fin = sprintf('%02d:00:00', (int)$heure_fin_raw);
        $check = $con->prepare("SELECT COUNT(*) FROM reservations_
              WHERE terrain_id = {$terrain}
              AND DATE(date) = '{$date}'
              AND (heure_debut < '{$heure_debut}' OR heure_fin > '{$heure_fin}')");
        $check->execute();
        $exists = $check->fetchColumn();
        if ($exists > 0) {
            $message = "⛔ Ce créneau horaire est déjà réservé pour ce terrain.";
        } else {
            $stmtReservation = $con->prepare("INSERT INTO reservations_(user_id, terrain_id, date, heure_debut, heure_fin)
                                              VALUES (:user_id, :terrain_id, :date, :heure_debut, :heure_fin)");
            $stmtReservation->bindParam('user_id', $idUser);
            $stmtReservation->bindParam('terrain_id', $terrain);
            $stmtReservation->bindParam('date', $date);
            $stmtReservation->bindParam('heure_debut', $heure_debut);
            $stmtReservation->bindParam('heure_fin', $heure_fin);

            if ($stmtReservation->execute()) {
                $message = "✅ Réservation effectuée avec succès.";
            } else {
                $message = "❌ Une erreur est survenue lors de la réservation.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation Terrain</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="../css/main.css">
    <style>
        .con-Input {
            margin-block: 10px;
        }

        input[type="submit"] {
            margin-top: 18px;
        }

        form {
            margin-top: 25px;
        }

        .message {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="con">
        <div class="left"><?php include "../navbar/navClient.php"; ?></div>
        <div class="right">
            <h1>Réservation</h1>

            <?php if (!empty($message)): ?>
                <p class="message"><?= htmlspecialchars($message) ?></p>
            <?php endif; ?>

            <form action="" method="post">
                <div class="con-Input">
                    <label for="terrain">Terrain:</label>
                    <select name="terrain" id="terrain">
                        <?php foreach ($terrains as $terr): ?>
                            <option value="<?= $terr->id ?>"><?= htmlspecialchars($terr->nom) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="con-Input">
                    <label for="date">Date:</label>
                    <input class="date" type="date" name="date" id="date" required>
                </div>

                <div class="con-Input">
                    <label for="heure_debut">Heure début:</label>
                    <select name="heure_debut" id="heure_debut">
                        <?php
                        for ($i = 7; $i <= 23; $i++) {
                            printf('<option value="%d">%02dh</option>', $i, $i);
                        }
                        ?>
                    </select>
                </div>

                <div class="con-Input">
                    <label for="heure_fin">Heure fin:</label>
                    <select name="heure_fin" id="heure_fin">
                        <?php
                        for ($i = 8; $i <= 23; $i++) {
                            printf('<option value="%d">%02dh</option>', $i, $i);
                        }
                        printf('<option value="0">00h</option>');
                        ?>
                    </select>
                </div>

                <input type="submit" value="Envoyer">
            </form>
        </div>
    </div>
</body>

</html>