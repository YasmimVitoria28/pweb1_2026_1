<?php

class db
{
    private $host     = 'localhost';
    private $user     = 'root';
    private $password = '';
    private $port     = '3306';
    private $dbname   = 'cafeteria';
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
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                ]
            );
        } catch (PDOException $e) {
            die('Erro na conexão: ' . $e->getMessage());
        }
    }

    // [R]ead - Ler todos os registros
    public function all()
    {
        $sql = "SELECT * FROM $this->table_name";
        $st = $this->conn->prepare($sql);
        $st->execute();
        return $st->fetchAll(PDO::FETCH_OBJ);
    }

    // [C]reate - Inserir um novo registro
    public function store($dados)
    {
        $campos = "";
        $marcadores = "";
        $vetorData = [];
        $sep = "";

        foreach ($dados as $campo => $valor) {
            $campos .= $sep . $campo;
            $marcadores .= $sep . "?";
            $vetorData[] = $valor;
            $sep = ",";
        }
        $sql = "INSERT INTO $this->table_name ($campos) VALUES ($marcadores)";

        try {
            $st = $this->conn->prepare($sql);
            $st->execute($vetorData);
        } catch (PDOException $e) {
            var_dump("Erro ao inserir", $e->getMessage());
        }
    }

    // [R]ead - Buscar um registro específico por ID
    public function find($id)
    {
        $sql = "SELECT * FROM $this->table_name WHERE id = ? LIMIT 1";

        try {
            $st = $this->conn->prepare($sql);
            $st->execute([$id]);
            return $st->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            var_dump("Erro ao buscar por ID", $e->getMessage());
            return false;
        }
    }

    // [U]pdate - Atualizar um registro por ID
    public function update($id, $dados)
    {
        $campos = "";
        $vetorData = [];
        $sep = "";

        foreach ($dados as $campo => $valor) {
            $campos .= $sep . "$campo = ?";
            $vetorData[] = $valor;
            $sep = ", ";
        }
        $vetorData[] = $id; // id vai no final, para o WHERE

        $sql = "UPDATE $this->table_name SET $campos WHERE id = ?";

        try {
            $st = $this->conn->prepare($sql);
            $st->execute($vetorData);
        } catch (PDOException $e) {
            var_dump("Erro ao atualizar", $e->getMessage());
        }
    }

    // [D]elete - Excluir um registro por ID
    public function delete($id)
    {
        $sql = "DELETE FROM $this->table_name WHERE id = ?";

        try {
            $st = $this->conn->prepare($sql);
            return $st->execute([$id]);
        } catch (PDOException $e) {
            var_dump("Erro ao excluir registro", $e->getMessage());
            return false;
        }
    }
}