<?php
// PASSO 1: Iniciar a sessão.
// Isso é necessário para acessar as variáveis de sessão, como a que verifica se o admin está logado.
session_start();

// Proteção: Se o administrador não estiver logado, redireciona para a página de login
// PASSO 2: Proteção da página.
// Verifica se a variável de sessão 'admin_logado' não existe ou não é 'true'.
if (!isset($_SESSION['admin_logado']) || $_SESSION['admin_logado'] !== true) {
    // Define uma mensagem para informar que o acesso é restrito
    // Se o usuário não estiver logado, cria uma mensagem de erro na sessão.
    $_SESSION['login_erro'] = "Acesso restrito. Por favor, faça login.";
    // Redireciona para a página de login e encerra o script.
    header('Location: index.php');
    exit();
}

// --------------------------------------------------------------------------
// INÍCIO DA LÓGICA DE LISTAGEM
// --------------------------------------------------------------------------
// --- LÓGICA DE BUSCA DE DADOS ---

// 1. Incluir classes de conexão (O caminho é subir um nível '..' e entrar em 'includes/')
// PASSO 3: Incluir a classe de conexão com o banco de dados.
require_once '../includes/classes/Database.php';
require_once '../includes/config/security.php';

// Conectar ao Banco de Dados
// PASSO 4: Conectar ao Banco de Dados.
// Cria uma nova instância da classe Database e obtém o objeto de conexão PDO.
$database = new Database();
$db = $database->getConnection();

// 2. Query SQL para Selecionar todas as reservas
// PASSO 5: Preparar e executar a consulta SQL.
// A query seleciona todas as colunas da tabela 'reservas'.
// ORDER BY ordena os resultados, mostrando as reservas mais recentes primeiro.
$query = "SELECT * FROM reservas 
        ORDER BY data_reserva DESC, hora_reserva DESC";

$stmt = $db->prepare($query);
$stmt->execute();
// fetchAll(PDO::FETCH_ASSOC) busca todos os resultados e os armazena em um array de arrays associativos.
$reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);
// count() conta o número total de reservas encontradas.
$num = count($reservas);

// --------------------------------------------------------------------------
// INÍCIO DO HTML
// --------------------------------------------------------------------------
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas | Admin La Tavola Fina</title>
    <link rel="shortcut icon" href="./assets/img/icon.svg" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Admin La Tavola Fina</span>
            <a href="logout.php" class="btn btn-outline-light">Sair</a>
        </div>
    </nav>
    <main class="container my-5">

        <?php
        // Exibe mensagem de status se houver
        // PASSO 6: Exibir mensagem de feedback (flash message).
        // Esta mensagem é definida em 'mudar_status.php' após uma atualização.
        if (isset($_SESSION['status_msg'])):
            $msg = $_SESSION['status_msg'];
        ?>
            <!-- O tipo do alerta (success, danger, etc.) e o texto são dinâmicos, vindos da sessão. -->
            <div class="alert alert-<?= $msg['tipo'] ?> alert-dismissible fade show" role="alert">
                <?= $msg['texto'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php
            unset($_SESSION['status_msg']); // Limpa a mensagem após exibir
            // Limpa a mensagem da sessão para que não seja exibida novamente.
            unset($_SESSION['status_msg']);
        endif;
        ?>

        <!-- Exibe o título com a contagem total de reservas. -->
        <h2 class="mb-4">Lista de Reservas (<?= $num ?>)</h2>

        <?php // PASSO 7: Verificar se existem reservas para exibir. 
        ?>
        <?php if ($num > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <!-- Cabeçalho da tabela -->
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Contato</th>
                            <th>Data/Hora</th>
                            <th>Pessoas</th>
                            <th>Observações</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php // PASSO 8: Iterar sobre o array de reservas e exibir cada uma em uma linha da tabela. 
                        ?>
                        <?php foreach ($reservas as $reserva):
                            // Determinar a classe de cor para o status
                            $badge_class = ($reserva['status'] == 'Confirmada') ? 'bg-success' : (($reserva['status'] == 'Cancelada') ? 'bg-danger' : 'bg-warning');
                        
                            $email_decriptografado = decrypt_data($reserva['email_cliente']);
                            $telefone_decriptografado = decrypt_data($reserva['telefone_cliente']);
                        ?>
                            <tr>
                                <!-- Exibição dos dados da reserva. htmlspecialchars() previne ataques XSS. -->
                                <td><?= $reserva['id_reserva'] ?></td>
                                <td><?= htmlspecialchars($reserva['nome_cliente']) ?></td>
                                <td>
                                    <?= htmlspecialchars($email_decriptografado) ?><br>
                                    <?= htmlspecialchars($telefone_decriptografado) ?>
                                </td>
                                <td>
                                    <!-- Formatação da data e hora para um formato mais legível. -->
                                    <?= date('d/m/Y', strtotime($reserva['data_reserva'])) ?><br>
                                    <?= substr($reserva['hora_reserva'], 0, 5) ?>
                                </td>
                                <td><?= $reserva['num_pessoas'] ?></td>
                                <td><?= htmlspecialchars(substr($reserva['observacoes'], 0, 50)) ?>...</td>
                                <td>
                                    <?php // PASSO 9: Criar o seletor de status interativo. 
                                    ?>
                                    <!-- O atributo 'data-reserva-id' armazena o ID da reserva para uso no JavaScript. -->
                                    <!-- O evento 'onchange' chama a função JavaScript 'mudarStatus' sempre que uma nova opção é selecionada. -->
                                    <select class="form-select form-select-sm" data-reserva-id="<?= $reserva['id_reserva'] ?>"
                                        onchange="mudarStatus(this)">
                                        <option value="Pendente" <?= ($reserva['status'] == 'Pendente') ? 'selected' : '' ?>>
                                            Pendente</option>
                                        <option value="Confirmada" <?= ($reserva['status'] == 'Confirmada') ? 'selected' : '' ?>>
                                            Confirmada</option>
                                        <option value="Cancelada" <?= ($reserva['status'] == 'Cancelada') ? 'selected' : '' ?>>
                                            Cancelada</option>
                                    </select>
                                    
                                </td>
                                
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <!-- Mensagem exibida se não houver nenhuma reserva no banco de dados. -->
            <div class="alert alert-info text-center">Nenhuma reserva encontrada.</div>
        <?php endif; ?>
    </main>

    <script>
        // Função que será chamada no evento onchange do select
        // PASSO 10: Função JavaScript para alterar o status da reserva.
        // 'selectElement' é o próprio elemento <select> que disparou o evento.
        function mudarStatus(selectElement) {
            // Pega o ID da reserva do atributo 'data-reserva-id'.
            const id = selectElement.getAttribute('data-reserva-id');
            // Pega o novo valor selecionado (ex: 'Confirmada').
            const novoStatus = selectElement.value;

            // Confirmação simples antes de enviar
            // Exibe uma caixa de diálogo para confirmar a ação. Se o usuário clicar em "Cancelar", a função para.
            if (!confirm(`Tem certeza que deseja mudar o status da Reserva #${id} para '${novoStatus}'?`)) {
                // Se cancelar, reverte o select para o valor original (útil se você souber o valor anterior, mas complexo para este caso. 
                // Por enquanto, apenas retorna para evitar a ação.)
                // A melhoria aqui seria recarregar a página para reverter a seleção visual, ou armazenar o valor antigo.
                window.location.reload();
                return;
            }

            // 1. Criar um objeto de formulário para enviar os dados via POST
            // PASSO 11: Preparar e enviar a requisição para o servidor.
            // FormData é uma forma fácil de construir dados de formulário para enviar via POST.
            const formData = new FormData();
            formData.append('id_reserva', id);
            formData.append('novo_status', novoStatus);

            // 2. Enviar a requisição para o backend (mudar_status.php)
            // Usa a API Fetch para enviar os dados para 'mudar_status.php'.
            fetch('mudar_status.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    // Se a requisição foi bem-sucedida (status 200)
                    // Se a resposta do servidor for OK (status 200-299), recarrega a página.
                    // O recarregamento fará com que o PHP leia a 'status_msg' da sessão (definida em mudar_status.php) e exiba o alerta de sucesso.
                    if (response.ok) {
                        // Como mudar_status.php faz um redirecionamento e define a SESSION, 
                        // a maneira mais fácil de mostrar o feedback é recarregar a página
                        // para que o PHP exiba o alerta de SESSION.
                        window.location.reload();
                    } else {
                        alert('Erro na comunicação com o servidor. Tente novamente.');
                    }
                })
                .catch(error => {
                    console.error('Erro na requisição:', error);
                    alert('Erro ao processar a mudança de status.');
                });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>