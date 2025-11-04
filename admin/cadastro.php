<?php
// Inicia a sessão para lidar com mensagens de erro ou redirecionamento futuro
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Admin | La Tavola Fina</title>
    <link rel="shortcut icon" href="./assets/img/icon.svg" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card shadow-lg" style="width: 100%; max-width: 400px;">
            <div class="card-header bg-dark text-white text-center">
                <h4 class="mb-0">Cadastro de Administrador</h4>
            </div>
            <div class="card-body d-flex flex-column mb-3">

                <?php
                // Exibe mensagem de status (sucesso, erro, aviso) se houver na sessão.
                if (isset($_SESSION['status_msg'])):
                    $msg = $_SESSION['status_msg'];
                ?>
                    <div class="alert alert-<?= htmlspecialchars($msg['tipo']) ?> text-center" role="alert">
                        <?= htmlspecialchars($msg['texto']) ?>
                    </div>
                <?php
                    // Limpa a mensagem da sessão para que não seja exibida novamente.
                    unset($_SESSION['status_msg']);
                endif;
                ?>

                <form action="processa_cadastro.php" method="POST" id="form-admin-cadastro">
                    <div class="mb-3">
                        <label for="nome_completo" class="form-label">Nome Completo</label>
                        <input type="text" class="form-control" id="nome_completo" name="nome_completo" required>
                    </div>
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Usuário</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" required>
                    </div>
                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-dark btn-lg">Criar Conta</button>
                    </div>
                </form>

                <p class="text-center pt-3">Já possui uma conta? <a  href="./index.php">Faça login</a></p>
            </div>
        </div>
    </div>
    <script src="./assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>