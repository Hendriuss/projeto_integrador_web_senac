<?php
class Contato {
    private $conexao;

    public function __construct(mysqli $conexao) {
        $this->conexao = $conexao;
    }

    // O método recebe os 3 dados que serão inseridos
    public function enviar($nome, $email, $conteudoMensagem) {
        
        // CORREÇÃO: Tabela 'mensagens' (assumindo que o banco está certo)
        // CORREÇÃO: Apenas 3 placeholders '?'
        $stmt = $this->conexao->prepare("
            INSERT INTO contato (nome, email, descricao)
            VALUES (?, ?, ?)
        ");
        
        if (!$stmt) {
            error_log("Erro no prepare: " . $this->conexao->error);
            return $this->conexao->error;
        }

        // CORREÇÃO: Apenas 3 tipos de dados 's'
        $stmt->bind_param("sss", $nome, $email, $conteudoMensagem);
        
        $resultado = $stmt->execute();
        $stmt->close();
        
        return $resultado;
    }
}
?>