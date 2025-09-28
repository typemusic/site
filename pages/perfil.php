<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TypeMusic</title>
  <link rel="stylesheet" href="../style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded" rel="stylesheet" />
  <link rel="icon" href="img/favicon.png" type="image/png">
  <style>

  </style>
</head>

<body>

  <?php include "../include/menu.php"; ?>
  <?php include "../include/searchBar.php"; ?>

  <div class="main-content">
    <div class="banner background-user" id="bc-user">
      <div class="user">
        <img id="img-user" src="../img/user.png" alt="">  se o usuario não colocar capa coloque user como padrao
        <div>
          <h2 id="name">Guilherme</h2>
          <div id="situation">
            <span class="status-icon online"></span>
            <p>Online</p>
          </div>
        </div>
      </div>
    </div>
    <div class="user-data">
      mude para os dados do usuario
      <div>
        <h2>2</h2>
        <p>as</p>
      </div>
      <div>
        <h2>2</h2>
        <p>as</p>
      </div>
      <div>
        <h2>2</h2>
        <p>as</p>
      </div>
      <div>
        <h2>2</h2>
        <p>as</p>
      </div>
      
    </div>
    <h2>Recentes</h2>
    <div class="recents-music-user">
      o mesmo modelo do index
    </div>

    <?php include "../include/footer.php"; ?>

  </div>

  <script src="js/index.js"></script>
  <script src="../js/perfil.js"></script>
</body>
</html>
