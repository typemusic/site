<?php
$song_id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : null;
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TypeMusic - Player</title>
  <link rel="stylesheet" href="style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
</head>

<body>
  <?php include "include/menu.php"; ?>
  <?php include "include/searchBar.php"; ?>

  <?php if ($song_id): ?>
    <main class="main-content">
      <div class="lyrics-box" id="lyrics">
        Carregando letra...
      </div>
      <div class="song-info" id="song-info">
        Carregando informações...
      </div>
      <br>
      <div id="id-music">ID</div>
    </main>
    
    

    <script>
      //buscar os dados da música (nome, capa, artista...)
      fetch('https://typemusic.hubsapiens.com.br/servidor/info.php?id=<?php echo $song_id; ?>')
        .then(res => res.json())
        .then(data => {
          const song = data.response.song;
          const infoDiv = document.getElementById('song-info');
          infoDiv.innerHTML = `
      <img src="${song.song_art_image_url}" alt="Capa da música" />
      <a href="${song.url}" target="_blank"><p class="song-title"><h1>${song.title}</h1></p></a>
      <a href="${song.primary_artist.url}" target="_blank"><h2><p class="artist-name"></h2>${song.primary_artist.name}</p></a>

      <button class="start-button">Começar</button>
        `;

          // buscar a letra completa com quebras e blocos
          fetch(`https://typemusic.hubsapiens.com.br/servidor/letra.php?id=${song.id}&type=full`)
            .then(res => res.text())
            .then(lyrics => {
              document.getElementById("lyrics").innerHTML = lyrics;
            })
            .catch(err => {
              document.getElementById("lyrics").innerText = "Erro ao carregar a letra.";
              console.error(err);
            });

        })
        .catch(err => {
          console.error('Erro ao buscar dados da música:', err);
          document.getElementById("song-data").innerText = "Erro ao carregar os dados da música.";
        });

        document.getElementById("id-music").innerText = <?php echo $song_id; ?>;
    </script>

  <?php else: ?>
    <p>Nenhum ID de música informado na URL.</p>
  <?php endif; ?>

  <?php include "include/footer.php"; ?>
</body>

</html>