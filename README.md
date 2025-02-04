# Chapéu Seletor de Hogwarts 🎩✨

## Sobre o Projeto
O Chapéu Seletor é uma aplicação web inspirada no universo de Harry Potter, que simula o famoso processo de seleção das casas de Hogwarts. O sistema analisa a descrição fornecida pelo aluno e, através de um algoritmo especial, determina qual casa melhor combina com suas características: Grifinória, Sonserina, Corvinal ou Lufa-Lufa.

 Este pequeno projeto, permite que os alunos se conectem ao grupo de trabalho do curso de desenvolvimento de sistemas, e sejam selecionados para as casas de Hogwarts, criando mais afinidade e tornando o ambiente entre os alunos mais agradavel.


## Funcionalidades 🌟

- **Cadastro de Alunos**: Permite registrar novos alunos com nome, turma e uma descrição pessoal
- **Seleção de Casas**: Analisa o perfil do aluno e determina sua casa em Hogwarts
- **Animação de Seleção**: Simula o momento de "pensamento" do Chapéu Seletor
- **Relatório Detalhado**: Exibe estatísticas e lista completa dos alunos e suas respectivas casas
- **Perfil Personalizado**: Gera uma análise detalhada das características do aluno

## Tecnologias Utilizadas 🚀

- PHP 7.4+
- MySQL
- HTML5
- CSS3
- JavaScript
- PDO para conexão com banco de dados

## Requisitos do Sistema 📋

- Servidor web (Apache/Nginx)
- PHP 7.4 ou superior
- MySQL 5.7 ou superior
- Extensão PDO PHP habilitada

## Instalação 🛠️

1. Clone o repositório:
```bash
git clone https://github.com/rafaelbernini/seletor-harry-potter.git
```

2. Configure o banco de dados:
- Crie um banco de dados MySQL
- Importe o arquivo `database.sql`
- Configure as credenciais no arquivo `config.php`

3. Configure o servidor web:
- Aponte o document root para a pasta `public/`
- Certifique-se que o mod_rewrite está habilitado (Apache)

4. Configure as permissões:
```bash
chmod 755 -R seletor-harry-potter/
chmod 777 -R seletor-harry-potter/public/img/
```

## Estrutura do Projeto 📁

```
seletor-harry-potter/
├── app/
│   ├── controllers/
│   │   └── SeletorController.php
│   ├── models/
│   │   └── Aluno.php
│   ├── views/
│   │   ├── cadastro.php
│   │   ├── resultado.php
│   │   └── relatorio.php
│   └── core/
│       └── Database.php
├── public/
│   ├── css/
│   ├── js/
│   ├── img/
│   └── index.php
└── config.php
```

## Como Usar 📝

1. **Cadastro de Aluno**:
   - Acesse a página inicial
   - Preencha o nome do aluno
   - Selecione a turma (DEV32025)
   - Escreva uma descrição detalhada sobre o aluno
   - Clique em "Cadastrar"

2. **Processo de Seleção**:
   - Após o cadastro, o Chapéu Seletor iniciará sua análise
   - Aguarde 10 segundos enquanto o chapéu "pensa"
   - O resultado será exibido com a casa escolhida e um perfil detalhado

3. **Visualização do Relatório**:
   - Clique em "Ver Relatório" para acessar as estatísticas
   - Veja a distribuição de alunos por casa
   - Consulte a lista completa de alunos selecionados

## Critérios de Seleção 🎯

O sistema analisa as seguintes características para cada casa:

- **Grifinória**: Coragem, bravura, determinação, força, heroísmo, ousadia
- **Sonserina**: Ambição, astúcia, liderança, poder, estratégia, determinação
- **Corvinal**: Inteligência, sabedoria, conhecimento, criatividade, estudo
- **Lufa-Lufa**: Lealdade, dedicação, trabalho, paciência, justiça, honestidade

## Contribuindo 🤝

1. Faça um Fork do projeto
2. Crie uma Branch para sua Feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a Branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## Licença 📄

Este projeto está sob a licença MIT. Veja o arquivo `LICENSE` para mais detalhes.

## Contato 📧

Seu Nome - [seu-email@exemplo.com]

Link do Projeto: [https://github.com/seu-usuario/seletor-harry-potter](https://github.com/seu-usuario/seletor-harry-potter)

---
⚡️ Desenvolvido com magia por [Seu Nome]
