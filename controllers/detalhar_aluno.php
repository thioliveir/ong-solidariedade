<?php
    header('Content-Type: application/json');
    
    require_once __DIR__ . '/../conexao.php';

    if (!isset($_GET['matricula'])) {
        echo json_encode(['success' => false, 'error' => 'Matrícula não informado']);
        exit;
    }

    $matricula = $_GET['matricula'];

    $stmt = $conexao->prepare("SELECT * FROM alunos WHERE matricula = ?");
    $stmt->bind_param("s", $matricula);
    $stmt->execute();
    $result = $stmt->get_result();
    $aluno = $result->fetch_assoc();

    if ($aluno) {
        echo json_encode(['success' => true, 'data' => $aluno]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Aluno não encontrado']);
    }
?>