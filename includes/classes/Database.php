<?php
require_once __DIR__ . '/../config/database.php';

class Database {
    // PASSO 1: Definir as propriedades (variáveis) da classe para a conexão.
    // Elas são 'private' para que só possam ser acessadas de dentro desta classe.
    // Os valores são atribuídos a partir das constantes definidas no arquivo de configuração.
    private $host = DB_HOST;
    private $db_name = DB_NAME;
    private $username = DB_USER;
    private $password = DB_PASS;
    private $charset = DB_CHARSET;
    public $conn; // Esta propriedade será pública para que o objeto de conexão possa ser acessado de fora.

    public function getConnection(){
        // PASSO 2: Inicializar a propriedade de conexão como nula.
        // Isso garante que não estamos reutilizando uma conexão antiga ou fechada.
        $this->conn = null;

        // PASSO 3: Montar o DSN (Data Source Name).
        // É uma string que informa ao PDO qual driver usar (mysql), o host, o nome do banco e o charset.
        $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset={$this->charset}";
        
        // PASSO 4: Definir opções de configuração para a conexão PDO.
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Define que o PDO deve lançar exceções em caso de erro.
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Define que o modo padrão de busca de dados será um array associativo (ex: ['coluna' => 'valor']).
            PDO::ATTR_EMULATE_PREPARES   => false,                  // Desabilita a emulação de prepared statements. Isso força o uso de prepared statements nativos do MySQL, o que é mais seguro contra SQL Injection.
        ];

        // PASSO 5: Tentar estabelecer a conexão dentro de um bloco try-catch.
        try{
            // Tenta criar uma nova instância do objeto PDO, que representa a conexão com o banco.
            $this->conn = new PDO($dsn, $this->username, $this->password, $options);
        }catch(PDOException $exception){
            // Se a conexão falhar, o PDO lançará uma PDOException, que é capturada aqui.
            
            // Registrar o erro detalhado no log do servidor para análise do desenvolvedor.
            // A mensagem completa, incluindo detalhes da exceção, será salva de forma segura.
            error_log("Erro de Conexão com o Banco de Dados: " . $exception->getMessage());

            http_response_code(503);
            die("Desculpe, estamos enfrentando problemas técnicos. Por favor, tente novamente mais tarde.");
        }

        // PASSO 6: Retornar o objeto de conexão (ou null, se a conexão falhou).
        return $this->conn;
    }
}