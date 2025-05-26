<?php
    require_once __DIR__ . '/../conexao.php';

    $sql = "SELECT matricula, dataInclusao, name, course, situation FROM alunos ORDER BY dataInclusao DESC";
    $result = $conexao->query($sql);

    $alunos = [];

    while($row = $result->fetch_assoc()) {
        $alunos[] = $row;
    }

    echo json_encode($alunos);
    
?>