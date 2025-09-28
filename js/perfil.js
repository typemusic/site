// Seleciona os elementos
const userPhotoWrapper = document.querySelector('.user-photo-wrapper');
const inputFoto = document.getElementById('input-foto');
const formFoto = document.getElementById('form-foto');
const imgUser = document.getElementById('img-user');

// Ao clicar na foto, abre o input escondido
userPhotoWrapper.addEventListener('click', () => {
    inputFoto.click();
});

// Quando o usuário selecionar uma imagem
inputFoto.addEventListener('change', () => {
    // Cria FormData para enviar via POST
    const formData = new FormData(formFoto);

    fetch('upload_foto.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json()) // esperamos JSON de resposta
    .then(data => {
        if (data.success) {
            // Atualiza a imagem na página
            imgUser.src = data.url + '?t=' + new Date().getTime(); // evita cache
        } else {
            alert('Erro ao enviar imagem: ' + data.error);
        }
    })
    .catch(err => {
        console.error(err);
        alert('Erro ao enviar imagem');
    });
});
