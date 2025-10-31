<?php
// PASSO 1: Iniciar a sessão.
// Essencial para verificar se o administrador está logado e para definir mensagens de feedback.
session_start();

// PASSO 2: Definir o tipo de conteúdo da resposta.
// Como este script é um endpoint para uma requisição JavaScript (fetch),
// informamos ao navegador que a resposta será no formato JSON.
header('Content-Type: application/json');

// PASSO 3: Proteção de segurança - Autenticação.
// Verifica se o administrador está logado. Se não estiver, a execução é interrompida.
if (!isset($_SESSION['admin_logado']) || $_SESSION['admin_logado'] !== true) {
    // Define o código de status HTTP para 401 (Não Autorizado).
    http_response_code(401); 
    // Envia uma resposta JSON de erro e encerra o script.
    echo json_encode(['success' => false, 'message' => 'Acesso não autorizado.']);
    exit();
}

// PASSO 4: Verificar o método da requisição e a presença dos dados.
// Garante que o script foi acessado via POST e que os dados esperados (id e status) foram enviados.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_reserva']) && isset($_POST['novo_status'])) {
    
    // PASSO 5: Coletar, validar e limpar os dados recebidos.
    // `filter_var` com `FILTER_VALIDATE_INT` garante que o ID é um número inteiro válido.
    $id_reserva = filter_var($_POST['id_reserva'], FILTER_VALIDATE_INT);
    // `htmlspecialchars` e `trim` limpam o status de tags HTML e espaços em branco.
    $novo_status = htmlspecialchars(trim($_POST['novo_status']));

    // PASSO 6: Validação de segurança extra.
    // Define uma lista de status permitidos para evitar que valores inesperados sejam inseridos no banco.
    $status_validos = ['Pendente', 'Confirmada', 'Cancelada'];
    
    // Se o ID não for um inteiro válido ou se o status não estiver na lista de valores permitidos...
    if ($id_reserva === false || !in_array($novo_status, $status_validos)) {
        // Define o código de status para 400 (Requisição Inválida).
        http_response_code(400);
        // Envia uma mensagem de erro e encerra o script.
        echo json_encode(['success' => false, 'message' => 'Dados de status inválidos fornecidos.']);
        exit();
    }

    // PASSO 7: Conectar ao Banco de Dados.
    require_once '../includes/classes/Database.php';
    $database = new Database();
    $db = $database->getConnection();
    
    // PASSO 8: Tentar executar a atualização no banco de dados.
    // O bloco try...catch captura possíveis erros de banco de dados (PDOException).
    try {
        // Prepara a query de UPDATE usando placeholders (:novo_status, :id_reserva) para prevenir SQL Injection.
        $query = "UPDATE reservas SET status = :novo_status WHERE id_reserva = :id_reserva";
        
        $stmt = $db->prepare($query);

        // Liga (bind) as variáveis PHP aos placeholders da query, garantindo a segurança.
        $stmt->bindParam(':novo_status', $novo_status);
        $stmt->bindParam(':id_reserva', $id_reserva, PDO::PARAM_INT);

        // PASSO 9: Executar a query e tratar o resultado.
        if ($stmt->execute()) {
            // SUCESSO: A atualização foi bem-sucedida.
            // Define uma "flash message" na sessão, que será exibida na página de listagem após o reload.
            $_SESSION['status_msg'] = [
                'tipo' => 'success', 
                'texto' => "Status da Reserva #{$id_reserva} alterado para '{$novo_status}'."
            ];
            
            // Envia uma resposta JSON de sucesso para o JavaScript que fez a requisição.
            echo json_encode(['success' => true]);
            
        } else {
            // FALHA: A execução da query falhou por algum motivo.
            // Define uma mensagem de erro na sessão.
            $_SESSION['status_msg'] = [
                'tipo' => 'warning', 
                'texto' => 'Falha ao executar a atualização no banco de dados.'
            ];
            // Define o código de status para 500 (Erro Interno do Servidor).
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Falha no UPDATE.']);
        }
        
    } catch (PDOException $e) {
        // ERRO DE BANCO DE DADOS: O bloco 'try' falhou.
        // Define uma mensagem de erro detalhada na sessão.
        $_SESSION['status_msg'] = [
            'tipo' => 'danger', 
            'texto' => 'Erro de banco de dados: ' . $e->getMessage()
        ];
        http_response_code(500);
        // Envia uma resposta JSON genérica para o cliente.
        echo json_encode(['success' => false, 'message' => 'Erro de BD.']);
    }

} else {
    // PASSO 10: Tratar acesso inválido.
    // Este bloco é executado se o script for acessado diretamente (via GET) ou se os dados POST estiverem faltando.
    $_SESSION['status_msg'] = [
        'tipo' => 'warning', 
        'texto' => 'Acesso inválido à página de processamento.'
    ];
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Acesso inválido.']);
}
// Encerra o script para garantir que nada mais seja executado.
exit();
?>