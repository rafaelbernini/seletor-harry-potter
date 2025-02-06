// Frases que o chapéu vai "pensar" durante a seleção (em ordem aleatória)
const frasesPensamento = [
    "Hmm... interessante...",
    "Vejo muito potencial...",
    "Que mente fascinante...",
    "Deixe-me ver...",
    "Difícil... muito difícil...",
    "Ah, que escolha intrigante...",
    "Muita coragem, vejo aqui...",
    "Que mente brilhante...",
    "Bastante ambição...",
    "Vejo grandes conquistas...",
    "Muita determinação...",
    "Uma mente única...",
    "Que personalidade forte...",
    "Escolhas, escolhas...",
    "Muito talento, sem dúvida..."
];

// Elemento que mostra as frases de pensamento
const pensandoElement = document.getElementById("pensando");
let fraseAtual = 0;

// Função para obter uma frase aleatória
function getFraseAleatoria() {
    return frasesPensamento[Math.floor(Math.random() * frasesPensamento.length)];
}

// Troca as frases a cada 1 segundos de forma aleatória
const intervalId = setInterval(() => {
    pensandoElement.textContent = getFraseAleatoria();
}, 1000);

// Após 10 segundos, mostra o resultado
setTimeout(() => {
    // Para o intervalo das frases
    clearInterval(intervalId);
    
    // Esconde o container de seleção com uma transição suave
    document.getElementById("selecao-container").style.opacity = "0";
    setTimeout(() => {
        document.getElementById("selecao-container").style.display = "none";
        
        // Mostra o resultado e os botões com uma transição suave
        const resultado = document.getElementById("resultado");
        const botoes = document.getElementById("botoes");
        
        resultado.style.display = "block";
        botoes.style.display = "block";
        
        setTimeout(() => {
            resultado.style.opacity = "1";
            botoes.style.opacity = "1";
        }, 100);
    }, 1000);
}, 10000);