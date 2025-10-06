<?php
// Inclui o acesso ao banco de dados e a sua classe de manipulação
include_once("includes/conexao.php"); 
include_once("includes/classes/Contato.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Pega e sanitiza os dados do formulário
    $nome     = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $email    = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $assunto  = filter_input(INPUT_POST, 'assunto', FILTER_SANITIZE_STRING);
    $mensagem = filter_input(INPUT_POST, 'mensagem', FILTER_SANITIZE_STRING);

    // Validação básica
    if (empty($nome) || empty($email) || empty($assunto) || empty($mensagem)) {
        // header("Location: contato.php?status=error");
        exit;
    }

    // Prepara o conteúdo completo para caber na coluna 'descricacao'
    $conteudo_completo = "Assunto: " . $assunto . " | Mensagem: " . $mensagem;

    try {
        // Cria a instância da classe, passando a conexão
        $contatoManager = new Contato($conexao);

        // Chama o método enviar
        if ($contatoManager->enviar($nome, $email, $conteudo_completo)) {
            // Sucesso na inserção
            header("Location: contato.php?status=success");
            exit;
        } else {
            // Se falhar, redireciona para o erro (você pode verificar o log do XAMPP para o erro exato)
            header("Location: contato.php?status=error aqui");
            exit;
        }

    } catch (Throwable $e) {
        // Captura erros fatais (ex: arquivo Contato.php não encontrado)
        error_log("Erro Fatal ao processar contato: " . $e->getMessage());
        header("Location: contato.php?status=error");
        exit;
    }
    
} else {
    header("Location: contato.php");
    exit;
}
?>