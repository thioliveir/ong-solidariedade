// conexao_pdo.php
<?php
$servername = "localhost";
$database = "ong_sol_bd";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode([
        "success" => false,
        "error" => "Erro de conexão: " . $e->getMessage()
    ]));
}
