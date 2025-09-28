
//buscar os dados da música (nome, capa, artista...)
fetch('https://typemusic.hubsapiens.com.br/servidor/info.php?id=1063')
  .then(res => res.json())
  .then(data => {
    const song = data.response.song;
    const infoDiv = document.getElementById('song-info');
    infoDiv.innerHTML = `
      <img src="${song.song_art_image_url}" alt="Capa da música" />
      <a href="${song.url}" target="_blank"><p class="song-title"><h1>${song.title}</h1></p></a>
      <a href="${song.primary_artist.url}" target="_blank"><h2><p class="artist-name"></h2>${song.primary_artist.name}</p></a>

      <a href="treino.php?music=1063"><button class="start-button">Começar</button></a>
        `;

    // buscar a letra completa com quebras e blocos
    fetch(`https://typemusic.hubsapiens.com.br/servidor/letra.php?id=${song.id}&type=full`)
      .then(res => res.text())



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