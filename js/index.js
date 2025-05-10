// Selecionando todos os carrosseis e seus respectivos botões
document.querySelectorAll('.carousel-container').forEach(container => {
  const carousel = container.querySelector('.carousel');
  const prevBtn = container.querySelector('.prev');
  const nextBtn = container.querySelector('.next');

  let scrollAmount = 0;
  const scrollPerClick = 650; // Ajuste do número de pixels para cada clique

  // Ação para o botão "next"
  nextBtn.addEventListener('click', () => {
    carousel.scrollBy({ left: scrollPerClick, behavior: 'smooth' });
  });

  // Ação para o botão "prev"
  prevBtn.addEventListener('click', () => {
    carousel.scrollBy({ left: -scrollPerClick, behavior: 'smooth' });
  });
});
