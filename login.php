<?php
session_start();
include_once "includes/conexao.php"; // <- garante que $conexao existe

if (isset($_SESSION['logado'])) {
    header("Location: index.php");
    exit();
}

$mensagem_erro = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login_padrao'])) {

    $login = trim($_POST['email']); 
    $senha = $_POST['senha'];

    $sql  = "SELECT id, nome, senha, nivel FROM usuarios WHERE login = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($user = $resultado->fetch_assoc()) {
        if (password_verify($senha, $user['senha'])) {

            $_SESSION['logado']         = true;
            $_SESSION['user_id']        = $user['id'];
            $_SESSION['user_name']      = $user['nome'];
            $_SESSION['user_nivel']     = $user['nivel'];
            $_SESSION['just_logged_in'] = true;

            header("Location: index.php");
            exit();
        }
    }

    $mensagem_erro = "E-mail/Usuário ou senha incorretos. Tente novamente.";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - Essência Pura</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
    body {
        background-color: #f5f0e6;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    .login-container {
        width: 100%;
        max-width: 400px;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        text-align: center;
        position: relative;
    }

    .header-logo {
        font-family: serif;
        color: #7CA982;
        margin-bottom: 25px;
        font-size: 2rem;
        font-weight: bold;
    }

    .btn-principal {
        background-color: #7CA982;
        border-color: #7CA982;
        color: white;
        transition: background-color 0.3s;
    }

    .btn-principal:hover {
        background-color: #5d8463;
        border-color: #5d8463;
    }

    .btn-google {
        background-color: #fff;
        color: #444;
        border: 1px solid #ddd;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: all 0.2s ease;
        border-radius: 8px;
    }

    .btn-google:hover {
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        background-color: #f5f5f5;
        color: #222;
    }

    .extra-links {
        display: flex;
        justify-content: space-between;
        font-size: 0.85em;
        margin-bottom: 15px;
    }

    /* Mensagem de erro centralizada que desaparece */
    .alert-temporaria {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 9999;
        padding: 12px 25px;
        border-radius: 10px;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        animation: fadeOut 4s forwards;
    }

    @keyframes fadeOut {
        0% { opacity: 1; }
        80% { opacity: 1; }
        100% { opacity: 0; }
    }
</style>
</head>
<body>

<div class="login-container">
    <div class="header-logo">
        <i class="bi bi-lock-fill me-2"></i> Essência Pura
    </div>

    <h5 class="mb-4">Acesse sua conta</h5>

    <?php if ($mensagem_erro): ?>
        <div class="alert alert-danger alert-temporaria">
            <?= $mensagem_erro ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3 text-start">
            <label for="email" class="form-label">Usuário/E-mail</label>
            <input type="text" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3 text-start">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" class="form-control" id="senha" name="senha" required>
        </div>

        <div class="extra-links">
            <a href="esqueci_senha.php" class="text-secondary">Esqueci minha senha</a>
            <a href="cadastro.php" class="text-secondary">Não tenho conta</a>
        </div>

        <div class="d-grid gap-2 mb-3">
            <button type="submit" name="login_padrao" class="btn btn-principal btn-lg">Entrar</button>
        </div>
    </form>

    <div class="d-grid gap-2 mb-3">
        <a href="login_google.php" class="btn btn-google btn-lg">
            <img src="img/Logo-Google.png" alt="Google" style="height:20px; vertical-align:middle;">
            Entrar com Google
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
