<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar</title>
    <link rel="stylesheet" href="style.css">
</head>

<?php
include('includes/navbar.php');
include('includes/searchbar.php');
?>

<body>
    <div class="container">
        <div class="lado-esquerdo"></div>
        <div class="container-cadastro">
            <form action="servidor/criaUsuario.php" method="POST">
                <div class="inputBox">
                    <label for="nome"> Nome </label>
                    <input type="text" name="nome" id="nome" class="inputUsuario" required>
                </div>
                <br>

                <div class="inputBox">
                    <label for="email"> Email </label>
                    <input type="email" name="email" id="email" class="inputUsuario" required>
                </div>
                <br>

                <div class="inputBox">
                    <label for="dataNascimento"> Data de Nascimento </label>
                    <input type="date" name="dataNascimento" id="dataNascimento" class="inputUsuario" required>
                </div>
                <br>

                <div class="inputBox">
                    <label for="senha"> Senha </label>
                    <input type="password" name="senha" id="senha" class="inputUsuario" required>
                </div>
                <br>
                <div class="inputBox">
                    <label for="confirmarSenha"> Confirmar Senha </label>
                    <input type="password" name="confirmarSenha" id="confirmarSenha" class="inputUsuario" required>
                </div>
                <br>

                <p>Sexo</p>
                <input type="radio" id="Masculino" name="sexo" value="Masculino" required>
                <label for="Masculino"> Masculino </label>
                <input type="radio" id="Feminino" name="sexo" value="Feminino" required>
                <label for="Feminino"> Feminino </label>

                <br>
                <input type="submit" name="submit" id="submit" value="Cadastrar">
            </form>
        </div>
    </div>
</body>

</html>