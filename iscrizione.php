<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iscrizione al Torneo</title>
    
    <!-- Link al CSS di Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="CSS/style_iscri.css" />
</head>
<body>
    <!-- Barra di navigazione -->
    <?php include "navbar.php"; ?>

    <!-- Header -->
    <header>
        <div class="container">
            <h1>Iscrizione al Torneo</h1>
            <p class="lead">Completa il modulo per partecipare al torneo e unisciti alla sfida!</p>
        </div>
    </header>

    <!-- Form di Iscrizione -->
    <main class="main-content">
        <h2>Dettagli della Squadra</h2>
        <form id="formIscrizioneDettagli" class="mt-4" action="process_iscrizione.php" method="POST">
            <!-- Dati del Caposquadra -->
<h3 class="mb-3">Caposquadra</h3>
<div class="caposquadra">
    <input type="text" name="nomeCaposquadra" class="form-control" placeholder="Nome Caposquadra" required>
    <input type="text" name="cognomeCaposquadra" class="form-control" placeholder="Cognome Caposquadra" required>
    <input type="text" id="idCaposquadra" name="idCaposquadra" class="form-control" placeholder="ID Caposquadra" required oninput="checkValue('idCaposquadra')">
                <small id="idCaposquadraError" class="text-danger"></small>
    <select name="classeCaposquadra" class="form-select" required>
        <option value="" disabled selected>Seleziona Classe Caposquadra</option>
        <option>1CHIA</option>
        <option>2CHIA</option>
        <option>1CHIB</option>
        <option>1ELEA</option>
        <option>2ELEA</option>
        <option>1ELEB</option>
        <option>2ELEB</option>
        <option>1TELA</option>
        <option>2TELA</option>
        <option>1TELB</option>
        <option>2TELB</option>
        <option>3BIAA</option>
        <option>4BIAA</option>
        <option>5BIAA</option>
        <option>3CHIA</option>
        <option>4CHIA</option>
        <option>5CHIA</option>
        <option>3ELEA</option>
        <option>4ELEA</option>
        <option>5ELEA</option>
        <option>5ELEB</option>
        <option>3TELA</option>
        <option>4TELA</option>
        <option>5TELA</option>
        <option>3TELB</option>
        <option>4TELB</option>
        <option>5TELB</option>
    </select>
   <input type="email" id="emailCaposquadra" name="emailCaposquadra" class="form-control" placeholder="Email Caposquadra" required oninput="checkValue('emailCaposquadra')">
                <small id="emailCaposquadraError" class="text-danger"></small>

                <input type="text" id="nomeSquadra" name="nomeSquadra" class="form-control" placeholder="Nome Squadra" required oninput="checkValue('nomeSquadra')">
                <small id="nomeSquadraError" class="text-danger"></small>
</div>
            <!-- Dati dei Partecipanti -->
            <h3 class="mb-3 mt-5">Partecipanti</h3>
            <div class="partecipanti-row">
                <div class="partecipante">
                    <h4>Partecipante 2</h4>
                    <input type="text" name="nomePartecipante2" class="form-control" placeholder="Nome Partecipante 2" required>
                    <input type="text" name="cognomePartecipante2" class="form-control" placeholder="Cognome Partecipante 2" required>
                    <input type="text" id="idPartecipante2" name="idPartecipante2" class="form-control" placeholder="ID Partecipante 2" required oninput="checkValue('idPartecipante2')">
                    <small id="idPartecipante2Error" class="text-danger"></small>
                    <select name="classePartecipante2" class="form-select" required>
                        <option value="" disabled selected>Seleziona Classe Partecipante 2</option>
                        <option>1CHIA</option>
                        <option>2CHIA</option>
                        <option>1CHIB</option>
                        <option>1ELEA</option>
                        <option>2ELEA</option>
                        <option>1ELEB</option>
                        <option>2ELEB</option>
                        <option>1TELA</option>
                        <option>2TELA</option>
                        <option>1TELB</option>
                        <option>2TELB</option>
                        <option>3BIAA</option>
                        <option>4BIAA</option>
                        <option>5BIAA</option>
                        <option>3CHIA</option>
                        <option>4CHIA</option>
                        <option>5CHIA</option>
                        <option>3ELEA</option>
                        <option>4ELEA</option>
                        <option>5ELEA</option>
                        <option>5ELEB</option>
                        <option>3TELA</option>
                        <option>4TELA</option>
                        <option>5TELA</option>
                        <option>3TELB</option>
                        <option>4TELB</option>
                        <option>5TELB</option>
                    </select>
                    <input type="email" id="emailPartecipante2" name="emailPartecipante2" class="form-control" placeholder="Email Partecipante 2" required oninput="checkValue('emailPartecipante2')">
                    <small id="emailPartecipante2Error" class="text-danger"></small>
                </div>
                <div class="partecipante">
                    <h4>Partecipante 3</h4>
                    <input type="text" name="nomePartecipante3" class="form-control" placeholder="Nome Partecipante 3" required>
                    <input type="text" name="cognomePartecipante3" class="form-control" placeholder="Cognome Partecipante 3" required>
                    <input type="text" id="idPartecipante3" name="idPartecipante3" class="form-control" placeholder="ID Partecipante 3" required oninput="checkValue('idPartecipante3')">
                    <small id="idPartecipante3Error" class="text-danger"></small>
                    <select name="classePartecipante3" class="form-select" required>
                        <option value="" disabled selected>Seleziona Classe Partecipante 3</option>
                        <option>1CHIA</option>
                        <option>2CHIA</option>
                        <option>1CHIB</option>
                        <option>1ELEA</option>
                        <option>2ELEA</option>
                        <option>1ELEB</option>
                        <option>2ELEB</option>
                        <option>1TELA</option>
                        <option>2TELA</option>
                        <option>1TELB</option>
                        <option>2TELB</option>
                        <option>3BIAA</option>
                        <option>4BIAA</option>
                        <option>5BIAA</option>
                        <option>3CHIA</option>
                        <option>4CHIA</option>
                        <option>5CHIA</option>
                        <option>3ELEA</option>
                        <option>4ELEA</option>
                        <option>5ELEA</option>
                        <option>5ELEB</option>
                        <option>3TELA</option>
                        <option>4TELA</option>
                        <option>5TELA</option>
                        <option>3TELB</option>
                        <option>4TELB</option>
                        <option>5TELB</option>
                    </select>
                    <input type="email" id="emailPartecipante3" name="emailPartecipante3" class="form-control" placeholder="Email Partecipante 3" required oninput="checkValue('emailPartecipante3')">
                    <small id="emailPartecipante3Error" class="text-danger"></small>
                </div>
            </div>
            <button type="submit" class="btn btn-custom mt-4">Invia Iscrizione</button>
        </form>
    </main>

    <!-- Script di Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<!-- jQuery (necessario per AJAX) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Script AJAX per il controllo in tempo reale -->
<script>
    function checkValue(campo) {
        let valore = $("#" + campo).val();
        if (valore.trim() === "") return; // Se il campo è vuoto, non fa la richiesta

        $.ajax({
            type: "POST",
            url: "check_values.php", // File PHP che controlla il valore nel database
            data: { campo: campo, valore: valore },
            success: function(response) {
                $("#" + campo + "Error").text(response); // Mostra il messaggio di errore
                checkFormValidity(); // Controlla se il form è valido
            }
        });
    }

    function checkFormValidity() {
        let isValid = true;

        // Controlla se esistono messaggi di errore nei campi
        $("small.text-danger").each(function () {
            if ($(this).text().trim() !== "") {
                isValid = false; // Se c'è un errore, il form non è valido
            }
        });

        // Disabilita o abilita il pulsante di invio in base alla validità del form
        if (isValid) {
            $("button[type='submit']").prop("disabled", false);
        } else {
            $("button[type='submit']").prop("disabled", true);
        }
    }

    $(document).ready(function () {
        // Disabilita il pulsante all'avvio
        $("button[type='submit']").prop("disabled", true);

        // Controlla la validità del form ogni volta che un input cambia
        $("input").on("input", function () {
            checkFormValidity();
        });
    });
</script>

</body>
</html>
