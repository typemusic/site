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
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php include "include/menu.php"; ?>

    <div class="container-cadastro">
        <div class="lado-esquerdo"></div>
        <div class="container-formulario">
            <form action="cadastro.php" method="POST">

                <div class="inputBox">
                    <label for="nome"> Nome </label>
                    <input type="text" name="nome" id="nome" class="inputUsuario"
                        value="<?= htmlspecialchars($dados['nome'] ?? '') ?>">
                    <?php if (isset($erros['nome'])): ?>
                        <div class="text-danger"><?= $erros['nome'] ?></div>
                    <?php endif; ?>
                </div>

                <div class="inputBox">
                    <label for="email"> Email </label>
                    <input type="email" name="email" id="email" class="inputUsuario"
                        value="<?= htmlspecialchars($dados['email'] ?? '') ?>">
                    <?php if (isset($erros['email'])): ?>
                        <div class="text-danger"><?= $erros['email'] ?></div>
                    <?php endif; ?>
                </div>

                <div class="inputBox">
                    <label for="dataNascimento"> Data de Nascimento </label>
                    <input type="date" name="dataNascimento" id="dataNascimento" class="inputUsuario"
                        value="<?= htmlspecialchars($dados['dataNascimento'] ?? '') ?>">
                    <?php if (isset($erros['dataNascimento'])): ?>
                        <div class="text-danger"><?= $erros['dataNascimento'] ?></div>
                    <?php endif; ?>
                </div>

                <div class="inputBox">
                    <label for="senha"> Senha </label>
                    <input type="password" name="senha" id="senha" class="inputUsuario">
                    <?php if (isset($erros['senha'])): ?>
                        <div class="text-danger"><?= $erros['senha'] ?></div>
                    <?php endif; ?>
                </div>

                <div class="inputBox">
                    <label for="confirmarSenha"> Confirmar Senha </label>
                    <input type="password" name="confirmarSenha" id="confirmarSenha" class="inputUsuario">
                    <?php if (isset($erros['confirmarSenha'])): ?>
                        <div class="text-danger"><?= $erros['confirmarSenha'] ?></div>
                    <?php endif; ?>
                </div>

                <p>Sexo</p>
                <input type="radio" id="Masculino" name="sexo" value="1" <?= (isset($dados['sexo']) && $dados['sexo'] == '1') ? 'checked' : '' ?>>
                <label for="Masculino"> Masculino </label>

                <input type="radio" id="Feminino" name="sexo" value="2" <?= (isset($dados['sexo']) && $dados['sexo'] == '2') ? 'checked' : '' ?>>
                <label for="Feminino"> Feminino </label>

                <?php if (isset($erros['sexo'])): ?>
                    <div class="text-danger"><?= $erros['sexo'] ?></div>
                <?php endif; ?>

                <br>
                <input type="submit" id="submit" value="Cadastrar">

            </form>
        </div>
    </div>

</body>

</html>

<?php
unset($_SESSION['erros'], $_SESSION['dados_form']);
?>