<?php
$config = require 'config.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$token = $config['token'];
$query = isset($_GET['q']) ? $_GET['q'] : null;
$genre = isset($_GET['genre']) ? $_GET['genre'] : null;

if (!$query) {
    echo json_encode(["error" => "Nenhuma consulta fornecida."]);
    exit;
}

$url = "https://api.genius.com/search?q=" . urlencode($query);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $token"
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode(["error" => curl_error($ch)]);
    exit;
}

curl_close($ch);
$data = json_decode($response, true);

// Agora, se o gênero foi fornecido, podemos filtrar as músicas/artistas
if ($genre) {
    $filtered_hits = [];
    foreach ($data['response']['hits'] as $hit) {
        $song = $hit['result'];
        if (strpos(strtolower($song['primary_artist']['name']), strtolower($genre)) !== false || strpos(strtolower($song['title']), strtolower($genre)) !== false) {
            $filtered_hits[] = $hit;
        }
    }
    $data['response']['hits'] = $filtered_hits; // Filtra os resultados
}

echo json_encode($data);
?>
