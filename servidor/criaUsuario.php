<?php

include('connect.php');

// Para capturar os dados do formulário
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $dataNascimento = $_POST['dataNascimento'];
    $senha = $_POST['senha'];
    $confirmarSenha = $_POST['confirmarSenha'];
    $sexo = $_POST['sexo'];
}

// Para confirmar se as senhas batem
if($senha !== $confirmarSenha){
    $erro = " As senhas não coincidem";
    exit();
}

// O hash serve pra não armazenar a senha bruta
$senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);

// Isso vai preparar a inserção no banco
$stmt = $conn->prepare("INSERT INTO tblUsuario (usrNome, usrEmail, usrDn, usrSenha, usrGenero) VALUES (?, ?, ? , ?, ?)");
$stmt->bind_param("sssss", $nome, $email, $dataNascimento, $senhaCriptografada, $sexo);

// Executar a inserção e também ver se ela deu certo
if($stmt-> execute()) {
    echo " Usuário cadastrado com sucesso" . $stmt->error;
} else {
    echo "Erro ao cadastrar";
}

// Fecha a conexão
$stmt->close();
$conn->close();

?>