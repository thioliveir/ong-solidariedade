<?php
$servername = "localhost"; //Padrão - server local
$database = "ong_sol_bd"; //alterar conforme o nome do seu banco de dados
$username = "root"; //padrão - root
$password = ""; //senha de conexão de banco de dados

$conexao = mysqli_connect($servername, $username, $password, $database);

//Check connection
if (!$conexao) {
    die(json_encode([
        "success" => false,
        "error" => "Erro de conexão: " . mysqli_connect_error()
    ]));
}

?>