<?php
// Arquivo: Usuario.php

class Usuario {
    private $db;
    private $nome;
    private $login;

   public function __construct(Database $db) { 
    $this->db = $db;
    }

    public function cadastrar($nome, $login, $senha) {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios (nome, login, senha) VALUES (?, ?, ?)";
        $stmt = $this->db->prepareAndExecute($sql, "sss", $nome, $login, $senha_hash);
        return $stmt->affected_rows > 0;
    }

    public function autenticar($login, $senha) {
        $sql = "SELECT nome, senha FROM usuarios WHERE login = ?";
        $stmt = $this->db->prepareAndExecute($sql, "s", $login);
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($senha, $user['senha'])) {
                $this->nome = $user['nome'];
                $this->login = $login;
                return true;
            }
        }
        return false;
    }

    public function getNome() {
        return $this->nome;
    }
}
?>