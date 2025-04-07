<?php
// Abilita la visualizzazione degli errori (solo per debug, poi rimuovi)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Configurazione della connessione al database
$host = '';
$dbname = '';
$username = '';
$password = '';

try {
    // Connessione unica al database
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Errore di connessione al database: " . $e->getMessage());
}

// Verifica se i dati sono stati inviati tramite AJAX
if (isset($_POST['campo']) && isset($_POST['valore'])) {
    $campo = $_POST['campo'];
    $valore = $_POST['valore'];

    // Controllo per la tabella Squadra
    $campi_squadra = [
        'nomeSquadra' => ['colonna' => 'nome', 'messaggio' => 'Squadra già registrata!']
    ];

    // Controllo per la tabella Persona (caposquadra e partecipanti)
    $campi_persona = [
        'idCaposquadra' => ['colonna' => 'id_brawl', 'messaggio' => 'ID Brawl già in uso!'],
        'emailCaposquadra' => ['colonna' => 'email', 'messaggio' => 'Email già registrata!'],
        'idPartecipante' => ['colonna' => 'id_brawl', 'messaggio' => 'ID Brawl già in uso per un partecipante!'],
        'emailPartecipante' => ['colonna' => 'email', 'messaggio' => 'Email già registrata per un partecipante!']
    ];

    // Controllo nella tabella Squadra
    if (array_key_exists($campo, $campi_squadra)) {
        $colonna = $campi_squadra[$campo]['colonna'];
        $messaggio = $campi_squadra[$campo]['messaggio'];

        try {
            $stmt = $conn->prepare("SELECT COUNT(*) FROM Squadra WHERE $colonna = :valore");
            $stmt->bindParam(':valore', $valore, PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                echo $messaggio;
            } else {
                echo "";
            }
        } catch (PDOException $e) {
            echo "Errore nella query (Squadra): " . $e->getMessage();
        }
    }

    // Controllo nella tabella Persona (per caposquadra e partecipanti con numeri)
    foreach ($campi_persona as $chiave => $dettagli) {
        if (strpos($campo, $chiave) === 0) { // Controlla se il nome inizia con "idPartecipante" o "emailPartecipante"
            $colonna = $dettagli['colonna'];
            $messaggio = $dettagli['messaggio'];

            try {
                $stmt = $conn->prepare("SELECT COUNT(*) FROM Persona WHERE $colonna = :valore");
                $stmt->bindParam(':valore', $valore, PDO::PARAM_STR);
                $stmt->execute();
                $count = $stmt->fetchColumn();

                if ($count > 0) {
                    echo $messaggio;
                } else {
                    echo "";
                }
            } catch (PDOException $e) {
                echo "Errore nella query (Persona): " . $e->getMessage();
            }
        }
    }
}
?>
