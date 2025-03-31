<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classifica del Torneo</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- File CSS Personalizzato -->
    <link rel="stylesheet" href="CSS/style_class.css">
</head>
<body>
    <!-- Barra di navigazione -->
    <?php include "navbar.php"; ?>

    <!-- Header -->
    <header>
        <div class="container">
            <h1>Classifica del Torneo</h1>
            <p class="lead">Consulta la classifica per scoprire chi sta dominando il torneo!</p>
        </div>
    </header>

    <!-- Classifica -->
    <main class="container mt-5 main-content">
        <h2 class="text-center mb-4">Classifica</h2>
        <div class="table-responsive">
            <table class="table table-dark table-bordered text-center align-middle">
                <thead>
                    <tr>
                        <th>Posizione</th>
                        <th>Squadra</th>
                        <th>Partite Giocate</th>
                        <th>Vittorie</th>
                        <th>Sconfitte</th>
                        <th>Punti</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Credenziali per la connessione al database
                    $servername = "sql204.infinityfree.com";
                    $username = "if0_37692320";
                    $password = "alignani2024";
                    $dbname = "if0_37692320_torneo";

                    // Connessione al database
                    $conn = new mysqli($servername, $username, $password, $dbname);

                    // Controllo della connessione
                    if ($conn->connect_error) {
                        die('<tr><td colspan="6">Errore di connessione al database: ' . $conn->connect_error . '</td></tr>');
                    }

                    // Query per ottenere le squadre confermate ordinate per punti
                    $sql = "SELECT nome AS Squadra, partite_giocate AS Partite_giocate, vittorie AS Vittorie, 
                                   sconfitte AS Sconfitte, punti AS Punti
                            FROM Squadra 
                            WHERE Confermato = 1 
                            ORDER BY Punti DESC";
                    $result = $conn->query($sql);

                    // Controlla se ci sono risultati
                    if ($result && $result->num_rows > 0) {
                        $posizione = 1; // Variabile per la posizione
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$posizione}</td>
                                    <td>{$row['Squadra']}</td>
                                    <td>{$row['Partite_giocate']}</td>
                                    <td>{$row['Vittorie']}</td>
                                    <td>{$row['Sconfitte']}</td>
                                    <td>{$row['Punti']}</td>
                                  </tr>";
                            $posizione++;
                        }
                    } else {
                        echo '<tr><td colspan="6">Nessuna squadra confermata al momento.</td></tr>';
                    }

                    // Chiudi la connessione
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
