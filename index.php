<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Letra via API Genius</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include('navbar.php'); ?>

<h1>Busca de Música + Letra (Genius API)</h1>

<form method="GET" action="">
  <label for="song_id">Digite o ID da música (Genius):</label>
  <input type="text" id="song_id" name="id" placeholder="Ex: 10521931" required>
  <select name="type">
    <option value="full">Full (com [partes] e quebras)</option>
    <option value="line">Line (Sem [partes] e quebras)</option>
    <option value="clear">Clear (sem [partes], formatado)</option>
  </select>
  <button type="submit">Buscar</button>
</form>

<?php if (isset($_GET['id'])): ?>
  <div class="music-info" id="song-data">
    <h2>Informações da música</h2>
    <p>Carregando dados...</p>
  </div>

  <div id="lyrics">
    <h2>Letra da Música</h2>
    <p>Carregando letra...</p>
  </div>

  <script>
    const id = "<?php echo $_GET['id']; ?>";
    const type = "<?php echo $_GET['type'] ?? 'full'; ?>";

    // Letra via sua API
    fetch(`http://localhost/genius/servidor/letra.php?id=${id}&type=${type}`)
      .then(res => res.text())
      .then(text => {
        document.getElementById("lyrics").innerHTML = `<pre>${text}</pre>`;
      });

    // Dados da música via Genius API (separado)
    fetch(`http://localhost/genius/servidor/info.php?id=${id}`)
      .then(res => res.json())
      .then(data => {
        const song = data.response.song;
        const infoDiv = document.getElementById('song-data');
        infoDiv.innerHTML = `
          <img src='${song.song_art_image_url}' class='cover' alt='Capa da música'>
          <h2><a href='${song.url}' target='_blank'>${song.title}</a></h2>
          <h3><a href='${song.primary_artist.url}' target='_blank'>${song.primary_artist.name}</a></h3>
          <h4>Idioma: ${song.language}</h4>
        `;
      });
  </script>
<?php endif; ?>

</body>
</html>
