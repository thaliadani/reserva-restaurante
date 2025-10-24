<?php
session_start();

// Habilitar a exibição de erros (SOMENTE EM DESENVOLVIMENTO!)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Define o cabeçalho para indicar que a resposta é JSON (importante para o AJAX/fetch)
header('Content-Type: application/json');

// 1. Proteção: Verifica se o administrador está logado
if (!isset($_SESSION['admin_logado']) || $_SESSION['admin_logado'] !== true) {
    // Retorna erro e código HTTP 401 (Não Autorizado)
    http_response_code(401); 
    echo json_encode(['success' => false, 'message' => 'Acesso não autorizado.']);
    exit();
}

// Verifica se os dados necessários foram enviados via POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_reserva']) && isset($_POST['novo_status'])) {
    
    // 2. Coletar e Sanear os dados
    $id_reserva = filter_var($_POST['id_reserva'], FILTER_VALIDATE_INT);
    $novo_status = htmlspecialchars(trim($_POST['novo_status']));

    // Verifica se o ID é um número válido e se o status é um valor permitido (para segurança extra)
    $status_validos = ['Pendente', 'Confirmada', 'Cancelada'];
    
    if ($id_reserva === false || !in_array($novo_status, $status_validos)) {
        http_response_code(400); // Bad Request
        echo json_encode(['success' => false, 'message' => 'Dados de status inválidos fornecidos.']);
        exit();
    }

    // 3. Conectar ao Banco de Dados (Caminho CORRETO a partir de admin/)
    require_once '../includes/classes/Database.php';
    $database = new Database();
    $db = $database->getConnection();
    
    try {
        // 4. Query SQL para ATUALIZAR o status (UPDATE)
        $query = "UPDATE reservas SET status = :novo_status WHERE id_reserva = :id_reserva";
        
        $stmt = $db->prepare($query);

        // Bind dos parâmetros com segurança
        $stmt->bindParam(':novo_status', $novo_status);
        $stmt->bindParam(':id_reserva', $id_reserva, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Sucesso: Define a mensagem na sessão para ser exibida após o reload
            $_SESSION['status_msg'] = [
                'tipo' => 'success', 
                'texto' => "Status da Reserva #{$id_reserva} alterado para '{$novo_status}'."
            ];
            
            // Retorna sucesso para o JavaScript
            echo json_encode(['success' => true]);
            
        } else {
            // Falha na execução
            $_SESSION['status_msg'] = [
                'tipo' => 'warning', 
                'texto' => 'Falha ao executar a atualização no banco de dados.'
            ];
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Falha no UPDATE.']);
        }
        
    } catch (PDOException $e) {
        // Erro de BD
        $_SESSION['status_msg'] = [
            'tipo' => 'danger', 
            'texto' => 'Erro de banco de dados: ' . $e->getMessage()
        ];
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Erro de BD.']);
    }

} else {
    // Acesso direto ou dados ausentes
    $_SESSION['status_msg'] = [
        'tipo' => 'warning', 
        'texto' => 'Acesso inválido à página de processamento.'
    ];
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Acesso inválido.']);
}
exit();
?>