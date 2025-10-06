<?php
// finalizar_compra.php
session_start();

// O include deve ser antes da lógica de redirecionamento, caso os dados sejam necessários
// ATENÇÃO: Verifique se o nome da variável é $produtos (no plural) no seu produtos_data.php
require_once 'produtos_data.php';

// Pega o método de pagamento da URL
$metodo_pagamento = $_GET['metodo'] ?? '';

// Redireciona se não houver um método válido
if (empty($metodo_pagamento)) {
    header("Location: pagamento.php"); // Redireciona para a página de escolha de pagamento
    exit;
}

// Redireciona se o carrinho estiver vazio
if (empty($_SESSION['carrinho'])) {
    header("Location: carrinho.php");
    exit;
}

$total_carrinho = 0;
$total_itens = 0;
$itens_carrinho = [];

// CÁLCULO REFORÇADO DO CARRINHO (AGORA CORRETO)
foreach ($_SESSION['carrinho'] as $id => $item_carrinho) {
    if (isset($produtos[$id])) {
        $detalhes_produto = $produtos[$id];
        
        $quantidade = (int)($item_carrinho['quantidade'] ?? 0);
        
        $detalhes_produto['quantidade'] = $quantidade;
        $subtotal = $detalhes_produto['preco'] * $quantidade;
        $detalhes_produto['subtotal'] = $subtotal;
        
        $itens_carrinho[] = $detalhes_produto;
        $total_carrinho += $subtotal;
        $total_itens += $quantidade;
    }
}

// Se o carrinho foi limpo ou os itens não foram encontrados, redireciona
if (empty($itens_carrinho)) {
    header("Location: carrinho.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Compra - Essência Pura</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .container-checkout { max-width: 900px; }
        .card-summary { background-color: #fff; border: 1px solid #ddd; padding: 20px; border-radius: 8px; }
        .card-details { border: 1px solid #ddd; border-radius: 8px; }
        .total-price { font-size: 1.5rem; font-weight: bold; color: #f0a07f; }
        
        /* Estilos aprimorados para PIX */
        .pix-container { 
            background-color: #e6ffed; 
            border: 1px solid #c3e6cb; 
            padding: 20px; 
            border-radius: 8px;
        }
        .pix-qr-code { 
            max-width: 200px; 
            border: 2px solid #28a745;
            border-radius: 5px;
        }
        .pix-key-container { 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            border: 1px dashed #28a745; 
            background-color: #fff;
            padding: 10px; 
            border-radius: 5px; 
            margin-top: 15px;
        }
    </style>
</head>
<body>

<div class="container container-checkout my-5">
    <h1 class="mb-4 text-center">Checkout</h1>

    <div class="row g-4">
        <div class="col-md-5 order-md-last">
            <div class="card card-summary">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-primary">Seu Pedido</span>
                    <span class="badge bg-primary rounded-pill"><?= $total_itens ?></span>
                </h4>
                <ul class="list-group mb-3">
                    <?php foreach ($itens_carrinho as $item): ?>
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0"><?= htmlspecialchars($item['nome']) ?> (x<?= $item['quantidade'] ?>)</h6>
                            </div>
                            <span class="text-muted">R$ <?= number_format($item['subtotal'], 2, ',', '.') ?></span>
                        </li>
                    <?php endforeach; ?>
                    <li class="list-group-item d-flex justify-content-between bg-light">
                        <span>**Total do Carrinho (BRL)**</span>
                        <strong class="total-price">R$ <?= number_format($total_carrinho, 2, ',', '.') ?></strong>
                    </li>
                </ul>
            </div>
            
            <div class="mt-3 text-center">
                <a href="pagamento.php" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Mudar Pagamento
                </a>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card card-details p-4">
                <h4 class="mb-3">Informações de Envio</h4>
                <form class="needs-validation" novalidate>
                    <div class="row g-3">
                        <div class="col-sm-6"><label for="firstName" class="form-label">Nome</label><input type="text" class="form-control" id="firstName" required></div>
                        <div class="col-sm-6"><label for="lastName" class="form-label">Sobrenome</label><input type="text" class="form-control" id="lastName" required></div>
                        <div class="col-12"><label for="email" class="form-label">Email</label><input type="email" class="form-control" id="email" placeholder="voce@exemplo.com" required></div>
                        <div class="col-12"><label for="address" class="form-label">Endereço</label><input type="text" class="form-control" id="address" placeholder="Rua, Bairro, Número" required></div>
                        <div class="col-md-5"><label for="country" class="form-label">País</label><select class="form-select" id="country" required><option value="">Escolha...</option><option>Brasil</option></select></div>
                        <div class="col-md-4"><label for="state" class="form-label">Estado</label><select class="form-select" id="state" required><option value="">Escolha...</option><option>Paraná</option><option>São Paulo</option></select></div>
                        <div class="col-md-3"><label for="zip" class="form-label">CEP</label><input type="text" class="form-control" id="zip" placeholder="00000-000" required></div>
                    </div>
                    
                    <hr class="my-4">

                    <?php if ($metodo_pagamento === 'pix'): ?>
                        <h4 class="mb-3 text-success"><i class="bi bi-qr-code-scan me-2"></i> Pagamento com PIX</h4>
                        <div class="pix-container">
                            <p class="lead text-center fw-bold">Total a pagar: R$ <?= number_format($total_carrinho, 2, ',', '.') ?></p>
                            
                            <div class="text-center mb-4">
                                <img src="img/pix.jpeg" alt="QR Code Pix" class="pix-qr-code img-fluid">
                                <p class="mt-2 text-muted">Escaneie o QR Code acima com o seu app de banco.</p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Chave Copia e Cola (PIX Key)</label>
                                <div class="pix-key-container">
                                    <span id="pix-key" class="fw-bold text-success">44991180048</span>
                                    <button type="button" class="btn btn-outline-success btn-sm" onclick="copyPixKey()">
                                        <i class="bi bi-clipboard"></i> Copiar Chave
                                    </button>
                                </div>
                            </div>
                            <div class="alert alert-info py-2 small">
                                O pagamento deve ser realizado em até 30 minutos.
                            </div>
                        </div>
                        
                    <?php elseif ($metodo_pagamento === 'cartao'): ?>
                        <h4 class="mb-3 text-primary"><i class="bi bi-credit-card me-2"></i> Dados do Cartão de Crédito</h4>
                        <div class="alert alert-primary">
                            Processamos seu pagamento em ambiente seguro.
                        </div>
                        <div class="row gy-3">
                            <div class="col-md-12"><label for="cc-name" class="form-label">Nome no Cartão</label><input type="text" class="form-control" id="cc-name" required></div>
                            <div class="col-md-12"><label for="cc-number" class="form-label">Número do Cartão de Crédito</label><input type="text" class="form-control" id="cc-number" required></div>
                            <div class="col-md-4"><label for="cc-expiration" class="form-label">Validade</label><input type="text" class="form-control" id="cc-expiration" placeholder="MM/AA" required></div>
                            <div class="col-md-4"><label for="cc-cvv" class="form-label">CVV</label><input type="text" class="form-control" id="cc-cvv" required></div>
                            <div class="col-md-4">
                                <label for="installments" class="form-label">Parcelas</label>
                                <select class="form-select" id="installments">
                                    <option value="1">1x de R$ <?= number_format($total_carrinho, 2, ',', '.') ?> (sem juros)</option>
                                    <option value="2">2x de R$ <?= number_format($total_carrinho / 2 * 1.05, 2, ',', '.') ?> (com juros)</option>
                                    <option value="3">3x de R$ <?= number_format($total_carrinho / 3 * 1.05, 2, ',', '.') ?> (com juros)</option>
                                </select>
                            </div>
                        </div>

                    <?php elseif ($metodo_pagamento === 'boleto'): ?>
                        <h4 class="mb-3 text-warning"><i class="bi bi-file-text me-2"></i> Boleto Bancário</h4>
                        <div class="alert alert-warning">
                            **Importante:** O boleto será gerado após a confirmação da compra. O prazo de compensação é de 1 a 3 dias úteis.
                        </div>
                        <div class="card p-3 border-warning">
                            <p class="mb-0 fw-bold">Valor do Boleto:</p>
                            <h3 class="text-warning">R$ <?= number_format($total_carrinho, 2, ',', '.') ?></h3>
                            <p class="small text-muted mb-0">O código de barras será exibido na próxima tela.</p>
                        </div>
                        
                    <?php endif; ?>

                    <hr class="my-4">
                    <button class="w-100 btn btn-success btn-lg" type="submit">
                        <i class="bi bi-bag-check-fill me-2"></i> Finalizar Compra
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Função para copiar a chave PIX
    function copyPixKey() {
        const pixKey = document.getElementById('pix-key').textContent;
        // Tenta usar a API moderna de área de transferência
        if (navigator.clipboard) {
            navigator.clipboard.writeText(pixKey).then(() => {
                alert('Chave Pix copiada para a área de transferência! ' + pixKey);
            }).catch(err => {
                console.error('Erro ao copiar a chave Pix:', err);
                fallbackCopy(pixKey);
            });
        } else {
            // Fallback para navegadores antigos
            fallbackCopy(pixKey);
        }
    }
    
    // Função de cópia de fallback (menos elegante, mas funciona)
    function fallbackCopy(text) {
        const textarea = document.createElement('textarea');
        textarea.value = text;
        document.body.appendChild(textarea);
        textarea.select();
        try {
            document.execCommand('copy');
            alert('Chave Pix copiada para a área de transferência! ' + text);
        } catch (err) {
            console.error('Fallback: Falha ao copiar!', err);
        }
        document.body.removeChild(textarea);
    }
</script>
</body>
</html>