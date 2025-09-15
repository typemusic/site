// Selecionando todos os carrosseis e seus respectivos botões
document.querySelectorAll('.carousel-container').forEach(container => {
  const carousel = container.querySelector('.carousel');
  const prevBtn = container.querySelector('.prev');
  const nextBtn = container.querySelector('.next');

  let scrollAmount = 0;
  const scrollPerClick = 650; // Ajuste do número de pixels para cada clique

  // Ação para o botão "next"
  nextBtn.addEventListener('click', () => {
    carousel.scrollBy({ left: scrollPerClick, behavior: 'smooth' });
  });

  // Ação para o botão "prev"
  prevBtn.addEventListener('click', () => {
    carousel.scrollBy({ left: -scrollPerClick, behavior: 'smooth' });
  });
});

async function buscarMusicas(listaIds, containerId) {
  const container = document.getElementById(containerId);
  if (!container) return;

  container.innerHTML = ''; // Limpa o container antes de adicionar novas músicas

  for (const { id } of listaIds) {
    try {
      const res = await fetch(`https://typemusic.hubsapiens.com.br/servidor/info.php?id=${id}`);
      const data = await res.json();

      if (!data?.response?.song) continue;

      const song = data.response.song;
      const title = song.title;
      const artist = song.primary_artist.name;
      const image = song.song_art_image_thumbnail_url || 'img/capaMusic.png';

      const card = document.createElement('a');
      card.href = `musicplayer.php?music=${id}`;
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
