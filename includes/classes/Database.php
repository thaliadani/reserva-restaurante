<?php
// Inclui as constantes de configuração
require_once __DIR__ . '/../config/database.php';

class Database {
    private $host = DB_HOST;
    private $db_name = DB_NAME;
    private $username = DB_USER;
    private $password = DB_PASS;
    private $charset = DB_CHARSET;
    public $conn;

    // Método para obter a conexão com o banco de dados
    public function getConnection(){
        $this->conn = null;

        $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset={$this->charset}";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Exibir erros
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Retornar dados como array associativo
            PDO::ATTR_EMULATE_PREPARES   => false,                  // Desabilitar emulação para segurança
        ];

        try{
            $this->conn = new PDO($dsn, $this->username, $this->password, $options);
        }catch(PDOException $exception){
            echo "Erro de Conexão: " . $exception->getMessage();
            // Em produção, você registraria o erro em um log, em vez de exibi-lo
        }

        return $this->conn;
    }
}