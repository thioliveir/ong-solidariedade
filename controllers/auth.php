<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start();

require_once __DIR__ . '/../conexao_pdo.php';

// Função de login
function login($username, $senha) {
    global $pdo;

    try {
        $stmt = $pdo->prepare("SELECT id, nome, username, senha, nivel_acesso, ativo FROM usuarios WHERE username = ? AND ativo = 1");
        $stmt->execute([$username]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario["senha"])) {
            $stmt = $pdo->prepare("UPDATE usuarios SET ultimo_login = NOW() WHERE id = ?");
            $stmt->execute([$usuario["id"]]);

            $_SESSION["user_id"] = $usuario["id"];
            $_SESSION["user_nome"] = $usuario["nome"];
            $_SESSION["user_username"] = $usuario["username"];
            $_SESSION["user_nivel"] = $usuario["nivel_acesso"];
            $_SESSION["user_logado"] = true;

            return true;
        }

        return false;
    } catch (\PDOException $e) {
        error_log("Erro no login: " . $e->getMessage());
        return false;
    }
}

// Função para logout
function logout() {
    session_destroy();
    header("Location: ../login.php");
    exit();
}

// Verifica se o usuário está logado
function verificarLogin() {
    if (!isset($_SESSION["user_logado"]) || $_SESSION["user_logado"] !== true) {
        header("Location: ../login.php");
        exit();
    }
}

// Verifica se o usuário é administrador
function verificarAdmin() {
    if ($_SESSION['user_nivel'] !== 'admin') {
        header("Location: ../views/dashboard.php");
        exit();
    }
}

// Processar o login
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "login") {
    $username = trim($_POST["username"]);
    $senha = trim($_POST["senha"]);

    if (empty($username) || empty($senha)) {
        $erro = "Usuário e senha são obrigatórios!";
    } else {
        if (login($username, $senha)) {
            header("Location: ../views/dashboard.php");
            exit();
        } else {
            $erro = "Usuário ou senha incorretos!";
        }
    }

    // Redireciona com erro
    header("Location: ../login.php?erro=" . urlencode($erro));
    exit();
}

// Processar o logout
if (isset($_GET["action"]) && $_GET["action"] === "logout") {
    logout();
}

// Redireciona para login por padrão
header("Location: ../login.php");
exit();
?>
