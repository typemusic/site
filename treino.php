<?php
$config = require 'config.php';
header("Content-Type: text/html; charset=utf-8");

$token = $config['token'];
$song_id = $_GET['id'] ?? null;
$type = $_GET['type'] ?? 'full'; // Pode ser 'full' ou 'clear'

if (!$song_id) {
    echo "Erro: nenhum ID de música foi fornecido.";
    exit;
}

// 1. Buscar dados da música pela API
$api_url = "https://api.genius.com/songs/$song_id";
$ch = curl_init($api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $token",
    "User-Agent: Mozilla/5.0"
]);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
if (!isset($data['response']['song']['path'])) {
    echo "Erro: caminho da música não encontrado.";
    exit;
}

$path = $data['response']['song']['path'];
$lyrics_url = "https://genius.com$path";

// 2. Baixar a página da letra
function getPageContent($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $html = curl_exec($ch);
    curl_close($ch);
    return $html;
}

$html = getPageContent($lyrics_url);

// 3. Extrair letra dos <div data-lyrics-container="true">
$dom = new DOMDocument();
libxml_use_internal_errors(true);
$dom->loadHTML($html);
libxml_clear_errors();

$xpath = new DOMXPath($dom);
$nodes = $xpath->query('//div[@data-lyrics-container="true"]');

$letra = '';
foreach ($nodes as $node) {
    if ($type === 'full') {
        $html_content = $node->ownerDocument->saveHTML($node);
        $texto = str_replace('<br>', "\n", $html_content);
        $texto = strip_tags($texto);
        $texto = preg_replace('/^\d+\s+Contributor.*?Lyrics/', '', $texto);
        $letra .= trim($texto) . "\n\n";
    } else {
        $texto = trim($node->textContent);
        if (!empty($texto)) {
            $letra .= $texto . ' '; // concatena com espaço
        }
    }
}

// 4. Limpeza final
if ($type === 'clear') {
    $letra = preg_replace('/^\d+\s+Contributor.*?Lyrics/', '', $letra);
    $letra = preg_replace('/\[[^\]]+\]/', '', $letra); // remove [Verso], etc.
    $letra = preg_replace('/\s+/', ' ', $letra); // compacta todos os espaços e quebras
} else {
    $letra = preg_replace('/\n{3,}/', "\n\n", $letra); // máx. 1 linha em branco
}

echo trim($letra);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Treino de Digitação com Música</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div id="container">
        <h1>Treinamento de Digitação: Música</h1>
        <div id="lyrics-container">
            <div id="lyrics"></div>
        </div>
        <div id="input-area">
            <textarea id="user-input" rows="3" placeholder="Digite aqui..." autofocus></textarea>
            <div id="feedback"></div>
        </div>
        <button id="restart-btn" onclick="restartTraining()">Reiniciar Treino</button>
    </div>

    <script>
        const lyricsContainer = document.getElementById("lyrics");
        const userInput = document.getElementById("user-input");
        const feedback = document.getElementById("feedback");
        const restartBtn = document.getElementById("restart-btn");

        let lyrics = ""; // A letra será inserida aqui
        let currentLine = 0;
        let currentIndex = 0;
        let lines = [];
        
        // Função para obter a letra da API
        function fetchLyrics(songId, type) {
            fetch(`letra.php?id=${songId}&type=${type}`)
                .then(response => response.text())
                .then(data => {
                    lyrics = data;
                    lines = lyrics.split('\n');
                    displayLyrics();
                })
                .catch(error => {
                    feedback.innerHTML = "Erro ao carregar letras.";
                });
        }

        // Exibe a letra dividida em 4 linhas
        function displayLyrics() {
            const visibleLines = lines.slice(currentLine, currentLine + 4);
            lyricsContainer.innerHTML = visibleLines.map(line => {
                return `<div class="line">${line}</div>`;
            }).join('');
        }

        // Função para lidar com a digitação
        function checkInput() {
            const typedText = userInput.value;
            const currentLineText = lines[currentLine] || "";
            const correctText = currentLineText.substring(0, typedText.length);
            const incorrectText = currentLineText.substring(typedText.length);

            // Marca o texto digitado corretamente
            let feedbackText = "";
            for (let i = 0; i < typedText.length; i++) {
                feedbackText += `<span class="correct">${typedText[i]}</span>`;
            }

            // Marca o erro
            feedbackText += `<span class="incorrect">${incorrectText}</span>`;
            feedback.innerHTML = feedbackText;

            if (typedText === currentLineText) {
                currentLine++;
                userInput.value = '';
                displayLyrics();
                scrollDown();
            }
        }

        function scrollDown() {
            if (currentLine > 3) {
                lyricsContainer.scrollTop = (currentLine - 3) * 30; // Ajuste para rolar a cada 4 linhas
            }
        }

        // Reiniciar o treino
        function restartTraining() {
            currentLine = 0;
            currentIndex = 0;
            userInput.value = '';
            feedback.innerHTML = '';
            displayLyrics();
        }

        userInput.addEventListener("input", checkInput);
        fetchLyrics(10252931, "full"); // Passar o ID da música e o tipo desejado
    </script>
</body>
</html>
