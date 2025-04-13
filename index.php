<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Embed Genius com PHP</title>
</head>
<body>

<form method="POST" action="">
    <label for="song_id">Digite o ID da música (Genius):</label>
    <input type="text" id="song_id" name="song_id" placeholder="Ex: 11718636">
    <button type="submit">Gerar Embed</button>
</form>


<button onclick="getLyrics()">Mostrar Letra</button>

<div id="result"></div>

<script>
    // Função para extrair o texto das letras
    function getLyrics() {
        // Seleciona o elemento que contém as letras
        var embedContent = document.querySelector(".rg_embed_body");

        // Remove as tags <a> e mantém as quebras de linha <br>
        var cleanedContent = embedContent.innerHTML.replace(/<a[^>]*>(.*?)<\/a>/g, '$1'); // Remove as tags <a> e mantém o texto dentro delas
        cleanedContent = cleanedContent.replace(/<\/?a[^>]*>/g, ''); // Remover qualquer tag <a> restante

        // Exibe o conteúdo sem as tags <a>, mas mantendo as quebras de linha
        document.getElementById("result").innerHTML = cleanedContent;
    }
</script>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pegando o ID digitado pelo usuário e sanitizando
    $song_id = htmlspecialchars($_POST['song_id']);

    // Gerando o código com o ID inserido
    echo '
    <div id="rg_embed_link_' . $song_id . '" class="rg_embed_link" data-song-id="' . $song_id . '">
        <script src="//genius.com/songs/' . $song_id . '/embed.js" crossorigin=""></script>
    </div>';
}
?>



</body>
</html>
