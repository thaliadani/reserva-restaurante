<?php 
// Inicia a sessão para lidar com mensagens de erro ou redirecionamento futuro
session_start(); 
// Se o usuário já estiver logado, redireciona para a lista de reservas
if (isset($_SESSION['admin_logado']) && $_SESSION['admin_logado'] === true) {
    header('Location: reservas_lista.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | La Tavola Fina</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card shadow-lg" style="width: 100%; max-width: 400px;">
            <div class="card-header bg-dark text-white text-center">
                <h4 class="mb-0">Acesso Administrativo</h4>
            </div>
            <div class="card-body">
                
                <?php 
                // Exibir mensagem de erro, se houver
                if (isset($_SESSION['login_erro'])): ?>
                    <div class="alert alert-danger text-center">
                        <?= $_SESSION['login_erro']; ?>
                    </div>
                <?php 
                    unset($_SESSION['login_erro']); // Limpa a mensagem após exibir
                endif; 
                ?>

                <form action="processa_login.php" method="POST">
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
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>