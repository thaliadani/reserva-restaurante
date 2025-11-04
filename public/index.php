<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Tavola Fina</title>
    <link rel="shortcut icon" href="./assets/imgs/icon.svg" type="image/x-icon">
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>



<body>
    <?php include '../includes/templates/header.php'; ?>
    <main class="container-fluid p-0">
        <div class="row">
            <div class="column">
                <section
                    class="hero-section text-white d-flex flex-column justify-content-center align-items-center text-center">
                    <div class="row">
                        <div class="column card-inicio shadow-lg p-4 animate__animated animate__fadeInDown">
                            <h1 class="display-3 fw-bold">La Tavola Fina</h1>
                            <p class="lead mb-4">Uma experiência gastronômica de alta classe no coração da cidade.</p>
                            <a href="reserva.php" class="btn btn-lg btn-primary shadow-lg fw-bold">Reservar Mesa Agora</a>
                        </div>
                    </div>
                </section>
            </div>
        </div>

    </main>

    <?php include '../includes/templates/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>