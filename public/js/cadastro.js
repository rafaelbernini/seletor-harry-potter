async function gerarDescricaoIA(nome) {
    const button = document.querySelector('#gerarDescricao');
    button.disabled = true;
    button.textContent = 'Gerando descrição...';

    try {
        const response = await fetch(BASE_URL + '?action=gerarDescricao', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ nome: nome })
        });

        if (!response.ok) {
            throw new Error('Erro ao comunicar com o servidor');
        }

        const data = await response.json();
        
        if (data.erro) {
            throw new Error(data.erro);
        }

        document.querySelector('#descricao').value = data.descricao;
        document.querySelector('#casa').value = data.casa;
        
    } catch (error) {
        console.error('Erro:', error);
        alert('Erro ao gerar descrição: ' + error.message);
    } finally {
        button.disabled = false;
        button.textContent = 'Gerar Descrição com IA';
    }
} 