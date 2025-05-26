# ong-solidariedade
Projeto desenvolvido para faculdade, onde simulamos uma uma ong beneficiente que disponibiliza cursos tecnologicos para pessoas em vulnerabilidade social.

# Funcionalidade
É necessário instalar o XAMPP pois o sistema é em PHP


# Passos para criação do banco de dados
Criar um banco de dados com as seguintes tabelas:
Tabela alunos com colunas: id, matricula, dataInclusao, name, cpf, birth, phone, course, situation, sex, cep, address, number, complemento, neighborhood, city e state

CREATE TABLE alunos (
    id INT(11) NOT NULL AUTO_INCREMENT,
    matricula varchar(20) NOT NULL,
    dataInclusao DATETIME NOT NULL,
    name varchar(100) DEFAULT NULL,
    cpf VARCHAR(14) DEFAULT NULL,
    birth DATE DEFAULT NULL,
    phone VARCHAR(20) DEFAULT NULL,
    course VARCHAR(100) DEFAULT NULL,
    situation VARCHAR(50) DEFAULT NULL,
    sex VARCHAR(10) DEFAULT NULL,
    cep varchar(10) DEFAULT NULL,
    address varchar(100) DEFAULT NULL,
    number VARCHAR(10) DEFAULT NULL,
    complemento VARCHAR(255) DEFAULT NULL,
    neighborhood VARCHAR(50) DEFAULT NULL,
    city VARCHAR(50) DEFAULT NULL,
    state VARCHAR(2) DEFAULT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY cpf (cpf)
);

outra tabela cursos com a seguinte estrutura:

id, nome, modalidade, carga_horaria, data_inicio, data fim, qtd_max_alunos, status, descrição, criado_em

CREATE TABLE cursos (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    modalidade VARCHAR(50) NOT NULL,
    carga_horaria INT(11) NOT NULL,
    data_inicio DATE NOT NULL,
    data_fim DATE NOT NULL,
    qtd_max_alunos INT(11) NOT NULL,
    status ENUM('ativo', 'inativo') DEFAULT 'ativo',
    descricao TEXT NULL,
    criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

Outra tabela curso_turno que tem chave primária composta pelos campos curso_id e turno_id. combinando esses dois em única para cada registro.

CREATE TABLE curso_turno (
    curso_id INT(11) NOT NULL,
    turno_id INT(11) NOT NULL,
    PRIMARY KEY (curso_id, turno_id),
    KEY turno_id (turno_id),
    FOREIGN KEY (curso_id) REFERENCES cursos(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (turno_id) REFERENCES turnos(id) ON DELETE CASCADE ON UPDATE CASCADE
)

Outra tabela de turnos que sera populada

CREATE TABLE turnos (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nome VARCHAR(20) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY nome (nome)
);

Inserindo os valores:

INSERT INTO turnos (id, nome) VALUES
(1, 'Manhã'),
(2, 'Tarde'),
(3, 'Noite');

Tabela de usuários

-- Criação da tabela de usuários

CREATE TABLE usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    nivel_acesso ENUM('admin', 'funcionario') DEFAULT 'funcionario',
    ativo BOOLEAN DEFAULT TRUE,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ultimo_login TIMESTAMP NULL
);


Popular as colunas de usuarios

-- Usuários de exemplo

INSERT INTO usuarios (nome, username, senha, nivel_acesso) 
VALUES ('Administrador', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

INSERT INTO usuarios (nome, username, senha, nivel_acesso) 
VALUES ('João Silva', 'joao', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'funcionario');

Indexar

-- Índice para otimização

CREATE INDEX idx_usuarios_username ON usuarios(username);
