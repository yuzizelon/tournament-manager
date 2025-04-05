<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Credenziali per il database
$host = "sql204.infinityfree.com";
$username = "if0_37692320";
$password = "alignani2024";
$database = "if0_37692320_torneo";

// Connessione al database
$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Recupero dati dal modulo
$nomeCapo = $_POST['nomeCaposquadra'];
$cognomeCapo = $_POST['cognomeCaposquadra'];
$idCapo = $_POST['idCaposquadra'];
$classeCapo = $_POST['classeCaposquadra'];
$emailCapo = $_POST['emailCaposquadra'];
$nomeSquadra = $_POST['nomeSquadra'];

// Dati per i due partecipanti
$nomeStudente1 = $_POST['nomePartecipante2'];
$cognomeStudente1 = $_POST['cognomePartecipante2'];
$idStudente1 = $_POST['idPartecipante2'];
$classeStudente1 = $_POST['classePartecipante2'];
$emailStudente1 = $_POST['emailPartecipante2'];

$nomeStudente2 = $_POST['nomePartecipante3'];
$cognomeStudente2 = $_POST['cognomePartecipante3'];
$idStudente2 = $_POST['idPartecipante3'];
$classeStudente2 = $_POST['classePartecipante3'];
$emailStudente2 = $_POST['emailPartecipante3'];

// Controllo se il nome della squadra esiste già
$sql_check_squadra = "SELECT * FROM Squadra WHERE nome = ?";
$stmt = $conn->prepare($sql_check_squadra);
$stmt->bind_param("s", $nomeSquadra);
$stmt->execute();
$result_squadra = $stmt->get_result();
if ($result_squadra->num_rows > 0) {
    die("<script>alert('Errore: Nome della squadra già esistente. Scegli un altro nome.'); window.location.href = 'iscrizione.php';</script>");
}

// Controllo se ID o email del caposquadra o degli studenti sono già registrati
$sql_check = "SELECT * FROM Persona WHERE id_brawl = ? OR email = ?";
$stmt = $conn->prepare($sql_check);
$stmt->bind_param("ss", $idCapo, $emailCapo);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    die("<script>alert('Errore: ID o email del caposquadra già registrati.'); window.location.href = 'iscrizione.php';</script>");
}

// Controllo per Studente 1
$stmt->bind_param("ss", $idStudente1, $emailStudente1);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    die("<script>alert('Errore: ID o email del Partecipante 2 già registrati.'); window.location.href = 'iscrizione.php';</script>");
}

// Controllo per Studente 2
$stmt->bind_param("ss", $idStudente2, $emailStudente2);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    die("<script>alert('Errore: ID o email del Partecipante 3 già registrati.'); window.location.href = 'iscrizione.php';</script>");
}

// Inserimento squadra con giocatore_2 e giocatore_3
$sqlSquadra = "INSERT INTO Squadra (nome, caposquadra, giocatore_2, giocatore_3, Confermato) VALUES (?, ?, ?, ?, 0)";
$stmt = $conn->prepare($sqlSquadra);
$stmt->bind_param("ssss", $nomeSquadra, $idCapo, $idStudente1, $idStudente2);
if (!$stmt->execute()) {
    die("<script>alert('Errore nel salvataggio della squadra: " . $conn->error . "'); window.location.href = 'iscrizione.php';</script>");
}

// Inserimento Caposquadra
$sqlPersona = "INSERT INTO Persona (id_brawl, nome, cognome, classe, email, stato, squadra_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sqlPersona);
$stato = "Caposquadra";
$stmt->bind_param("sssssss", $idCapo, $nomeCapo, $cognomeCapo, $classeCapo, $emailCapo, $stato, $nomeSquadra);
if (!$stmt->execute()) {
    die("<script>alert('Errore nel salvataggio del caposquadra: " . $conn->error . "'); window.location.href = 'iscrizione.php';</script>");
}

// Inserimento Studente 1
$stato = "Partecipante";
$stmt->bind_param("sssssss", $idStudente1, $nomeStudente1, $cognomeStudente1, $classeStudente1, $emailStudente1, $stato, $nomeSquadra);
if (!$stmt->execute()) {
    die("<script>alert('Errore nel salvataggio dello studente 2: " . $conn->error . "'); window.location.href = 'iscrizione.php';</script>");
}

// Inserimento Studente 2
$stmt->bind_param("sssssss", $idStudente2, $nomeStudente2, $cognomeStudente2, $classeStudente2, $emailStudente2, $stato, $nomeSquadra);
if (!$stmt->execute()) {
    die("<script>alert('Errore nel salvataggio dello studente 3: " . $conn->error . "'); window.location.href = 'iscrizione.php';</script>");
}

$conn->close();

echo "<script>alert('Iscrizione completata con successo!'); window.location.href = 'iscrizione.php';</script>";

?>
