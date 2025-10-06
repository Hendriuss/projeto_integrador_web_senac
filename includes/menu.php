<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand text-white fw-bold" href="index.php">Ospina</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">

      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link text-white" href="index.php">Início</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="contato.php">Contato</a>
        </li>
        <?php
        // Verifica se a sessão 'logado' existe para saber se o usuário está autenticado
        if (isset($_SESSION['logado'])) {
          // Se estiver logado, exibe a saudação com o nome do usuário e o botão de Sair
          echo '<li class="nav-item">';
          echo '<a class="nav-link text-white" href="#"><i class="bi bi-person-fill"></i> Olá, ' . htmlspecialchars($_SESSION['user_name']) . '</a>';
          echo '</li>';
          echo '<li class="nav-item">';
          echo '<a class="nav-link text-white" href="sair.php"><i class="bi bi-box-arrow-right"></i> Sair</a>';
          echo '</li>';
        } else {
          // Se não estiver logado, exibe o link de Login
          echo '<li class="nav-item">';
          echo '<a class="nav-link text-white" href="login.php"><i class="bi bi-person-fill"></i> Login</a>';
          echo '</li>';
        }
        ?>
      </ul>

      <div class="d-flex align-items-center gap-3">
        <span class="nav-link text-white" id="cep-link"><i class="bi bi-geo-alt-fill"></i> insira seu cep</span>

        <div id="cep-container" class="d-none">
          <input type="text" id="cep-input" class="form-control" placeholder="Digite o CEP" maxlength="8">
          <div id="cep-resultado" class="mt-2 text-white"></div>
        </div>

        <a href="carrinho.php" class="btn btn-light position-relative">
          <i class="bi bi-cart-fill"></i>
          <?php
          $qtd = isset($_SESSION['carrinho']) ? count($_SESSION['carrinho']) : 0;
          if ($qtd > 0):
          ?>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            <?= $qtd ?>
          </span>
          <?php endif; ?>
        </a>
      </div>
    </div>
  </div>
</nav>

<style>
/* Estilos para a barra de navegação */
nav.navbar {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  z-index: 1000;
  background-color: rgba(124, 169, 130, 0.5); /* Cor com 50% de transparência */
  transition: background-color 0.3s ease; /* Transição suave */
}

/* Nova regra para quando o mouse passar por cima */
nav.navbar:hover {
  background-color: #425a52; /* OU USE #444444 para o cinza escuro */
}

.navbar-nav .nav-link {
  transition: all 0.3s;
}

.navbar-nav .nav-link:hover {
  color: #F5F0E6 !important;
  text-decoration: underline;
}

.navbar-brand:hover {
  color: #F5F0E6 !important;
}

.btn:hover {
  opacity: 0.8;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const cepLink = document.getElementById('cep-link');
  const cepContainer = document.getElementById('cep-container');
  const cepInput = document.getElementById('cep-input');
  const cepResultado = document.getElementById('cep-resultado');

  // Exibir o input quando o link for clicado
  cepLink.addEventListener('click', () => {
    cepContainer.classList.toggle('d-none');
    if (!cepContainer.classList.contains('d-none')) {
      cepInput.focus();
    }
  });

  // Enviar o CEP quando 8 dígitos forem digitados
  cepInput.addEventListener('input', (event) => {
    const cep = event.target.value.replace(/\D/g, ''); // Remove caracteres não numéricos

    if (cep.length === 8) {
      // Fazer a requisição para o servidor (cep.php)
      fetch(`cep.php?cep=${cep}`)
        .then(response => {
          // Verifica se a resposta foi bem-sucedida
          if (!response.ok) {
            throw new Error('Erro na requisição');
          }
          // Converte a resposta para JSON
          return response.json();
        })
        .then(data => {
          // Se a busca for bem-sucedida, exibe o endereço
          if (data.logradouro) {
            cepResultado.textContent = `${data.logradouro}, ${data.bairro}, ${data.localidade} - ${data.uf}`;
            cepResultado.style.color = 'green';
          } else {
            // Se o CEP não for encontrado
            cepResultado.textContent = 'CEP não encontrado.';
            cepResultado.style.color = 'orange';
          }
        })
        .catch(error => {
          // Em caso de erro na requisição
          console.error('Erro:', error);
          cepResultado.textContent = 'Ocorreu um erro ao buscar o CEP.';
          cepResultado.style.color = 'red';
        });
    } else {
      // Limpa o resultado se o CEP for incompleto
      cepResultado.textContent = '';
    }
  });
});
</script>