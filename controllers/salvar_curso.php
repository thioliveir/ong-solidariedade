<?php

    // Erro ao tentar acessar o arquivo de configuração
    /*
    if($_SERVER["REQUEST_METHOD"] !== "POST") {
        http_response_code(405);
        echo json_encode(["success" => false, "error" => "Método não permitido"]);
        exit;
    }
    */
    header("Content-Type: application/json");
    
    require_once __DIR__ . "/../conexao.php";
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Lança exceções para erros do MySQL

    try {
        $data = $_POST;

        // Tratar o campo name
        function capitalizeName($name) {
            $words = explode(" ", strtolower($name));
            $words = array_map("ucfirst", $words);
            return implode(" ", $words);
        }

        $conn = $conexao;

        $nome   = capitalizeName($data["nome"]);
        $modalidade     = $data["modalidade"];
        $carga_horaria = (int)$data["carga_horaria"];
        $data_inicio    = $data["data_inicio"];
        $data_fim      = $data["data_fim"];
        $qtd_max_alunos  = (int)$data["qtd_max_alunos"];
        $status     = $data["status"];
        $descricao    = $data["descricao"];
        $turno       = $data["turno"];

        $conn->begin_transaction();

        // Verificar se o curso já existe
        $stmtCheck = $conn->prepare("SELECT id FROM cursos WHERE nome = ?");
        $stmtCheck->bind_param("s", $nome);
        $stmtCheck->execute();
        $stmtCheck->store_result();

        if($stmtCheck->num_rows > 0) {
            // Curso já existe
            echo json_encode(["success" => false, "message" => "Curso já cadastrado"]);
            $stmtCheck->close();
            $conn->close();
            exit;
        }
        $stmtCheck->close();

        // 1. Inserir o curso
        $stmt = $conn->prepare("
            INSERT INTO cursos 
            (nome, modalidade, carga_horaria, data_inicio, data_fim, qtd_max_alunos, status, descricao) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("ssississ", 
            $nome, $modalidade, $carga_horaria, 
            $data_inicio, $data_fim, $qtd_max_alunos, 
            $status, $descricao
        );
        $stmt->execute();
        $id = $conn->insert_id;

        // 2. Inserir os turnos
        if (!is_array($turno)) {
            throw new Exception("Turnos inválidos");
        }

        // Obter todos os turnos possíveis do banco
        $turnosDisponiveis = [];
        $result = $conn->query("SELECT id, nome FROM turnos");
        while ($row = $result->fetch_assoc()) {
            $turnosDisponiveis[$row["nome"]] = $row["id"];
        }

        $stmtTurno = $conn->prepare("INSERT INTO curso_turno (curso_id, turno_id) VALUES (?, ?)");

        foreach ($turno as $turnoNome) {
            if (!isset($turnosDisponiveis[$turnoNome])) {
                throw new Exception("Turno inválido: " . $turnoNome);
            }
            $turnoId = $turnosDisponiveis[$turnoNome];
            $stmtTurno->bind_param("ii", $id, $turnoId);
            $stmtTurno->execute();
        }

        $stmt->close();
        $stmtTurno->close();
        $conn->commit();
        $conn->close();

        echo json_encode(["success" => true, "id" => $id]);

    } catch (Exception $e) {
        if(isset($conn)) {
            $conn->rollback();
        }
        http_response_code(500);
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }


?>