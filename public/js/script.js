// Frases que o chapéu vai "pensar" durante a seleção
const frasesPensamento = [
    "Hmm... interessante...",
    "Vejo muito potencial...",
    "Que mente fascinante...",
    "Deixe-me ver...",
    "Difícil... muito difícil..."
];

// Elemento que mostra as frases de pensamento
const pensandoElement = document.getElementById("pensando");
let fraseAtual = 0;

// Troca as frases a cada 2 segundos
const intervalId = setInterval(() => {
    pensandoElement.textContent = frasesPensamento[fraseAtual];
    fraseAtual = (fraseAtual + 1) % frasesPensamento.length;
}, 2000);

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