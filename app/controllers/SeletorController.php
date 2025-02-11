<?php

require_once 'C:/xampp/htdocs/seletor-harry-potter/app/models/Aluno.php';
require_once 'C:/xampp/htdocs/seletor-harry-potter/app/services/GeminiService.php';

class SeletorController {
    private $db;
    private $geminiService;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->geminiService = new GeminiService();
    }

    public function index() {
        require_once 'C:/xampp/htdocs/seletor-harry-potter/app/views/cadastro.php';
    }

    public function cadastrar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nome = $_POST['nome'] ?? '';
            $turma = $_POST['turma'] ?? '';
            $descricao = $_POST['descricao'] ?? '';
            
            try {
                // Verifica se já existe um registro com este nome
                $stmt = $this->db->prepare("SELECT id FROM alunos WHERE nome = ?");
                $stmt->execute([$nome]);
                
                if ($stmt->rowCount() > 0) {
                    // Atualiza o registro existente
                    $stmt = $this->db->prepare("UPDATE alunos SET turma = ?, descricao = ? WHERE nome = ?");
                    $stmt->execute([$turma, $descricao, $nome]);
                } else {
                    // Insere novo registro
                    $stmt = $this->db->prepare("INSERT INTO alunos (nome, turma, descricao) VALUES (?, ?, ?)");
                    $stmt->execute([$nome, $turma, $descricao]);
                }

                // Redireciona para a página de resultado
                $alunoId = $this->db->lastInsertId();
                header("Location: ?action=selecionar&id=" . $alunoId);
                exit;
            } catch (Exception $e) {
                echo "<script>alert('Erro ao cadastrar aluno: " . $e->getMessage() . "');</script>";
                require_once 'app/views/cadastro.php';
            }
        }
    }

    public function selecionar() {
        $database = new Database();
        $db = $database->getConnection();
        $alunoModel = new Aluno($db);

        $alunoId = $_GET['id'];

        // Busca TODOS os dados do aluno no banco de dados
        $stmt = $db->prepare("SELECT * FROM alunos WHERE id = :id");
        $stmt->bindParam(":id", $alunoId);
        $stmt->execute();
        $aluno = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$aluno) {
            die("Aluno não encontrado");
        }

        $descricao = $aluno['descricao'];

        // Simula a chamada da API
        $perfil = $this->chamarAPI($descricao);

        // Determina a casa com base no perfil
        $casa = $this->definirCasa($perfil);

        // Atualiza a casa do aluno no banco de dados
        if ($alunoModel->updateCasa($alunoId, $casa, $perfil)) {
            // Atualiza o array $aluno com os novos dados
            $aluno['casa'] = $casa;
            $aluno['perfil'] = $perfil;
            
            require_once 'C:/xampp/htdocs/seletor-harry-potter/app/views/resultado.php';
        } else {
            echo "Erro ao atualizar a casa do aluno.";
        }
    }
    private function chamarAPI($descricao) {
        // Simulação local do Chapéu Seletor
        $descricaoLower = strtolower($descricao);
        
        // Arrays de palavras-chave para cada tipo de perfil
      
        $palavrasChave = [
            'grifinoria' => ['coragem', 'bravura', 'determinação', 'força', 'heroísmo', 'ousadia', 'nobreza'],
            'sonserina' => ['ambição', 'astúcia', 'liderança', 'poder', 'estratégia', 'determinação', 'orgulho'],
            'corvinal' => ['inteligência', 'sabedoria', 'conhecimento', 'criatividade', 'estudo', 'aprendizado', 
                          'curiosidade', 'lógica', 'raciocínio', 'pesquisa', 'inovação', 'descoberta'],
            'lufa_lufa' => ['lealdade', 'dedicação', 'trabalho', 'paciência', 'justiça', 'honestidade', 'bondade']
        ];
        
        // Contagem de palavras-chave encontradas
        $pontos = [
            'grifinoria' => 0,
            'sonserina' => 0,
            'corvinal' => 0,
            'lufa_lufa' => 0
        ];
        
        // Analisa a descrição em busca de palavras-chave
        foreach ($palavrasChave as $casa => $palavras) {
            foreach ($palavras as $palavra) {
                if (strpos($descricaoLower, $palavra) !== false) {
                    $pontos[$casa]++;
                }
            }
        }
        
        // Adiciona verificação de distribuição
        $database = new Database();
        $db = $database->getConnection();
        $aluno = new Aluno($db);

        $distribuicao = [
            'grifinoria' => $aluno->getAlunosByCasa("Grifinória"),
            'sonserina' => $aluno->getAlunosByCasa("Sonserina"),
            'corvinal' => $aluno->getAlunosByCasa("Corvinal"),
            'lufa_lufa' => $aluno->getAlunosByCasa("Lufa-Lufa")
        ];

        // Se alguma casa estiver com menos alunos, aumenta suas chances
        $casaMenosAlunos = array_search(min($distribuicao), $distribuicao);
        if (max($distribuicao) - min($distribuicao) >= 2) {
            $pontos[$casaMenosAlunos] += 2; // Bônus para casa com menos alunos
        }
        
        // Determina o perfil baseado nas palavras encontradas
        $casaMaiorPontuacao = array_search(max($pontos), $pontos);
        
        // Perfis pré-definidos para cada casa
        $perfis = [
            'grifinoria' => "Demonstra notável coragem e determinação. Uma pessoa de forte caráter, que não hesita em defender suas convicções e proteger os outros. Possui a bravura característica dos verdadeiros Grifinórios.",
            'sonserina' => "Revela grande ambição e astúcia em suas palavras. Demonstra capacidade de liderança e determinação para alcançar seus objetivos. Possui a perspicácia típica dos Sonserinos.",
            'corvinal' => "Apresenta uma mente brilhante e sede de conhecimento. Valoriza a sabedoria e a criatividade, sempre buscando aprender mais. Tem a inteligência característica dos Corvinais.",
            'lufa_lufa' => "Mostra excepcional lealdade e dedicação. Valoriza o trabalho árduo e o tratamento justo a todos. Possui a bondade e perseverança típicas dos Lufa-Lufas."
        ];
        
        // Se nenhuma palavra-chave foi encontrada, escolhe aleatoriamente
        if (max($pontos) == 0) {
            $casaMaiorPontuacao = array_rand($perfis);
        }
        
        return $perfis[$casaMaiorPontuacao];
    }

    private function definirCasa($perfil) {
        // Converte o texto para minúsculas para facilitar a comparação
        $perfilLower = strtolower($perfil);
        
        // Array com palavras-chave para cada casa
        $caracteristicas = [
            'Grifinória' => ['coragem', 'bravura', 'determinação', 'ousadia', 'nobreza', 'lealdade'],
            'Sonserina' => ['ambição', 'astúcia', 'determinação', 'liderança', 'engenhosidade', 'perspicácia'],
            'Corvinal' => ['inteligência', 'sabedoria', 'criatividade', 'originalidade', 'conhecimento', 
                          'curiosidade', 'lógica', 'raciocínio', 'pesquisa', 'inovação', 'descoberta'],
            'Lufa-Lufa' => ['dedicação', 'lealdade', 'paciência', 'justiça', 'trabalho', 'honestidade']
        ];
        
        // Contadores para cada casa
        $pontos = [
            'Grifinória' => 0,
            'Sonserina' => 0,
            'Corvinal' => 0,
            'Lufa-Lufa' => 0
        ];
        
        // Calcula pontos para cada casa baseado nas características encontradas
        foreach ($caracteristicas as $casa => $palavrasChave) {
            foreach ($palavrasChave as $palavra) {
                if (strpos($perfilLower, $palavra) !== false) {
                    $pontos[$casa]++;
                }
            }
        }
        
        // Encontra a casa com mais pontos
        $casaEscolhida = array_search(max($pontos), $pontos);
        
        // Se houver empate, escolhe aleatoriamente entre as casas empatadas
        $maxPontos = max($pontos);
        $casasEmpatadas = array_keys(array_filter($pontos, function($p) use ($maxPontos) {
            return $p == $maxPontos;
        }));
        
        if (count($casasEmpatadas) > 1) {
            $casaEscolhida = $casasEmpatadas[array_rand($casasEmpatadas)];
        }
        
        // Verifica a distribuição atual
        $database = new Database();
        $db = $database->getConnection();
        $aluno = new Aluno($db);

        $distribuicao = [
            'Grifinória' => $aluno->getAlunosByCasa("Grifinória"),
            'Sonserina' => $aluno->getAlunosByCasa("Sonserina"),
            'Corvinal' => $aluno->getAlunosByCasa("Corvinal"),
            'Lufa-Lufa' => $aluno->getAlunosByCasa("Lufa-Lufa")
        ];

        // Se houver desbalanceamento significativo
        if (max($distribuicao) - min($distribuicao) >= 2) {
            $casaMenosAlunos = array_search(min($distribuicao), $distribuicao);
            return $casaMenosAlunos;
        }
        
        return $casaEscolhida;
    }

    public function relatorio() {
        try {
            // Inicializa as estatísticas com as casas corretas
            $estatisticas = [
                'Grifinória' => 0,
                'Sonserina' => 0,
                'Corvinal' => 0,
                'Lufa-Lufa' => 0
            ];

            // Busca o total de alunos por casa
            $stmt = $this->db->query("
                SELECT 
                    CASE 
                        WHEN casa LIKE '%Grif%' THEN 'Grifinória'
                        WHEN casa LIKE '%Sons%' THEN 'Sonserina'
                        WHEN casa LIKE '%Corv%' THEN 'Corvinal'
                        WHEN casa LIKE '%Lufa%' THEN 'Lufa-Lufa'
                        ELSE casa 
                    END as casa_normalizada,
                    COUNT(*) as total 
                FROM alunos 
                GROUP BY 
                    CASE 
                        WHEN casa LIKE '%Grif%' THEN 'Grifinória'
                        WHEN casa LIKE '%Sons%' THEN 'Sonserina'
                        WHEN casa LIKE '%Corv%' THEN 'Corvinal'
                        WHEN casa LIKE '%Lufa%' THEN 'Lufa-Lufa'
                        ELSE casa 
                    END
            ");

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if (isset($estatisticas[$row['casa_normalizada']])) {
                    $estatisticas[$row['casa_normalizada']] = $row['total'];
                }
            }

            // Verifica o total de alunos e a distribuição
            $totalAlunos = array_sum($estatisticas);
            $alunosPorCasa = ceil(30 / 4); // Deve ser aproximadamente 7-8 alunos por casa

            // Busca todos os alunos com suas informações
            $stmt = $this->db->query("
                SELECT 
                    nome, 
                    turma, 
                    CASE 
                        WHEN casa LIKE '%Grif%' THEN 'Grifinória'
                        WHEN casa LIKE '%Sons%' THEN 'Sonserina'
                        WHEN casa LIKE '%Corv%' THEN 'Corvinal'
                        WHEN casa LIKE '%Lufa%' THEN 'Lufa-Lufa'
                        ELSE casa 
                    END as casa,
                    descricao,
                    created_at 
                FROM alunos 
                ORDER BY created_at DESC
            ");
            $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Carrega a view com o caminho completo
            require_once 'C:/xampp/htdocs/seletor-harry-potter/app/views/relatorio.php';
        } catch (Exception $e) {
            echo "Erro ao gerar relatório: " . $e->getMessage();
        }
    }

    public function gerarDescricao() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Limpa qualquer output anterior
            ob_clean();
            
            $data = json_decode(file_get_contents('php://input'), true);
            $nome = $data['nome'] ?? '';

            try {
                $resultado = $this->geminiService->gerarDescricao($nome);
                
                // Remove os asteriscos da descrição e casa
                $descricao = str_replace('**', '', $resultado['descricao']);
                $casa = str_replace('**', '', $resultado['casa']);
                
                // Salva no banco de dados
                $stmt = $this->db->prepare("INSERT INTO alunos (nome, turma, descricao, casa) VALUES (?, ?, ?, ?)");
                $turma = "DEV32025"; // Pegando a turma padrão
                $stmt->execute([
                    $nome,
                    $turma,
                    $resultado['descricao'],
                    $resultado['casa']
                ]);

                if ($stmt->rowCount() > 0) {
                    header('Content-Type: application/json');
                    echo json_encode([
                        'descricao' => $resultado['descricao'],
                        'casa' => $resultado['casa'],
                        'success' => true
                    ]);
                } else {
                    throw new Exception('Erro ao salvar no banco de dados');
                }
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode(['erro' => $e->getMessage()]);
            }
            exit;
        }
    }
}