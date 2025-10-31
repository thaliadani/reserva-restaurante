<?php
// PASSO 1: Iniciar a sessão para usar mensagens de feedback.
session_start();

// PASSO 2: Incluir os arquivos necessários.
require_once '../includes/classes/Database.php'; 

// PASSO 3: Verificar se o formulário foi enviado via POST.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // PASSO 4: Coletar e limpar os dados do formulário.
    $usuario = trim($_POST['usuario'] ?? '');
    $nome_completo = trim($_POST['nome_completo'] ?? '');
    $senha = $_POST['senha'] ?? '';

    // Validação básica: garantir que os campos não estão vazios.
    if (empty($usuario) || empty($senha) || empty($nome_completo)) {
        $_SESSION['status_msg'] = ['tipo' => 'danger', 'texto' => 'Todos os campos são obrigatórios.'];
        header("Location: cadastro.php");
        exit();
    }

    // PASSO 5: Conectar ao Banco de Dados.
    $database = new Database();
    $db = $database->getConnection();
    
    // PASSO 6: Verificar se o nome de usuário já existe.
    // Isso evita duplicatas e garante que cada nome de usuário seja único.
    $query_check = "SELECT id_admin FROM usuarios_admin WHERE usuario = :usuario";
    $stmt_check = $db->prepare($query_check);
    $stmt_check->bindParam(':usuario', $usuario);
    $stmt_check->execute();

    if ($stmt_check->rowCount() > 0) {
        // Se rowCount > 0, o usuário já existe.
        $_SESSION['status_msg'] = ['tipo' => 'warning', 'texto' => 'Este nome de usuário já está em uso. Por favor, escolha outro.'];
        header("Location: cadastro.php");
        exit();
    }

    // PASSO 7: Criar o hash da senha.
    // password_hash() cria um hash seguro e moderno. É a forma recomendada de armazenar senhas.
    $senha_hashed = password_hash($senha, PASSWORD_DEFAULT);

    // PASSO 8: Preparar e executar a inserção no banco de dados.
    try {
        $query_insert = "INSERT INTO usuarios_admin (nome_completo, usuario, senha) VALUES (:nome_completo, :usuario, :senha)";
        $stmt_insert = $db->prepare($query_insert);
        
        $stmt_insert->bindParam(':usuario', $usuario);
        $stmt_insert->bindParam(':nome_completo', $nome_completo);
        $stmt_insert->bindParam(':senha', $senha_hashed);

        if ($stmt_insert->execute()) {
            // Sucesso! Redireciona para a página de login com uma mensagem de sucesso.
            $_SESSION['status_msg'] = ['tipo' => 'success', 'texto' => 'Cadastro realizado com sucesso! Você já pode fazer login.'];
            header("Location: index.php");
            exit();
        } else {
            throw new Exception("A execução da inserção falhou.");
        }

    } catch (Exception $e) {
        // Em caso de erro no banco de dados, registra o erro e informa o usuário.
        error_log("Erro no cadastro de admin: " . $e->getMessage());
        $_SESSION['status_msg'] = ['tipo' => 'danger', 'texto' => 'Ocorreu um erro ao tentar criar a conta. Tente novamente.'];
        header("Location: cadastro.php");
        exit();
    }

} else {
    // Se o arquivo for acessado diretamente (não via POST), redireciona.
    header("Location: cadastro.php");
    exit();
}
?>