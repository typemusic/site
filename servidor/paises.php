<?php

// URL da API com a especificação de campos
$url = "https://restcountries.com/v3.1/all?fields=name,translations,cca2";

// Inicializar o cURL
$ch = curl_init();

// Configurar as opções do cURL
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

// Executar a requisição e obter a resposta
$response = curl_exec($ch);

// Verificar se houve erro durante a requisição
if (curl_errno($ch)) {
    echo 'Erro no cURL: ' . curl_error($ch);
    exit();
}

// Fechar a conexão cURL
curl_close($ch);

// Decodificar a resposta JSON
$countries = json_decode($response, true);

// Gera o campo de seleção de países
echo '<label for="pais">Selecione seu País:</label>';
echo '<select name="pais" id="pais" required>';

if ($countries) {
    // Para cada país, verifica se a tradução para o português está disponível
    foreach ($countries as $country) {
        // Debug: Veja a estrutura do país
        echo '<pre>';
        print_r($country);  // Verifica como os dados estão estruturados
        echo '</pre>';
        
        // Verifica se existe a tradução para o português
        if (isset($country['translations']['por'])) {
            // A tradução para o português pode ser uma string ou um array
            $nome = $country['translations']['por'];

            // Caso seja um array, pegamos a string correta (se necessário)
            if (is_array($nome)) {
                $nome = implode(', ', $nome); // Junta os itens do array com vírgula
            }
        } else {
            // Se não houver tradução para o português, usa o nome comum
            $nome = isset($country['name']['common']) ? $country['name']['common'] : 'Nome não disponível';
        }

        // Código do país (ex: BR, US, etc.)
        $codigo = isset($country['cca2']) ? $country['cca2'] : 'desconhecido';

        // Exibe a opção no dropdown
        echo "<option value=\"$codigo\">$nome</option>";
    }
} else {
    // Caso a resposta da API não seja válida
    echo '<option>Erro ao carregar países.</option>';
}

echo '</select><br><br>';
?>
