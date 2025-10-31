<?php
// Inicia a sessão para lidar com mensagens de erro ou redirecionamento futuro
session_start();
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
                <h4 class="mb-0">Cadastro</h4>
            </div>
            <div class="card-body d-flex flex-column mb-3">

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
                        <button type="submit" class="btn btn-dark btn-lg">Criar Conta</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="./assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>