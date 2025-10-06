<?php
// Arquivo: Database.php

class Database {
    private $conexao;

    public function __construct(mysqli $conexao) {
        $this->conexao = $conexao;
    }

    // Implementa o método customizado que a classe Usuario precisa
    public function prepareAndExecute($sql, $tipos = '', ...$params) {
        $stmt = $this->conexao->prepare($sql);

        if (!$stmt) {
            throw new Exception("Erro na preparação da query: " . $this->conexao->error);
        }

        if ($tipos) {
            $stmt->bind_param($tipos, ...$params);
        }

        if (!$stmt->execute()) {
            throw new Exception("Erro na execução da query: " . $stmt->error);
        }
        
        return $stmt;
    }
    
    public function close() {
        $this->conexao->close();
    }
}
?>