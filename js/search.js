    // Função que realiza a busca e atualiza a URL com o termo pesquisado
    async function searchMusic(event) {
      if (event) event.preventDefault();
      
      const query = document.getElementById('query').value.trim();
      if (!query) return;
      
      // Atualiza a URL com o termo da pesquisa
      window.history.pushState({}, '', `?q=${encodeURIComponent(query)}`);
      
      const resultsDiv = document.getElementById('results');
      resultsDiv.innerHTML = '<p>Buscando...</p>';

      try {
        const response = await fetch(`https://typemusic.hubsapiens.com.br/servidor/search.php?q=${encodeURIComponent(query)}`);
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

          // O <a> envolve a imagem e os textos, direcionando para a página de detalhes
          card.innerHTML = `
            <a href="musicplayer.php?music=${song.id}">
              <div class="music-card-search">
                <img src="${song.song_art_image_thumbnail_url}" alt="Capa" />
                <p class="title">${song.title}</p>
                <p class="artist">${song.primary_artist.name}</p>
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

    // Ao carregar a página, verifica se há um parâmetro 'q' na URL para preencher a busca
    window.addEventListener('DOMContentLoaded', () => {
      const urlParams = new URLSearchParams(window.location.search);
      const currentQuery = urlParams.get('q');
      if (currentQuery) {
        document.getElementById('query').value = currentQuery;
        searchMusic();  // Executa a busca automaticamente com o parâmetro da URL
      }
    });