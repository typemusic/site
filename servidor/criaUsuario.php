<?php


include 'config.php';


// Para capturar os dados do formulário
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $dataNascimento = $_POST['dataNascimento'];
    $senha = $_POST['senha'];
    $confirmarSenha = $_POST['confirmarSenha'];
    $sexo = $_POST['sexo'];
}


// Hash
$senha_hash = password_hash($confirmarSenha, PASSWORD_BCRYPT);

// Para confirmar se as senhas batem
if($senha !== $confirmarSenha){
    $erro = " As senhas não coincidem";
    exit();
}

$sql = "INSERT INTO tblUsuario (usrNome, usrEmail, usrDn, usrSenha, usrGenero) VALUES ( '$nome' , '$email' , '$dataNascimento' , '$senha_hash' , '$sexo')" ;

if ($conn->query($sql) === TRUE) {
    echo "Usuário criado com sucesso!";
} else {
    echo "Erro: " . $conn->error;
}

$conn->close();

?>  