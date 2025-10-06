<?php
// 1. Configuração Inicial e Inclusão de Dados
session_start();
include_once("produtos_data.php"); 
include_once("includes/menu.php"); 

// 2. Lógica para obter e verificar o produto
$produto = null;
$produto_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($produto_id !== null && array_key_exists($produto_id, $produtos)) {
    // Produto encontrado no array $produtos
    $produto = $produtos[$produto_id];
} else {
    // Produto não encontrado ou ID faltando. Redireciona para o index.
    header("Location: index.php");
    exit();
}

// Define o título da página com o nome do produto
$page_title = $produto['nome'];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?> | Essência Pura</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            overflow-x: hidden;
            background-color: #d0d0d0;
            padding-top: 80px;
        }
        nav.navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background-color: rgba(124, 169, 130, 0.85);
        }
        .content {
            padding: 20px;
        }
        .produto-detalhe img {
            max-height: 500px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .detalhes-card {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        /* === CORES PERSONALIZADAS PARA OS BOTÕES === */
        
        /* Botão ADICIONAR AO CARRINHO (Azul Forte) */
        .btn-add-carrinho {
            background-color: #007bff; /* Azul primário */
            border-color: #007bff;
            color: white;
        }
        .btn-add-carrinho:hover {
            background-color: #0056b3;
            border-color: #0056b3;
            color: white;
        }
        
        /* Botão COMPRE AGORA (Verde Limão Vibrante) */
        .btn-compre-agora {
            background-color: #32CD32; /* Verde Limão */
            border-color: #32CD32;
            color: white;
            font-weight: bold;
        }
        .btn-compre-agora:hover {
            background-color: #28a745; /* Verde padrão do Bootstrap */
            border-color: #28a745;
            color: white;
        }
        /* ========================================= */
    </style>
</head>
<body>

<div class="container content my-5">
    <a href="index.php#produtos" class="btn btn-secondary mb-4"><i class="bi bi-arrow-left"></i> Voltar aos Produtos</a>

    <div class="row produto-detalhe">
        <div class="col-md-6 mb-4">
            <img src="<?= htmlspecialchars($produto['imagem']) ?>" class="img-fluid" alt="<?= htmlspecialchars($produto['nome']) ?>">
        </div>

        <div class="col-md-6">
            <div class="detalhes-card">
                <h1 class="mb-3"><?= htmlspecialchars($produto['nome']) ?></h1>
                
                <h3 class="text-success mb-4">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></h3>
                
                <p class="lead">
                    <strong>Descrição:</strong> <?= htmlspecialchars($produto['descricao'] ?? 'Esta é uma fragrância exclusiva, feita com ingredientes puros e selecionados. Possui notas florais e amadeiradas, garantindo uma fixação duradoura e elegante.') ?>
                </p>

                <p>
                    <strong>Tipo:</strong> Eau de Parfum<br>
                    <strong>Volume:</strong> 100ml<br>
                    <strong>Disponibilidade:</strong> Em estoque
                </p>

                <hr>

                <form action="carrinho.php" method="GET">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($produto_id) ?>">
                    <input type="hidden" name="name" value="<?= urlencode($produto['nome']) ?>">
                    <input type="hidden" name="price" value="<?= htmlspecialchars($produto['preco']) ?>">
                    
                    <div class="mb-3 d-flex align-items-center">
                        <label for="quantidade" class="form-label me-3 mb-0">Quantidade:</label>
                        <input type="number" id="quantidade" name="quantity" class="form-control" value="1" min="1" style="width: 80px;" required>
                    </div>
                    
                    <hr>

                    <div class="mb-4">
                        <label for="cep" class="form-label fw-bold">Calcular Frete e Prazo</label>
                        <div class="input-group">
                            <input type="text" id="cep" class="form-control" placeholder="Digite seu CEP (Ex: 00000-000)" maxlength="9" onkeyup="formatarCEP(this)">
                            <button class="btn btn-outline-secondary" type="button" onclick="consultarCEP()">Calcular</button>
                        </div>
                        
                        <div id="resultado-endereco" class="mt-3 small text-muted">
                            </div>
                        <div id="resultado-frete" class="mt-2 small **fw-bold**">
                            Disponibilidade de frete será exibida aqui.
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-lg w-100 btn-add-carrinho">
                        <i class="bi bi-cart-plus me-2"></i> **Adicionar ao Carrinho**
                    </button>

                    <button type="submit" class="btn btn-lg w-100 mt-3 btn-compre-agora" formaction="carrinho.php?action=add&checkout=true">
                        <i class="bi bi-bag-check me-2"></i> **Compre Agora**
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>

<footer class="bg-dark text-white text-center p-4 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-3">
                <h5>Essência Pura</h5>
                <p>Onde cada fragrância conta uma história.</p>
            </div>
            <div class="col-md-4 mb-3">
                <h5>Siga-nos</h5>
                <a href="https://www.instagram.com/_silvax_07" target="_blank" class="text-white me-3"><i class="bi-instagram fs-4"></i></a>
            </div>
            <div class="col-md-4 mb-3">
                <h5>Contato</h5>
                <p>contato@essenciapura.com</p>
                <p>+55 (44) 99118-0048</p>
            </div>
        </div>
        <hr class="bg-light">
        <p class="mb-0">© 2025 Essência Pura. Todos os direitos reservados.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Função para formatar o CEP (00000-000)
    function formatarCEP(input) {
        let value = input.value.replace(/\D/g, '');
        if (value.length > 5) {
            value = value.substring(0, 5) + '-' + value.substring(5, 8);
        }
        input.value = value;
    }

    // Função principal para consultar o CEP e calcular o frete
    function consultarCEP() {
        const cep = document.getElementById('cep').value.replace(/\D/g, '');
        const resultadoEndereco = document.getElementById('resultado-endereco');
        const resultadoFrete = document.getElementById('resultado-frete');
        
        // Limpa resultados anteriores
        resultadoEndereco.innerHTML = 'Consultando CEP...';
        resultadoFrete.innerHTML = 'Calculando frete...';

        if (cep.length !== 8) {
            resultadoEndereco.innerHTML = '<span class="text-danger">CEP inválido. Digite 8 dígitos.</span>';
            resultadoFrete.innerHTML = 'Disponibilidade de frete será exibida aqui.';
            return;
        }

        // 1. Consulta ao ViaCEP para obter o endereço
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(data => {
                if (data.erro) {
                    resultadoEndereco.innerHTML = '<span class="text-danger">CEP não encontrado.</span>';
                    resultadoFrete.innerHTML = 'Não foi possível calcular o frete.';
                } else {
                    // Exibe o endereço
                    const endereco = `
                        ${data.logradouro}, ${data.bairro}<br>
                        ${data.localidade} - ${data.uf}
                    `;
                    resultadoEndereco.innerHTML = endereco;

                    // 2. Simulação de Cálculo de Frete
                    const estado = data.uf;
                    let valorFrete = 0;
                    let prazoDias = 0;

                    if (['SP', 'RJ', 'MG', 'PR'].includes(estado)) {
                        valorFrete = 15.00;
                        prazoDias = 3;
                    } else if (['BA', 'PE', 'CE', 'RS'].includes(estado)) {
                        valorFrete = 25.00;
                        prazoDias = 7;
                    } else {
                        valorFrete = 35.00;
                        prazoDias = 10;
                    }
                    
                    // Exibe o Frete
                    const freteFormatado = valorFrete.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                    resultadoFrete.innerHTML = `
                        **Frete Padrão:** ${freteFormatado} | Prazo: ${prazoDias} dias úteis
                    `;
                    resultadoFrete.classList.remove('text-muted');
                }
            })
            .catch(error => {
                console.error('Erro na consulta de CEP:', error);
                resultadoEndereco.innerHTML = '<span class="text-danger">Erro ao conectar com o serviço de CEP.</span>';
                resultadoFrete.innerHTML = 'Não foi possível calcular o frete.';
            });
    }
</script>

</body>
</html>