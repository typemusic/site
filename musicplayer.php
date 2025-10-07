<?php
$music = isset($_GET['music']) ? htmlspecialchars($_GET['music']) : null;
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TypeMusic - Player</title>
  <link rel="stylesheet" href="style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded" rel="stylesheet" />
  <link rel="icon" href="img/favicon.png" type="image/png">
</head>

<body>

  <?php include "include/menu.php"; ?>
  <?php include "include/searchBar.php"; ?>

  <?php if ($music): ?>
    <div class="main-content">
      <div class="music-box">
        <div class="lyrics-box" id="lyrics">
          Carregando letra...
        </div>
        <div class="song-info" id="song-info">
          Carregando informações...
        </div>
      </div>

      <?php include "include/footer.php"; ?>
      
    </div>

  <?php else: ?>
    <p>Nenhum ID de música informado na URL.</p>
  <?php endif; ?>
</body>

<script>

//buscar os dados da música (nome, capa, artista...)
fetch('https://typemusic.hubsapiens.com.br/servidor/info.php?id=<?php echo $music; ?>')
  .then(res => res.json())
  .then(data => {
    const song = data.response.song;
    const infoDiv = document.getElementById('song-info');
    infoDiv.innerHTML = `
      <img src="${song.song_art_image_url}" alt="Capa da música" />
      <a href="${song.url}" target="_blank"><p class="song-title"><h1>${song.title}</h1></p></a>
      <a href="${song.primary_artist.url}" target="_blank"><h2><p class="artist-name"></h2>${song.primary_artist.name}</p></a>

      <a href="treino.php?music=${song.id}"><button class="start-button">Começar</button></a>
        `;


  })
  .catch(err => {
    console.error('Erro ao buscar dados da música:', err);
    document.getElementById("song-data").innerText = "Erro ao carregar os dados da música.";
  });

const urlParams = new URLSearchParams(window.location.search);
const type = urlParams.get('type') ?? null;
const div = "lyrics";

window.onload = function () {
  letras(type, div);
};

function letras(type, div) {
  var embedContent = document.querySelector(".rg_embed_body");
  if (!embedContent) {
    setTimeout(() => letras(type, div), 500); // tenta novamente em 0,5s
    return;
  }

  var cleanedContent = embedContent.innerHTML;
  // limpeza °-°
  cleanedContent = cleanedContent.replace(/<a[^>]*>(.*?)<\/a>/gi, '$1'); // remove a mantendo o conteúdo
  cleanedContent = cleanedContent.replace(/<\/?a[^>]*>/gi, ''); // remove a mantendo o conteúdo
  cleanedContent = cleanedContent.replace(/<br\s*\/?>/gi, '<br>'); // normaliza br
  cleanedContent = cleanedContent.replace(/<\/?[bip]>/gi, ''); // remove tags <b> e <i> e <p>
  cleanedContent = cleanedContent.replace(/<\/?center>/gi, ''); // remove tag <center>
  cleanedContent = cleanedContent.replace(/<\/?strong>/gi, ''); // remove <strong>
  cleanedContent = cleanedContent.replace(/<\/?span>/gi, ''); // remove tag <span>
  cleanedContent = cleanedContent.replace(/<\/?blockquote>/gi, ''); // remove tag <blockquote>
  cleanedContent = cleanedContent.replace(/<\/?h1>/gi, ''); // remove tags <h1>
  cleanedContent = cleanedContent.replace(/<\/?h2>/gi, ''); // remove tags <h2>
  cleanedContent = cleanedContent.replace(/<\/?h3>/gi, ''); // remove tags <h3>
  cleanedContent = cleanedContent.replace(/<\/?h4>/gi, ''); // remove tags <h4>
  cleanedContent = cleanedContent.replace(/<\/?h5>/gi, ''); // remove tags <h5>
  cleanedContent = cleanedContent.replace(/<\/?h6>/gi, ''); // remove tags <h6>
  cleanedContent = cleanedContent.replace(/<\/?ul>/gi, ''); // remove tags <ul>
  cleanedContent = cleanedContent.replace(/<\/?ol>/gi, ''); // remove tags <ol>
  cleanedContent = cleanedContent.replace(/<\/?li>/gi, ''); // remove tags <li>
  cleanedContent = cleanedContent.replace(/<\/?hr>/gi, ''); // remove tags <hr>



  if (type == "full") {
    // Sem alterações
  }
  if (type == "clear") {
    cleanedContent = cleanedContent.replace(/\[[^\]]+\]/g, ''); // remove [Refrão], [Verso], etc
    cleanedContent = cleanedContent.replace(/(<br>\s*){2,}/gi, '<br><br>'); // evita múltiplos br
    cleanedContent = cleanedContent.replace(/<br\s*\/?>/, ''); // remove o primeiro br
  }
  if (type == "line") {
    cleanedContent = cleanedContent.replace(/<br>/gi, ''); // remove todos os br
    cleanedContent = cleanedContent.replace(/\[[^\]]+\]/g, ''); // remove [Refrão], [Verso], etc
  }

  document.getElementById(div).innerHTML = cleanedContent;
}
</script>


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