<?php
$song_id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : null;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Detalhes da Música</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<a href="busca.php" class="button">← Voltar à busca</a>
<h1>Detalhes da Música (Genius)</h1>

<?php if ($song_id): ?>
  <!-- Container para exibir as informações da música -->
  <div class="music-info" id="song-data">Carregando informações da música...</div>

  <!-- Exibe a letra da música -->
  <div id="lyrics">Carregando letra...</div>

  <?php if ($song_id): ?>
    <a href="treino.php?id=<?= $song_id ?>" style="display: inline-block; padding: 10px 20px; background: #4CAF50; color: white; text-decoration: none; border-radius: 5px; font-weight: bold;">
        Iniciar Treino de Digitação
    </a>
<?php endif; ?>

  <script>
    // Primeiro, buscar os dados da música (nome, capa, artista...)
    fetch('http://localhost/genius/servidor/info.php?id=<?php echo $song_id; ?>')
      .then(res => res.json())
      .then(data => {
        const song = data.response.song;
        const infoDiv = document.getElementById('song-data');
        infoDiv.innerHTML = `
          <img src="${song.song_art_image_url}" class="cover" alt="Capa">
          <h2><a href="${song.url}" target="_blank">${song.title}</a></h2>
          <h3><a href="${song.primary_artist.url}" target="_blank">${song.primary_artist.name}</a></h3>
          <h4>Idioma: ${song.language}</h4>
        `;

        // Depois, buscar a letra completa com quebras e blocos
        fetch(`http://localhost/genius/servidor/letra.php?id=${song.id}&type=full`)
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
  </script>

<?php else: ?>
  <p>Nenhum ID de música informado na URL.</p>
<?php endif; ?>

</body>
</html>
