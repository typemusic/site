<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$token = '3mLirxgaipD2_5WRxEzd3LxX44gMER3ZFW9Sjm8pw9fKJT2p0hLUshAujAh11I6j'; // Substitua com seu token real da Genius
$song_id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$song_id) {
    echo json_encode(["error" => "ID da música não fornecido"]);
    exit;
}

$url = "https://api.genius.com/songs/$song_id";

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
echo $response;
?>
