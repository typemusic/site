<?php
session_start();
require_once('conn.php');

if (!isset($_SESSION['dados_form'])) {
    header("Location: cadastro.php");
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

    $_SESSION['usuario'] = [
        'id' => $conexao->lastInsertId(),
        'nome' => $dados['nome'],
        'email' => $dados['email']
    ];


    $_SESSION['sucesso'] = "Cadastro realizado com sucesso";




    header("Location: ../index.php");
    exit();
} catch (PDOException $e) {
    echo "Erro ao inserir registro: " . $e->getMessage();
}

?>