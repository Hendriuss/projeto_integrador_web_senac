<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #d0d0d0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .cadastro-card {
            width: 100%;
            max-width: 400px;
        }
    </style>
</head>
<body>

<div class="card p-4 shadow cadastro-card">
    <h1 class="text-center mb-4">Criar Conta</h1>
    
    <form action="registrar.php" method="POST">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome Completo</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" class="form-control" id="senha" name="senha" required>
        </div>
        
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-success">Registrar</button>
            <a href="login.php" class="btn btn-link text-center">Já tenho uma conta</a>
        </div>
    </form>
</div>

</body>
</html>