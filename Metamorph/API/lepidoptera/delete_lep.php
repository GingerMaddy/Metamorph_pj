<?php
session_start(); // Inizia sessione

// Verifica POST
var_dump($_POST); // Mostra i dati POST ricevuti

// Include file di connessione al database
include_once('./../librerie_comuni/db_connection.php');

// Verifica se il metodo della richiesta è POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Controlla se è stato inviato "lep_id"
    if (isset($_POST["lep_id"])) {

        // Sanitizza l'input
        $lep_id = test_input($_POST["lep_id"]);

        // Connessione al database
        $db = set_up_connection('localhost', 'Metamorph', 'Maddalena', '12345'); 

        if (!$db) {
            die("Connessione al database fallita."); // Interrompe se la connessione fallisce
        }

        // Query di eliminazione
        $query = "DELETE FROM Lepidoptera WHERE lep_id = :lep_id";

        // Definisci i parametri
        $params = [':lep_id' => $lep_id];

        // Esegui la query
        try {
            $result = execute_query($query, $db, $params); // Esegui la query con i parametri forniti

            // Verifica il risultato
            if ($result) {
                echo "Il record con ID Lepidoptera $lep_id è stato eliminato con successo.";
            } else {
                echo "Errore durante l'eliminazione del record."; // Mostra un messaggio di errore se la query fallisce
            }
        } catch (Exception $e) {
            // Cattura eccezioni e restituisci messaggio
            echo "Errore durante l'esecuzione della query: " . $e->getMessage();
        }
    } else {
        die("Dati non forniti."); // Se i dati richiesti non sono corretti
    }
} else {
    die("Richiesta non valida."); // Se il metodo non è POST
}
?>