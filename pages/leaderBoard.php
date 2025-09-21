<?php
session_start();

if (count($_POST) > 0) {
    $erros = [];

    // Validações
    if (!isset($_POST['nome']) || trim($_POST['nome']) === '') {
        $erros['nome'] = "Nome é obrigatório";
    } elseif (strlen($_POST['nome']) < 3) {
        $erros['nome'] = "Nome deve ter pelo menos 3 caracteres";
    }

    if (!isset($_POST['email']) || trim($_POST['email']) === '') {
        $erros['email'] = "E-mail é obrigatório";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $erros['email'] = "Formato de e-mail inválido";
    }

    if (!isset($_POST['dataNascimento']) || trim($_POST['dataNascimento']) === '') {
        $erros['dataNascimento'] = "Data de nascimento é obrigatória";
    }

    if (!isset($_POST['senha']) || trim($_POST['senha']) === '') {
        $erros['senha'] = "Senha é obrigatória";
    }

    if (!isset($_POST['confirmarSenha']) || trim($_POST['confirmarSenha']) === '') {
        $erros['confirmarSenha'] = "É obrigatório confirmar a senha";
    } elseif ($_POST['senha'] !== $_POST['confirmarSenha']) {
        $erros['confirmarSenha'] = "As senhas não coincidem";
    }

    if (!isset($_POST['sexo'])) {
        $erros['sexo'] = "Escolha um gênero";
    } elseif (!in_array($_POST['sexo'], ['1', '2'])) {
        $erros['sexo'] = "Gênero inválido";
    }

    if (!empty($erros)) {
        $_SESSION['erros'] = $erros;
        $_SESSION['dados_form'] = $_POST;
    } else {
        $_SESSION['dados_form'] = $_POST;
        header("Location: servidor/criaUsuario.php");
        exit();
    }
}

$erros = $_SESSION['erros'] ?? [];
$dados = $_SESSION['dados_form'] ?? [];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded" rel="stylesheet" />
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <?php include "../include/menu.php"; ?>
    <?php include "../include/searchBar.php"; ?>

    <div class="main-content">
        
    </div>

</body>
<script src="js/theme.js"></script>
</html>

<?php
unset($_SESSION['erros'], $_SESSION['dados_form']);
?>