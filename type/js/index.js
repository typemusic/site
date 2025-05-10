const carousel = document.querySelector('.carousel');
const prevBtn = document.querySelector('.prev');
const nextBtn = document.querySelector('.next');

let scrollAmount = 0;
const scrollPerClick = 650; // deve-se ajustar

nextBtn.addEventListener('click', () => {
  carousel.scrollBy({ left: scrollPerClick, behavior: 'smooth' });
});

prevBtn.addEventListener('click', () => {
  carousel.scrollBy({ left: -scrollPerClick, behavior: 'smooth' });
});