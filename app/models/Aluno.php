<?php

class Aluno {
    private $conn;
    private $table_name = "alunos";

    public $id;
    public $nome;
    public $turma;
    public $descricao;
    public $casa;
    public $perfil;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                SET nome=:nome, turma=:turma, descricao=:descricao";

        $stmt = $this->conn->prepare($query);

        // Limpa os dados
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->turma = htmlspecialchars(strip_tags($this->turma));
        $this->descricao = htmlspecialchars(strip_tags($this->descricao));

        // Bind dos valores
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":turma", $this->turma);
        $stmt->bindParam(":descricao", $this->descricao);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function updateCasa($id, $casa, $perfil) {
        $query = "UPDATE " . $this->table_name . "
                SET casa = :casa, perfil = :perfil
                WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":casa", $casa);
        $stmt->bindParam(":perfil", $perfil);
        $stmt->bindParam(":id", $id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getAllAlunos() {
        $query = "SELECT id, nome, turma, casa FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getAlunosByCasa($casa){
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name . " WHERE casa = :casa";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":casa", $casa);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
}