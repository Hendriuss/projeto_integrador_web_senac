<?php
// pagamento.php
session_start();

// -----------------------------------------------------------
// 1. INCLUSÃO DE DADOS E LÓGICA DE REDIRECIONAMENTO
// -----------------------------------------------------------

// Inclui os dados dos produtos para poder calcular o total
// *** VERIFIQUE se o seu arquivo existe e se a variável de produtos é $produtos ***
include 'produtos_data.php'; 


// Redireciona se o carrinho estiver vazio
if (empty($_SESSION['carrinho'])) {
    header("Location: carrinho.php");
    exit;
}

$total_carrinho = 0;
$total_itens = 0;

// -----------------------------------------------------------
// 2. CÁLCULO REFORÇADO DO TOTAL DO CARRINHO (A causa mais provável da falha)
// -----------------------------------------------------------

foreach ($_SESSION['carrinho'] as $id => $item_carrinho) {
    // 💡 Verifica se o ID do produto existe no array de dados `$produtos`
    if (isset($produtos[$id])) {
        
        // Pega o preço unitário do array de dados (mais seguro)
        // Usa (float) para garantir que seja um número, ou 0.0 se não existir
        $preco_unitario = (float)($produtos[$id]['preco'] ?? 0.0);
        
        // Pega a quantidade do array de sessão (o que o usuário realmente adicionou)
        // Usa (int) para garantir que seja um número, ou 0 se não existir
        $quantidade = (int)($item_carrinho['quantidade'] ?? 0); 
        
        $total_carrinho += $preco_unitario * $quantidade;
        $total_itens += $quantidade;
    }
}

// Se o total_carrinho for 0, algo deu errado (ou todos os produtos têm preço zero)
$total_formatado = number_format($total_carrinho, 2, ',', '.');
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escolha o Pagamento - Essência Pura</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f5f0e6; padding-top: 50px; }
        .payment-option {
            cursor: pointer;
            transition: all 0.3s;
            border: 2px solid #ddd;
            border-radius: 10px;
        }
        .payment-option:hover {
            border-color: #f0a07f;
            background-color: #fffaf7;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .total-box {
            background-color: #DCA5B0;
            color: white;
            padding: 15px;
            border-radius: 8px;
        }
        /* Estilos para o bloco de debug */
        .debug-box {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 10px;
            margin-top: 20px;
            border-radius: 5px;
            font-size: 0.8rem;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
    </style>
</head>
<body>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="mb-4 text-center">Como você prefere pagar?</h1>
            
            <div class="total-box text-center mb-5">
                <h4>Total do Pedido:</h4>
                <h2 class="display-4">R$ <?= $total_formatado ?></h2> 
            </div>
            
            <p class="text-center text-muted mb-4">Selecione uma opção para continuar.</p>

            <div class="row g-4">
                
                <div class="col-md-4">
                    <a href="finalizar_compra.php?metodo=pix" class="d-block text-decoration-none">
                        <div class="card p-4 text-center payment-option h-100">
                            <i class="bi bi-qr-code-scan display-4 text-success mb-3"></i>
                            <h5 class="card-title">PIX</h5>
                            <p class="card-text text-success fw-bold">Pagamento instantâneo!</p>
                        </div>
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="finalizar_compra.php?metodo=cartao" class="d-block text-decoration-none">
                        <div class="card p-4 text-center payment-option h-100">
                            <i class="bi bi-credit-card display-4 text-primary mb-3"></i>
                            <h5 class="card-title">Cartão de Crédito</h5>
                            <p class="card-text text-muted">Em até 12x (com juros).</p>
                        </div>
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="finalizar_compra.php?metodo=boleto" class="d-block text-decoration-none">
                        <div class="card p-4 text-center payment-option h-100">
                            <i class="bi bi-file-text display-4 text-warning mb-3"></i>
                            <h5 class="card-title">Boleto Bancário</h5>
                            <p class="card-text text-muted">Prazo de 1-3 dias para compensação.</p>
                        </div>
                    </a>
                </div>
            </div>
            
            <div class="text-center mt-5">
                <a href="carrinho.php" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i> Voltar para o Carrinho</a>
            </div>
            
            <?php if ($total_carrinho == 0 && !empty($_SESSION['carrinho'])): ?>
            <div class="debug-box">
                <strong>ERRO DE CÁLCULO: TOTAL ZERADO.</strong> Verifique os dados abaixo:<br>
                <br>
                <strong>Conteúdo do Carrinho (Sessão):</strong>
                <?php print_r($_SESSION['carrinho']); ?><br>
                <br>
                <strong>Teste de Carregamento de Produtos (Apenas o 1º Produto):</strong>
                <?php 
                    if (isset($produtos) && is_array($produtos)) {
                        $first_id = key($produtos);
                        if ($first_id !== null) {
                            echo "ID 1: " . print_r($produtos[$first_id], true);
                        } else {
                            echo "Array \$produtos está vazio.";
                        }
                    } else {
                        echo "Array \$produtos não foi carregado. Verifique produtos_data.php.";
                    }
                ?>
            </div>
            <?php endif; ?>
            </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>