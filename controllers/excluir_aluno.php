<?php

    if($_SERVER["REQUEST_METHOD"] !== "POST") {
        http_response_code(405);
        echo json_encode(["success" => false, "error" => "Método não permitido"]);
        exit;
    }
    
    header("Content-Type: application/json");
    
    require_once __DIR__ . '/../conexao.php';
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try {
        $matricula = $_POST['matricula'] ?? null;
        if(!$matricula) {
            echo json_encode(["success" => false, "message" => "Matrícula não informada"]);
            exit;
        }

        $stmt = $conexao->prepare("DELETE FROM alunos WHERE matricula = ?");
        $stmt->bind_param("s", $matricula);
        $stmt->execute();

        if($stmt->affected_rows > 0) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "Aluno não encontrado ou já excluído"]);
        }

        $stmt->close();
        $conexao->close();

        
    } catch (mysqli_sql_exception $e) {
        echo json_encode(["success" => false, "message" => "Erro ao excluir aluno: " . $e->getMessage()]);
    }
    

?>