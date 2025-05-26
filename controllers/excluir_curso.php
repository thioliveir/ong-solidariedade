<?php
    
    if($_SERVER["REQUEST_METHOD"] !== "POST") {
        http_response_code(405);
        echo json_encode(["success" => false, "error" => "Método não permitido"]);
        exit;
    }

    header("Content-Type: application/json");
    require_once 'verifica_ajax.php';
    require_once __DIR__ . '/../conexao.php';
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    
    try {
        $id = $_POST['id'] ?? null;
        if(!$id) {
            echo json_encode(["success" => false, "message" => "ID não informado no Banco de Dados"]);
            exit;
        }

        // Inicia a transação
        $conexao->begin_transaction();

        // Exclui primeiro da tabela de junção curso_turno
        $stmtTurno = $conexao->prepare("DELETE FROM curso_turno WHERE curso_id = ?");
        $stmtTurno->bind_param("i", $id);
        $stmtTurno->execute();
        $stmtTurno->close();

        // Depois exclui da tabela cursos
        $stmtCurso = $conexao->prepare("DELETE FROM cursos WHERE id = ?");
        $stmtCurso->bind_param("i", $id);
        $stmtCurso->execute();

        if($stmtCurso->affected_rows > 0) {
            $conexao->commit();
            echo json_encode(["success" => true]);
        } else {
            $conexao->rollback();
            echo json_encode(["success" => false, "message" => "Curso não encontrado ou já excluído"]);
        }

        $stmtCurso->close();
        $conexao->close();

        
    } catch (mysqli_sql_exception $e) {
        $conexao->rollback();
        echo json_encode(["success" => false, "message" => "Erro ao excluir curso: " . $e->getMessage()]);
    }

?>