<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Tavola Fina</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
    <?php include '../includes/templates/header.php'; ?>

    <main>
        <div class="container my-5">
            <div class="row">
                <div class="column">
                    <h2 class="text-center my-4">Reserve sua Mesa</h2>
                    <form action="processa_reserva.php" method="POST" class="col-lg-6 mx-auto">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="data_reserva" class="form-label">Data</label>
                                <input type="date" class="form-control" id="data_reserva" name="data_reserva" required>
                            </div>
                            <div class="col-md-4">
                                <label for="hora_reserva" class="form-label">Hora</label>
                                <input type="time" class="form-control" id="hora_reserva" name="hora_reserva" required>
                            </div>
                            <div class="col-md-4">
                                <label for="num_pessoas" class="form-label">Número de Pessoas</label>
                                <input type="number" class="form-control" id="num_pessoas" name="num_pessoas" min="1"
                                    max="10" required>
                            </div>

                            <div class="my-3">
                                <label for="nome_cliente" class="form-label">Nome Completo</label>
                                <input type="text" class="form-control" id="nome_cliente" name="nome_cliente" required>
                            </div>

                            <div class="mb-3">
                                <label for="email_cliente" class="form-label">E-mail</label>
                                <input type="email" class="form-control" id="email_cliente" name="email_cliente"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="telefone_cliente" class="form-label">Telefone</label>
                                <input type="number" class="form-control" id="telefone_cliente" name="telefone_cliente"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="observacoes" class="form-label">
                                    Observações e Pedidos Especiais
                                </label>
                                <textarea class="form-control" id="observacoes" name="observacoes" rows="4"
                                    placeholder="Informe aqui se houver alguma restrição, celebração especial ou preferência de assento."></textarea>
                            </div>
                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-danger btn-lg">Confirmar Reserva</button>
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
        <?php if (isset($_SESSION['reserva_status'])):
            // Coleta o status e a mensagem
            $status = $_SESSION['reserva_status'];
            $mensagem = $_SESSION['reserva_mensagem'];

            // Limpa as variáveis de sessão para que o modal não apareça novamente
            unset($_SESSION['reserva_status']);
            unset($_SESSION['reserva_mensagem']);
            ?>

            // Código JavaScript para exibir o modal
            document.addEventListener('DOMContentLoaded', function () {
                const status = "<?= $status ?>";
                const mensagem = "<?= htmlspecialchars($mensagem) ?>";

                const modal = new bootstrap.Modal(document.getElementById('feedbackModal'));

                // Ajusta o estilo do modal com base no status
                const modalHeader = document.querySelector('#feedbackModal .modal-header');
                const modalTitle = document.querySelector('#feedbackModalLabel');
                const modalBodyText = document.querySelector('#modal-body-text');

                if (status === 'sucesso') {
                    modalHeader.className = 'modal-header bg-success text-white';
                    modalTitle.textContent = 'Reserva Concluída!';
                } else if (status === 'erro') {
                    modalHeader.className = 'modal-header bg-danger text-white';
                    modalTitle.textContent = 'Erro na Reserva';
                }

                modalBodyText.innerHTML = mensagem;

                modal.show();
            });

        <?php endif; ?>
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>