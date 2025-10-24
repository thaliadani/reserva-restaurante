<?php
// INICIA A SESSÃO NO TOPO
session_start();

// 1. Incluir a classe de conexão com o banco de dados
require_once '../includes/classes/Database.php';

// Verifica se os dados foram enviados pelo método POST (do formulário)
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 2. Coletar e Sanear os dados do formulário
    // Usamos htmlspecialchars() e trim() para segurança básica contra XSS e espaços
    $nome = trim($_POST['nome_cliente'] ?? '');
    $email = trim($_POST['email_cliente'] ?? '');
    $telefone = trim($_POST['telefone_cliente'] ?? ''); // Opcional, pode ser nulo
    $data = $_POST['data_reserva'];
    $hora = $_POST['hora_reserva'];
    $pessoas = (int) $_POST['num_pessoas'];
    $observacoes = trim($_POST['observacoes'] ?? ''); // Opcional, pode ser nulo

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Formato de e-mail inválido.");
    }

    // 3. Conectar ao Banco de Dados
    $database = new Database();
    $db = $database->getConnection();

    // 4. Query SQL com Prepared Statement (usando placeholders :nome_do_campo)
    $query = "INSERT INTO reservas 
            (nome_cliente, email_cliente, telefone_cliente, data_reserva, hora_reserva, num_pessoas, observacoes) 
            VALUES 
            (:nome_cliente, :email_cliente, :telefone_cliente, :data_reserva, :hora_reserva, :num_pessoas, :observacoes)";

    // Preparar a instrução SQL
    $stmt = $db->prepare($query);

    // 5. Bind dos parâmetros (Ligação dos dados aos placeholders)
    // Isso garante que os dados sejam tratados como texto e não como comandos SQL!
    $stmt->bindValue(':nome_cliente', htmlspecialchars($nome), PDO::PARAM_STR);
    $stmt->bindValue(':email_cliente', $email, PDO::PARAM_STR);
    $stmt->bindValue(':telefone_cliente', htmlspecialchars($telefone), PDO::PARAM_STR);
    $stmt->bindValue(':data_reserva', $data, PDO::PARAM_STR);
    $stmt->bindValue(':hora_reserva', $hora, PDO::PARAM_STR);
    $stmt->bindValue(':num_pessoas', $pessoas, PDO::PARAM_INT); // Especifica que é um inteiro
    $stmt->bindValue(':observacoes', htmlspecialchars($observacoes), PDO::PARAM_STR);

    // 6. Executar a instrução
    if ($stmt->execute()) {
        // SUCESSO: Armazena o status na sessão e redireciona de volta para a reserva.php
        $_SESSION['reserva_status'] = 'sucesso';
        $_SESSION['reserva_mensagem'] = 'Sua reserva foi confirmada com sucesso! Aguardamos você.';

        // Redireciona para o formulário (ou para a página inicial, se preferir)
        header("Location: reserva.php");
        exit();
    } else {
        // ERRO: Armazena o status de erro na sessão
        $_SESSION['reserva_status'] = 'erro';
        $_SESSION['reserva_mensagem'] = 'Houve um erro ao processar sua reserva. Tente novamente ou ligue para o restaurante.';

        // Redireciona para o formulário
        header("Location: reserva.php");
        exit();
    }

} else {
    // Se alguém tentar acessar processa_reserva.php diretamente
    header("Location: reserva.php");
    exit();
}
?>