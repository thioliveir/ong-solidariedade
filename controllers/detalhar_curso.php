<?php
    header('Content-Type: application/json');
    
    require_once __DIR__ . '/../conexao.php';

    if (!isset($_GET['id'])) {
        echo json_encode(['success' => false, 'error' => 'ID não informado']);
        exit;
    }

    $id = $_GET['id'];

    
    $stmt = $conexao->prepare("SELECT * FROM cursos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $curso = $result->fetch_assoc();

    if (!$curso) {
        echo json_encode(['success' => false, 'error' => "Curso não encontrado"]);
        exit;
    }
    // Buscar os turnos vinculados ao curso usando JOIN
    $stmtTurnos = $conexao->prepare("
        SELECT turnos.nome
        FROM cursos
        JOIN curso_turno ON cursos.id = curso_turno.curso_id
        JOIN turnos ON curso_turno.turno_id = turnos.id
        WHERE cursos.id = ?
    ");
    $stmtTurnos->bind_param("i", $id);
    $stmtTurnos->execute();
    $resultTurnos = $stmtTurnos->get_result();

    $turno = [];
    while ($row = $resultTurnos->fetch_assoc()) {
        $turno[] = $row["nome"];
    }

    //Adiciona os turnos ao array do curso
    $curso["turno"] = $turno;

    echo json_encode(["success" => true, "curso" => $curso]);
?>