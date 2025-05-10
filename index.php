<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TypeMusic</title>
  <link rel="stylesheet" href="style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
</head>

<body>
  <?php include "include/menu.php"; ?>
  <?php include "include/searchBar.php"; ?>

  <section>
    <h3>Recomendadas</h3>
    <div class="carousel-container">
      <button class="btn prev">&#10094;</button>
      <div class="carousel" id="carousel-recomendadas">
        <!-- As músicas recomendadas serão carregadas aqui -->
      </div>
      <button class="btn next">&#10095;</button>
    </div>

    <h3>Mais Ouvidas</h3>
    <div class="carousel-container">
      <button class="btn prev">&#10094;</button>
      <div class="carousel" id="carousel-mais-ouvidas">
        <!-- As músicas mais ouvidas serão carregadas aqui -->
      </div>
      <button class="btn next">&#10095;</button>
    </div>

    <h3>Mais Treinadas</h3>
    <div class="carousel-container">
      <button class="btn prev">&#10094;</button>
      <div class="carousel" id="carousel-mais-treinadas">
        <!-- As músicas mais treinadas serão carregadas aqui -->
      </div>
      <button class="btn next">&#10095;</button>
    </div>
  </section>

  <script>
    async function buscarMusicas(listaIds, containerId) {
      const container = document.getElementById(containerId);
      if (!container) return;

      container.innerHTML = ''; // Limpa o container antes de adicionar novas músicas

      for (const { id } of listaIds) {
        try {
          const res = await fetch(`http://localhost/genius/servidor/info.php?id=${id}`);
          const data = await res.json();

          if (!data?.response?.song) continue;

          const song = data.response.song;
          const title = song.title;
          const artist = song.primary_artist.name;
          const image = song.song_art_image_thumbnail_url || 'img/capaMusic.png';

          const card = document.createElement('a');
          card.href = `musicplayer.php?id=${id}`;
          card.innerHTML = `
            <div class="music-card">
              <img src="${image}" alt="Capa da música" />
              <p class="title">${title}</p>
              <p class="artist">${artist}</p>
            </div>
          `;
          container.appendChild(card);
        } catch (err) {
          console.error(`Erro ao carregar música com ID ${id}:`, err);
        }
      }
    }

    // Carrega as músicas ao carregar a página
    fetch('musicas.json')
      .then(res => res.json())
      .then(data => {
        buscarMusicas(data.recomendadas, 'carousel-recomendadas');
        buscarMusicas(data.mais_ouvidas, 'carousel-mais-ouvidas');
        buscarMusicas(data.mais_treinadas, 'carousel-mais-treinadas');
      })
      .catch(err => console.error('Erro ao carregar o JSON de músicas:', err));
  </script>

  <?php include "include/footer.php"; ?>
</body>
<script src="js/index.js"></script>

</html>
