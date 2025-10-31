<?php
// Define o fuso horário para garantir que a comparação de tempo seja correta.
// Use o fuso horário do seu servidor/localização. Ex: 'America/Sao_Paulo'.
date_default_timezone_set('America/Sao_Paulo');

// Define um caminho base para facilitar a inclusão de arquivos.
// __DIR__ é o diretório do arquivo atual (admin), então '..' sobe um nível.
define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/includes/classes/Database.php';

echo "Iniciando script de limpeza de reservas antigas em " . date('Y-m-d H:i:s') . "\n";

try {
    // 1. Conectar ao banco de dados
    $database = new Database();
    $db = $database->getConnection();

    // 2. Preparar a query SQL para deletar reservas passadas
    // A função CONCAT junta a data e a hora em uma única string.
    // A função STR_TO_DATE converte essa string em um formato DATETIME.
    // NOW() retorna a data e hora atuais do servidor de banco de dados.
    // A query deleta todas as linhas onde a data/hora da reserva é anterior a agora.
    $query = "DELETE FROM reservas WHERE STR_TO_DATE(CONCAT(data_reserva, ' ', hora_reserva), '%Y-%m-%d %H:%i:%s') < NOW()";

    $stmt = $db->prepare($query);

    // 3. Executar a query
    $stmt->execute();

    // 4. Obter e registrar o número de linhas afetadas (reservas deletadas)
    $num_deleted = $stmt->rowCount();

    if ($num_deleted > 0) {
        $log_message = "Limpeza concluída. {$num_deleted} reserva(s) antiga(s) foram deletadas.\n";
    } else {
        $log_message = "Nenhuma reserva antiga para deletar.\n";
    }

    echo $log_message;
    // Opcional: Salvar em um arquivo de log
    // file_put_contents(BASE_PATH . '/logs/cron.log', date('Y-m-d H:i:s') . " - " . $log_message, FILE_APPEND);

} catch (Exception $e) {
    $error_message = "Erro durante a execução do script de limpeza: " . $e->getMessage() . "\n";
    echo $error_message;
    // Salva o erro no log do PHP ou em um arquivo de log customizado
    error_log($error_message);
}