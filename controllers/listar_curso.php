<?php
    header('Content-Type: application/json; charset=utf-8');

    
    require_once __DIR__ . '/../conexao.php';

    $sql = "
        SELECT 
            c.id, 
            c.nome, 
            c.modalidade, 
            c.carga_horaria, 
            c.data_inicio, 
            c.data_fim, 
            c.qtd_max_alunos, 
            c.status, 
            c.descricao, 
            c.criado_em,
            GROUP_CONCAT(t.nome SEPARATOR ', ') AS turnos
        FROM cursos c
        LEFT JOIN curso_turno ct ON c.id = ct.curso_id
        LEFT JOIN turnos t ON ct.turno_id = t.id
        GROUP BY c.id
        ORDER BY c.id DESC
    ";
    $result = $conexao->query($sql);

    if (!$result) {
        http_response_code(500);
        $erro = $conexao->error ?? 'Erro desconhecido';
        echo json_encode(["erro" => "Erro ao consultar cursos: " . $erro]);
        exit;
    }

    $courses = [];

    while($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }

    echo json_encode($courses);
?>