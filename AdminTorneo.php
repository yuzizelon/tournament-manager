<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit;
}

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Configurazione database
$host = '';
$dbname = '';
$username = '';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Errore di connessione: " . $e->getMessage());
}

$table = $_GET['table'] ?? 'Partita';

// Definizione delle chiavi primarie per ogni tabella
$primaryKeys = [
    'Persona' => 'id_brawl',
    'Squadra' => 'nome',
    'Partita' => 'cod_partita'
];

// Controllo se la tabella è valida
if (!isset($primaryKeys[$table])) {
    die("Tabella non valida.");
}

$primaryKey = $primaryKeys[$table];

// Funzione per ottenere i dati
function getDati($conn, $table) {
    try {
        $query = "SELECT * FROM $table";
        if ($table === 'Partita') {
            $query .= " ORDER BY settimana DESC";
        }
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Errore nel recupero dati: " . $e->getMessage());
    }
}

$dati = getDati($conn, $table);

// Eliminazione record
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];

    try {
        $stmt = $conn->prepare("DELETE FROM $table WHERE $primaryKey = ?");
        $stmt->execute([$id]);
        header("Location: AdminTorneo.php?table=$table");
        exit();
    } catch (PDOException $e) {
        die("Errore nell'eliminazione: " . $e->getMessage());
    }
}

// Modifica record
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id'])) {
    $id = $_POST['edit_id'];
    unset($_POST['edit_id'], $_POST['submit_edit']);

    if (empty($_POST)) {
        die("Errore: Nessun campo da modificare.");
    }

    $columns = array_keys($_POST);
    $values = array_values($_POST);
    $setClause = implode(', ', array_map(fn($col) => "$col = ?", $columns));

    try {
        $stmt = $conn->prepare("UPDATE $table SET $setClause WHERE $primaryKey = ?");
        $stmt->execute([...$values, $id]);

        header("Location: AdminTorneo.php?table=$table");
        exit();
    } catch (PDOException $e) {
        die("Errore nella modifica: " . $e->getMessage());
    }
}

// Impostazione vincitore
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['set_vincitore'])) {
    $id = $_POST['id'];
    $vincitore = $_POST['set_vincitore'];

    try {
        $stmt = $conn->prepare("UPDATE Partita SET vincitore = ? WHERE cod_partita = ?");
        $stmt->execute([$vincitore, $id]);

        $stmt = $conn->prepare("SELECT squadra_1, squadra_2 FROM Partita WHERE cod_partita = ?");
        $stmt->execute([$id]);
        $partita = $stmt->fetch(PDO::FETCH_ASSOC);
        $perdente = ($partita['squadra_1'] === $vincitore) ? $partita['squadra_2'] : $partita['squadra_1'];

        $stmt = $conn->prepare("UPDATE Squadra SET Partite_giocate = Partite_giocate + 1, Vittorie = Vittorie + 1, Punti = Punti + 1 WHERE nome = ?");
        $stmt->execute([$vincitore]);

        $stmt = $conn->prepare("UPDATE Squadra SET Partite_giocate = Partite_giocate + 1, Sconfitte = Sconfitte + 1 WHERE nome = ?");
        $stmt->execute([$perdente]);

        header("Location: AdminTorneo.php?table=Partita");
        exit();
    } catch (PDOException $e) {
        die("Errore nell'aggiornamento del vincitore: " . $e->getMessage());
    }
}

// Aggiungi una nuova partita
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_partita'])) {
    $squadra_1 = $_POST['squadra_1'];
    $squadra_2 = $_POST['squadra_2'];
    $settimana = $_POST['settimana'];

    try {
        $stmt = $conn->prepare("INSERT INTO Partita (squadra_1, squadra_2, settimana) VALUES (?, ?, ?)");
        $stmt->execute([$squadra_1, $squadra_2, $settimana]);

        header("Location: AdminTorneo.php?table=Partita");
        exit();
    } catch (PDOException $e) {
        die("Errore nell'inserimento della partita: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/admin_torneo_styles.css">
    <title>Gestione Torneo</title>
</head>
<body>
    <h1>Gestione Torneo</h1>
    <nav>
        <a href="?table=Persona">Persone</a> |
        <a href="?table=Squadra">Squadre</a> |
        <a href="?table=Partita">Partite</a> |
        <a href="logout.php" style="color: red;">Logout</a>
    </nav>

    <h2><?php echo ucfirst(htmlspecialchars($table ?? '')); ?></h2>

    <table border="1">
        <thead>
            <tr>
                <?php if (!empty($dati)): ?>
                    <?php foreach (array_keys($dati[0]) as $colonna): ?>
                        <th><?php echo htmlspecialchars($colonna ?? ''); ?></th>
                    <?php endforeach; ?>
                    <th>Azioni</th>
                <?php else: ?>
                    <th>Nessun dato disponibile</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dati as $riga): ?>
                <tr>
                    <form method="post">
                        <?php foreach ($riga as $colonna => $valore): ?>
                            <td>
                                <input type="text" name="<?php echo htmlspecialchars($colonna ?? ''); ?>" value="<?php echo htmlspecialchars($valore ?? ''); ?>">
                            </td>
                        <?php endforeach; ?>
                        <td>
                            <input type="hidden" name="edit_id" value="<?php echo $riga[$primaryKey]; ?>">
                            <button type="submit" name="submit_edit">Modifica</button>
                            <button type="submit" name="delete_id" value="<?php echo $riga[$primaryKey]; ?>" onclick="return confirm('Sei sicuro di voler eliminare questo record?')">Elimina</button>
                        </td>
                    </form>

                    <?php if ($table === 'Partita'): ?>
                        <td>
                            <form method="post">
                                <input type="hidden" name="id" value="<?php echo $riga['cod_partita']; ?>">
                                <button type="submit" name="set_vincitore" value="<?php echo htmlspecialchars($riga['squadra_1'] ?? ''); ?>">Vittoria Squadra 1</button>
                                <button type="submit" name="set_vincitore" value="<?php echo htmlspecialchars($riga['squadra_2'] ?? ''); ?>">Vittoria Squadra 2</button>
                            </form>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if ($table === 'Partita'): ?>
        <h3>Aggiungi una nuova partita</h3>
        <form method="post">
            <label for="squadra_1">Squadra 1:</label>
            <input type="text" id="squadra_1" name="squadra_1" required>
            <br>
            <label for="squadra_2">Squadra 2:</label>
            <input type="text" id="squadra_2" name="squadra_2" required>
            <br>
            <label for="settimana">Settimana:</label>
            <input type="number" id="settimana" name="settimana" min="1" required>
            <br>
            <button type="submit" name="add_partita">Aggiungi Partita</button>
        </form>
    <?php endif; ?>
</body>
</html>
