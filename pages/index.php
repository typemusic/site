<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TypeMusic</title>
  <link rel="stylesheet" href="../style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded" rel="stylesheet" />
  <link rel="icon" href="img/favicon.png" type="image/png">
</head>

<body>
  
  <?php include "../include/menu.php"; ?>
  <?php include "../include/searchBar.php"; ?>

  <div class="main-content">

    <img src="../img/banner.png" class="banner">
    <section class="carousels">
      <h3>Recomendadas</h3>
      <div class="carousel-container">
        <button class="button-carousel prev">&#10094;</button>
        <div class="carousel" id="carousel-recomendadas">
          <!-- As músicas recomendadas serão carregadas aqui -->
        </div>
        <button class="button-carousel next">&#10095;</button>
      </div>

      <h3>Mais Ouvidas</h3>
      <div class="carousel-container">
        <button class="button-carousel prev">&#10094;</button>
        <div class="carousel" id="carousel-mais-ouvidas">
          <!-- As músicas mais ouvidas serão carregadas aqui -->
        </div>
        <button class="button-carousel next">&#10095;</button>
      </div>

      <h3>Mais Treinadas</h3>
      <div class="carousel-container">
        <button class="button-carousel prev">&#10094;</button>
        <div class="carousel" id="carousel-mais-treinadas">
          <!-- As músicas mais treinadas serão carregadas aqui -->
        </div>
        <button class="button-carousel next">&#10095;</button>
      </div>
    </section>
    <?php include "../include/footer.php"; ?>

  </div>
  <script src="js/index.js"></script>
<script src="js/theme.js"></script>

</body>

</html>