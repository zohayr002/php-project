<?php


include "../connect.php";
include "../auth/authAdmin.php";






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
        .tabs>:first-child .hover {
            background-color: #9696ef0a;

            &> :first-child:hover {
                background-color: unset;
            }
        }

        .tabs >:first-child .hover::after {
            content: "";
            position: absolute;
            background: var(--primary);
            width: 4px;
            height: 100%;
            left: 2px;
            border-radius: 50px;
        }
    </style>
</head>

<body>
    <div class="con">
        <div class="left">
            <?php include "../navbar/navAdmin.php"?>
        </div>
        <div class="right">
            <h1>Dashboard</h1>

            
        </div>
    </div>
</body>

</html>