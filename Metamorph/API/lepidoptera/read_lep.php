<?php
session_start(); // Inizia sessione

// Include le funzioni di connessione al database
include_once('./../librerie_comuni/db_connection.php');

// Verifica se il metodo della richiesta è GET
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    // Connessione al database
    $db = set_up_connection('localhost', 'Metamorph', 'Maddalena', '12345'); 
    if (!$db) {
        die("Connessione al database fallita."); // Interrompe l'esecuzione se la connessione fallisce
    }

    // Definisci la query di selezione
    $query = "SELECT * FROM Lepidoptera";

    // Esegui la query
    try {
        $stmt = $db->prepare($query);
        $stmt->execute();
        // Recupera tutti i risultati
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Imposta il tipo di contenuto su application/json
        header('Content-Type: application/json');

        // Restituisci i risultati in formato JSON
        echo json_encode($results);
    } catch (Exception $e) {
        
        // Cattura eventuali eccezioni e visualizza il messaggio di errore
        echo json_encode(["error" => "Errore durante l'esecuzione della query: " . $e->getMessage()]);
    }
} else {
    die("Richiesta non valida."); // Se il metodo della richiesta non è GET
}
?>