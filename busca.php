<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Buscar no Genius</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include('navbar.php'); ?>

<h1>Buscar músicas ou artistas (Genius API)</h1>

<form onsubmit="searchMusic(event)">
  <input type="text" id="query" placeholder="Digite uma música ou artista..." required>
  <button type="submit">Buscar</button>
</form>

<div class="result-container" id="results"></div>

<script>
  async function searchMusic(event) {
    event.preventDefault();
    const query = document.getElementById('query').value.trim();
    const resultsDiv = document.getElementById('results');
    resultsDiv.innerHTML = '<p>Buscando...</p>';

    try {
      const response = await fetch(`http://localhost/genius/servidor/search.php?q=${encodeURIComponent(query)}`);
      const data = await response.json();

      if (!data.response || !data.response.hits.length) {
        resultsDiv.innerHTML = '<p>Nenhum resultado encontrado.</p>';
        return;
      }

      resultsDiv.innerHTML = '';
      data.response.hits.forEach(hit => {
        const song = hit.result;
        const card = document.createElement('div');
        card.className = 'card';

        // Aqui o <a> envolve a imagem e os textos e leva para a página de detalhes
        card.innerHTML = `
          <a href="music.php?id=${song.id}">
            <img src="${song.song_art_image_thumbnail_url}" alt="Capa">
            <h3>${song.title}</h3>
            <p>${song.primary_artist.name}</p>
          </a>
        `;
        resultsDiv.appendChild(card);
      });

    } catch (error) {
      console.error(error);
      resultsDiv.innerHTML = '<p>Erro ao buscar resultados.</p>';
    }
  }
</script>

</body>
</html>
