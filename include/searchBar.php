<header>
<a href="/">
  <div class="logo"></div>
</a>
  <div class="search-container">
    <button id="search-button" type="submit">
      <span class="material-symbols-rounded">search</span>
    </button>
    <input type="text" id="query" placeholder="Buscar músicas..." required />
  </div>
  <a href="cadastro.php" id="menuToggle"><img src="img/user.png" alt="Perfil" class="user-img" /></a>
</header>

<script>
  function resumirTitulo(card, alturaMax) {
    const divMusic = card.querySelector('.music-date');
    if (!divMusic) return;

    const titleEl = divMusic.querySelector('.title');
    if (!titleEl) return;

    if (divMusic.offsetHeight > alturaMax) {
      titleEl.textContent = titleEl.textContent.substring(0, 12) + '...';
    }
  }


  async function buscarMusicas(listaIds, containerId) {
    const container = document.getElementById(containerId);
    if (!container) return;
    container.innerHTML = '';

    for (const {
        id
      }
      of listaIds) {
      try {
        const res = await fetch(`https://typemusic.hubsapiens.com.br/servidor/info.php?id=${id}`);
        const data = await res.json();
        if (!data?.response?.song) continue;

        const song = data.response.song;
        const artist = song.primary_artist.name;
        const image = song.song_art_image_thumbnail_url || 'img/capaMusic.png';
        const fullTitle = song.title;


        const card = document.createElement('a');
        card.href = `musicplayer.php?music=${id}`;
        card.className = 'music-card-link';
        card.innerHTML = `
        <div class="music-card">
          <img src="${image}" alt="Capa da música" />
          <div class="music-date">
            <p class="title">${fullTitle}</p>
            <p class="artist">${artist}</p>
          </div>
        </div>
      `;

        container.appendChild(card);
        resumirTitulo(card, 65);

      } catch (err) {
        console.error(`Erro ao carregar música ID ${id}:`, err);
      }
    }
  }


  // Lógica de redirecionamento da busca
  // Ao clicar no botão ou pressionar Enter no input, redireciona para search.php?q=termo
  document.getElementById('search-button').addEventListener('click', function(e) {
    e.preventDefault();
    const termo = document.getElementById('query').value.trim();
    if (termo !== "") {
      window.location.href = `/search.php?q=${encodeURIComponent(termo)}`;
    }
  });

  // Permite que a tecla Enter, ao ser pressionada dentro do input, dispare a busca
  document.getElementById('query').addEventListener('keyup', function(event) {
    if (event.key === 'Enter') {
      event.preventDefault();
      document.getElementById('search-button').click();
    }
  });

  
  function setTheme(mode) {
    const logo = document.getElementById('logo');

    if (mode === 'auto') {
      document.documentElement.removeAttribute('data-theme');
      localStorage.removeItem('theme');

      const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
      logo.src = prefersDark ? 'img/logo_white.png' : 'img/logo_default.png';
    } else {
      document.documentElement.setAttribute('data-theme', mode);
      localStorage.setItem('theme', mode);
      logo.src = mode === 'dark' ? 'img/logo_white.png' : 'img/logo_default.png';
    }
  }

  (function() {
    const savedTheme = localStorage.getItem('theme');
    const logo = document.getElementById('logo');

    if (savedTheme) {
      document.documentElement.setAttribute('data-theme', savedTheme);
      logo.src = savedTheme === 'dark' ? 'img/logo_white.png' : 'img/logo_default.png';
    } else {
      const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
      logo.src = prefersDark ? 'img/logo_white.png' : 'img/logo_default.png';
    }
  })();
</script>