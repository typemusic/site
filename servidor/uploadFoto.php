<?php
session_start();
require_once('connect.php'); // Ajuste o caminho se necessário

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$usuario = $_SESSION['usuario'];

// Verifica se enviou um arquivo
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {

    $arquivoTmp = $_FILES['foto']['tmp_name'];
    $nomeOriginal = $_FILES['foto']['name'];
    $extensao = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));
    $permitidos = ['jpg', 'jpeg', 'png', 'webp'];

    if (!in_array($extensao, $permitidos)) {
        die("Formato de arquivo não permitido.");
    }

    // Cria pasta uploads se não existir
    $pastaUpload = 'uploads/';
    if (!is_dir($pastaUpload)) {
        mkdir($pastaUpload, 0755, true);
    }

    // Gera um nome único para evitar sobrescrever
    $novoNome = 'user_' . $usuario['id'] . '_' . time() . '.' . $extensao;
    $destino = $pastaUpload . $novoNome;

    if (move_uploaded_file($arquivoTmp, $destino)) {
        // Salva o caminho no banco de dados
        $conexao = novaConexao();

        $sql = "UPDATE tblUsuario SET usrPerfil = :foto WHERE idUsuario = :id";
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':foto', $destino);
        $stmt->bindValue(':id', $usuario['id']);
        $stmt->execute();

        // Atualiza a sessão
        $_SESSION['usuario']['foto'] = $destino;

        header("Location: perfil.php"); // Redireciona de volta para o perfil
        exit();
    } else {
        die("Erro ao mover o arquivo.");
    }
} else {
    die("Nenhum arquivo enviado.");
}
