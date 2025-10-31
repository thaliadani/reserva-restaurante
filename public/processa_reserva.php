<?php
// PASSO 1: Iniciar a sessão.
session_start();

// PASSO 2: Incluir os arquivos necessários.
require_once '../includes/classes/Database.php';
// NOVO: Incluir o arquivo de segurança para a CHAVE e funções de criptografia.
require_once '../includes/config/security.php'; 

// PASSO 3: Verificar o método da requisição.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // PASSO 4: Coletar, limpar e CRIPTOGRAFAR os dados do formulário.
    $nome = trim($_POST['nome_cliente'] ?? '');
    
    $email = trim($_POST['email_cliente'] ?? '');
    // $emailHash = hash('sha256', strtolower(trim($email))); // REMOVIDO: HASH É IRREVERSÍVEL.

    $telefone = trim($_POST['telefone_cliente'] ?? '');
    // $salt = "um_salt_secreto_e_unico"; // REMOVIDO: HASH É IRREVERSÍVEL.
    // $dados_para_hash = $numero_telefone . $salt;
    // $hash_telefone = hash('sha256', $dados_para_hash); // REMOVIDO: HASH É IRREVERSÍVEL.

    // APLICANDO CRIPTOGRAFIA SIMÉTRICA para salvar o dado de forma segura:
    $email_criptografado = encrypt_data($email);
    $telefone_criptografado = encrypt_data($telefone);
    // FIM DA CRIPTOGRAFIA

    $data = $_POST['data_reserva'];
    $hora = $_POST['hora_reserva'];
    $pessoas = (int) ($_POST['num_pessoas'] ?? 0); 
    $observacoes = trim($_POST['observacoes'] ?? '');

    // PASSO 5: Validação básica dos dados.
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['reserva_status'] = 'erro';
        $_SESSION['reserva_mensagem'] = 'O formato do e-mail fornecido é inválido. Por favor, corrija e tente novamente.';
        header("Location: reserva.php");
        die("Formato de e-mail inválido.");
    }
    
    // NOVO: Validação de telefone (exemplo básico: apenas dígitos).
    // Use expressões regulares mais robustas se necessário.
    $telefone_limpo = preg_replace('/[^0-9]/', '', $telefone);
    if (empty($telefone_limpo) || strlen($telefone_limpo) < 8) {
        $_SESSION['reserva_status'] = 'erro';
        $_SESSION['reserva_mensagem'] = 'O número de telefone é obrigatório e deve ser válido.';
        header("Location: reserva.php");
        die("Telefone inválido.");
    }

    // PASSO 6: Conectar ao Banco de Dados.
    $database = new Database();
    $db = $database->getConnection();

    // PASSO 7: Preparar a consulta SQL para inserção.
    // Os placeholders permanecem, a segurança contra SQL Injection é MANTIDA.
    $query = "INSERT INTO reservas 
              (nome_cliente, email_cliente, telefone_cliente, data_reserva, hora_reserva, num_pessoas, observacoes) 
              VALUES 
              (:nome_cliente, :email_cliente, :telefone_cliente, :data_reserva, :hora_reserva, :num_pessoas, :observacoes)";

    $stmt = $db->prepare($query);

    // PASSO 8: Ligar (bind) os valores aos placeholders da query.
    // AGORA LIGAMOS AS VARIÁVEIS CRIPTOGRAFADAS.
    $stmt->bindValue(':nome_cliente', htmlspecialchars($nome), PDO::PARAM_STR);
    $stmt->bindValue(':email_cliente', $email_criptografado, PDO::PARAM_STR); // Dado criptografado
    $stmt->bindValue(':telefone_cliente', $telefone_criptografado, PDO::PARAM_STR); // Dado criptografado
    $stmt->bindValue(':data_reserva', $data, PDO::PARAM_STR);
    $stmt->bindValue(':hora_reserva', $hora, PDO::PARAM_STR);
    $stmt->bindValue(':num_pessoas', $pessoas, PDO::PARAM_INT); 
    $stmt->bindValue(':observacoes', htmlspecialchars($observacoes), PDO::PARAM_STR);

    // PASSO 9: Executar a query e tratar o resultado. (Sem alterações)
    if ($stmt->execute()) {
        $_SESSION['reserva_status'] = 'sucesso';
        $_SESSION['reserva_mensagem'] = 'Sua reserva foi confirmada com sucesso! Aguardamos você.';

        header("Location: reserva.php");
        exit();
    } else {
        $_SESSION['reserva_status'] = 'erro';
        $_SESSION['reserva_mensagem'] = 'Houve um erro ao processar sua reserva. Tente novamente ou ligue para o restaurante.';

        header("Location: reserva.php");
        exit();
    }

} else {
    // PASSO 10: Tratar acesso direto. (Sem alterações)
    header("Location: reserva.php");
    exit();
}
?>