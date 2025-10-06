<?php
// Inicie a sessão no topo da página
session_start();
// Inclua seu arquivo de dados para usar os nomes e preços nos cards
include_once("produtos_data.php"); 
 
include_once("includes/menu.php"); // Se você tiver o menu, mantenha esta linha
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo à Essência Pura</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            min-height: 10vh;
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
        .banner {
            width: 90%;
            height: 600px;
            border-radius: 10px;
            margin-bottom: 30px;
            background: url("img/banner.jpeg") no-repeat center;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 2rem;
            text-shadow: 2px 2px 5px rgba(0,0,0,0.6);
            margin: 0 auto;
            position: relative;
        }
        /* Corrigido: Cards precisam ser menores para caberem bem */
        .card img {
            height: 350px; 
            object-fit: cover;
        }
        .welcome-alert {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            padding: 12px 25px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            animation: fadeOut 4s forwards; /* desaparece após 4s */
        }

        @keyframes fadeOut {
            0% { opacity: 1; }
            80% { opacity: 1; }
            100% { opacity: 0; }
        }
    </style>
</head>
<body>

<?php
// Lógica para exibir a mensagem de boas-vindas
if (isset($_SESSION['just_logged_in']) && $_SESSION['just_logged_in'] === true) {
    $user_name = isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Visitante';
    echo '<div class="alert alert-success welcome-alert" role="alert">';
    echo 'Bem-vindo de volta, ' . $user_name . '!';
    echo '</div>';
    unset($_SESSION['just_logged_in']);
}
?>

<div class="content">
    <div class="banner text-center mb-5">
        <div>
            <h1>Bem-vindo à Essência Pura</h1>
            <a href="#produtos" class="btn btn-light mt-3">Confira nossos produtos</a>
        </div>
    </div>
    
    <div class="m-5">
        <section id="sobre" class="mb-5">
            <h2>Nossa Essência</h2>
            <div class="row g-4 mt-2 align-items-center">
                <div class="col-md-6">
                    <p>Desde a nossa fundação, na Essência Pura, buscamos capturar a beleza e a complexidade da natureza em cada frasco de perfume...</p>
                </div>
            </div>
        </section>
        
        <section id="produtos" class="mb-5">
            <h2>Produtos em Destaque</h2>
            <div class="row g-4 mt-2">

                <?php 
                // Loop que exibe os 18 produtos dinamicamente 
                // Usando array_slice para limitar o número se desejar (aqui mostra todos)
                $produtos_em_destaque = array_slice($produtos, 0, 18, true); 
                ?>
                
                <?php foreach($produtos_em_destaque as $id => $p): ?>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="card">
                        <img src="<?= $p['imagem'] ?>" class="card-img-top" alt="<?= $p['nome'] ?>">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= $p['nome'] ?></h5>
                            <p class="fw-bold">R$ <?= number_format($p['preco'], 2, ',', '.') ?></p>
                            
                            <a href="detalhes.php?id=<?= $id ?>" class="btn btn-success mb-2">Saiba Mais</a><br>
                            
                            <a href="carrinho.php?action=add&id=<?= $id ?>&name=<?= urlencode($p['nome']) ?>&price=<?= $p['preco'] ?>" class="btn btn-warning">
                                Adicionar ao Carrinho
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

            </div>
        </section>
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

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            <video class="w-100 rounded" controls muted loop>
                <source src="video/perfume.mp4" type="video/mp4">
                Seu navegador não suporta a tag de vídeo.
            </video>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>