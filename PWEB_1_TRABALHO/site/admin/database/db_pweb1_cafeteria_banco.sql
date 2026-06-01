<?php
/**
 * Classe de Conexão com o Banco de Dados (MySQLi)
 * Projeto: Cafeteria - PWEB 1
 */
class DB {
    // Configurações de acesso ao servidor local Laragon
    private $host = "127.0.0.1";       // IP do servidor local (localhost)
    private $user = "root";            // Usuário padrão do Laragon
    private $password = "";            // Senha padrão do Laragon (vazia)
    private $database = "cafeteria";   // Nome do banco de dados que criamos
    private $con;                      // Variável que guardará a conexão ativa

    /**
     * Método responsável por estabelecer a conexão com o banco de dados
     * @return mysqli Retorna o objeto de conexão ativa
     */
    public function conectar() {
        // Inicializa a conexão utilizando a extensão nativa MySQLi do PHP
        $this->con = new mysqli($this->host, $this->user, $this->password, $this->database);

        // Verifica se ocorreu algum erro durante a tentativa de conexão
        if ($this->con->connect_error) {
            // Se falhar, interrompe a execução do sistema e exibe o erro
            die("Erro crítico de Conexão: " . $this->con->connect_error);
        }

        // Define o charset para utf8mb4 para garantir que acentos (á, é) e o 'ç' 
        // sejam salvos e lidos corretamente sem caracteres estranhos
        $this->con->set_charset("utf8mb4");

        // Retorna a conexão pronta para ser utilizada nas queries (consultas)
        return $this->con;
    }
}
?>