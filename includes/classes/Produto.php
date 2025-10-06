<?php
// Arquivo: Produto.php (Versão Completa)

// Certifique-se de incluir a classe Database se ela não for carregada automaticamente
// require_once 'Database.php'; 

class Produto {
    private $db;
    public $id;
    public $nome;
    public $preco;
    public $estoque;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    // NOVO MÉTODO: Busca todos os produtos para a listagem
    public function buscarTodos() {
        $sql = "SELECT id, nome, preco, estoque, imagem, referencia, descricao FROM produtos ORDER BY nome ASC";
        $stmt = $this->db->prepareAndExecute($sql);
        $result = $stmt->get_result();
        
        // Retorna um array associativo de todos os produtos
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function buscarPorId($id) {
        $sql = "SELECT id, nome, preco, estoque, imagem, descricao FROM produtos WHERE id = ?";
        $stmt = $this->db->prepareAndExecute($sql, "i", $id);
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            $this->id = $data['id'];
            $this->nome = $data['nome'];
            $this->preco = $data['preco'];
            $this->estoque = $data['estoque'];
            // Se você tiver colunas 'imagem' e 'descricao' na tabela, adicione-as aqui também!
            // $this->imagem = $data['imagem'];
            // $this->descricao = $data['descricao'];
            return $data; // Retorna o array de dados completo
        }
        return false;
    }

    public function vender($quantidade) {
        // ... (seu código de venda original)
        if ($this->estoque >= $quantidade) {
             $novo_estoque = $this->estoque - $quantidade;
             $sql = "UPDATE produtos SET estoque = ? WHERE id = ?";
             $this->db->prepareAndExecute($sql, "ii", $novo_estoque, $this->id);
             return true;
         }
         return false;
    }
}
?>