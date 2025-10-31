<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Tavola Fina</title>
    <link rel="shortcut icon" href="./assets/imgs/icon.svg" type="image/x-icon">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
    <?php include '../includes/templates/header.php'; ?>

    <main>
        <div class="container my-5">
            <div class="row">
                <div class="column w-75 mx-auto">
                    <h1 class="text-center p-4 fw-bold">Reserve sua Mesa</h2>
                    <form action="processa_reserva.php" method="POST" class="col-lg-6 mx-auto" id="reservaForm">
                        <div class="row mb-3">
                            <div class="col">
                                <label for="data_reserva" class="form-label">Data</label>
                                <input type="date" class="form-control" id="data_reserva" name="data_reserva" required>
                            </div>
                            <div class="col">
                                <label for="hora_reserva" class="form-label">Hora</label>
                                <input type="time" class="form-control" id="hora_reserva" name="hora_reserva" min="19:00" max="00:00" required>
                            </div>
                            <div class="col-12 mb-3">
                                <small class="form-text text-muted">Funcionamos todos os dias e  o nosso horário de funcionamento é das 19:00h às 00:00h.</small>
                            </div>
                            <div class="col mb-3">
                                <label for="num_pessoas" class="form-label">Número de Pessoas</label>
                                <input type="number" class="form-control" id="num_pessoas" name="num_pessoas" min="1"
                                    max="10" required>
                            </div>

                            <div class="mb-3">
                                <label for="nome_cliente" class="form-label">Nome Completo</label>
                                <input type="text" class="form-control" id="nome_cliente" name="nome_cliente" required>
                            </div>

                            <div class="mb-3">
                                <label for="email_cliente" class="form-label">E-mail</label>
                                <input type="email" class="form-control" id="email_cliente" name="email_cliente"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="telefone_cliente" class="form-label">Telefone/Celular</label>
                                <input type="tel" class="form-control" id="telefone_cliente" name="telefone_cliente" required>
                            </div>
                            <div class="mb-3">
                                <label for="observacoes" class="form-label">
                                    Observações e Pedidos Especiais
                                </label>
                                <textarea class="form-control" id="observacoes" name="observacoes" rows="4"
                                    placeholder="Informe aqui se houver alguma restrição, celebração especial ou preferência de assento." style="resize: none;"></textarea>
                            </div>
                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">Confirmar Reserva</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

        </div>
    </main>

    <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="feedbackModalLabel">Status da Reserva</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal-body-text">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <?php include '../includes/templates/footer.php'; ?>

    <script src="./assets/js/script.js"></script>

    <script>
        <?php
        // PASSO 1: Verificar no lado do servidor (PHP) se existe uma mensagem de feedback na sessão.
        // Essas variáveis de sessão são definidas em 'processa_reserva.php' após o envio do formulário.
        if (isset($_SESSION['reserva_status'])):
            // PASSO 2: Coletar o status ('sucesso' ou 'erro') e a mensagem da sessão para variáveis PHP.
            $status = $_SESSION['reserva_status'];
            $mensagem = $_SESSION['reserva_mensagem'];

            // PASSO 3: Limpar as variáveis da sessão.
            // Este é um passo crucial para garantir que o modal seja exibido apenas uma vez (padrão "flash message").
            // Se o usuário recarregar a página, a mensagem não aparecerá novamente.
            unset($_SESSION['reserva_status']);
            unset($_SESSION['reserva_mensagem']);
            ?>

            // PASSO 4: Iniciar o código JavaScript que será executado no navegador do usuário.
            // O evento 'DOMContentLoaded' garante que o script só rode depois que toda a página HTML for carregada.
            document.addEventListener('DOMContentLoaded', function () {
                // PASSO 5: Passar os valores do PHP para variáveis JavaScript.
                // O PHP "imprime" os valores diretamente no código JavaScript antes de enviá-lo ao navegador.
                // Usamos htmlspecialchars() na mensagem por segurança, para prevenir ataques XSS.
                const status = "<?= $status ?>";
                const mensagem = "<?= htmlspecialchars($mensagem) ?>";

                // PASSO 6: Inicializar o componente Modal do Bootstrap.
                const modal = new bootstrap.Modal(document.getElementById('feedbackModal'));

                // PASSO 7: Selecionar os elementos do modal que serão modificados.
                const modalHeader = document.querySelector('#feedbackModal .modal-header');
                const modalTitle = document.querySelector('#feedbackModalLabel');
                const modalBodyText = document.querySelector('#modal-body-text');

                // PASSO 8: Personalizar o modal com base no status (sucesso ou erro).
                if (status === 'sucesso') {
                    // Se for sucesso, muda a cor do cabeçalho para verde e ajusta o título.
                    modalHeader.className = 'modal-header bg-success text-white';
                    modalTitle.textContent = 'Reserva Concluída!';
                } else if (status === 'erro') {
                    // Se for erro, muda a cor do cabeçalho para vermelho e ajusta o título.
                    modalHeader.className = 'modal-header bg-danger text-white';
                    modalTitle.textContent = 'Erro na Reserva';
                }

                // PASSO 9: Inserir a mensagem de feedback no corpo do modal.
                modalBodyText.innerHTML = mensagem;

                // PASSO 10: Exibir o modal para o usuário.
                modal.show();
            });

        <?php endif; // Fim da verificação 'if (isset($_SESSION...))' ?>
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>