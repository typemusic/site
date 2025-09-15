<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$music = isset($_GET['music']) ? htmlspecialchars($_GET['music']) : null;
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teste de Digitação</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded" rel="stylesheet" />
    <link rel="icon" href="../img/favicon.png" type="image/png">
</head>


<body>
    <?php include "../include/menu.php"; ?>
    <?php include "../include/searchBar.php"; ?>
    <div class="main-content">
        <div class="container">
            <h1>Teste de Digitação</h1>
            <div class="info" id="info"></div>
            <div class="dicas" id="dicas">
                <ul>
                    <li>
                        <b>Evite olhar para o teclado:</b> Forçar a memória muscular ajuda a digitar mais rápido e com precisão, sem distrações.
                    </li>
                    <li>
                        <b>Mantenha os dedos na posição correta:</b> Coloque os dedos sobre as teclas F e J, que são as referências para os dedos indicadores. Isso ajuda a melhorar a agilidade e precisão.
                    </li>
                    <li>
                        <b>Use todos os dedos:</b> Tente evitar digitar apenas com os dedos indicadores. Ao utilizar todos os dedos, a digitação se torna mais rápida e menos cansativa.
                    </li>
                    <li>
                        <b>Pratique a digitação com postura correta:</b> Sente-se de forma confortável, com os ombros relaxados, e os cotovelos a 90 graus. A posição adequada evita lesões e facilita movimentos mais rápidos.
                    </li>
                </ul>

            </div>
            <button id="startButton" onclick="startTest()">Iniciar Teste</button>

            <div id="test-area" style="display: none;">
                <div id="progress"></div>
                <div id="expectedLyric">Aguardando letra...</div>
                <div id="image-container"><img id="dynamic-image" src="img/spaco.png" alt="Imagem ativada pelo espaço"></div>
                <input type="text" id="typingInput" placeholder="Digite aqui a letra mostrada" maxlength="1" autofocus>
                <div id="message"></div>
                <div id="stats"></div>
                <p id="cronometro">0 segundos</p>
            </div>
        </div>
</body>
<script src="../js/treino.js"></script>

</html>

<?php

$music = htmlspecialchars($_GET['music']) ?? null;

if (!$music) {
    echo "Erro: nenhum ID de música foi fornecido.";
    exit;
}

// Gerando o código com o ID inserido
echo '
    <div id="rg_embed_link_' . $music . '" class="rg_embed_link" data-song-id="' . $music . '">
        <script src="//genius.com/songs/' . $music . '/embed.js" crossorigin=""></script>
    </div>';



?>