<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TypeMusic - Buscar</title>
  <link rel="stylesheet" href="style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
</head>

<body>
  <?php include "include/menu.php"; ?>
  <form onsubmit="searchMusic(event)">
    <?php include "include/searchBar.php"; ?>
  </form>

  <section class="content">
  <h3 id="search-title">Resultados:</h3>
  <div class="grid-container" id="results"></div>
  </section>

  <?php include "include/footer.php"; ?>

  <script>
    async function searchMusic(event) {
      event.preventDefault();
      const query = document.getElementById('query').value.trim();
      const resultsDiv = document.getElementById('results');
      resultsDiv.innerHTML = '<p>Buscando...</p>';

      try {
        const response = await fetch(`../servidor/search.php?q=${encodeURIComponent(query)}`);
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
    <a href="musicplayer.php?id=${song.id}">
    <div class="music-card-search">
      <img src="${song.song_art_image_thumbnail_url}" alt="Capa" />
      <p class="title">${song.title}</p>
      <p class="artist">${song.primary_artist.name}<</p>
    </div>
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