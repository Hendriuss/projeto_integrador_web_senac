<?php
session_start();
include_once 'produtos_data.php'; // <-- usa este arquivo

// Lista de produtos
$produtos = [
    1 => ['nome'=>'Lattafa Fakhar Black','preco'=>279.90,'img'=>'img/imagem.jpeg','desc'=>'Perfume importado exclusivo, fragrância marcante.'],
    2 => ['nome'=>'Produto 2','preco'=>219.90,'img'=>'img/imagem1.jpeg','desc'=>'Descrição breve do produto 2.'],
    3 => ['nome'=>'Malik Al Sharq','preco'=>219.90,'img'=>'img/imagem2.jpeg','desc'=>'Perfume elegante, aroma sofisticado.'],
];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Produtos - Essência Pura</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
    body { background-color: #f5f0e6; min-height: 100vh; }
    .card {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    }
    .card img { height: 300px; object-fit: cover; }
    .btn-ver { background-color: #7CA982; color: white; }
    .btn-ver:hover { background-color: #4A6352; }
    .btn-add { background-color: #DCA5B0; color: white; }
    .btn-add:hover { background-color: #b4828e; }
    .btn-buy { background-color: #f0a07f; color: white; }
    .btn-buy:hover { background-color: #d68966; }
    footer {
        background-color: #7CA982;
        color: white;
        text-align: center;
        padding: 15px 0;
        margin-top: 30px;
    }
    footer a { color: white; margin: 0 10px; font-size: 1.5rem; transition: color 0.3s; }
    footer a:hover { color: #DCA5B0; }
</style>
</head>
<body>

<div class="container mt-5">

    <!-- Botão Voltar para Início -->
    <a href="index.php" class="btn btn-secondary mb-4"><i class="bi bi-arrow-left"></i> Voltar para Início</a>

    <h2 class="mb-4 text-center">🌸 Todos os Produtos</h2>
    <div class="row g-4">

        <?php foreach($produtos as $id => $produto): ?>
        <div class="col-lg-4 col-md-6 col-12">
            <div class="card">
                <img src="<?= $produto['img'] ?>" class="card-img-top">
                <div class="card-body text-center">
                    <h5 class="card-title"><?= $produto['nome'] ?></h5>
                    <p class="card-text"><?= $produto['desc'] ?></p>
                    <p class="fw-bold">R$ <?= number_format($produto['preco'],2,',','.') ?></p>

                    <a href="detalhe.php?id=<?= $id ?>" class="btn btn-ver mb-2">Ver Produto</a>
                    <a href="carrinho.php?action=add&name=<?= urlencode($produto['nome']) ?>&price=<?= $produto['preco'] ?>" class="btn btn-add mb-2">
                        <i class="bi bi-cart"></i> Adicionar ao Carrinho
                    </a>
                    <a href="carrinho.php?action=add&name=<?= urlencode($produto['nome']) ?>&price=<?= $produto['preco'] ?>&comprar=1" class="btn btn-buy">
                        Comprar Agora
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

    </div>
</div>

<footer>
    <p>Siga-nos nas redes sociais</p>
    <a href="https://instagram.com/seuusuario" target="_blank"><i class="bi bi-instagram"></i></a>
    <a href="https://wa.me/5599999999999" target="_blank"><i class="bi bi-whatsapp"></i></a>
    <p class="mt-2">&copy; 2025 Essência Pura - Todos os direitos reservados</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
?php

session_start();



// Lista de produtos

$produtos = [

  1 => ['nome'=>'Lattafa Fakhar Black','preco'=>279.90,'img'=>'img/IMAGEM.png','desc'=>'Perfume importado exclusivo, fragrância marcante.'],

  2 => ['nome'=>'Produto 2','preco'=>219.90,'img'=>'img/imagem1.jpg','desc'=>'Descrição breve do produto 2.'],

  3 => ['nome'=>'Malik Al Sharq','preco'=>219.90,'img'=>'img/Imagem2.jpg','desc'=>'Perfume elegante, aroma sofisticado.'],

];

?>



<!DOCTYPE html>

<html lang="pt-BR">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Produtos - Essência Pura</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>

  body { background-color: #f5f0e6; min-height: 100vh; }

  .card {

    border-radius: 15px;

    overflow: hidden;

    box-shadow: 0 4px 8px rgba(0,0,0,0.1);

    transition: transform 0.3s, box-shadow 0.3s;

  }

  .card:hover {

    transform: translateY(-5px);

    box-shadow: 0 8px 16px rgba(0,0,0,0.2);

  }

  .card img { height: 300px; object-fit: cover; }

  .btn-ver { background-color: #7CA982; color: white; }

  .btn-ver:hover { background-color: #4A6352; }

  .btn-add { background-color: #DCA5B0; color: white; }

  .btn-add:hover { background-color: #b4828e; }

  .btn-buy { background-color: #f0a07f; color: white; }

  .btn-buy:hover { background-color: #d68966; }

  footer {

    background-color: #7CA982;

    color: white;

    text-align: center;

    padding: 15px 0;

    margin-top: 30px;

  }

  footer a { color: white; margin: 0 10px; font-size: 1.5rem; transition: color 0.3s; }

  footer a:hover { color: #DCA5B0; }

</style>

</head>

<body>



<div class="container mt-5">



  <!-- Botão Voltar para Início -->

  <a href="index.php" class="btn btn-secondary mb-4"><i class="bi bi-arrow-left"></i> Voltar para Início</a>



  <h2 class="mb-4 text-center">🌸 Todos os Produtos</h2>

  <div class="row g-4">



    <?php foreach($produtos as $id => $produto): ?>

    <div class="col-lg-4 col-md-6 col-12">

      <div class="card">

        <img src="<?= $produto['img'] ?>" class="card-img-top">

        <div class="card-body text-center">

          <h5 class="card-title"><?= $produto['nome'] ?></h5>

          <p class="card-text"><?= $produto['desc'] ?></p>

          <p class="fw-bold">R$ <?= number_format($produto['preco'],2,',','.') ?></p>



          <a href="produto_detalhe.php?id=<?= $id ?>" class="btn btn-ver mb-2">Ver Produto</a>

          <a href="carrinho.php?action=add&name=<?= urlencode($produto['nome']) ?>&price=<?= $produto['preco'] ?>" class="btn btn-add mb-2">

            <i class="bi bi-cart"></i> Adicionar ao Carrinho

          </a>

          <a href="carrinho.php?action=add&name=<?= urlencode($produto['nome']) ?>&price=<?= $produto['preco'] ?>&comprar=1" class="btn btn-buy">

            Comprar Agora

          </a>

        </div>

      </div>

    </div>

    <?php endforeach; ?>



  </div>

</div>



<footer>

  <p>Siga-nos nas redes sociais</p>

  <a href="https://instagram.com/seuusuario" target="_blank"><i class="bi bi-instagram"></i></a>

  <a href="https://wa.me/5599999999999" target="_blank"><i class="bi bi-whatsapp"></i></a>

  <p class="mt-2">&copy; 2025 Essência Pura - Todos os direitos reservados</p>

</footer>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>