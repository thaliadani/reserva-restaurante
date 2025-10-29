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
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
    <?php
    include '../includes/templates/header.php';
    ?>

    <main class="container my-5">
        <div class="row">
            <div class="column w-75 mx-auto">
                <div class="col-12 text-center mb-5">
                    <h1 class="display-4 fw-bold">A História do La Tavola Fina</h1>
                    <p class="lead text-muted">Onde a tradição italiana encontra a alta gastronomia.</p>
                </div>
                <div class="row align-items-center mb-5 pb-4 border-bottom">
                    <div class="col-md-6 order-md-1">
                        <h2 class="h3 mb-3 text-dark text-center">A Arte da Mesa Refinada</h2>
                        <p>
                            O La Tavola Fina nasceu de um sonho em trazer a essência da culinária italiana mais pura e refinada
                            para o Brasil.
                            Cada prato é uma obra de arte, utilizando apenas ingredientes sazonais e importados, garantindo uma
                            experiência
                            sensorial incomparável. Nossa filosofia é simples: celebrar o momento de estar à mesa.
                        </p>
                        <p>
                            Valorizamos a lentidão do processo, a precisão das técnicas e a paixão em servir. Não somos apenas
                            um restaurante;
                            somos uma jornada pela Itália que você ainda não conhece.
                        </p>
                    </div>
                    <div class="col-md-6 order-md-2">
                        <img src="./assets/imgs/restaurante.png" class="img-fluid rounded shadow-lg w-100"
                            alt="Ambiente do Restaurante La Tavola Fina">
                    </div>
                </div>

                <div class="row align-items-center flex-row-reverse mb-5 pb-4">
                    
                    <div class="col-md-6">
                        <h2 class="h3 mb-3 text-dark text-center">Nosso Maestro: Chef Marcelo Bianchi</h2>
                        <p>
                        Formado nas melhores escolas de Florença, o Chef Bianchi é o coração criativo do La Tavola Fina.
                        Sua paixão por receitas ancestrais, combinada com técnicas modernas, resultou em um menu que
                        respeita
                        o passado enquanto abraça a inovação.
                        </p>
                        <p class="fst-italic text-secondary">
                        "Cozinhar é contar uma história, e a nossa história é sobre excelência e paixão pelo sabor."
                        </p>
                    </div>
                    <div class="col-md-6 text-center">
                        <img src="./assets/imgs" class="img-fluid rounded-circle shadow-lg mb-3 w-100" alt="Chef Marcelo Bianchi">
                    </div>
                </div>

            </div>
        </div>

        <div class="text-center mt-5 p-4 bg-light rounded shadow-sm">
            <p class="lead">Pronto para vivenciar a sofisticação do sabor?</p>
            <a href="cardapio.php" class="btn btn-dark btn-lg me-3">Veja o Cardápio</a>
            <a href="reserva.php" class="btn btn-primary btn-lg">Faça sua Reserva</a>
        </div>

    </main>
    <?php include '../includes/templates/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

</body>

</html>