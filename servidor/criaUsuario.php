<?php
require_once('config.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conexao = novaConexao();

    $senha_hash = password_hash($_POST['confirmarSenha'], PASSWORD_BCRYPT);

    try {
        $sql = "INSERT INTO tblUsuario (usrNome, usrEmail, usrDn, usrSenha, usrGenero) 
                VALUES (:n, :e, :d, :s, :g)";
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':n', $_POST['nome']);
        $stmt->bindValue(':e', $_POST['email']);
        $stmt->bindValue(':d', $_POST['dataNascimento']);
        $stmt->bindValue(':s', $senha_hash);
        $stmt->bindValue(':g', $_POST['sexo']);
        $stmt->execute();

        // Redireciona para o index
        header("Location: ../index.php");
        exit();
    } catch (PDOException $e) {
        echo "Erro ao inserir registro: " . $e->getMessage();
    }
}
?>
