  const img = document.getElementById('img-user');
  const destino = document.getElementById('bc-user');
  const userBox = document.querySelector('.user');

  function extrairCor() {
    const canvas = document.createElement('canvas');
    canvas.width = canvas.height = 50;
    const ctx = canvas.getContext('2d');
    ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

    const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height).data;

    let r = 0, g = 0, b = 0, count = 0;

    for (let i = 0; i < imageData.length; i += 4) {
      r += imageData[i];
      g += imageData[i + 1];
      b += imageData[i + 2];
      count++;
    }

    r = Math.floor(r / count);
    g = Math.floor(g / count);
    b = Math.floor(b / count);

    const corDominante = `rgb(${r}, ${g}, ${b})`;

    // Criar versão mais clara da cor
    const rClaro = Math.min(255, r + 40);
    const gClaro = Math.min(255, g + 30);
    const bClaro = Math.min(255, b + 80);
    const corClara = `rgb(${rClaro}, ${gClaro}, ${bClaro})`;

    // Aplicar degradê
    destino.style.backgroundImage = `linear-gradient(to bottom, ${corClara}, ${corDominante})`;

    // Calcular luminosidade para decidir cor do texto
    const luminosidade = (0.299 * r + 0.587 * g + 0.114 * b);

    if (luminosidade < 180) {
      userBox.style.color = 'var(--text-dark)';
    } else {
      userBox.style.color = 'var(--text-light)';
    }
  }

  img.onload = extrairCor;
  if (img.complete) extrairCor();