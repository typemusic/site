<?php
$config = require 'config.php';
header("Content-Type: text/plain; charset=utf-8");

$token = $config['token'];
$song_id = $_GET['id'] ?? null;
$type = $_GET['type'] ?? 'full'; // Pode ser 'full', 'clear' ou 'line'

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
    if ($type === 'full' || $type === 'line') {
        $html_content = $node->ownerDocument->saveHTML($node);
        $texto = str_replace('<br>', "\n", $html_content);
        $texto = strip_tags($texto);
        $texto = preg_replace('/^\d+\s+Contributor.*?Lyrics/', '', $texto);
        $letra .= trim($texto) . "\n\n";
    } else { // clear
        $texto = trim($node->textContent);
        if (!empty($texto)) {
            $letra .= $texto . ' ';
        }
    }
}

// 4. Limpeza final
if ($type === 'clear') {
    $letra = preg_replace('/^\d+\s+Contributor.*?Lyrics/', '', $letra);
    $letra = preg_replace('/\[[^\]]+\]/', '', $letra); // Remove [Refrão], [Verso], etc.
    $letra = preg_replace('/\s+/', ' ', $letra);       // Remove quebras e múltiplos espaços
    $letra = trim($letra);
} elseif ($type === 'line') {
    $letra = preg_replace('/^\d+\s+Contributor.*?Lyrics/', '', $letra);
    $letra = preg_replace('/\[[^\]]+\]/', '', $letra); // Remove [partes]
    $letra = preg_replace('/\n{3,}/', "\n\n", $letra); // Limita linhas em branco
    $letra = trim($letra);
} elseif ($type === 'full') {
    $letra = preg_replace('/\n{3,}/', "\n\n", $letra); // Limita linhas em branco
}

echo trim($letra);
