<?php


include 'config.php';


// Para capturar os dados do formulário
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $dataNascimento = $_POST['dataNascimento'];
    $senha = $_POST['senha'];
    $confirmarSenha = $_POST['confirmarSenha'];
    $pais = $_POST['pais'];
    $sexo = $_POST['sexo'];
}

// Para confirmar se as senhas batem
if($senha !== $confirmarSenha){
    $erro = " As senhas não coincidem";
    exit();
}

$sql = "INSERT INTO tblUsuario (usrNome, usrEmail, usrDn, usrSenha, usrGenero, usrPais) VALUES ( '$nome' , '$email' , '$dataNascimento' , '$confirmarSenha' , '$sexo' , '$pais')" ;

if ($conn->query($sql) === TRUE) {
    echo "Usuário criado com sucesso!";
} else {
    echo "Erro: " . $conn->error;
}

$conn->close();

?>  