<?php
session_start();
include_once("includes/conexao.php");
include_once("includes/classes/Usuario.php");

$db = new Database();
$usuario = new Usuario($db);

$login = filter_input(INPUT_POST, 'email', FILTER_UNSAFE_RAW);
$senha = filter_input(INPUT_POST, 'senha', FILTER_UNSAFE_RAW);

if ($usuario->autenticar($login, $senha)) {
    $_SESSION['logado'] = true;
    $_SESSION['user_name'] = $usuario->getNome(); // Pega o nome da pessoa da classe
    $_SESSION['just_logged_in'] = true;
    header('Location: index.php');
    exit();
} else {
    header('Location: login.php?error=login_invalido');
    exit();
}

$db->close();
?>