<?php
    header("Content-Type: application/json");
    
    require_once __DIR__ . '/../conexao.php';

    $campos = [
        "matricula",
        "dataInclusao",
        "name",
        "cpf",
        "birth",
        "phone",
        "course",
        "situation",
        "sex",
        "cep",
        "address",
        "number",
        "complemento",
        "neighborhood",
        "city",
        "state"
    ];

    foreach ($campos as $campo) {
        $$campo = $_POST[$campo] ?? null;
    }

    if (!$matricula) {
        echo json_encode(["success" => false, "error" => "Matrícula não informada"]);
        exit;
    }

    $stmt = $conexao->prepare("
        UPDATE alunos SET 
            name = ?, cpf = ?, birth = ?, phone = ?, course = ?, situation = ?, sex = ?, cep = ?, address = ?, number = ?, complemento = ?, neighborhood = ?, city = ?, state = ?
        WHERE matricula = ?
    ");

    $stmt->bind_param("sssssssssssssss", $name, $cpf, $birth, $phone, $course, $situation, $sex, $cep, $address, $number, $complemento, $neighborhood, $city, $state, $matricula);

    if($stmt->execute()) {
        echo json_encode(["success" => true, "mensagem" => "Aluno atualizado com sucesso!"]);
    } else {
        echo json_encode(["success" => false, "error" => $stmt->error]);
    }


?>