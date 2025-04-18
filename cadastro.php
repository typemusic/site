<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="box">
        <form action="">
            <div class="inputBox">
                <label for="nome"> Nome </label>
                <input type="text" name="nome" id="nome" class="inputUsuario" required>
            </div>
            <div class="inputBox">
                <label for="email"> Email </label>
                <input type="email" name="email" id="email" class="inputUsuario" required>
            </div>
            <div class="inputBox">
                <label for="dataNascimento"> Data de Nascimento </label>
                <input type="date" name="dataNascimento"" id =" dataNascimento"" class="inputUsuario" required>
            </div>
            <div class="inputBox">
                <label for="senha"> Senha </label>
                <input type="password" name="senha"" id =" senha"" class="inputUsuario" required>
            </div>
            <div class="inputBox">
                <label for="senha"> Confirmar Senha </label>
                <input type="password" name="senha"" id =" senha"" class="inputUsuario" required>
            </div>
            <p>Sexo</p>
            <input type="radio" id="Masculino" name="sexo" value=" Masculino " required>
            <label for="Masculino"> Masculino </label>
            <input type="radio" id="Feminino" name="sexo" value=" Feminino " required>
            <label for="Feminino"> Feminino </label>
        </form>
    </div>

</body>

</html>