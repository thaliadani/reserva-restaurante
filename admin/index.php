<?php
// Inicia a sessão para lidar com mensagens de erro ou redirecionamento futuro
session_start();
// Se o usuário já estiver logado, redireciona para a lista de reservas
if (isset($_SESSION['admin_logado']) && $_SESSION['admin_logado'] === true) {
    header('Location: reservas_lista.php');
    exit();
}

// Inclua os arquivos necessários
require_once '../includes/classes/Database.php';
require_once '../includes/classes/RemoveReserva.php';

// Cria as instâncias das classes
$database = new Database();
$removeReserva = new RemoveReserva($database);

// Executa a função para remover as reservas expiradas
$removeReserva->removerReservasExpiradas();

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | La Tavola Fina</title>
    <link rel="shortcut icon" href="./assets/img/icon.svg" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card shadow-lg" style="width: 100%; max-width: 400px;">
            <div class="card-header bg-dark text-white text-center">
                <h4 class="mb-0">Acesso Administrativo</h4>
            </div>
            <div class="card-body d-flex flex-column mb-3">

                <?php
                // Exibe mensagem de erro de login, se houver.
                if (isset($_SESSION['login_erro'])):
                ?>
                    <div class="alert alert-danger text-center" role="alert">
                        <?= htmlspecialchars($_SESSION['login_erro']) ?>
                    </div>
                <?php
                    unset($_SESSION['login_erro']);
                endif;

                // Exibe mensagem de status (sucesso do cadastro, etc.), se houver.
                if (isset($_SESSION['status_msg'])):
                    $msg = $_SESSION['status_msg'];
                ?>
                    <div class="alert alert-<?= htmlspecialchars($msg['tipo']) ?> text-center" role="alert">
                        <?= htmlspecialchars($msg['texto']) ?>
                    </div>
                <?php
                    unset($_SESSION['status_msg']);
                endif;
                ?>

                <form action="processa_login.php" method="POST" id="form-admin">
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Usuário</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" required>
                    </div>
                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-dark btn-lg">Entrar</button>
                    </div>
                </form>

                <p class="text-center pt-3">Não possui cadastro? <a  href="./cadastro.php">Cria aqui</a></p>
            </div>
        </div>
    </div>
    <script src="./assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>