<?php
session_start();

// Define a variável de sessão para o carrinho, se ainda não existir
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

// -----------------------------------------------------------
// 1. Lógica de ADICIONAR ITEM AO CARRINHO (action=add)
// -----------------------------------------------------------

if (isset($_GET['action']) && $_GET['action'] == 'add' && isset($_GET['id'])) {
    
    // Captura e sanitiza os dados da URL
    $produto_id = (int)$_GET['id'];
    $nome = urldecode($_GET['name'] ?? 'Produto Desconhecido');
    $preco = (float)($_GET['price'] ?? 0.0);
    $quantidade = 1; // Por padrão, adiciona 1 unidade

    // Cria a estrutura do item
    $item = [
        'id' => $produto_id,
        'nome' => $nome,
        'preco' => $preco,
        'quantidade' => $quantidade 
    ];

    // Verifica se o produto já está no carrinho
    if (isset($_SESSION['carrinho'][$produto_id])) {
        // Se já existir, apenas incrementa a quantidade
        $_SESSION['carrinho'][$produto_id]['quantidade'] += $quantidade;
    } else {
        // Se não existir, adiciona o novo item
        $_SESSION['carrinho'][$produto_id] = $item;
    }

    // -----------------------------------------------------------
    // 2. 🚀 LÓGICA DE REDIRECIONAMENTO IMEDIATO PARA PAGAMENTO
    // -----------------------------------------------------------
    
    // Verifica se o clique veio do botão "Comprar Agora"
    if (isset($_GET['comprar']) && $_GET['comprar'] == 1) {
        $pagina_pagamento = "pagamento.php"; // Página que você vai criar/usar
        
        // Redireciona o usuário para o pagamento
        header("Location: " . $pagina_pagamento);
        exit(); // CRUCIAL: Interrompe a execução do script após o redirecionamento
    }
    
    // -----------------------------------------------------------
    // 3. Redirecionamento Padrão (se for só 'Adicionar ao Carrinho')
    // -----------------------------------------------------------
    
    // Se não for para comprar agora, volta para o carrinho (ou para a própria página de detalhes)
    // Se voltar para o carrinho, desabilite o código abaixo e deixe o seu HTML do carrinho mostrar.
    // Neste exemplo, vamos redirecionar para evitar que a URL de adição fique na barra de endereços.
    header("Location: carrinho.php");
    exit();
}

// -----------------------------------------------------------
// RESTANTE DO CÓDIGO E HTML DO CARRINHO (Remoção, Atualização, Exibição)
// -----------------------------------------------------------

// Lógica para remover item (action=remove)
if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])) {
    $produto_id = (int)$_GET['id'];
    if (isset($_SESSION['carrinho'][$produto_id])) {
        unset($_SESSION['carrinho'][$produto_id]);
    }
    header("Location: carrinho.php");
    exit();
}

// Lógica para limpar carrinho (action=clear)
if (isset($_GET['action']) && $_GET['action'] == 'clear') {
    unset($_SESSION['carrinho']);
    header("Location: carrinho.php");
    exit();
}

// -----------------------------------------------------------
// INÍCIO DO HTML PARA EXIBIÇÃO DO CARRINHO
// -----------------------------------------------------------
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Meu Carrinho - Essência Pura</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
<body>

<div class="container my-5">
    <h1>Seu Carrinho de Compras</h1>
    <hr>
    
    <?php if (empty($_SESSION['carrinho'])): ?>
        <div class="alert alert-warning">
            Seu carrinho está vazio!
        </div>
        <a href="index.php" class="btn btn-primary">Voltar às Compras</a>
    <?php else: 
        $total_carrinho = 0;
    ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th class="text-center">Preço Unit.</th>
                    <th class="text-center">Qtd.</th>
                    <th class="text-end">Subtotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['carrinho'] as $id => $item): 
                    $subtotal = $item['preco'] * $item['quantidade'];
                    $total_carrinho += $subtotal;
                ?>
                <tr>
                    <td><?= htmlspecialchars($item['nome']) ?></td>
                    <td class="text-center">R$ <?= number_format($item['preco'], 2, ',', '.') ?></td>
                    <td class="text-center"><?= $item['quantidade'] ?></td>
                    <td class="text-end">R$ <?= number_format($subtotal, 2, ',', '.') ?></td>
                    <td>
                        <a href="carrinho.php?action=remove&id=<?= $id ?>" class="btn btn-sm btn-danger">Remover</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="row">
            <div class="col-md-6">
                <a href="index.php" class="btn btn-secondary">Continuar Comprando</a>
                <a href="carrinho.php?action=clear" class="btn btn-warning">Limpar Carrinho</a>
            </div>
            <div class="col-md-6 text-end">
                <h3>Total: R$ <?= number_format($total_carrinho, 2, ',', '.') ?></h3>
                <a href="pagamento.php" class="btn btn-success btn-lg mt-3">
                    Finalizar Compra
                </a>
            </div>
        </div>

    <?php endif; ?>
</div>

</body>
</html>