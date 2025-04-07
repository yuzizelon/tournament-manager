<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partite del Torneo</title>

    <!-- Link al CSS di Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="CSS/style_nav.css" />
    <link rel="stylesheet" type="text/css" href="CSS/style_part.css" />
</head>
<body>

<!-- Barra di navigazione -->
<?php include "navbar.php"; ?>

<!-- Sezione principale -->
<header>
    <div class="container">
        <h1 class="display-4 fw-bold">Le Partite del Torneo</h1>
    </div>
</header>

<!-- Contenuto principale -->
<main class="container my-5">
    <div class="text-center">
        <h2 class="mb-4">Calendario delle partite</h2>

        <!-- Barra di ricerca -->
        <div class="mb-4">
            <label for="searchWeeks" class="form-label">Seleziona la settimana:</label>
            <select id="searchWeeks" class="form-select w-50 mx-auto" onchange="filterWeeks()">
                <option value="all">Tutte le settimane</option>
                <?php for ($i = 1; $i <= 10; $i++) { echo "<option value='$i'>Settimana $i</option>"; } ?>
            </select>
        </div>

        <!-- Tabella partite -->
        <div class="table-responsive">
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th>Squadra 1</th>
                        <th>Squadra 2</th>
                    </tr>
                </thead>
                <tbody id="partiteTable">
                    <?php
                        // Connessione al database
                        $host = '';
                        $dbname = '';
                        $username = '';
                        $password = '';

                        try {
                            $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                            $sql = "SELECT squadra_1, squadra_2, vincitore, settimana FROM Partita";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $partite = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            if (count($partite) > 0) {
                                foreach ($partite as $partita) {
                                    $squadra1 = htmlspecialchars($partita['squadra_1']);
                                    $squadra2 = htmlspecialchars($partita['squadra_2']);
                                    $vincitore = htmlspecialchars($partita['vincitore']);

                                    echo "<tr data-week='" . htmlspecialchars($partita['settimana']) . "'>";
                                    echo "<td>" . ($squadra1 === $vincitore ? "<strong>" . strtoupper($squadra1) . "</strong>" : $squadra1) . "</td>";
                                    echo "<td>" . ($squadra2 === $vincitore ? "<strong>" . strtoupper($squadra2) . "</strong>" : $squadra2) . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr id='noMatchesRow'><td colspan='2'>Nessuna partita trovata.</td></tr>";
                            }
                        } catch (PDOException $e) {
                            echo "<tr><td colspan='2'>Errore: " . $e->getMessage() . "</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
            <p id="noMatchesMessage" class="text-center text-muted" style="display: none;">Nessuna partita in programma</p>
        </div>
    </div>
</main>

<!-- Script per filtro -->
<script>
    function filterWeeks() {
        const selectedWeek = document.getElementById('searchWeeks').value;
        const rows = document.querySelectorAll('#partiteTable tr');
        let hasMatches = false;

        rows.forEach(row => {
            if (row.id === "noMatchesRow") return; // Ignora il messaggio predefinito
            const week = row.getAttribute('data-week');
            if (selectedWeek === 'all' || week === selectedWeek) {
                row.style.display = '';
                hasMatches = true;
            } else {
                row.style.display = 'none';
            }
        });

        document.getElementById('noMatchesMessage').style.display = hasMatches ? 'none' : 'block';
    }

    document.addEventListener("DOMContentLoaded", filterWeeks);
</script>

<!-- Script di Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
