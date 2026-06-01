<?php
class db
{
    private $host       = 'localhost';
    private $user       = 'root';
    private $password   = '';
    private $port       = '3306';
    private $dbname     = 'db_pweb1_2026_1';
    private $table_name;
    private $conn;

    public function __construct($table_name)
    {
        $this->table_name = $table_name;
        $this->conn = $this->connect();
    }

    private function connect()
    {
        try {
            return new PDO(
                "mysql:host=$this->host;dbname=$this->dbname;port=$this->port;charset=utf8",
                $this->user,
                $this->password,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            die('Erro na conexão: ' . $e->getMessage());
        }
    }

    // SELECT * FROM tabela
    public function index()
    {
        $sql = "SELECT * FROM $this->table_name";
        $st  = $this->conn->prepare($sql);
        $st->execute();
        return $st->fetchAll(PDO::FETCH_CLASS);
    }

    // SELECT * FROM tabela WHERE id = ?
    public function find($id)
    {
        $sql = "SELECT * FROM $this->table_name WHERE id = ?";
        $st  = $this->conn->prepare($sql);
        $st->execute([$id]);
        return $st->fetchObject();
    }

    // INSERT INTO tabela (campos) VALUES (?)
    public function store($dados)
    {
        $campos     = implode(',', array_keys($dados));
        $marcadores = implode(',', array_fill(0, count($dados), '?'));
        $valores    = array_values($dados);

        $sql = "INSERT INTO $this->table_name ($campos) VALUES ($marcadores)";
        try {
            $st = $this->conn->prepare($sql);
            $st->execute($valores);
        } catch (PDOException $e) {
            throw new Exception("Erro ao inserir: " . $e->getMessage());
        }
    }

    // SELECT * FROM tabela WHERE campo LIKE '%valor%'
    public function search($dados)
    {
        $campo = $dados['tipo'];
        $valor = $dados['valor'];
        $sql = "SELECT * FROM $this->table_name WHERE $campo LIKE ?";
        try {
            $st = $this->conn->prepare($sql);
            $st->execute(["%$valor%"]);
            return $st->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $e) {
            throw new Exception("Erro ao buscar: " . $e->getMessage());
        }
    }

    // DELETE FROM tabela WHERE id = ?
    public function destroy($id)
    {
        $sql = "DELETE FROM $this->table_name WHERE id = ?";
        try {
            $st = $this->conn->prepare($sql);
            $st->execute([$id]);
        } catch (PDOException $e) {
            throw new Exception("Erro ao deletar: " . $e->getMessage());
        }
    }
}