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

                    // buscar a letra completa com quebras e blocos
                    fetch(`https://typemusic.hubsapiens.com.br/servidor/letra.php?id=${song.id}&type=full`)
                        .then(res => res.text())



                })
                .catch(err => {
                    console.error('Erro ao buscar dados da música:', err);
                    document.getElementById("info").innerText = "Erro ao carregar os dados da música.";
                });


            //cronometro
            let segundos = 0;
            let intervalo;

            function atualizarCronometro() {
                let minutos = Math.floor(segundos / 60);
                let segundosRestantes = segundos % 60;
                document.getElementById("cronometro").textContent = minutos + " minutos e " + segundosRestantes + " segundos";
            }

            document.getElementById("startButton").addEventListener("click", function() {
                intervalo = setInterval(function() {
                    segundos++;
                    atualizarCronometro();
                }, 1000);
            });

            //main
            let lyrics = [

            ];

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
            const info = document.getElementById("info");



            startButtonEl.addEventListener("click", startTest);

            function startTest() {
                minutos = 0;
                segundos = 0;
                currentLyricIndex = 0;
                currentLetterIndex = 0;
                correctCount = 0;
                errorCount = 0;
                updateProgress();
                showCurrentLyric();
                testAreaEl.style.display = "block";
                startButtonEl.style.display = "none";
                typingInput.value = "";
                typingInput.focus();

                
                dicas.style.display = "none";
                info.style.display = "none";

                imageContainer.style.display = "none";
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
                expectedElem.innerText = "";
                progressElem.innerText = "Teste concluído!";
                messageElem.innerText = "Parabéns, você completou o teste!";
                const percCorrect = (correctCount / (correctCount + errorCount) * 100).toFixed(2);
                statsElem.innerHTML = "Acertos: " + percCorrect + "%";
                clearInterval(intervalo);
                startButtonEl.style.display = "block";
            }

            function updateStats() {
                const totalAttempts = correctCount + errorCount;
                const percCorrect = totalAttempts > 0 ? ((correctCount / totalAttempts) * 100).toFixed(2) : 100;
                statsElem.innerHTML = "Acertos: " + percCorrect + "%";
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

            
    const urlParams = new URLSearchParams(window.location.search);
    const type = "clear";

    window.onload = function() {
        letras(type);
    };

    function letras(type) {
        var embedContent = document.querySelector(".rg_embed_body");
        if (!embedContent) {
            setTimeout(() => letras(type), 500); // tenta novamente em 0,5s
            return;
        }

        var cleanedContent = embedContent.innerHTML;
        // limpeza °-°
        cleanedContent = cleanedContent.replace(/<a[^>]*>(.*?)<\/a>/gi, '$1'); // remove a mantendo o conteúdo
        cleanedContent = cleanedContent.replace(/<\/?a[^>]*>/gi, ''); // remove a mantendo o conteúdo
        cleanedContent = cleanedContent.replace(/<br\s*\/?>/gi, '<br>'); // normaliza br
        cleanedContent = cleanedContent.replace(/<\/?[bip]>/gi, ''); // remove tags <b> e <i> e <p>
        cleanedContent = cleanedContent.replace(/<\/?center>/gi, ''); // remove tag <center>
        cleanedContent = cleanedContent.replace(/<\/?strong>/gi, ''); // remove <strong>
        cleanedContent = cleanedContent.replace(/<\/?span>/gi, ''); // remove tag <span>
        cleanedContent = cleanedContent.replace(/<\/?blockquote>/gi, ''); // remove tag <blockquote>
        cleanedContent = cleanedContent.replace(/<\/?h1>/gi, ''); // remove tags <h1>
        cleanedContent = cleanedContent.replace(/<\/?h2>/gi, ''); // remove tags <h2>
        cleanedContent = cleanedContent.replace(/<\/?h3>/gi, ''); // remove tags <h3>
        cleanedContent = cleanedContent.replace(/<\/?h4>/gi, ''); // remove tags <h4>
        cleanedContent = cleanedContent.replace(/<\/?h5>/gi, ''); // remove tags <h5>
        cleanedContent = cleanedContent.replace(/<\/?h6>/gi, ''); // remove tags <h6>
        cleanedContent = cleanedContent.replace(/<\/?ul>/gi, ''); // remove tags <ul>
        cleanedContent = cleanedContent.replace(/<\/?ol>/gi, ''); // remove tags <ol>
        cleanedContent = cleanedContent.replace(/<\/?li>/gi, ''); // remove tags <li>
        cleanedContent = cleanedContent.replace(/<\/?hr>/gi, ''); // remove tags <hr>

        if (type == "full") {
            // Sem alterações
        }
        if (type == "clear") {
            cleanedContent = cleanedContent.replace(/\[[^\]]+\]/g, ''); // remove [Refrão], [Verso], etc
            cleanedContent = cleanedContent.replace(/(<br>\s*){2,}/gi, '<br><br>'); // evita múltiplos br
            cleanedContent = cleanedContent.replace(/<br\s*\/?>/, ''); // remove o primeiro br
        }
        if (type == "line") {
            cleanedContent = cleanedContent.replace(/<br>/gi, ''); // remove todos os br
            cleanedContent = cleanedContent.replace(/\[[^\]]+\]/g, ''); // remove [Refrão], [Verso], etc
        }


        // Transforma em array de linhas 
        lyrics = cleanedContent.split('<br>').map(linha => linha.trim());

        // limpando array 
        lyrics = lyrics
            .map(line => line.replace("\n", " ").trim()) // Substituir \n por espaço e remover espaços extras
            .filter(line => line !== ""); // Filtrar linhas vazias        
    }