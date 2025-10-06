<?php


session_start();

if (!isset($_SESSION['usuario'])) {
  header("Location: login.php");
  exit();
}

$usuario = $_SESSION['usuario'];

if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] === 0) {
  $pastaUploads = "uploads/";
  if (!is_dir($pastaUploads)) {
    mkdir($pastaUploads, 0777, true);
  }

  $nomeArquivo = basename($_FILES["foto"]["name"]);
  $destino = $pastaUploads . uniqid() . "-" . $nomeArquivo;

  if (move_uploaded_file($_FILES["foto"]["tmp_name"], $destino)) {

    $usuario["foto"] = $destino;
    $_SESSION['usuario'] = $usuario;


    require_once "servidor/connect.php";

    $pdo = novaConexao();

    $idUsuario = $usuario['id'];

    $stmt = $pdo->prepare("UPDATE tblUsuario SET usrPerfil = :foto WHERE IDusuario = :id");
    $stmt->execute(['foto' => $destino, 'id' => $idUsuario]);

    $mensagem = "Upload realizado com sucesso!";
  } else {
    $mensagem = "Erro ao mover o arquivo!";
  }
}





?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TypeMusic</title>
  <link rel="stylesheet" href="style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded" rel="stylesheet" />
  <link rel="icon" href="img/favicon.png" type="image/png">
  <style>

  </style>
</head>

<body>

  <?php include "include/menu.php"; ?>
  <?php include "include/searchBar.php"; ?>

  <div class="main-content">
    <div class="banner background-user" id="bc-user">
      <div class="user">
        <div class="user-photo-wrapper">
          <img id="img-user" src="<?= $usuario['foto'] ?? 'img/user.png' ?>" alt="Foto do usuário" />

          <!-- input escondido -->
          <form id="form-foto" action="./perfil.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="foto" id="input-foto" accept="image/*" style="display: none;">
          </form>
        </div>
        <div>
          <h2 id="name"><?= $usuario['nome'] ?></h2>
          <div id="situation">
            <span class="status-icon online"></span>
            <p>Online</p>
          </div>
        </div>
      </div>
    </div>
    <div class="user-data">
      <div>
        <h2>46</h2>
        <p>Músicas</p>
      </div>
      <div>
        <h2>25 </h2>
        <p>PPM</p>
      </div>
      <div>
        <h2>546</h2>
        <p>Pontos</p>
      </div>
      <div>
        <h2>#203</h2>
        <p>Rank</p>
      </div>

    </div>
    <h2>Recentes</h2>
    <div class="recents-music-user">

    </div>

    <?php include "include/footer.php"; ?>

  </div>

  <script>
    const imgUser = document.getElementById('img-user');
    const inputFoto = document.getElementById('input-foto');
    const formFoto = document.getElementById('form-foto');


    imgUser.addEventListener('click', () => {
      inputFoto.click();
    });


    inputFoto.addEventListener('change', () => {
      formFoto.submit();
    });
  </script>

</body>

</html>