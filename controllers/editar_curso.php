<?php
    header("Content-Type: application/json");
    
    require_once __DIR__ . '/../conexao.php';

    $cursos = [
        "id",
        "nome",
        "modalidade",
        "carga_horaria",
        "data_inicio",
        "data_fim",
        "qtd_max_alunos",
        "status",
        "descricao",
        "turno"
    ];

    foreach ($cursos as $curso) {
        if ($curso === 'id') {
            $$curso = $_POST[$curso] ?? $_GET[$curso] ?? null;
        } else {
            $$curso = $_POST[$curso] ?? null;
        }
    }

    if (!$id) {
        echo json_encode(["success" => false, "error" => "ID não informado"]);
        exit;
    }

    $stmt = $conexao->prepare("
        UPDATE cursos SET
            nome = ?, modalidade = ?, carga_horaria = ?, data_inicio = ?, data_fim = ?, qtd_max_alunos = ?, status = ?, descricao = ?
        WHERE id = ?
    ");

    $stmt->bind_param("ssississi", $nome, $modalidade, $carga_horaria, $data_inicio, $data_fim, $qtd_max_alunos, $status, $descricao, $id);

    if(!$stmt->execute()) {
        echo json_encode(["success" => false, "message" => "Erro ao atualizar curso: " . $stmt->error]);
        exit;
    }

    //Atualizar turno
    $conexao->query("DELETE FROM curso_turno WHERE curso_id = " . intval($id));

    $mapTurnos = [
        "Manhã" => 1,
        "Tarde" => 2,
        "Noite" => 3,
    ];

    if(is_array($turno)) {
        $stmtTurno = $conexao->prepare("INSERT INTO curso_turno (curso_id, turno_id) VALUES (?, ?)");

        foreach($turno as $nomeTurno) {
            if(isset($mapTurnos[$nomeTurno])) {
                $turno_id = $mapTurnos[$nomeTurno];
                $stmtTurno->bind_param("ii", $id, $turno_id);
                $stmtTurno->execute();
            }
        }
    }

    echo json_encode(["success" => true, "message" => "Curso atualizado com sucesso!"]);
    
?>