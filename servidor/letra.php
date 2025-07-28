<?php
$config = require 'config.php';
header("Content-Type: text/plain; charset=utf-8");

$token = $config['token'];
$song_id = $_GET['id'] ?? null;
$type = $_GET['type'] ?? 'full'; // Pode ser 'full', 'line' ou 'clear'

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
if (empty($html)) {
    echo "Erro: não foi possível baixar a página da letra.";
    exit;
}

// 3. Extrair letra dos <div data-lyrics-container="true">
$dom = new DOMDocument();
libxml_use_internal_errors(true);
$dom->loadHTML($html);
libxml_clear_errors();

$xpath = new DOMXPath($dom);
$excludeNodes = $xpath->query('//div[@data-lyrics-container="true"]//div[@data-exclude-from-selection="true"]');

// Remover elementos indesejados
foreach ($excludeNodes as $excludeNode) {
    $toRemove = $xpath->query('.//*[contains(@class, "SongBioPreview__Wrapper") or contains(@class, "SongBioPreview__Container")]', $excludeNode);
    foreach ($toRemove as $node) {
        $node->parentNode->removeChild($node);
    }
}

$nodes = $xpath->query('//div[@data-lyrics-container="true"]');

if ($nodes->length === 0) {
    echo "Erro: letras não encontradas no HTML.";
    exit;
}

// 4. Montar o conteúdo da letra
$letra = '';
foreach ($nodes as $node) {
    $html_content = $node->ownerDocument->saveHTML($node);
    $texto = str_replace('<br>', "\n", $html_content);
    $texto = strip_tags($texto);
    $texto = preg_replace('/^\d+\s+Contributor.*?Lyrics/', '', $texto);
    $letra .= trim($texto) . "\n\n";
}
$letra = preg_replace('/\n{3,}/', "\n\n", $letra); // Limita espaços em branco

// 5. Aplicar formatações por tipo
if ($type === 'line') {
    $letra = preg_replace('/\[[^\]]+\]/', '', $letra); // Remove [Verso], etc.
} elseif ($type === 'clear') {
    $letra = preg_replace('/\[[^\]]+\]/', '', $letra); // Remove [Verso], etc.
    $letra = preg_replace('/\s+/', ' ', $letra); // Junta tudo em uma linha
} elseif ($type === 'full') {
    // Nenhuma modificação adicional
}

echo trim($letra);
