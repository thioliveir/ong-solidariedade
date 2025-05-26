<?php
    session_start();

    // Verifica se o usuário está logado
    if(!isset($_SESSION["user_logado"]) || $_SESSION["user_logado"] !== true) {
        // Usuário não está logado, redirecionar para login
        header("Location: ../login.php");
        exit();
    }

    // Verificar se sessão não expirou (2 horas)
    if(isset($_SESSION["last_activity"]) && (time() - $_SESSION["last_activity"] > 7200)) {
        // Sessão expirou
        session_destroy();
        header("Location: ../login.php?erro=" . urlencode("Sessão expirada. Faça login novamente."));
        exit();
    }

    // Atualiza o timestamp da última atividade
    $_SESSION["last_activity"] = time();

    // Definir variáveis globais do usuário para usar nas páginas
    $usuario_logado = [
        "id" => $_SESSION['user_id'],
        "nome" => $_SESSION["user_nome"],
        "username" => $_SESSION["user_username"],
        "nivel_acesso" => $_SESSION["user_nivel"],
    ];


?>