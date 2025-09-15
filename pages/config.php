<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TypeMusic</title>
    <link rel="stylesheet" href="../style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded" rel="stylesheet" />
    <link rel="icon" href="img/favicon.png" type="image/png">
</head>

<body>
    <?php include "../include/menu.php"; ?>
    <?php include "../include/searchBar.php"; ?>


    <div class="main-content">
        <button onclick="setTheme('light')">Modo Claro</button>
        <button onclick="setTheme('dark')">Modo Escuro</button>
        <button onclick="setTheme('auto')">Automático</button>
    </div>

</body>
<script src="js/config.js"></script>

</html>