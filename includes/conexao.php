<?php
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "Ospina";

// Cria a conexão
$conexao = new mysqli($host, $usuario, $senha, $banco);

// Verifica erro de conexão
if ($conexao->connect_error) {
    die("Erro na conexão: " . $conexao->connect_error);
}

// Define charset para UTF-8
$conexao->set_charset("utf8mb4");
?>
