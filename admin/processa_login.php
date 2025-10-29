<?php
// PASSO 1: Iniciar a sessão.
// É essencial para que possamos armazenar informações do usuário logado (como $_SESSION['admin_logado'])
// e também para passar mensagens de erro de volta para a página de login.
session_start();

// PASSO 2: Incluir os arquivos necessários.
// Incluímos a classe Database para poder nos conectar ao banco de dados.
require_once '../includes/classes/Database.php'; 

// PASSO 3: Verificar se o formulário foi enviado.
// Checamos se o método da requisição é POST, o que indica que o formulário de login foi submetido.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // PASSO 4: Coletar e limpar os dados do formulário.
    // Usamos trim() para remover espaços em branco do início e do fim.
    // O operador '??' (null coalescing) garante que, se o campo não for enviado, o valor será uma string vazia, evitando erros.
    $usuario_form = trim($_POST['usuario'] ?? '');
    $senha_form = $_POST['senha'] ?? '';

    // PASSO 5: Conectar ao Banco de Dados.
    // Criamos uma instância da nossa classe Database e obtemos o objeto de conexão PDO.
    $database = new Database();
    $db = $database->getConnection();
    
    // PASSO 6: Preparar a consulta SQL para buscar o usuário.
    // Usamos um "prepared statement" com um placeholder (:usuario) para evitar injeção de SQL.
    // A consulta busca na tabela 'usuarios_admin' pelo 'usuario' fornecido. LIMIT 1 otimiza a busca.
    $query = "SELECT usuario, senha FROM usuarios_admin WHERE usuario = :usuario LIMIT 0,1";
    
    $stmt = $db->prepare($query);
    // Ligamos (bind) o valor da variável $usuario_form ao placeholder :usuario.
    $stmt->bindParam(':usuario', $usuario_form);
    $stmt->execute();

    // Buscamos o resultado como um array associativo. Se nenhum usuário for encontrado, $admin será false.
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    // PASSO 7: Verificar a senha.
    // Primeiro, checamos se um usuário foi encontrado ($admin).
    // Depois, usamos password_verify() para comparar a senha enviada ($senha_form) com o hash da senha armazenado no banco ($admin['senha']).
    // Esta é a maneira correta e segura de verificar senhas.
    if ($admin && password_verify($senha_form, $admin['senha'])) {
        // SUCESSO NO LOGIN: A senha corresponde.
        // Armazenamos na sessão que o admin está logado e qual é o seu nome de usuário.
        $_SESSION['admin_logado'] = true;
        $_SESSION['admin_usuario'] = $admin['usuario']; 
        
        // Redirecionamos para a página principal do painel administrativo.
        header("Location: reservas_lista.php");
        exit();
        
    } else {
        // FALHA NO LOGIN: Usuário não encontrado ou senha incorreta.
        // Criamos uma mensagem de erro na sessão que será exibida na página de login.
        $_SESSION['login_erro'] = "Usuário ou senha inválidos.";
        // Redirecionamos de volta para a página de login.
        header("Location: index.php");
        exit();
    }

} else {
    // Se alguém tentar acessar este arquivo diretamente (via GET), redireciona para a página de login.
    header("Location: index.php");
    exit();
}
?>