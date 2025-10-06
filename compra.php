<?php
session_start();

// Verifica se há produtos no carrinho antes de permitir a compra
if (empty($_SESSION['carrinho'])) {
    header('Location: index.php');
    exit;
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Processa os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cep = $_POST['cep'];
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];

    // Salva os dados de forma simplificada em um arquivo, para demonstração
    $dados_compra = "Nome: $nome\n";
    $dados_compra .= "Email: $email\n";
    $dados_compra .= "Endereço: $rua, $numero - $bairro, $cidade - $estado\n";
    $dados_compra .= "CEP: $cep\n\n";
    $dados_compra .= "--- Produtos ---\n";

    $total = 0;
    foreach ($_SESSION['carrinho'] as $item) {
        // AQUI ESTÁ A CORREÇÃO: VERIFICAÇÃO SE A CHAVE 'quantity' EXISTE
        $quantity = isset($item['quantity']) ? $item['quantity'] : 1;
        $dados_compra .= "Produto: {$item['name']} | Preço: R$ " . number_format($item['price'], 2, ',', '.') . "\n";
        $total += $item['price'] * $quantity;
    }
    $dados_compra .= "Total da Compra: R$ " . number_format($total, 2, ',', '.') . "\n";
    $dados_compra .= "===================================\n\n";

    // Salva o log da compra
    file_put_contents('compras.log', $dados_compra, FILE_APPEND | LOCK_EX);

    // Limpa o carrinho
    $_SESSION['carrinho'] = [];

    // Redireciona para uma página de sucesso
    header('Location: sucesso.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Compra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #d0d0d0; }
        .container { padding-top: 20px; }
        .form-check-label { cursor: pointer; }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="mb-4 text-center">Finalizar Compra</h1>
            <div class="card p-4">
                <form action="comprar.php" method="POST">
                    
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome Completo</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cep" class="form-label">CEP</label>
                            <input type="text" class="form-control" id="cep" name="cep" maxlength="8" required>
                            <div class="form-text">Digite o CEP para preencher o endereço.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="cidade" class="form-label">Cidade</label>
                            <input type="text" class="form-control" id="cidade" name="cidade" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="rua" class="form-label">Rua</label>
                            <input type="text" class="form-control" id="rua" name="rua" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="bairro" class="form-label">Bairro</label>
                            <input type="text" class="form-control" id="bairro" name="bairro" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <input type="text" class="form-control" id="estado" name="estado" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="numero" class="form-label">Número</label>
                            <input type="text" class="form-control" id="numero" name="numero" required>
                        </div>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="aceitarTermos" required>
                        <label class="form-check-label" for="aceitarTermos">
                            Concordo com os Termos e Condições
                        </label>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Finalizar Compra</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('cep').addEventListener('blur', function() {
        const cep = this.value.replace(/\D/g, '');
        if (cep.length === 8) {
            fetch(`cep.php?cep=${cep}`)
                .then(res => res.json())
                .then(data => {
                    if (!data.erro) {
                        document.getElementById('rua').value = data.logradouro || '';
                        document.getElementById('bairro').value = data.bairro || '';
                        document.getElementById('cidade').value = data.localidade || '';
                        document.getElementById('estado').value = data.uf || '';
                    } else {
                        alert('CEP não encontrado. Por favor, preencha o endereço manualmente.');
                    }
                })
                .catch(() => {
                    alert('Erro na consulta de CEP. Por favor, preencha o endereço manualmente.');
                });
        }
    });
</script>

</body>
</html>