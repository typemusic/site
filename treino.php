<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$music = isset($_GET['music']) ? htmlspecialchars($_GET['music']) : null;

if (empty($music)) {
    echo "Erro: Nenhum ID de música foi fornecido.";
}

// Gerando o código com o ID inserido
echo '
    <div id="rg_embed_link_' . $music . '" class="rg_embed_link" data-song-id="' . $music . '">
        <script src="//genius.com/songs/' . $music . '/embed.js" crossorigin=""></script>
    </div>';

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TypeMusic</title>
    <link rel="stylesheet" href="style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded" rel="stylesheet" />
    <link rel="icon" href="img/favicon.png" type="image/png">
</head>

<!-- 
    _   __                      
   / | / /_  ______ _____  __/|_
  /  |/ / / / / __ `/ __ \|    /   
 / /|  / /_/ / /_/ / / / /_ __| 
/_/ |_/\__, /\__,_/_/ /_/ |/    
      /____/                    

       _                   _____         _                     
      | |                 |  __ \       | |            
      | | ___   __ _  ___ | |__) |__  __| |_ __ ___   
  _   | |/ _ \ / _` |/ _ \|  ___/ _ \/ _` | '__/ _ \    
 | |__| | (_) | (_| | (_) | |  |  __/ (_| | | | (_) |  
  \____/ \___/ \__,_|\___/|_|   \___|\__,_|_|  \___/    
                                                                 
  ______    _     _       
 |  ____|  | |   (_)      
 | |__ __ _| |__  _  ___  
 |  __/ _` | '_ \| |/ _ \ 
 | | | (_| | |_) | | (_) |
 |_|  \__,_|_.__/|_|\___/ 
                          
    _____       _ _ _                              
  / ____|     (_) | |                             
 | |  __ _   _ _| | |__   ___ _ __ _ __ ___   ___ 
 | | |_ | | | | | | '_ \ / _ \ '__| '_ ` _ \ / _ \
 | |__| | |_| | | | | | |  __/ |  | | | | | |  __/
  \_____|\__,_|_|_|_| |_|\___|_|  |_| |_| |_|\___|
                                                
-->

<body>
    <?php include "include/menu.php"; ?>
    <?php include "include/searchBar.php"; ?>

    <div class="main-content">
        <div class="music-box" style="width: 100%;">
             <div id="test-area" style="display: none; width: 100%;">
                <div id="progress"></div>
                <div id="expectedLyric">Aguardando letra...</div>
                <div id="image-container"><img id="dynamic-image" src="img/spaco.png" alt="Imagem ativada pelo espaço">
                </div>
                <input type="text" id="typingInput" placeholder="Digite aqui a letra mostrada" maxlength="1" autofocus>
                <div id="message"></div>
                <div id="stats"></div>
                <p id="cronometro">0 segundos</p>
            </div>
            <div class="dicas" id="dicas">
                <h1>Treino de Digitação</h1>
                <ul>
                    <li>
                        <b>Evite olhar para o teclado:</b> Forçar a memória muscular ajuda a digitar mais rápido e com
                        precisão, sem distrações.
                    </li>
                    <li>
                        <b>Mantenha os dedos na posição correta:</b> Coloque os dedos sobre as teclas F e J, que são as
                        referências para os dedos indicadores. Isso ajuda a melhorar a agilidade e precisão.
                    </li>
                    <li>
                        <b>Use todos os dedos:</b> Tente evitar digitar apenas com os dedos indicadores. Ao utilizar todos
                        os dedos, a digitação se torna mais rápida e menos cansativa.
                    </li>
                    <li>
                        <b>Pratique a digitação com postura correta:</b> Sente-se de forma confortável, com os ombros
                        relaxados, e os cotovelos a 90 graus. A posição adequada evita lesões e facilita movimentos mais
                        rápidos.
                    </li>
                </ul>
            </div>
            <div class="song-info">
                <div id="info"></div>
                <button class="start-button" id="startButton" onclick="startTest()">Iniciar Teste</button>
            </div>
        </div>
    </div>
    <script>
        //buscar os dados da música (nome, capa, artista...)
        fetch('https://typemusic.hubsapiens.com.br/servidor/info.php?id=<?php echo $music; ?>')
            .then(res => res.json())
            .then(data => {
                const song = data.response.song;
                const infoDiv = document.getElementById('info');
                infoDiv.innerHTML = `
      <img src="${song.song_art_image_url}" alt="Capa da música" />
      <a href="${song.url}" target="_blank"><p class="song-title"><h1>${song.title}</h1></p></a>
      <a href="${song.primary_artist.url}" target="_blank"><h2><p class="artist-name"></h2>${song.primary_artist.name}</p></a>
      `;

            })
            .catch(err => {
                console.error('Erro ao buscar dados da música:', err);
                document.getElementById("info").innerText = "Erro ao carregar os dados da música.";
            });

        window.onload = function() {
            letras();
        };

        function letras() {
            var embedContent = document.querySelector(".rg_embed_body");
            if (!embedContent) {
                setTimeout(() => letras(), 250); // tenta novamente em 0,5s
                return;
            }

            var cleanedContent = embedContent.innerHTML;
            // limpeza °-°
            cleanedContent = cleanedContent
                .replace(/<a[^>]*>(.*?)<\/a>/gi, '$1') // remove <a> mantendo o conteúdo
                .replace(/<\/?a[^>]*>/gi, '') // remove <a> restante
                .replace(/<br\s*\/?>/gi, '<br>') // normaliza <br>
                .replace(/<\/?[bip]>/gi, '') // remove <b>, <i>, <p>
                .replace(/<\/?center>/gi, '') // remove <center>
                .replace(/<\/?strong>/gi, '') // remove <strong>
                .replace(/<\/?span>/gi, '') // remove <span>
                .replace(/<\/?blockquote>/gi, '') // remove <blockquote>
                .replace(/<\/?h[1-6]>/gi, '') // remove <h1> a <h6>
                .replace(/<\/?ul>/gi, '') // remove <ul>
                .replace(/<\/?ol>/gi, '') // remove <ol>
                .replace(/<\/?li>/gi, '') // remove <li>
                .replace(/<\/?hr>/gi, '') // remove <hr>
                .replace(/\[[^\]]+\]/g, '') // remove [Refrão], [Verso], etc
                .replace(/(<br>\s*){2,}/gi, '<br><br>') // evita múltiplos br
                .replace(/<br\s*\/?>/, '') // remove o primeiro br
                .replace(/\n/g, '<br>') // troca \n
                .replace(/\\n/g, '<br>') // troca \n
            fv = "Ozbo*"
            let lyricsEspaco = cleanedContent.replace(/<\/?br>/gi, ' '); // troca tags <br> por espaco
            let lyricsCaractere = lyricsEspaco.replace(/\s+/g, ''); // Retira os espacos
            lyricsCaractere = lyricsCaractere.split('').map(caractere => caractere
                .trim()); // transforma em array de caracteres
            lyricsEspaco = lyricsEspaco.split(' ').map(espaco => espaco.trim()); // transforma em array de palavras
            palavras = lyricsEspaco.length
            caracteres = lyricsCaractere.length
            console.log(fv);


            // Transforma em array de linhas 
            lyrics = cleanedContent.split('<br>').map(linha => linha.trim());

            // limpando array 
            lyrics = lyrics
                .map(line => line.replace("\n", " ").trim()) // Substituir \n por espaço e remover espaços extras
                .filter(line => line !== ""); // Filtrar linhas vazias     

            lyricsEspaco = lyricsEspaco
                .map(line => line.replace("\n", " ").trim()) // Substituir \n por espaço e remover espaços extras
                .filter(line => line !== ""); // Filtrar linhas vazias  

            lyricsCaractere = lyricsCaractere
                .map(line => line.replace("\n", " ").trim()) // Substituir \n por espaço e remover espaços extras
                .filter(line => line !== ""); // Filtrar linhas vazias  


            return lyrics;
        }


        //cronometro
        let segundos = 0;
        let intervalo;

        function atualizarCronometro() {
            let minutos = Math.floor(segundos / 60);
            let segundosRestantes = segundos % 60;
            document.getElementById("cronometro").textContent = minutos + " minutos e " + segundosRestantes +
                " segundos";
        }

        function enviarInfos(ppm, pontos, percCorrect) {
            let valor = "ppm";

            fetch("treino.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "variavel=" + encodeURIComponent(valor)
            });
        }


        function iniciarCronometro() {
            if (intervalo) return; // evita múltiplos intervalos
            intervalo = setInterval(() => {
                segundos++;
                atualizarCronometro();
            }, 1000);
        }

        function pausarCronometro() {
            clearInterval(intervalo);
            intervalo = null;
        }

        let currentLyricIndex = 0;
        let currentLetterIndex = 0;
        let correctCount = 0;
        let errorCount = 0;

        const startButtonEl = document.getElementById("startButton");
        const testAreaEl = document.getElementById("test-area");
        const expectedElem = document.getElementById("expectedLyric");
        const typingInput = document.getElementById("typingInput");
        const progressElem = document.getElementById("progress");
        const messageElem = document.getElementById("message");
        const statsElem = document.getElementById("stats");
        const imageContainer = document.getElementById("image-container");
        const dicas = document.getElementById("dicas");

        lyrics = letras();


        startButtonEl.addEventListener("click", startTest);


        function startTest() {
            if (!lyrics || lyrics.length === 0) {
                window.alert("Letra não carregada ou Música sem letra!")
                return false
            } else {
                minutos = 0;
                segundos = 0;
                currentLyricIndex = 0;
                currentLetterIndex = 0;
                correctCount = 0;
                errorCount = 0;
                updateProgress();
                showCurrentLyric();
                iniciarCronometro()
                testAreaEl.style.display = "block";
                startButtonEl.style.display = "none";
                typingInput.value = "";
                typingInput.focus();
                dicas.style.display = "none";
                imageContainer.style.display = "none";
                return true
            }
        }



        function showCurrentLyric() {
            if (currentLyricIndex < lyrics.length) {
                currentLetterIndex = 0;
                messageElem.innerText = "";
                updateProgress();
                updateLetterHighlight();
            } else {
                finishTest();
            }
            typingInput.value = "";
        }

        function updateLetterHighlight() {
            const fullLyric = lyrics[currentLyricIndex];
            let displayLyric = "";
            for (let i = 0; i < fullLyric.length; i++) {
                if (i === currentLetterIndex) {
                    displayLyric += `<span class="highlight-letter">${fullLyric.charAt(i)}</span>`;

                } else {
                    displayLyric += fullLyric.charAt(i);
                }
            }
            expectedElem.innerHTML = displayLyric;

            if (fullLyric.charAt(currentLetterIndex) === " ") {
                showImage();
            } else {
                imageContainer.style.display = "none";
            }

        }



        function updateProgress() {
            progressElem.innerText = "Linha " + (currentLyricIndex + 1) + " de " + lyrics.length;
        }

        function finishTest() {
            let palavraMedia = palavras / caracteres
            ppm = palavraMedia / segundos * 60 // palavras por minuto
            ppm = parseFloat(ppm.toFixed(2)) // arrendondar
            // cara que linguagem ruim, odeio js, como os cara não
            // faz uma função de arrendondar que volta double

            cpm = caracteres / segundos
            cpm = parseFloat(cpm.toFixed(2))

            percCorrect = parseFloat(updateStats())
            expectedElem.innerText = "";
            progressElem.innerText = "Teste concluído!";
            // velocidade * precisão * tamanho / tempo
            pontos = ppm * percCorrect * caracteres / segundos;
            pontos = parseFloat(pontos.toFixed(2)) // arredondar
            messageElem.innerText = "Parabéns, você completou o teste! pontos:" + pontos;
            pausarCronometro()
            startButtonEl.style.display = "block";
            enviarInfos(ppm, pontos, percCorrect)

            window.location.href = "https://localhost/music/treinoRelatorio.php";
        }

        function updateStats() {
            const totalAttempts = correctCount + errorCount;
            const percCorrect = totalAttempts > 0 ? ((correctCount / totalAttempts) * 100).toFixed(2) : 100;
            statsElem.innerHTML = "Acertos: " + percCorrect + "%";
            return percCorrect
        }

        typingInput.addEventListener("input", function() {
            if (typingInput.value.length > 0) {
                // Obtém o caractere esperado da letra atual
                let expectedLetter = lyrics[currentLyricIndex].charAt(currentLetterIndex);
                let typedLetter = typingInput.value.charAt(0);

                if (typedLetter === expectedLetter) {
                    correctCount++;
                    currentLetterIndex++;
                    typingInput.value = "";


                    if (currentLetterIndex < lyrics[currentLyricIndex].length) {
                        updateLetterHighlight();
                    } else {
                        currentLyricIndex++;
                        showCurrentLyric();
                    }
                } else {
                    errorCount++;
                    messageElem.innerText = "Letra incorreta. Tente novamente.";
                    typingInput.value = "";
                }
            }
        });


        function showImage() {
            imageContainer.style.display = "block";
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- JQUERY p/ ajax -->
</body>

</html>