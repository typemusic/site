<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TypeMusic</title>
    <link rel="stylesheet" href="style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
</head>

<body>
<?php include "include/menu.php"; ?>
<?php include "include/searchBar.php"; ?>


    <div class="main-content user-content">
        <div class="perfil">
            <div class="user-data-base">
                <img src="icons/icon_user.png">
                <div>
                    <h1>Carlos Henrique da Fonseca Filho</h1>
                    <h4>Olá! Sou apaixonado por desafios de digitação e velocidade. Sempre buscando aprimorar minha
                        precisão e superar recordes no teclado!</h4>
                </div>
            </div>
            <div class="user-data-plays">
                <div class="data-play">
                    <div>
                    <img src="icons/SearchBar.png" alt="">
                    <h1>52</h1>
                    </div>
                    <p>musicas</p>
                </div>
                <div class="data-play">
                    <div>
                    <img src="icons/SearchBar.png" alt="">
                    <h1>18</h1>
                    </div>
                    <p>PPM Médio</p>
                </div>
                <div class="data-play">
                    <div>
                    <img src="icons/SearchBar.png" alt="">
                    <h1>2290</h1>
                    </div>
                    <p>pontos</p>
                </div>
                <div class="data-play">
                    <div>
                    <h1>#25965</h1>
                    </div>
                    <p>Rank Atual</p>
                </div>
            </div>
        </div>
        <div class="config">

            <form class="settings-form">
                <h2>Perfil</h2>
                <label for="nome">Nome:</label>
                <input type="text" id="nome" placeholder="nome" disabled>

                <label for="email">Email:</label>
                <input type="email" id="email" placeholder="email" disabled>

                <label for="senha">Senha:</label>
                <input type="password" id="senha" placeholder="senha" disabled>

                <h2>Notificações</h2>
                <label for="emailNotif">Notificações por e-mail:</label>
                <input type="checkbox" id="emailNotif">

                <label for="smsNotif">Notificações via SMS:</label>
                <input type="checkbox" id="smsNotif">

                <h2>Privacidade</h2>
                <label for="privacidade">Visibilidade do perfil:</label>
                <select id="privacidade">
                    <option>Público</option>
                    <option>Privado</option>
                </select>

                <button type="submit">Salvar Configurações</button>
            </form>
        </div>

    </div>


    <?php include "include/footer.php"; ?>
</body>
<script src="js/index.js"></script>

</html>