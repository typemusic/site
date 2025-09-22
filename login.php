<?php
session_start();
require_once __DIR__ . '/servidor/connect.php';


$erros = [];
$email = '';

$senha = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    // Validações
    if ($email === '') {
        $erros['email'] = "E-mail é obrigatório";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros['email'] = "Formato de e-mail inválido";
    }

    if ($senha === '') {
        $erros['senha'] = "Senha é obrigatória";
    }


    if (empty($erros)) {
        try {
            $conexao = novaConexao();
            $sql = "SELECT * FROM tblUsuario WHERE usrEmail = :email LIMIT 1";
            $stmt = $conexao->prepare($sql);
            $stmt->bindValue(':email', $email);
            $stmt->execute();

            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario && password_verify($senha, $usuario['usrSenha'])) {

                $_SESSION['usuario'] = [
                    'id' => $usuario['IDusuario'],
                    'nome' => $usuario['usrNome'],
                    'email' => $usuario['usrEmail']
                ];
                header("Location: index.php");
                exit();
            } else {
                $erros['login'] = "E-mail ou senha incorretos";
            }
        } catch (PDOException $e) {
            $erros['login'] = "Erro no banco de dados: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php include "include/menu.php"; ?>

    <div class="container-cadastro">
        <div class="container-formulario">
            <form action="login.php" method="post">


                <div class="inputBox">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" class="inputUsuario"
                        value="<?= htmlspecialchars($email) ?>">
                    <?php if (isset($erros['email'])): ?>
                        <div class="text-danger"><?= $erros['email'] ?></div>
                    <?php endif; ?>
                </div>

                <br>


                <div class="inputBox">
                    <label for="senha">Senha</label>
                    <input type="password" name="senha" id="senha" class="inputUsuario">
                    <?php if (isset($erros['senha'])): ?>
                        <div class="text-danger"><?= $erros['senha'] ?></div>
                    <?php endif; ?>
                </div>

                <br>


                <?php if (isset($erros['login'])): ?>
                    <div class="text-danger"><?= $erros['login'] ?></div>
                <?php endif; ?>

                <br>
                <input type="submit" id="submit" value="Entrar">

                <div style="display: flex; justify-content: center; align-items: center; margin-top: 15px;">
                    <span>Não tem uma conta?</span>
                    <a href="cadastro.php"
                        style="margin-left: 5px; text-decoration: none; color: #c5b4ff;">Cadastre-se</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>