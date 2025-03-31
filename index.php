<!DOCTYPE html>
<html lang="it">
<head>
    <title>Gestione dei tornei</title>
    <!-- Link al CSS di Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
 <link rel="stylesheet" type="text/css" href="CSS/style_ind.css" />
<link rel="stylesheet" type="text/css" href="CSS/style_nav.css" />
</head>
<body>
<?php include "navbar.php"; ?>
    <!-- Header con un'immagine di sfondo, titolo e descrizione -->
    <header>
        <div class="container">
            <h1 class="display-3"><strong>Gestione dei tornei</strong></h1>
            <p class="lead">Unisciti a noi per un'esperienza di gioco epica! Mostra le tue abilità e diventa il campione!</p>
        </div>
    </header>

    <!-- Sezione principale centrata con contenuto descrittivo -->
<main class="container-custom my-5 main-content d-flex align-items-center justify-content-center">
    <h2 class="text-center mb-4">Partecipa al Torneo</h2>
    <p class="text-center">Iscriviti oggi stesso e unisciti alla battaglia. Competizioni, emozioni e premi ti aspettano!</p>
    <div class="text-center mt-5">
        <a href="iscrizione.php" class="btn btn-custom btn-lg">Iscriviti al Torneo</a>
    </div>
</main>


    <!-- Script di Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

    <!--Script JS -->
    <script src="script.js"></script>
</body>
</html>
