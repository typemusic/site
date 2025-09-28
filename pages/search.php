<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TypeMusic - Buscar</title>
  <link rel="stylesheet" href="../style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded" rel="stylesheet" />
  <link rel="icon" href="../img/favicon.png" type="image/png">
</head>
<body>

  <?php include "../include/menu.php"; ?>
    <!-- O formulário continua utilizando nossa função JS para a busca -->
  <form onsubmit="searchMusic(event)">
    <?php include "../include/searchBar.php"; ?>
  </form>
  <div class="main-content">

  <section class="content">
    <h3 id="search-title">Resultados:</h3>
    <div class="grid-container" id="results"></div>
  </section>

</div>
</body>
<script src="../js/search.js"></script>
<script src="js/theme.js"></script>
</html>
