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
    <?php

    include '../includes/templates/header.php';
    ?>

    <main class="container my-5">
        <div class="row">
            <div class="column w-75 mx-auto">
                <div class="text-center mb-5">
                    <h1 class="display-4 fw-bold">Nosso Menu</h1>
                    <p class="lead text-muted">A seleção de pratos que celebra a tradição e a inovação italiana, com o melhor
                        das nossas <span class="fw-bold">Pizzas artesanais</span>.</p>
                </div>
                <section class="mb-5">
                    <h2 class="border-bottom pb-2 mb-4">Antipasti (Entradas)</h2>
                    <div class="row row-cols-1 row-cols-md-2 g-4">

                        <div class="col">
                            <div class="card shadow-sm h-100">
                                <div class="card-body">
                                    <h5 class="card-title d-flex justify-content-between">
                                        <span>Carpaccio di Salmone</span>
                                        <span class="fw-bold cor-preco">R$ 55,00</span>
                                    </h5>
                                    <p class="card-text text-muted">Finas fatias de salmão fresco marinado em azeite trufado,
                                        limão siciliano e alcaparras.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="card shadow-sm h-100">
                                <div class="card-body">
                                    <h5 class="card-title d-flex justify-content-between">
                                        <span>Burrata Cremosa com Pesto</span>
                                        <span class="fw-bold cor-preco">R$ 48,00</span>
                                    </h5>
                                    <p class="card-text text-muted">Burrata fresca servida com tomate cereja assado e nosso
                                        pesto caseiro de manjericão.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </section>

                <section class="mb-5">
                    <h2 class="border-bottom pb-2 mb-4">Pizze (Pizzas) - A Nossa Especialidade</h2>
                    <div class="row row-cols-1 row-cols-md-2 g-4">

                        <div class="col">
                            <div class="card shadow-sm h-100">
                                <div class="card-body">
                                    <h5 class="card-title d-flex justify-content-between">
                                        <span>Pizza Margherita DOC</span>
                                        <span class="fw-bold cor-preco">R$ 65,00</span>
                                    </h5>
                                    <p class="card-text text-muted">Molho de tomate San Marzano, muçarela de búfala, manjericão
                                        fresco e azeite extra virgem.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="card shadow-sm h-100">
                                <div class="card-body">
                                    <h5 class="card-title d-flex justify-content-between">
                                        <span>Pizza Prosciutto e Funghi</span>
                                        <span class="fw-bold cor-preco">R$ 78,00</span>
                                    </h5>
                                    <p class="card-text text-muted">Molho de tomate, muçarela, presunto de Parma, cogumelos
                                        frescos e um toque de orégano.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="card shadow-sm h-100">
                                <div class="card-body">
                                    <h5 class="card-title d-flex justify-content-between">
                                        <span>Pizza Quattro Formaggi</span>
                                        <span class="fw-bold cor-preco">R$ 75,00</span>
                                    </h5>
                                    <p class="card-text text-muted">A combinação perfeita de muçarela, gorgonzola, parmesão e
                                        provolone.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="card shadow-sm h-100">
                                <div class="card-body">
                                    <h5 class="card-title d-flex justify-content-between">
                                        <span>Pizza Diavola (Apimentada)</span>
                                        <span class="fw-bold cor-preco">R$ 72,00</span>
                                    </h5>
                                    <p class="card-text text-muted">Molho de tomate, muçarela e salame picante (calabresa
                                        italiana).</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </section>

                <section class="mb-5">
                    <h2 class="border-bottom pb-2 mb-4">Outros Piatti Principali (Pratos Principais)</h2>
                    <div class="row row-cols-1 row-cols-md-2 g-4">

                        <div class="col">
                            <div class="card shadow-sm h-100">
                                <div class="card-body">
                                    <h5 class="card-title d-flex justify-content-between">
                                        <span>Risotto di Gamberi e Asparagi</span>
                                        <span class="fw-bold cor-preco">R$ 115,00</span>
                                    </h5>
                                    <p class="card-text text-muted">Arroz Carnaroli cremoso com camarões frescos e pontas de
                                        aspargos verdes.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="card shadow-sm h-100">
                                <div class="card-body">
                                    <h5 class="card-title d-flex justify-content-between">
                                        <span>Filetto al Tartufo</span>
                                        <span class="fw-bold cor-preco">R$ 130,00</span>
                                    </h5>
                                    <p class="card-text text-muted">Filé Mignon grelhado ao ponto, coberto com molho cremoso de
                                        funghi e azeite de trufas brancas.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </section>

                <section class="mb-5">
                    <h2 class="border-bottom pb-2 mb-4">Dolci (Sobremesas)</h2>
                    <div class="row row-cols-1 row-cols-md-2 g-4">

                        <div class="col">
                            <div class="card shadow-sm h-100">
                                <div class="card-body">
                                    <h5 class="card-title d-flex justify-content-between">
                                        <span>Tiramisù Tradizionale</span>
                                        <span class="fw-bold cor-preco">R$ 38,00</span>
                                    </h5>
                                    <p class="card-text text-muted">O clássico italiano, com mascarpone, café e biscoito
                                        Savoiardi.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </section>

                <div class="text-center mt-5 p-4 bg-light rounded shadow-sm">
                    <p class="lead">Gostou do que viu? Reserve sua experiência gastronômica!</p>
                    <a href="reserva.php" class="btn btn-primary btn-lg">Fazer Reserva Agora</a>
                </div>

            </div>
        </div>

    </main>

    <?php include '../includes/templates/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>