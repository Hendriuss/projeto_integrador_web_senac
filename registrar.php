<?php
// Arquivo: registrar.php

// Inicia a sessão (necessário para autenticação ou mensagens futuras)
session_start();

// 1. Inclui o arquivo que CRIA a variável $conexao (do tipo mysqli)
require_once("includes/conexao.php"); 
// 2. Inclui a classe Database (ESSENCIAL para a tipagem correta)
require_once("includes/classes/Database.php"); 
// 3. Inclui a classe Usuario
require_once("includes/classes/Usuario.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 4. Instancia a classe Database, passando o objeto mysqli ($conexao)
    // O objeto $db AGORA é do tipo Database.
    $db = new Database($conexao);

    // 5. Cria um novo objeto Usuario, passando o objeto Database ($db)
    // Isso satisfaz o construtor Usuario::__construct(Database $db)
    $usuario = new Usuario($db); 

    // 6. Sanitiza e coleta os dados do POST
    $nome = filter_input(INPUT_POST, 'nome', FILTER_UNSAFE_RAW);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_UNSAFE_RAW);

    // Validação básica
    if (empty($nome) || empty($email) || empty($senha)) {
        header('Location: cadastro.php?error=campos_vazios');
        exit();
    }
    
    try {
        // 7. Tenta cadastrar o usuário
        if ($usuario->cadastrar($nome, $email, $senha)) {
            // Sucesso
            header('Location: login.php?cadastro_ok=true');
            exit();
        } else {
            // Falha (mais provável: e-mail já existe)
            header('Location: cadastro.php?error=email_existente');
            exit();
        }
        
    } catch (Exception $e) {
        // Captura erros de banco de dados (lançados pela classe Database)
        error_log("Erro no registro (SQL/DB): " . $e->getMessage());
        header('Location: cadastro.php?error=db_error');
        exit();
    } finally {
        // Fecha a conexão usando o método da classe Database
        $db->close();
    }
} else {
    // Se acessado diretamente, redireciona para o formulário
    header('Location: cadastro.php');
    exit();
}
// SEM TAG DE FECHAMENTO ?>