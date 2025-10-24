<?php
session_start();

// Habilitar a exibição de erros (SOMENTE EM DESENVOLVIMENTO!)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 1. Incluir a classe de conexão (Caminho CORRETO a partir de admin/)
require_once '../includes/classes/Database.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $usuario_form = trim($_POST['usuario'] ?? '');
    $senha_form = $_POST['senha'] ?? '';

    // 2. Conectar ao Banco de Dados
    $database = new Database();
    $db = $database->getConnection();
    
    // 3. Buscar o usuário no banco de dados
    $query = "SELECT usuario, senha FROM usuarios_admin WHERE usuario = :usuario LIMIT 0,1";
    
    $stmt = $db->prepare($query);
    $stmt->bindParam(':usuario', $usuario_form);
    $stmt->execute();

    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    // 4. Lógica de Verificação
    if ($admin && password_verify($senha_form, $admin['senha'])) {
        
        // SUCESSO! Inicia a sessão e redireciona
        $_SESSION['admin_logado'] = true;
        $_SESSION['admin_usuario'] = $admin['usuario']; 
        
        header("Location: reservas_lista.php");
        exit();
        
    } else {
        // FALHA
        $_SESSION['login_erro'] = "Usuário ou senha inválidos.";
        header("Location: index.php");
        exit();
    }

} else {
    // Redireciona se a página for acessada diretamente
    header("Location: index.php");
    exit();
}
?>