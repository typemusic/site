<?php
session_start();
require_once('connect.php');

if (!isset($_SESSION['dados_form'])) {
    header("Location: ../cadastro.php");
    exit();
}

$dados = $_SESSION['dados_form'];
unset($_SESSION['dados_form']);

$conexao = novaConexao();

$senha_hash = password_hash($dados['senha'], PASSWORD_BCRYPT);

try {
    $sql = "INSERT INTO tblUsuario (usrNome, usrEmail, usrDn, usrSenha, usrGenero) 
                VALUES (:n, :e, :d, :s, :g)";
    $stmt = $conexao->prepare($sql);
    $stmt->bindValue(':n', $dados['nome']);
    $stmt->bindValue(':e', $dados['email']);
    $stmt->bindValue(':d', $dados['dataNascimento']);
    $stmt->bindValue(':s', $senha_hash);
    $stmt->bindValue(':g', $dados['sexo']);
    $stmt->execute();

    $_SESSION['sucesso'] = "Cadastro realizado com sucesso";

    // Redireciona para o index
    header("Location: ../index.php");
    exit();
} catch (PDOException $e) {
    echo "Erro ao inserir registro: " . $e->getMessage();
}

?>