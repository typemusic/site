<?php
$music = isset($_GET['music']) ? htmlspecialchars($_GET['music']) : null;
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TypeMusic - Player</title>
  <link rel="stylesheet" href="../style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded" rel="stylesheet" />
  <link rel="icon" href="../img/favicon.png" type="image/png">
</head>

<body>

  <?php include "../include/menu.php"; ?>
  <?php include "../include/searchBar.php"; ?>

  <?php if ($music): ?>
    <div class="main-content">
      <div class="lyrics-box" id="lyrics">
        Carregando letra...
      </div>
      <div class="song-info" id="song-info">
        Carregando informações...
      </div>
      <br>
      <?php include "../include/footer.php"; ?>
    </div>

  <?php else: ?>
    <p>Nenhum ID de música informado na URL.</p>
  <?php endif; ?>
</body>

<script src="../js/musicplayer.js"></script>
<script src="js/theme.js"></script>
</html>

<?php

$music = htmlspecialchars($_GET['music']) ?? null;

if (!$music) {
  echo "Erro: nenhum ID de música foi fornecido.";
  exit;
}

// Gerando o código com o ID inserido
echo '
    <div id="rg_embed_link_' . $music . '" class="rg_embed_link" data-song-id="' . $music . '">
        <script src="//genius.com/songs/' . $music . '/embed.js" crossorigin=""></script>
    </div>';
?>