<?php
// PASSO 1: Iniciar a sessão.
// Isso é crucial para que possamos armazenar mensagens de feedback (sucesso ou erro)
// e exibi-las na página do formulário após o redirecionamento.
session_start();

// PASSO 2: Incluir os arquivos necessários.
// Incluímos a classe Database para nos conectarmos ao banco de dados.
require_once '../includes/classes/Database.php';

// PASSO 3: Verificar o método da requisição.
// Este bloco de código só será executado se o formulário for enviado (método POST).
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // PASSO 4: Coletar e limpar os dados do formulário.
    // `trim()` remove espaços em branco do início e do fim.
    // O operador '??' (null coalescing) garante um valor padrão (string vazia) se o campo não for enviado, evitando erros.
    $nome = trim($_POST['nome_cliente'] ?? '');
    $email = trim($_POST['email_cliente'] ?? '');
    $telefone = trim($_POST['telefone_cliente'] ?? '');
    $data = $_POST['data_reserva'];
    $hora = $_POST['hora_reserva'];
    $pessoas = (int) ($_POST['num_pessoas'] ?? 0); // Converte para inteiro.
    $observacoes = trim($_POST['observacoes'] ?? '');

    // PASSO 5: Validação básica dos dados.
    // `filter_var` com `FILTER_VALIDATE_EMAIL` verifica se o e-mail tem um formato válido.
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Se a validação falhar, define uma mensagem de erro e redireciona.
        $_SESSION['reserva_status'] = 'erro';
        $_SESSION['reserva_mensagem'] = 'O formato do e-mail fornecido é inválido. Por favor, corrija e tente novamente.';
        header("Location: reserva.php");
        die("Formato de e-mail inválido.");
    }

    // PASSO 6: Conectar ao Banco de Dados.
    // Cria uma instância da classe Database e obtém o objeto de conexão PDO.
    $database = new Database();
    $db = $database->getConnection();

    // PASSO 7: Preparar a consulta SQL para inserção.
    // Usamos um "prepared statement" com placeholders nomeados (ex: :nome_cliente).
    // Esta é a maneira mais segura de executar queries, pois previne ataques de injeção de SQL.
    $query = "INSERT INTO reservas 
            (nome_cliente, email_cliente, telefone_cliente, data_reserva, hora_reserva, num_pessoas, observacoes) 
            VALUES 
            (:nome_cliente, :email_cliente, :telefone_cliente, :data_reserva, :hora_reserva, :num_pessoas, :observacoes)";

    $stmt = $db->prepare($query);

    // PASSO 8: Ligar (bind) os valores aos placeholders da query.
    // Isso associa as variáveis PHP aos placeholders na query SQL, garantindo que os dados sejam tratados corretamente.
    // `htmlspecialchars` é usado para converter caracteres especiais em entidades HTML, uma camada extra de segurança contra XSS.
    $stmt->bindValue(':nome_cliente', htmlspecialchars($nome), PDO::PARAM_STR);
    $stmt->bindValue(':email_cliente', $email, PDO::PARAM_STR);
    $stmt->bindValue(':telefone_cliente', htmlspecialchars($telefone), PDO::PARAM_STR);
    $stmt->bindValue(':data_reserva', $data, PDO::PARAM_STR);
    $stmt->bindValue(':hora_reserva', $hora, PDO::PARAM_STR);
    $stmt->bindValue(':num_pessoas', $pessoas, PDO::PARAM_INT); // Especifica que o valor é um inteiro.
    $stmt->bindValue(':observacoes', htmlspecialchars($observacoes), PDO::PARAM_STR);

    // PASSO 9: Executar a query e tratar o resultado.
    if ($stmt->execute()) {
        // SUCESSO: A reserva foi inserida no banco de dados.
        // Armazenamos uma mensagem de sucesso na sessão para ser exibida na próxima página.
        $_SESSION['reserva_status'] = 'sucesso';
        $_SESSION['reserva_mensagem'] = 'Sua reserva foi confirmada com sucesso! Aguardamos você.';

        // Redireciona o usuário de volta para a página de reserva.
        header("Location: reserva.php");
        exit();
    } else {
        // ERRO: A inserção no banco de dados falhou.
        // Armazenamos uma mensagem de erro na sessão.
        $_SESSION['reserva_status'] = 'erro';
        $_SESSION['reserva_mensagem'] = 'Houve um erro ao processar sua reserva. Tente novamente ou ligue para o restaurante.';

        // Redireciona o usuário de volta para a página de reserva.
        header("Location: reserva.php");
        exit();
    }

} else {
    // PASSO 10: Tratar acesso direto.
    // Se alguém tentar acessar este arquivo diretamente (via GET, por exemplo), redireciona para a página de reserva.
    header("Location: reserva.php");
    exit();
}
?>