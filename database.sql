CREATE DATABASE IF NOT EXISTS seletor_hp;
USE seletor_hp;

CREATE TABLE IF NOT EXISTS alunos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    turma VARCHAR(50) NOT NULL,
    descricao TEXT,
    casa VARCHAR(50),
    perfil TEXT -- Coluna para armazenar o perfil gerado pela API
);



CREATE TABLE IF NOT EXISTS alunos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    turma VARCHAR(50) NOT NULL,
    descricao TEXT,
    casa VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);