<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

   

<body>

     <?php 
    include "include/menu.php";
    ?>

    <div class="container-cadastro">
        <div class="container-formulario">
            <form action="login.php" method="post">
                <div class="inputBox">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" class="inputUsuario">
                </div>
                <br>
                <div class="inputBox">
                    <label for="senha">Senha</label>
                    <input type="password" name="senha" id="senha" class="inputUsuario">
                </div>

                <br>
                <input type="submit" id="submit" value="Cadastrar">

            </form>
        </div>
    </div>
</body>

</html>