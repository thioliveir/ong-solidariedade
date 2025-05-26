<?php
/*
// Tenta acessar o arquivo de configuração
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["success" => false, "error" => "Método não permitido"]);
    exit;
}
*/
header("Content-Type: application/json");

require_once __DIR__ . '/../conexao.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Lança exceções para erros do MySQL

try {
    
    $data = $_POST;

    // Tratamento no campo name
    function capitalizeName($name) {
        $words = explode(" ", strtolower($name));
        $words = array_map("ucfirst", $words);
        return implode(" ", $words);
    }

    
    $matricula     = $data['matricula'];
    $dataInclusao  = date('Y-m-d H:i:s'); // Usar data atual
    $name          = capitalizeName($data['name']);
    $cpf           = $data['cpf'];
    $birth         = $data['birth'];
    $phone         = $data['phone'] ?? null;
    $course        = $data['course'];
    $situation     = $data['situation'];
    $sex           = $data['sex'];
    $cep           = $data['cep'];
    $address       = $data['address'];
    $number        = $data['number'] ?? null;
    $complemento   = $data['complemento'] ?? null;
    $neighborhood  = $data['neighborhood'] ?? null;
    $city          = $data['city'];
    $state         = $data['state'];

    // Verificar se o CPF já existe
    $stmtCheck = $conexao->prepare("SELECT id FROM alunos WHERE cpf = ?");
    $stmtCheck->bind_param("s", $cpf);
    $stmtCheck->execute();
    $stmtCheck->store_result();

    if($stmtCheck->num_rows > 0) {
        //CPF já existe
        echo json_encode(["success" => false, "message" => "CPF já cadastrado"]);
        $stmtCheck->close();
        $conexao->close();
        exit;
    }
    $stmtCheck->close();

    $stmt = $conexao->prepare("INSERT INTO alunos (
        matricula, dataInclusao, name, cpf, birth, phone, course, situation,
        sex, cep, address, number, complemento, neighborhood, city, state
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssssssssssssss", $matricula, $dataInclusao, $name, $cpf, $birth, $phone, $course, $situation,
        $sex, $cep, $address, $number, $complemento, $neighborhood, $city, $state);

    $stmt->execute();

    if($stmt->affected_rows > 0) {
        echo json_encode(["success" => true]);
    }else {
        echo json_encode(["success" => false, "message" => $stmt->error]);
    }
    $stmt->close();
    $conexao->close();

} catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062 && strpos($e->getMessage(), 'cpf') !== false) {
            echo json_encode(["success" => false, "message" => "CPF já cadastrado."]);
        } else {
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
        };
}


?>